<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/30/17
 * Time: 4:46 PM
 */

namespace Models;
use Illuminate\Database\Eloquent\Model as EModel;

class User extends EModel
{

    protected  $fillable =['user_name','email','password','status_id'];
    protected  $guarded = ['id'];
    public  function customer()
    {
        return $this->hasMany('Models\Customer');
    }

    public function conversation()
    {
        return $this->hasMany('Models\Conversation');
    }

    public function todo()
    {
        return $this->hasMany('Models\Todo');
    }

    public function appointment()
    {
        return $this->hasMany('Models\Appointment');
    }


    public static function createUser(array $user)
    {
        $newuser = new User($user);
        $newuser->save();
        return $newuser;
    }

    public static function login($user)
    {
        $loginUser = User::where('email',$user['email'])->where('status_id',1)->first();
       return $loginUser;
    }
}