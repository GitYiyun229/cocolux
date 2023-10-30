<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Product;
use App\Models\ProductOptions;
use Illuminate\Http\Request;
use App\DataTables\ArticleDataTable;
use App\DataTables\Scopes\ArticleDataTableScope;
use App\Repositories\Contracts\ArticleCategoryInterface;
use App\Repositories\Contracts\ArticleInterface;
use App\Http\Requests\Article\CreateArticle;
use App\Http\Requests\Article\UpdateArticle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    protected $articleCategoryRepository;
    protected $articleRepository;
    protected $resizeImage;

    public function __construct(ArticleCategoryInterface $articleCategoryRepository, ArticleInterface $articleRepository)
    {
        $this->middleware('auth');
        $this->articleCategoryRepository = $articleCategoryRepository;
        $this->articleRepository = $articleRepository;
        $this->resizeImage = $this->articleRepository->resizeImage();
    }

    /**
     * Display a listing of the resource.
     *
     * @param ArticleDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(ArticleDataTable $dataTable)
    {
        $data = request()->all();
        $categories = $this->articleCategoryRepository->getAll();
        if ($categories->count() === 0){
            Session::flash('danger', 'Chưa có danh mục nào');
            return redirect()->route('admin.article-category.index');
        }
        return $dataTable->addScope(new ArticleDataTableScope())->render('admin.article.index', compact('data','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->articleCategoryRepository->getAll();
        return view('admin.article.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateArticle $req
     * @return \Illuminate\Http\Response
     */
    public function store(CreateArticle $req)
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
            $data['products'] = $data['products_add'];
            $model = $this->articleRepository->create($data);
            if (!empty($data['image'])){
                $this->articleRepository->saveFileUpload($image_root,$this->resizeImage,$model->id,'article');
            }
            DB::commit();
            Session::flash('success', trans('message.create_article_success'));
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::info([
                'message' => $ex->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.create_article_error'));
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = $this->articleRepository->getOneById($id);
        $categories = $this->articleCategoryRepository->getAll();
        $products = array();
        if ($article->products){
            if ($article->updated_at < '2023-10-17'){
                $products = ProductOptions::select('id','title','slug','sku','images','price')->whereIn('parent_id',explode(',',$article->products))->get();
                $article_products = ProductOptions::select('id')->whereIn('parent_id',explode(',',$article->products))->pluck('id')->toArray();
                $article->products = implode(',',$article_products);
            }else{
                $products = ProductOptions::select('id','title','slug','sku','images','price')->whereIn('id',explode(',',$article->products))->get();
            }
        }
        return view('admin.article.update', compact('article','categories','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateArticle  $req
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateArticle $req)
    {
        $data_root = $this->articleRepository->getOneById($id);
        DB::beginTransaction();
        try {
            $data = $req->validated();
            $article = $this->articleRepository->getOneById($id);
            if (!empty($data['image']) && $data_root->image != $data['image']){
                $this->articleRepository->removeImageResize($data_root->image,$this->resizeImage, $id,'article');
                $data['image'] = $this->articleRepository->saveFileUpload($data['image'],$this->resizeImage, $id,'article');
            }
            if (empty($data['slug'])){
                $data['slug'] = $req->input('slug')?\Str::slug($req->input('slug'), '-'):\Str::slug($data['title'], '-');
            }
            $data['products'] = $data['products_add'];
            $article->update($data);
            DB::commit();
            Session::flash('success', trans('message.update_article_success'));
            return redirect()->route('admin.article.edit', $id);
        } catch (\Exception $exception) {
            \Log::info([
                'message' => $exception->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.update_article_error'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->articleRepository->getOneById($id);

        // Đường dẫn tới tệp tin
        $resize = $this->resizeImage;
        $img_path = pathinfo($data->image, PATHINFO_DIRNAME);
        foreach ($resize as $item){
            $array_resize_ = str_replace($img_path.'/','/public/article/'.$item[0].'x'.$item[1].'/'.$data->id.'-',$data->image);
            $array_resize_ = str_replace(['.jpg', '.png','.bmp','.gif','.jpeg'],'.webp',$array_resize_);
            Storage::delete($array_resize_);
        }

        $this->articleRepository->delete($id);

        return [
            'status' => true,
            'message' => trans('message.delete_article_success')
        ];
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $product_ids = $request->input('product_ids');
        $products = ProductOptions::with(['product' => function ($query) {
            $query->select('id', 'is_new','sku','brand','slug','attribute_path');
        }])->whereHas('product', function ($query) use ($keyword,$product_ids) {
            $query->where('product_options.active', 1);
            if ($keyword){
                $query->where('product_options.title', 'LIKE', '%'.$keyword.'%')
                ->Orwhere('product_options.slug', 'LIKE', '%'.\Str::slug($keyword, '-').'%')
                ->Orwhere('product_options.sku', 'LIKE', '%'.$keyword.'%');
            }
            if ($product_ids){
                $query->whereNotIn('id', explode(',',$product_ids));
            }
        })
            ->select('product_options.id','product_options.sku', 'product_options.title', 'product_options.parent_id','product_options.price','product_options.normal_price','product_options.slug','product_options.images')
            ->addSelect('products.title as product_name')
            ->join('products', 'product_options.parent_id', '=', 'products.id')
            ->orderBy('product_options.id', 'DESC')
            ->where('product_options.sku','!=',null)
            ->where('product_options.slug','!=',null)
            ->limit(30)->get()->toArray();

        $result = array();
        $result['error'] = false;
        $result['data'] = $products;
        return response()->json($result);
    }

    /**
     * @param $id
     * @return array
     */
    public function changeActive($id)
    {
        $article = Article::findOrFail($id);
        $article->update(['active' => !$article->active]);
        return [
            'status' => true,
            'message' => trans('message.change_active_article_success')
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function changeIsHome($id)
    {
        $article = Article::findOrFail($id);
        $article->update(['is_home' => !$article->is_home]);
        return [
            'status' => true,
            'message' => trans('message.change_is_home_article_success')
        ];
    }
}
