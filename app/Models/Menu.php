<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Menu extends Model
{
    use HasFactory;
    use NodeTrait;
    public $table = "menu";
    protected $fillable = ['name', 'link', 'parent_id','category_id'];
    protected $guarded = ['id', '_lft', '_rgt'];

    public function category()
    {
        return $this->belongsTo(MenuCategory::class,'category_id','id')->where('id',1);
    }
}
