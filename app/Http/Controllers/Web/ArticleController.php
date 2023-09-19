<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Repositories\Contracts\ArticleCategoryInterface;
use App\Repositories\Contracts\ArticleInterface;
use Illuminate\Http\Request;
use App\Models\ArticlesCategories;

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
        $article = $this->articleRepository->getAll();
        return view('web.article.home', compact('article'));
    }

    /**
     * Display a home of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cat($slug)
    {
        $category = ArticlesCategories::where(['slug'=> $slug,'active'=> 1])
            ->select('id','title','type','seo_title','seo_keyword','seo_description')
            ->first();
        if (!$category) {
            abort(404);
        }
        if ($category->type == 1){
            $articles = $this->articleRepository->paginate(9,['id','slug','image','description','title','active','category_id','created_at'],['active'=>1,'category_id'=>$category->id]);
            return view('web.article.promotion',compact('category','articles'));
        }else{
            $articles = $this->articleRepository->paginate(10,['id','slug','image','description','title','active','category_id','created_at'],['active'=>1,'category_id'=>$category->id]);
            return view('web.article.home',compact('category','articles'));
        }

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
        $articles = $this->articleRepository->getList(['category_id' => $article->category_id,'active' => 1],['id','slug','image','description','title','active','category_id','created_at'], $limit);
        return view('web.article.detail', compact('article','articles'));
    }
}
