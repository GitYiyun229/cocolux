<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Product;
use App\Models\ProductOptions;
use App\Models\Setting;
use App\Repositories\Contracts\ArticleCategoryInterface;
use App\Repositories\Contracts\ArticleInterface;
use App\Services\DealService;
use Illuminate\Http\Request;
use App\Models\ArticlesCategories;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\SEOMeta;

class ArticleController extends Controller
{
    protected $articleCategoryRepository;
    protected $articleRepository;
    protected $dealService;

    public function __construct(ArticleCategoryInterface $articleCategoryRepository, ArticleInterface $articleRepository, DealService $dealService)
    {
        $this->articleCategoryRepository = $articleCategoryRepository;
        $this->articleRepository = $articleRepository;
        $this->dealService = $dealService;
    }
    /**
     * Display a home of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $logo = Setting::where('key', 'logo')->first();

        SEOTools::setTitle('Tin tức mới nhất về mỹ phẩm xu hướng làm đẹp mỗi tuần');
        SEOTools::setDescription('CocoLux luôn cập nhật nhanh chóng đầy đủ những tin tức, xu hướng làm đẹp được giới trẻ yêu thích nhất. Cung cấp những mẹo nhỏ tiện lợi hơn trong chăm sóc da, trang điểm giúp các nàng tiết kiệm thời gian nhưng vẫn hữu ích.');
        SEOTools::addImages(asset($logo->value));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');

        $cat_article = ArticlesCategories::where(['active'=> 1])->withDepth()->defaultOrder()->get()->toTree();
        $article = $this->articleRepository->paginate(12,['id','slug','image','description','title','active','category_id','created_at'],['active'=>1]);
        $article_hot = Article::where(['active' => 1, 'is_home' => 1])->limit(3)->get();
        $product_hots = ProductOptions::where(['active' => 1, 'is_default' => 1])
            ->select('id','title','images','brand','hot_deal','sku','slug','parent_id','price','normal_price')
            ->with(['product' => function($query){
                $query->select('id','is_hot','slug');
            }])->whereHas('product', function ($query) {
                $query->where('is_hot', 1);
            })->limit(5)->get();
        return view('web.article.home', compact('article','cat_article','product_hots','article_hot'));
    }

    /**
     * Display a home of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cat($slug,$id)
    {
        $category = ArticlesCategories::where(['id'=> $id,'active'=> 1])
            ->select('id','title','seo_title','seo_keyword','seo_description')
            ->first();
        if (!$category) {
            abort(404);
        }
        $cat_article = ArticlesCategories::where(['active'=> 1])->withDepth()->defaultOrder()->get()->toTree();
        $article = $this->articleRepository->paginate(12,['id','slug','image','description','title','active','category_id','created_at'],['active'=>1,'category_id'=>$id]);
        $article_hot = Article::where(['active' => 1, 'is_home' => 1])->limit(3)->get();
        $product_hots = ProductOptions::where(['active' => 1, 'is_default' => 1])
            ->select('id','title','images','brand','hot_deal','sku','slug','parent_id','price','normal_price')
            ->with(['product' => function($query){
                $query->select('id','is_hot','slug');
            }])->whereHas('product', function ($query) {
                $query->where('is_hot', 1);
            })->limit(5)->get();

        SEOTools::setTitle($category->seo_title?$category->seo_title:$category->title);
        SEOTools::setDescription($category->seo_description?$category->seo_description:$category->description);
        SEOTools::addImages($category->image?asset($category->image):null);
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');
        SEOMeta::setKeywords($category->seo_keyword?$category->seo_keyword:$category->title);

        return view('web.article.cat', compact('article','cat_article','product_hots','article_hot'));
    }

    /**
     * Display a home of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($slug, $id)
    {
        $article = $this->articleRepository->getOneById($id,['category']);

        preg_match_all('/product-option-(\d+)/', $article->content, $matches);
        $productOptionIds = $matches[1];
        if (!empty($productOptionIds)){
            $products = ProductOptions::whereIn('id', $productOptionIds)->select('id','slug','title','price','sku','images')->where('sku','!=',null)->where('slug','!=',null)->get();
            $productInfoMap = [];
            foreach ($products as $product) {
                $productInfoMap[$product->id] = [
                    'title' => $product->title,
                    'image' => $product->image_first,
                    'price' => format_money($product->price),
                    'url' => route('detailProduct',['slug' => $product->slug, 'sku' => $product->sku]),
                ];
            }
            $contentWithTitles = preg_replace_callback('/product-option-(\d+)/', function ($match) use ($productInfoMap) {
                $productId = $match[1];
                if (isset($productInfoMap[$productId])) {
                    $productInfo = $productInfoMap[$productId];
                    $title = $productInfo['title'];
                    $image = asset($productInfo['image']);
                    $price = $productInfo['price'];
                    $url = $productInfo['url'];
                    return "<div class='item_block_template' style='display: flex; padding: 10px; margin: 10px 0; border: 1px solid #f3f3f3;'>
                            <div class='item_thumb_sp' style='width: 100%; max-width: 150px; margin-right: 10px; position: relative; height: auto; padding-bottom: 20%; overflow: hidden;'>
                                <span style='font-size:16px;'>
                                <img alt='$title' class='img_thumb' data-was-processed='true' src='$image' style='position: absolute; width: 100%; height: 100%; max-width: 100%; max-height: 100%; bottom: 0; left: 0; object-fit: contain; transition: opacity 0.3s ease-out 0s;'>
                                </span>
                            </div>
                            <div class='item_info_sp' style='width: calc(100% - 160px); display: flex; flex-direction: column; align-items: flex-start;'>
                                <div class='sp_name' style='font-size: 16px; font-weight: 700; margin-top: 10px; margin-bottom: 10px; display: block; display: -webkit-box; overflow: hidden; text-overflow: ellipsis; -webkit-line-clamp: 3; -webkit-box-orient: vertical;'>
                                    <span style='font-size:16px;'>$title</span>
                                </div>
                                <div class='sp_block_price' style='margin-bottom: 10px;'>
                                    <span style='font-size:16px;'>
                                        <strong class='item_giamoi' style='color: #c73030; line-height: 20px;'>$price</strong>&nbsp;
                                    </span>
                                </div>
                                <div class='sp_block_muangay'>
                                    <span style='font-size:16px;'>
                                        <a class='btn btn-danger' href='$url'>Mua ngay </a>
                                    </span>
                                </div>
                            </div>
                        </div>";
                }
                // Trả lại chuỗi ban đầu nếu không tìm thấy
                return $match[0];
            }, $article->content);
            $article->content = $contentWithTitles;
        }

        $promotions = $this->dealService->isFlashSaleAvailable();
        $promotions_flash_id = $promotions->pluck('id')->toArray();
//        $applied_stop_time = $promotions->pluck('applied_stop_time','id')->toArray();
        $hot_deal = $this->dealService->isHotDealAvailable();
        $promotions_hot_id = $hot_deal->pluck('id')->toArray();

        $products_choose = null;

        if ($article->products){
            $id_products = explode(',',$article->products);
            if ($article->updated_at < '2023-10-17'){
                $products_choose = ProductOptions::whereIn('parent_id', $id_products)
                    ->select('id','title','images','brand','hot_deal','flash_deal','sku','slug','parent_id','price','normal_price')
                    ->where('sku','!=',null)->where('slug','!=',null)->get();
            }else{
                $products_choose = ProductOptions::whereIn('id', $id_products)
                    ->select('id','title','images','brand','hot_deal','flash_deal','sku','slug','parent_id','price','normal_price')
                    ->where('sku','!=',null)->where('slug','!=',null)->get();
            }

        }

        $cat_article = ArticlesCategories::where(['active'=> 1])->withDepth()->defaultOrder()->get()->toTree();
        $parent_cat = ArticlesCategories::select('id','title','slug')->where(['active'=> 1,'id' => $article->category_id])->first();
        $article_hot = Article::where(['active' => 1, 'is_home' => 1])->limit(3)->get();
        $product_hots = ProductOptions::where(['active' => 1, 'is_default' => 1])
            ->select('id','title','images','brand','hot_deal','sku','slug','parent_id','price','normal_price')
            ->with(['product' => function($query){
                $query->select('id','is_hot','slug');
            }])->whereHas('product', function ($query) {
                $query->where('is_hot', 1);
            })->limit(5)->get();

        SEOTools::setTitle($article->seo_title?$article->seo_title:$article->title);
        SEOTools::setDescription($article->seo_description?$article->seo_description:$article->description);
        SEOTools::addImages($article->image?asset($article->image):null);
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');
        SEOMeta::setKeywords($article->seo_keyword?$article->seo_keyword:$article->title);

        return view('web.article.detail', compact('article','cat_article','article_hot','product_hots','parent_cat','products_choose','promotions_flash_id','promotions_hot_id'));
    }
}
