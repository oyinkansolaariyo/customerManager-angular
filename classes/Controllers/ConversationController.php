<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/30/17
 * Time: 4:56 PM
 */

namespace Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Models\Conversation;
use Utils\Utility;
use Models\Customer;


class ConversationController extends BaseController
{
    public  function addConversation(Request $request,Response $response,$args)
    {
        try{
            $user = $this->user;
            $user_id = $user['id'];
            $conversation = $request->getParsedBody();
            $conversation['user_id'] = $user_id;
            $valid = Utility::validateInput($conversation,['subject','customer_id']);
            if(empty($valid))
            {
                $newConversation = Conversation::addConversation($conversation);
                Customer::where('id',$user_id)->increment('conversation_count');
                if($newConversation){
                    $new_conversation = $newConversation->toArray();
                    return $response->withJson(Utility::setSuccessMessage('Conversation added succesfully',$new_conversation));
                }
                else{
                    return $response->withJson(Utility::setErrorMessage('102','Couldn\'t add a conversation for the specified user'));
                }
            }
            else{
                return $response->withJson(Utility::setErrorMessage('102','Please enter a subject for the conversation'));
            }
        }catch(\Exception $e){
            return $response->withJson(Utility::setErrorMessage('102',$e->getMessage()));
        }
    }

    public  function getCustomerConversations(Request $request, Response $response,$args)
    {
        try{
          $customer_id = $args['customer_id'];
          if(isset($customer_id))
          {
              $customer_conversations = Conversation::getCustomerConversations($customer_id);
              if($customer_conversations){
                  $conversations = $customer_conversations->toArray();
                  return $response->withJson(Utility::setSuccessMessage('Conversations fetchd succesfully succesfully',$conversations));
              }
              else{
              return $response->withJson(Utility::setErrorMessage('102','Couldn\'t find conversations for the specified user'));
             }
          }
          else{
              return $response->withJson(Utility::setErrorMessage('102','Please choose a customer'));
          }
        }catch(\Exception $e){
            return $response->withJson(Utility::setErrorMessage('102',$e->getMessage()));
        }
    }


    public  function getConversation(Request $request, Response $response, $args)
    {
        try{
            $conversation_id = $args['conversation_id'];
            if(isset($conversation_id)) {
                $conversation = Conversation::getConversation($conversation_id);
                if($conversation) {
                    $fetched_conversation =  $conversation->toArray();
                    return $response->withJson(Utility::setSuccessMessage('Conversation fetched succesfully succesfully',$fetched_conversation));
                }
                else{
                    return $response->withJson(Utility::setErrorMessage('105','Couldn\'t find conversation with the specified id'));
                }
            }
            else{
                return $response->withJson(Utility::setErrorMessage('105','Please specify a conversation'));
            }
        }catch(\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('102',$e->getMessage()));
        }
    }



    public  function updateConversation(Request $request,Response $response,$args) {
        try{
            $updates = $request->getParsedBody();
            if($updates) {
                $update_conversation = Conversation::updateConversation($updates['conversation']);
                if($update_conversation == true) {
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


    public  function numberOfConversations(Request $request,Response $response,$args) {
        try{
            $user = $this->user;
            $user_id = $user['id'];
            $number = Conversation::numberOfConversations($user_id);
            return $response->withJson(Utility::setSuccessMessage('', $number));
        }catch (\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('107', $e->getMessage()));
        }
    }







}