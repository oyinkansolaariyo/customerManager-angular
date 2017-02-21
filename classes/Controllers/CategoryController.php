<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 2/5/17
 * Time: 11:20 PM
 */

namespace Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Models\Category;
use Utils\Utility;
class CategoryController extends BaseController
{
    public  function getAllCategories(Request $request,Response $response, $args) {
        try{
            $categories = Category::allCategories();
            if($categories)
            {
                $all_categories = $categories->toArray();
                return $response->withJson(Utility::setSuccessMessage('All categories fetched successfully',$all_categories));

            }
            else{
                return $response->withJson(Utility::setErrorMessage('105','Couldnot fetch categories'));
            }
        }catch (\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('105',$e->getMessage()));
        }
    }
}