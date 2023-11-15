<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\ArticlesCategories;
use App\Models\AttributeValues;
use App\Models\ProductOptions;
use App\Models\ProductsCategories;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class CreateSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sitemap = App::make('sitemap');
        // add home pages
        $sitemap->add(route('home'), Carbon::now(), 1, 'daily');

        //product_cat
        $product_cats = ProductsCategories::select('id','slug','updated_at')->where(['is_visible' => 1,'parent_id'=>null])->orderBy('created_at', 'desc')->get();
        foreach ($product_cats as $cat) {
            $name = $cat->slug.'-i.'.$cat->id;
            $sitemap->add(route('home').'/sitemaps/'.$name.'.xml', Carbon::now(), 1, 'daily');
            //product
            $name_site = App::make('sitemap');
            $products = ProductOptions::with(['product' => function ($query) {
                    $query->select('id','slug');
                }])->whereHas('product', function ($query) use ($cat) {
                    $query->select('id','title','slug','category_path')->where('active', 1)->where('category_path', 'LIKE', '%'.$cat->id.'%');
                })
                ->select('product_options.id','product_options.sku', 'product_options.slug')
                ->where('product_options.sku','!=',null)
                ->where('product_options.slug','!=',null)
                ->join('products', 'product_options.parent_id', '=', 'products.id')
                ->orderBy('product_options.id', 'DESC')
                ->get();
            foreach ($products as $item){
                if ($item->slug && $item->sku){
                    $name_site->add(route('detailProduct',['slug'=>$item->slug,'sku'=>$item->sku]), Carbon::now(), 1, 'daily');
                }
            }
            $name_site->add(route('catProduct',['slug'=>$cat->slug,'id'=>$cat->id]), Carbon::now(), 1, 'daily');
            $name_site->store('xml', 'sitemaps/'.$name);
            if (File::exists(public_path('sitemaps/'.$name.'.xml'))) {
                chmod(public_path('sitemaps/'.$name.'.xml'), 0777);
            }
        }

        //brand
        $sitemap->add(route('home').'/sitemaps/brand.xml', Carbon::now(), 1, 'daily');
        $sitemap_brand = App::make('sitemap');
        $sitemap_brand->add(route('homeBrand'), Carbon::now(), 1, 'daily');
        $brands = AttributeValues::select('id','slug')->where('attribute_id', 19)->orderBy('name','DESC')->get();
        foreach ($brands as $brand){
            $sitemap_brand->add(route('detailBrand',['slug'=>$brand->slug,'id'=>$brand->id]), Carbon::now(), 1, 'daily');
        }
        $sitemap_brand->store('xml', 'sitemaps/brand');
        if (File::exists(public_path('sitemaps/brand.xml'))) {
            chmod(public_path('sitemaps/brand.xml'), 0777);
        }

        //article
        $sitemap->add(route('home').'/sitemaps/blog.xml', Carbon::now(), 1, 'daily');
        $sitemap_blog = App::make('sitemap');
        $sitemap_blog->add(route('homeArticle'), Carbon::now(), 1, 'daily');
        $articles = Article::select('id','slug')->where('active', 1)->orderBy('id','DESC')->get();
        foreach ($articles as $article){
            $sitemap_blog->add(route('detailArticle',['slug'=>$article->slug,'id'=>$article->id]), Carbon::now(), 1, 'daily');
        }
        $article_cats = ArticlesCategories::select('id','slug')->where('active', 1)->orderBy('id','DESC')->get();
        foreach ($article_cats as $article_cat){
            $sitemap_blog->add(route('catArticle',['slug'=>$article_cat->slug,'id'=>$article_cat->id]), Carbon::now(), 1, 'daily');
        }
        $sitemap_blog->store('xml', 'sitemaps/blog');
        if (File::exists(public_path('sitemaps/blog.xml'))) {
            chmod(public_path('sitemaps/blog.xml'), 0777);
        }

        // save file and permission
        $sitemap->store('xml', 'sitemap');
        if (File::exists(public_path('sitemap.xml'))) {
            chmod(public_path('sitemap.xml'), 0777);
        }
    }
}
