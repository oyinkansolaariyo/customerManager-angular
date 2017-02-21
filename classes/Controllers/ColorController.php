<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 2/9/17
 * Time: 4:56 PM
 */

namespace Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Models\Color;
use Utils\Utility;


class ColorController extends BaseController
{
    public  function getColors(Request $request,Response $response,$args)
    {
        try{
           $all_colors = Color::getAllColors();
           if($all_colors){
               return $response->withJson(Utility::setSuccessMessage('Colors fetched successfully',$all_colors));
           }
           else{
               return $response->withJson(Utility::setErrorMessage('101','Couldnot fetch colors'));
           }
        }catch (\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('101',$e->getMessage()));
        }
    }
}