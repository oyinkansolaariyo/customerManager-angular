<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 2/9/17
 * Time: 4:56 PM
 */

namespace Models;

use Illuminate\Database\Eloquent\Model as EModel;
class Color extends EModel
{
    protected  $fillable =['id','color_name'];

    public  static  function getAllColors() {
        $all_colors = Color::all();
        return $all_colors;
    }
}