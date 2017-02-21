<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/30/17
 * Time: 4:48 PM
 */

namespace Models;
use Illuminate\Database\Eloquent\Model as EModel;

class Conversation extends EModel
{

    protected  $fillable = ['subject','customer_id','user_id','status_id','appointment_count'];
    protected  $guarded = ['id'];
    public  function  user()
    {
        return $this->belongsTo('Models\User');
    }
    public  function  customer()
    {
        return $this->belongsTo('Models\Customer');
    }

    public function conversationDetail()
    {
        return $this->hasMany('Models\conversationDetail');
    }


    public static function numberOfConversations($user_id){
        $count = Conversation::where('user_id',$user_id)->count();
        return $count;
    }

    public  static function addConversation( array $conversation) {
       $new_conversation =  new Conversation($conversation);
       $new_conversation->save();
       return $new_conversation;
    }

    public static function getCustomerConversations($customer_id) {
     $conversations = Conversation::where('customer_id',$customer_id)->get();
     return $conversations;
    }

    public  static  function getConversation($conversation_id) {
        $conversation = Conversation::where('id',$conversation_id)->first();
        return $conversation;
    }

    public static function  updateConversation($conversation) {
        $conversation = Conversation::where('id',$conversation['id'])->first()->update(['subject'=>$conversation['subject']]);
        if($conversation) {
            return true;
        }
        else{
            return false;
        }
    }
}