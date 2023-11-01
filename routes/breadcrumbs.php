<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Trang chủ', route('home'), ['icon' => 'fa-solid fa-house-chimney']);
});

// Home > Page
Breadcrumbs::for('detailPage', function ($trail, $page) {
    $trail->parent('home');
    $trail->push($page->title, route('detailPage',['slug' => $page->slug]));
});

// Home > Blog[Danh-muc]
Breadcrumbs::for('catArticle', function ($trail,$cats) {
    $trail->parent('home');
    $trail->push($cats->title, route('catArticle',['slug' => $cats->slug, 'id' => $cats->id]));
});

// Home > Blog[Danh-muc] > [Title]
Breadcrumbs::for('detailArticle', function ($trail,$parent_cat,$article) {
    $trail->parent('home');
    if ($parent_cat->id == $article->category->id){
        $trail->push($parent_cat->title, route('catArticle',['slug' => $parent_cat->slug, 'id' => $parent_cat->id]));
    }else{
        $trail->push($parent_cat->title, route('catArticle',['slug' => $parent_cat->slug, 'id' => $parent_cat->id]));
        $trail->push($article->category->title, route('catArticle',['slug' => $article->category->slug, 'id' => $article->category->id]));
    }
    $trail->push($article->title, route('detailArticle',['slug' => $article->slug, 'id' => $article->id]));
});

// Home > Thương hiệu
Breadcrumbs::for('homeBrand', function ($trail) {
    $trail->parent('home');
    $trail->push('Thương hiệu', route('homeBrand'));
});

// Home > Thương hiệu > Brand
Breadcrumbs::for('detailBrand', function ($trail, $brand) {
    $trail->parent('home');
    $trail->push('Thương hiệu', route('homeBrand'));
    $trail->push($brand->name, route('detailBrand',['slug' => $brand->slug, 'id' => $brand->id]));
});

// Home > Danh mục > [Category]
Breadcrumbs::for('catProduct', function ($trail, $category) {
    $trail->parent('home');
    $trail->push('Danh mục', route('catProduct', ['slug'=>$category->slug,'id'=>$category->id]));
    $trail->push($category->title, route('catProduct', ['slug'=>$category->slug,'id'=>$category->id]));
});

// Home > [Category...] > [Product]
Breadcrumbs::for('detailProduct', function ($trail, $product,$list_cats) {
    $trail->parent('home');
    foreach ($list_cats as $item){
        if (!empty($item->slug) && !empty($item->id)){
            $trail->push($item->title, route('catProduct', ['slug'=>!empty($item->slug)?trim($item->slug):'','id'=>$item->id]));
        }else{
            $trail->push($item->title);
        }
    }
    $trail->push($product->title);
});

// Home > Tìm kiếm > Từ khóa: [Keyword]
Breadcrumbs::for('search', function ($trail, $keyword) {
    $trail->parent('home');
    $trail->push('Tìm kiếm');
    $trail->push('Từ khóa: '.$keyword, route('search'));
});
