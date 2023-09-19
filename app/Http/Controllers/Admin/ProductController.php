<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Scopes\ProductDataTableScope;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ProductInterface;
use App\Repositories\Contracts\ProductCategoryInterface;
use App\DataTables\ProductDataTable;
use App\Http\Requests\Product\CreateProduct;
use App\Http\Requests\Product\UpdateProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    protected $productResponstory, $productCategoryResponstory;
    protected $resizeImage;

    function __construct(ProductCategoryInterface $productCategoryResponstory,ProductInterface $productResponstory)
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
        if ($categories->count() === 0){
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
        return view('admin.product.create', compact('categories'));
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
            $data['slug'] = $req->input('slug')?\Str::slug($req->input('slug'), '-'):\Str::slug($data['title'], '-');
            if (!empty($data['image'])){
                $image_root = $data['image'];
                $data['image'] = urldecode($image_root);
            }
            $model = $this->productResponstory->create($data);
            if (!empty($data['image'])){
                $this->productResponstory->saveFileUpload($image_root,$this->resizeImage,$model->id,'product');
            }
            DB::commit();
            Session::flash('success', trans('message.create_product_success'));
            return redirect()->back();
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
        return view('admin.product.update', compact('product','categories'));
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
            $page = $this->productResponstory->getOneById($id);
            if (!empty($data['image']) && $data_root->image != $data['image']){
                if ($data_root->image){
                    $this->productResponstory->removeImageResize($data_root->image,$this->resizeImage, $id,'product');
                }
                $data['image'] = $this->productResponstory->saveFileUpload($data['image'],$this->resizeImage, $id,'product');
            }
            if (empty($data['slug'])){
                $data['slug'] = $req->input('slug')?\Str::slug($req->input('slug'), '-'):\Str::slug($data['title'], '-');
            }
            $page->update($data);
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
        foreach ($resize as $item){
            $array_resize_ = str_replace($img_path.'/','/public/product/'.$item[0].'x'.$item[1].'/'.$data->id.'-',$data->image);
            $array_resize_ = str_replace(['.jpg', '.png','.bmp','.gif','.jpeg'],'.webp',$array_resize_);
            Storage::delete($array_resize_);
        }

        $this->productResponstory->delete($id);

        return [
            'status' => true,
            'message' => trans('message.delete_product_success')
        ];
    }
}
