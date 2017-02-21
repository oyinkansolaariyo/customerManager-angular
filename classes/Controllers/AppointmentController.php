<?php

/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/30/17
 * Time: 4:54 PM
 */

namespace Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Models\Appointment;
use Models\Conversation;
use Utils\Utility;


class AppointmentController extends BaseController
{

    public  function numberOfAppointments(Request $request,Response $response,$args) {
        try{
            $number = Appointment::numberOfAppointments();
            return $response->withJson(Utility::setSuccessMessage('Appointment booked succesfully', $number));
        }catch (\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('107', $e->getMessage()));
        }
    }
    public  function bookAppointment(Request $request,Response $response,$args)
    {
        try {
            $appointment_details = $request->getParsedBody();
            if ($appointment_details) {
                $valid = Utility::validateInput($appointment_details, ['conversation_id', 'description', 'to_time', 'from_time', 'whom_to_see', 'appointment_date']);
                if (empty($valid)) {
                    $new_appointment = Appointment::AddAppointment($appointment_details);
                    if (!empty($new_appointment)) {
                        Conversation::where('id',$appointment_details['conversation_id'])->increment('appointment_count');
                        $appointment = $new_appointment->toArray();
                        return $response->withJson(Utility::setSuccessMessage('Appointment booked succesfully', $appointment));
                    } else {
                        return $response->withJson(Utility::setErrorMessage('107', 'Couldn\'t book appointment'));
                    }
                } else {
                    return $response->withJson(Utility::setErrorMessage('107', 'You have to fill in all require fields'));
                }
            }
            else{
                return $response->withJson(Utility::setErrorMessage('107', 'Please fill the form'));
            }
        }  catch (\Exception $e)
        {

            return $response->withJson(Utility::setErrorMessage('107', $e->getMessage()));
        }
    }


    public function allAppointments(Request $request,Response $response, $args)
    {
        try{
            $conversation_id = $request->getParsedBody();
            if($conversation_id) {
                $valid = Utility::validateInput($conversation_id,['conversation_id']);
                if(empty($valid)) {
                    $all_appointments = Appointment::allAppointments($conversation_id['conversation_id']);
                    if(!empty($all_appointments)) {
                        $appointments =  $all_appointments->toArray();
                        return $response->withJson(Utility::setSuccessMessage('All appointments fetched succesfully succesfully', $appointments));
                    }
                    else{
                        return $response->withJson(Utility::setErrorMessage('108', 'Couldn\'t fetch appointments'));
                    }
                } else {
                    return $response->withJson(Utility::setErrorMessage('108', 'You have to fill in all require fields'));
                }

            } else {
                return $response->withJson(Utility::setErrorMessage('108', 'Please fill the form'));
            }
        }
        catch(\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('108', $e->getMessage()));
        }
    }



    public  function updateAppointment(Request $request,Response $response,$args) {
        try{
            $update_details = $request->getParsedBody();
            if($update_details) {
                $valid = Utility::validateInput($update_details,['id','status_id']);
                if(empty($valid)) {
                    $update = Appointment::updateAppointmentStatus($update_details['id'],$update_details['status_id']);
                    if($update == true) {
                        return $response->withJson(Utility::setSuccessMessage('Appointment updated succesfully successfully', ''));
                    }
                    else{
                        return $response->withJson(Utility::setErrorMessage('109', 'Couldn\'t update appointment'));
                    }
                }
                else{
                    return $response->withJson(Utility::setErrorMessage('109', 'You have to fill in all require fields'));
                }
            }
            else{
                return $response->withJson(Utility::setErrorMessage('109', 'Please fill the form'));
            }

        } catch (\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('109', $e->getMessage()));
        }
    }


}