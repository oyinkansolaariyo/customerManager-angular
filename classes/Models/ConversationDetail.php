<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/30/17
 * Time: 4:49 PM
 */

namespace Models;

use Illuminate\Database\Eloquent\Model as EModel;

class ConversationDetail extends EModel
{
     protected  $fillable = ['text','conversation_id','category_id'];
     protected  $guarded = ['id'];
    public  function conversation()
    {
        return $this->belongsTo('Model\Conversation');
    }

    public  function category()
    {
        return $this->hasOne('Model\Category');
    }

    public  static  function addDetail(array $detail) {
        $new_detail = new conversationDetail($detail);
        $new_detail->save();
        return $new_detail;
    }


    public  static function getDetails($conversation_id) {
        $details = ConversationDetail::where('conversation_id',$conversation_id)->get();
        return $details;
    }


    public static function getDetailsByCategory($conversation_id,$category_id) {
        $details = ConversationDetail::where('conversation_id',$conversation_id)->where('category_id',$category_id)->get();
        return $details;
    }

    public  static function bulkDelete($details_id) {
         ConversationDetail::destroy($details_id['details_id']);
         return true;
    }

    public  static function updateCategory($detail_id,$category_id) {
       $update = ConversationDetail::where('id',$detail_id)->first()->update(['category_id' => $category_id]);
       if ($update) {
           return true;
       }
       else {
           return false;
       }

    }

    public  static function updateDetail($details) {
        $update = ConversationDetail::where('id',$details['id'])->first()->update(['text'=>$details['text']]);
        if ($update) {
            return true;
        }
        else {
            return false;
        }
    }

}