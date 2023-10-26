<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'), ['icon' => 'home.png']);
});

// Home > About
Breadcrumbs::for('about', function ($trail) {
    $trail->parent('home');
    $trail->push('About', route('about'));
});

// Home > Blog
Breadcrumbs::for('homeArticle', function ($trail) {
    $trail->parent('home');
    $trail->push('Blog', route('homeArticle'));
});

// Home > Blog > [Category]
Breadcrumbs::for('category', function ($trail, $category) {
    $trail->parent('homeArticle');
    $trail->push($category->title, route('catArticle', ['slug'=>$category->slug,'id'=>$category->id]));
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
    $trail->parent('category', $post->category);
    $trail->push($post->title, route('post', $post->id));
});
