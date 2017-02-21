<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 2/5/17
 * Time: 7:56 PM
 */

namespace Models;
use Illuminate\Database\Eloquent\Model as Emodel;

class Category extends  Emodel
{
    protected  $guarded = ['id','name'];

    public  static function allCategories() {
        $categories = Category::all();
        return $categories;
    }

}