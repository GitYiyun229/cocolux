<?php
return [
    "page"    =>  "trang/{slug}",
    "article"  =>  [
        "cat" => 'danh-muc-tin/{slug}',
        "detail" => 'chi-tiet-tin/{slug}/{id}',
    ],
    "contact"    =>  'lien-he',
    "album"    =>  'hinh-anh',
    "video"    =>  'video',
    "store"    =>  'he-thong-cua-hang',
    "product"    =>  [
        'home' => 'thuc-don',
        'cat' => 'thuc-don/{slug}',
        'detail' => 'thuc-don/{slugCat}/{slug}',
    ],
    'cart' => [
        'home' => 'cart',
        'delete' => 'xoa-san-pham/{id}',
        'success' => 'dat-hang-thanh-cong/{id}',
    ],
];
