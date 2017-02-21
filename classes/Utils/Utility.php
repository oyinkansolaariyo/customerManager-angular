<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/31/17
 * Time: 11:04 AM
 */

namespace Utils;


class Utility
{
    public  static  function setSession($key,$value= null)
    {
        if($key != null && $value != null){
            $_SESSION[$key] = serialize($value);
            return $value;
        }
        elseif ($value == null){
            return unserialize($_SESSION[$key]);
        }
        else{
            return false;

        }
    }

    public static function setFlashMessage($message) {
        self::setSession('message', $message);
    }

    public static function getFlashMessage() {
        $msg = self::setSession('message');
        self::unsetSessions('message');
        return $msg;
    }

    public  static  function isLoggedIn()
    {
        return self::setSession('loggedin');
    }

    public static  function  registerSession()
    {
        return self::setSession('loggedin',true);
    }

    public static function validateInput(array $input, array $compulsoryFields) {
        if(empty($input)){
            return ['Input Fields cannot be empty'];
        }
        $keys = array_keys($input);
        foreach($compulsoryFields as $field){
            if(!in_array($field,$keys) || strlen(trim($input[$field])) == 0){
                return [$field.' cannot be empty'];
            }

        }
        return [];

    }

    public static function unsetSessions($key = null) {
        if($key) {
            unset($_SESSION[$key]);
        }else{
            session_destroy();
        }
    }

    public static  function setErrorMessage($code,$message){
        $displayMessage = [
            'status'=>'error',
            'data' =>[
                'code'=> $code,
                'message' => $message
            ]

        ];
        return $displayMessage;
    }

    public  static  function setSuccessMessage($message,$response){
        $displayMessage = [
            'status'=>'success',
            'data'=>[
                'message'=> $message,
                'response'=>$response
            ]
        ]  ;
        return $displayMessage;
    }





}