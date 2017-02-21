<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/30/17
 * Time: 4:57 PM
 */

namespace Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Models\Todo;
use Utils\Utility;
class TodoController extends BaseController
{


    public  function numberOfTodos(Request $request,Response $response,$args) {
        try{
            $user = $this->user;
            $user_id = $user['id'];
            $number = Todo::numberOfTodo($user_id);
            return $response->withJson(Utility::setSuccessMessage('Fetched', $number));
        }catch (\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('107', $e->getMessage()));
        }
    }
    public  function addNewTodo(Request $request,Response $response, $args) {
        try{
            $user = $this->user;
            $user_id = $user['id'];
           $details = $request->getParsedBody();
           $details['todo']['user_id'] = $user_id;
           if($details) {
               $valid = Utility::validateInput($details['todo'],['description','color_name','time']);
               if(empty($valid)) {
                  $new_todo = Todo::addTodo($details['todo']);
                  if(!empty($new_todo)) {
                      $new_task = $new_todo->toArray();
                      return $response->withJson(Utility::setSuccessMessage('Todo added succesfully',$new_task));
                  }
                  else{
                      return $response->withJson(Utility::setErrorMessage('102','Could not add task'));
                  }
               }
               else{
                   return $response->withJson(Utility::setErrorMessage('102','You have to fill in all required fields'));
               }
           }
           else{
               return $response->withJson(Utility::setErrorMessage('102','You have to fill in all required fields'));
           }
        }
        catch(\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('102',$e->getMessage()));
        }
    }

    public  function UpdateStatus(Request $request,Response $response,$args) {
        try{
            $update = $request->getParsedBody();
            if($update) {
                $details_id = $update['todo_id'];
                $category_id = $update['status_id'];

                    $updated = Todo::updateStatus($details_id,$category_id);
                    if($updated == true) {
                        return $response->withJson(Utility::setSuccessMessage('Successfully',''));
                    }
                    else{
                        return $response->withJson(Utility::setErrorMessage('105','Couldn\'t update todo '));
                    }
            }
            else{
                return $response->withJson(Utility::setErrorMessage('105','You hav to specify details '));
            }

        }catch(\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('105',$e->getMessage()));
        }
    }

    public  function getUserTodos(Request $request,Response $response, $args) {
        try{
            $user = $this->user;
            $user_id = $user['id'];
            if($user_id) {
                $todos = Todo::allUserTodos($user_id);
                if(!empty($todos)) {
                    $all_todos = $todos->toArray();
                    return $response->withJson(Utility::setSuccessMessage('Successfuly',$all_todos));
                }
                else{
                    return $response->withJson(Utility::setErrorMessage('102','Didnt get any task for the specified user'));
                }
            }
            else{
                return $response->withJson(Utility::setErrorMessage('102','You have to specify a user'));
            }
        }
        catch(\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('102',$e->getMessage()));
        }
    }


    public  function deleteTodo(Request $request,Response $response,$args) {
        try{
            $todo_id = $request->getParsedBody();
            if($todo_id['todo_id']) {
                $delete_todo = Todo::deleteTodo($todo_id['todo_id']);
                if($delete_todo == true) {
                    return $response->withJson(Utility::setSuccessMessage('Todo deleted Successfuly',''));
                }
                else{
                    return $response->withJson(Utility::setErrorMessage('102','Culdnot delete Todo or Todo doesnt exist'));
                }
            }
            else{
                return $response->withJson(Utility::setErrorMessage('102','You have to specify a todo'));
            }
        }catch(\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('103',$e->getMessage()));
        }
    }
}