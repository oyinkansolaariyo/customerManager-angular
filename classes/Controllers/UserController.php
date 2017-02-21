<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/30/17
 * Time: 4:58 PM
 */

namespace Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Models\User;
use Utils\Utility;

class UserController extends BaseController
{
    public  function index(Request $request,Response $response, $args)
    {
        $this->container->renderer->render($response,'login.phtml',[]);
        return $response;
    }

    public  function register(Request $request,Response $response, $args)
    {
        $this->container->renderer->render($response,'register.phtml',[]);
        return $response;
    }

    public  function logout(Request $request,Response $response, $args)
    {
        Utility::unsetSessions();
        return $response->withJson(Utility::setSuccessMessage('100','loggedout'));

    }

    public function loginHandler(Request $request,Response $response, $args) {
        try{
            $loginRequest = $request->getParsedBody();
            $valid =  Utility::validateInput($loginRequest,['email','password']);
           if(empty($valid)) {
               $login = User::login($loginRequest);
               if(!empty($login)) {
                   $loginData = $login->toArray();
                   $valid = password_verify($loginRequest['password'],$loginData['password']);
                   if($valid){
                       unset($loginData['password']);
                       Utility::setSession('user', $loginData);
                       Utility::registerSession();
                       return $response->withStatus(302)->withHeader('location', '/');
                   }
                   else{
                       Utility::setFlashMessage(Utility::setErrorMessage('302','Couldn\'t find the user'));
                       return $response->withStatus(302)->withHeader('location', '/login');
                   }
               }else {
                   Utility::setFlashMessage(Utility::setErrorMessage('302','Invalid credentials. please check and try again.'));
                   return $response->withStatus(302)->withHeader('location', '/login');
               }

           }else {
               Utility::setFlashMessage(Utility::setErrorMessage('302','Please fill in the appropriate fields.'));
               return $response->withStatus(302)->withHeader('location', '/login');
           }
        }
        catch (\Exception $e){
            return $response->withJson(Utility::setErrorMessage('302',$e->getMessage()));
        }

    }

    public function creationHandler(Request $request,Response $response, $args) {
        try{

            $newUser = $request->getParsedBody();
            $valid = Utility::validateInput($newUser,['user_name','email','password']);
            if(empty($valid)){
                $newUser['password'] = password_hash($newUser['password'],PASSWORD_BCRYPT);
                $new = User::createUser($newUser);
                if($new && !empty($new)){
                    $newData = $new->toArray();
                    unset($newData['password']);
                    Utility::setSession('user', $newData);
                    Utility::registerSession();
                    Utility::setFlashMessage('User added succesfully');
                    return $response->withStatus(302)->withHeader('location', '/');
                }
                else{

                    Utility::setFlashMessage(Utility::setErrorMessage('302','Couldn\'t add user successfully'));
                    return $response->withStatus(302)->withHeader('location', '/register');
                }
            }else{
                Utility::setFlashMessage(Utility::setErrorMessage('302','You didnt fill all required fields, please check again'));
                return $response->withStatus(302)->withHeader('location', '/register');

            }

        }
        catch (\Exception $e){
            Utility::setFlashMessage(Utility::setErrorMessage('302','Please check your mail, This email already exist'));
            return $response->withStatus(302)->withHeader('location', '/register');

        }


    }




}