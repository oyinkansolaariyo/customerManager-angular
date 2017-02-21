<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 2/4/17
 * Time: 8:25 PM
 */

namespace Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Models\ConversationDetail;
use Models\Category;
use Utils\Utility;

class ConversationDetailController extends  BaseController
{
    public  function addDetail(Request $request, Response $response, $args) {
        try{
            $detail = $request->getParsedBody();
            $valid = Utility::validateInput($detail,['text','conversation_id','category_id']);
            if(empty($valid)) {
                $new_details = ConversationDetail::addDetail($detail);
                if($new_details) {
                    $new_detail = $new_details->toArray();
                    return $response->withJson(Utility::setSuccessMessage('Detail added succesfully',$new_detail));
                }
                else{
                    return $response->withJson(Utility::setErrorMessage('103','Couldnt add a new detail to the conversation, or conversation not found'));
                }
            }
            else{
                return $response->withJson(Utility::setErrorMessage('103','You have to fill in all required fields'));
            }
        }catch(\Exception $e){
            return $response->withJson(Utility::setErrorMessage('103',$e->getMessage()));
        }

    }


    public  function getConversationDetails(Request $request,Response $response,$args) {
        try{
            $conversation_id = $args['conversation_id'];
            if($conversation_id) {
                $details = ConversationDetail::getDetails($conversation_id);
                if($details) {
                    $all_details = $details->toArray();
                    return $response->withJson(Utility::setSuccessMessage('Details fetched successfully',$all_details));
                }
                else{
                    return $response->withJson(Utility::setErrorMessage('104','Couldn\'t  fetch the details of the specified conversation'));
                }
            }
            else{
                return $response->withJson(Utility::setErrorMessage('104','You hav to specify a conversation '));
            }
        }catch(\Exception $e){
            return $response->withJson(Utility::setErrorMessage('104',$e->getMessage()));
        }
    }

    public  function getDetailsByCategory(Request $request,Response $response,$args) {
        try{

            $category = $request->getParsedBody();
            if( isset($category)) {
                $details = ConversationDetail::getDetailsByCategory($category['conversation_id'],$category['category_id']);
                if($details) {
                    $category_details = $details->toArray();
                    return $response->withJson(Utility::setSuccessMessage('Details fetched successfully',$category_details));
                }
                else{
                    return $response->withJson(Utility::setErrorMessage('105','Couldn\'t  fetch the details of the specified conversation'));
                }
            }
            else{
                return $response->withJson(Utility::setErrorMessage('105','You hav to specify a conversation '));
            }


        }catch (\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('105',$e->getMessage()));
        }
    }



    public  function bulkDeleteDetails(Request $request,Response $response,$args) {
        try{
            $details_id = $request->getParsedBody();
            if($details_id) {
               $deleted = ConversationDetail::bulkDelete($details_id);
               if($deleted == true) {
                   return $response->withJson(Utility::setSuccessMessage('Details deleted successfully',''));
               }
               else{
                   return $response->withJson(Utility::setErrorMessage('106','Couldn\'t delete the details,or  the details don\'t exist'));
               }

            }
            else{
                return $response->withJson(Utility::setErrorMessage('105','You hav to specify details '));
            }

        }catch(\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('105',$e->getMessage()));
        }
    }


    public  function bulkUpdateDetailsCategory(Request $request,Response $response,$args) {
        try{
            $update = $request->getParsedBody();
            $count = 0;
            if($update) {
                $no_of_details = count($update['details_id']);
                $details_id = $update['details_id'];
                $category_id = $update['category_id'];
                for ($i= 0; $i < $no_of_details; $i++) {
                    $updated = ConversationDetail::updateCategory($details_id[$i],$category_id);
                    if($updated == true) {
                        $count ++;
                    }
                }
                if($count ==  $no_of_details) {
                    return $response->withJson(Utility::setSuccessMessage($count.'Details updated successfully',''));
                }
                else{
                    $remaining = $no_of_details- $count;
                    return $response->withJson(Utility::setErrorMessage('106','Couldn\'t update '. $remaining .' details or  the details don\'t exist'));
                }
            }
            else{
                return $response->withJson(Utility::setErrorMessage('105','You hav to specify details '));
            }

        }catch(\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('105',$e->getMessage()));
        }
    }


    public  function updateDetail(Request $request,Response $response,$args) {
        try{
            $updates = $request->getParsedBody();
            if($updates) {
                $update_detail = ConversationDetail::updateDetail($updates['detail']);
                if($update_detail == true) {
                    return $response->withJson(Utility::setSuccessMessage('Conversation updated successfully',''));
                }
                else{
                    return $response->withJson(Utility::setErrorMessage('105','Couldn\t update conversation'));
                }
            }
            else{
                return $response->withJson(Utility::setSuccessMessage('105','You have to specify a conversation'));
            }

        }catch(\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('106',$e->getMessage()));
        }
    }



}