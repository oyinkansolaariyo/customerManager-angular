<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/30/17
 * Time: 4:48 PM
 */

namespace Models;

use Illuminate\Database\Eloquent\Model as EModel;
use Models\User;
class Customer extends EModel
{

    protected  $fillable = ['customer_name','phone_number' ,'email' ,'address' ,'user_id','conversation_id','status_id'];
    protected  $guarded = ['id'];
    public  function user()
    {
        return $this->belongsTo('Models\User');
    }

    public  function appointment()
    {
        return $this->hasMany('Models\Appointment');
    }

    public  function conversation()
    {
        return $this->hasMany('Models\Conversation');
    }

    public static function numberOfCustomers($user_id){
        $count = Customer::where('user_id',$user_id)->count();
        return $count;
    }

    public  static  function numberOfConversations($id) {
        $conversation_count = Customer::where('id',$id)->first()->toArray();
        return $conversation_count['conversation_count'];
    }

    public static function addCustomer(array $customer)
    {
        $model = new self($customer);
        $model->save();
        return $model;
    }

    public static function getUserCustomers($user_id)
    {
        $customers = Customer::where('user_id',$user_id)->get();
        return $customers;
    }

    public static function  getCustomerDetails($costumer_id)
    {
        $customer = Customer::where('id',$costumer_id)->first();
        return $customer;
    }

    public  static  function deleteCustomer($customer_id)
    {
        $deleted = Customer::destroy($customer_id);
        if($deleted){
            return true;
        }
        else{
            return false;
        }
    }

    public  static function updateCustomer($customer_updates)
    {
       $count = 0;
     $update_customer = Customer::where('id',$customer_updates['customer']['id'])->first();
        foreach($customer_updates['customer'] as $key=>$value) {
            $update_customer->update([$key=>$value]);
            $count++;
        }
       if($count == count($customer_updates['customer'])){
           return true;
       }
       else{
           return false;
       }

    }
}