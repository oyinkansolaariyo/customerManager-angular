<?php

/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/30/17
 * Time: 4:45 PM
 */
namespace Models;
use Illuminate\Database\Eloquent\Model as EModel;

class Appointment extends EModel
{
    protected  $fillable = ['description','conversation_id','status_id','appointment_date','from_time','to_time','whom_to_see'];
    protected  $guarded = ['id'];


    public function conversation()
    {
        return $this->belongsTo('Models\Conversation');
    }

    public static function numberOfAppointments(){
        $count = Appointment::count();
        return $count;
    }

    public static function AddAppointment($appointment)
    {
        $new_appointment = new Appointment($appointment);
        $new_appointment->save();
        return $new_appointment;
    }

    public  static function allAppointments($conversation_id)
    {
       $all_appointments =  Appointment::where('conversation_id',$conversation_id)->get();
       return $all_appointments;
    }

    public static  function updateAppointmentStatus($appointment_id,$new_status) {
        $appointment = Appointment::where('id',$appointment_id)->update(['status_id'=> $new_status]);
        if($appointment) {
            return true;
        }
        else {
            return false;
        }
    }
}