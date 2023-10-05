<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Product;
use App\Models\Setting;
use App\Repositories\Contracts\ArticleCategoryInterface;
use App\Repositories\Contracts\ArticleInterface;
use Illuminate\Http\Request;
use App\Models\ArticlesCategories;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\SEOMeta;

class ArticleController extends Controller
{
    protected $articleCategoryRepository;
    protected $articleRepository;

    public function __construct(ArticleCategoryInterface $articleCategoryRepository, ArticleInterface $articleRepository)
    {
        $this->articleCategoryRepository = $articleCategoryRepository;
        $this->articleRepository = $articleRepository;
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
        $product_hots = Product::where(['active' => 1, 'is_hot' => 1])
            ->select('id','title','image','brand','hot_deal')
            ->with(['productOption' => function($query){
                $query->where(['is_default' => 1,'active' => 1])->select('id', 'title', 'parent_id','price','slug','images');
            }])->limit(5)->get();
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
        $product_hots = Product::where(['active' => 1, 'is_hot' => 1])
            ->select('id','title','image','brand','hot_deal')
            ->with(['productOption' => function($query){
                $query->where(['is_default' => 1,'active' => 1])->select('id', 'title', 'parent_id','price','slug','images');
            }])->limit(5)->get();

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
        if ($article->type == 0){
            $limit = 4;
        }else{
            $limit = 3;
        }
        $cat_article = ArticlesCategories::where(['active'=> 1])->withDepth()->defaultOrder()->get()->toTree();
        $article_hot = Article::where(['active' => 1, 'is_home' => 1])->limit(3)->get();
        $product_hots = Product::where(['active' => 1, 'is_hot' => 1])
            ->select('id','title','image','brand','hot_deal')
            ->with(['productOption' => function($query){
                $query->where(['is_default' => 1,'active' => 1])->select('id', 'title', 'parent_id','price','slug','images');
            }])->limit(5)->get();

        SEOTools::setTitle($article->seo_title?$article->seo_title:$article->title);
        SEOTools::setDescription($article->seo_description?$article->seo_description:$article->description);
        SEOTools::addImages($article->image?asset($article->image):null);
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('cocolux.com');
        SEOMeta::setKeywords($article->seo_keyword?$article->seo_keyword:$article->title);

        return view('web.article.detail', compact('article','cat_article','article_hot','product_hots'));
    }
}
