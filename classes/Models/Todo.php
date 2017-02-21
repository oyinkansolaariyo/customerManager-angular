<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/30/17
 * Time: 4:47 PM
 */

namespace Models;

use Illuminate\Database\Eloquent\Model as EModel;
class Todo extends EModel
{

    protected $fillable = ['description','user_id','status_id','color_name','time'];
    protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo('Models\User');
    }

    public static function numberOfTodo($user_id){
        $count = Todo::where('user_id',$user_id)->count();
        return $count;
    }

    public  static  function addTodo($todo)
    {
        $new_todo = new Todo($todo);
        $new_todo->save();
        return $new_todo;
    }

    public  static function updateStatus($todo_id,$status_id) {
        $update = Todo::where('id',$todo_id)->first()->update(['status_id' => $status_id]);
        if ($update) {
            return true;
        }
        else {
            return false;
        }

    }

    public  static function deleteTodo($todo_id) {
        $delete  =Todo::destroy($todo_id);
        if($delete) {
            return true;
        }
        else{
            return false;
        }
    }


    public  static  function allUserTodos($user_id) {
        $todo = Todo::where('user_id',$user_id)->get();
        return $todo;
    }


}