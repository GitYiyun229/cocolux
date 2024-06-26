<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Scopes\ProductDataTableScope;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValues;
use App\Models\Product;
use App\Models\ProductOptions;
use App\Models\ProductsCategories;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ProductInterface;
use App\Repositories\Contracts\ProductCategoryInterface;
use App\DataTables\ProductDataTable;
use App\Http\Requests\Product\CreateProduct;
use App\Http\Requests\Product\UpdateProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;


class ProductController extends Controller
{

    protected $productResponstory, $productCategoryResponstory;
    protected $resizeImage;

    function __construct(ProductCategoryInterface $productCategoryResponstory, ProductInterface $productResponstory)
    {
        $this->middleware('auth');
        $this->productCategoryResponstory = $productCategoryResponstory;
        $this->productResponstory = $productResponstory;
        $this->resizeImage = $this->productResponstory->resizeImage();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductDataTable $dataTable)
    {
        $data = request()->all();
        $categories = $this->productCategoryResponstory->getAll();
        if ($categories->count() === 0) {
            Session::flash('danger', 'Chưa có danh mục nào');
            return redirect()->route('admin.product-category.index');
        }
        return $dataTable->addScope(new ProductDataTableScope())->render('admin.product.index', compact('data', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->productCategoryResponstory->getAll();
        $attribute = Attribute::select('id', 'code', 'name', 'type')->where(function ($query) {
            $query->orWhere('type', 'select')
                ->orWhere('type', 'ckeditor');
        })->where(['active' => 1])->with(['attributeValue' => function ($query) {
            $query->select('id', 'slug', 'name', 'attribute_id')->where('active', 1);
        }])->get();
        return view('admin.product.create', compact('categories', 'attribute'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProduct $req)
    {
        DB::beginTransaction();
        try {
            $data = $req->validated();
            $image_root = '';
            $data['slug'] = $req->input('slug') ? \Str::slug($req->input('slug'), '-') : \Str::slug($data['title'], '-');
            if (!empty($data['image'])) {
                $image_root = $data['image'];
                $data['image'] = urldecode($image_root);
            }
            $model = $this->productResponstory->create($data);
            if (!empty($data['image'])) {
                $this->productResponstory->saveFileUpload($image_root, $this->resizeImage, $model->id, 'product');
            }
            $category = ProductsCategories::findOrFail($data['category_id']);
            if ($category->path) {
                $data['category_path'] = $category->path . ',' . $category->id;
            } else {
                $data['category_path'] = $category->id;
            }
            if (!empty($data['description'])) {
                $ContentHtml = $data['description'];
                $html = $this->productResponstory->FileHtmlImageToWebp($ContentHtml, $model->id, 'product');
                $data['description'] = $html;
                $article = $this->productResponstory->getOneById($model->id);
                $article->update($data);
            }

            DB::commit();
            Session::flash('success', trans('message.create_product_success'));
            return redirect()->route('admin.product.edit', $model->id);
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::info([
                'message' => $ex->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.create_product_error'));
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = $this->productCategoryResponstory->getAll();
        $product = $this->productResponstory->getOneById($id);
        $product_option = ProductOptions::where(['parent_id' => $product->id])->get();
        $attribute_value = $product->attributes;
        $attribute = Attribute::select('id', 'code', 'name', 'type')->where(function ($query) {
            $query->orWhere('type', 'select')
                ->orWhere('type', 'ckeditor');
        })->where(['active' => 1])->with(['attributeValue' => function ($query) {
            $query->select('id', 'slug', 'name', 'attribute_id')->where('active', 1);
        }])->orderBy('id', 'DESC')->get();

        foreach ($attribute as $item) {
            if ($attribute_value) {
                $result = array_filter($attribute_value, function ($value) use ($item) {
                    return $value->id == $item->id;
                });
                if (!empty($result)) {
                    $values = [];
                    foreach ($result as $value) {
                        $values['id'] = $value->value->id;
                        $values['content'] = $value->value->name;
                    }
                    $item->content = $values;
                }
            }
        }
        return view('admin.product.update', compact('product', 'categories', 'attribute', 'product_option'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateProduct $req)
    {
        $data_root = $this->productResponstory->getOneById($id);
        DB::beginTransaction();


        try {
            $data = $req->validated();
            // dd($data);
            if (!empty($data['description']) && $data_root->content != $data['description']) {
                $ContentHtml = $data['description'];
                $html = $this->productResponstory->FileHtmlImageToWebp($ContentHtml, $id, 'product');
                $data['description'] = $html;
            }

            if (!empty($data['image']) && $data_root->image != $data['image']) {
                if ($data_root->image && !\Str::contains($data_root->image, 'cdn.cocolux.com')) {
                    if (Storage::disk('local')->exists($data_root->image)) {
                        $this->productResponstory->removeImageResize($data_root->image, $this->resizeImage, $id, 'product');
                    }
                }
                $data['image'] = $this->productResponstory->saveFileUpload($data['image'], $this->resizeImage, $id, 'product', 'resize');
                if (!empty($data['image']) && $data_root->image != $data['image']) {
                    $this->imgwebp($data['image']);
                }
            }
            $data['updated_at'] = now()->format('Y-m-d H:i:s');

            // dd($data['updated_at']);
            //upload ảnh nhiều bằng ckfinder3 thì dùng hàm này
            if (isset($req['sortedIds']) && !empty($req['sortedIds'])) {
                foreach (explode(',', $req['sortedIds']) as $item) {
                    $this->imgwebp($item);
                }
            }

            if (empty($data['slug'])) {
                $data['slug'] = $req->input('slug') ? \Str::slug($req->input('slug'), '-') : \Str::slug($data['title'], '-');
            }
            $attribute = Attribute::select('id', 'code', 'name', 'type')->where(function ($query) {
                $query->orWhere('type', 'select')
                    ->orWhere('type', 'ckeditor');
            })->where(['active' => 1])->get();

            $attributes = array();
            $attribute_path = array();
            foreach ($attribute as $item) {

                if (request($item->code)) {
                    if ($item->type == 'select') {
                        $attribute_value = AttributeValues::select('id', 'name')->where(['active' => 1, 'id' => request($item->code)])->first();
                        $value = [
                            'id' => request($item->code),
                            'name' => $attribute_value->name,
                            'type' => $item->type
                        ];
                        $attribute_value_id = $attribute_value->id;
                    } else {
                        $attribute_value = AttributeValues::select('id', 'name')->where(['active' => 1, 'attribute_id' => $item->id])->first();
                        $NameHtml = '';
                        if (!empty(request($item->code))) {
                            $NameHtml = request($item->code);
                            if (!empty($NameHtml)) {
                                $NameHtml = $this->productResponstory->FileHtmlImageToWebp($NameHtml, $id, 'product');
                            }
                        }
                        $value = [
                            'id' => $attribute_value->id,
                            'name' =>  $NameHtml,
                            'type' => $item->type
                        ];
                        $attribute_value_id = $attribute_value->id;
                    }
                    $attributes[] = [
                        'id' => $item->id,
                        'name' => $item->name,
                        'value' => $value,
                    ];
                    $attribute_path[] =  $item->id . ':' . $attribute_value_id;
                }
            }

            $attribute_path_st = implode(',', $attribute_path);
            $data['attributes'] = $attributes;
            $data['attribute_path'] = $attribute_path_st;
            $category = ProductsCategories::findOrFail($data['category_id']);
            if ($category->path) {
                $data['category_path'] = $category->path . ',' . $category->id;
            } else {
                $data['category_path'] = $category->id;
            }
            // dd(
            //     $attribute
            // );
            // dd($data['image']);
            $data_root->update($data);
            DB::commit();
            Session::flash('success', trans('message.update_product_success'));
            return redirect()->route('admin.product.edit', $id);
        } catch (\Exception $exception) {
            \Log::info([
                'message' => $exception->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.update_product_error'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $data = $this->productResponstory->getOneById($id);

        // Đường dẫn tới tệp tin
        $resize = $this->resizeImage;
        $img_path = pathinfo($data->image, PATHINFO_DIRNAME);
        foreach ($resize as $item) {
            $array_resize_ = str_replace($img_path . '/', '/public/product/' . $item[0] . 'x' . $item[1] . '/' . $data->id . '-', $data->image);
            $array_resize_ = str_replace(['.jpg', '.png', '.bmp', '.gif', '.jpeg'], '.webp', $array_resize_);
            Storage::delete($array_resize_);
        }
        $product_option = ProductOptions::where('parent_id', $id)->select('id')->get(); // check product exist in cat
        if (count($product_option)) {
            return [
                'status' => false,
                'message' => 'Vẫn còn sản phẩm phụ trong sản phẩm này'
            ];
        } else {
            $this->productResponstory->delete($id);
            return [
                'status' => true,
                'message' => trans('message.delete_product_success')
            ];
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function changeActive($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['active' => !$product->active]);
        return [
            'status' => true,
            'message' => trans('message.change_active_product_success')
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function changeIsHome($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_home' => !$product->is_home]);
        return [
            'status' => true,
            'message' => trans('message.change_is_home_product_success')
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function changeIsHot($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_hot' => !$product->is_hot]);
        return [
            'status' => true,
            'message' => trans('message.change_is_hot_product_success')
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function changeIsNew($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_new' => !$product->is_new]);
        return [
            'status' => true,
            'message' => trans('message.change_is_new_product_success')
        ];
    }


    function imgwebp($image)
    {
        try {
            $manager = new ImageManager(['driver' => 'gd']);
            $imagePath = public_path($image);
            $imageName = basename($image);
            $imagepath_rep = str_replace($imageName, '', $imagePath);
            $newImageName = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
            $newImagePath = $imagepath_rep . $newImageName;
            $image = Image::make($imagePath)->resize(600, 600);
            if (!Storage::disk('public')->exists($newImagePath)) {
                $image->save($newImagePath, 90);
            }
        } catch (\Exception $exception) {
            \Log::info([
                'message' => $exception->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
        }
    }
}
