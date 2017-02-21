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
use Models\Customer;
use Utils\Utility;

class CustomerController extends BaseController
{



    public  function numberOfCustomers(Request $request,Response $response,$args) {
        try{
            $user = $this->user;
            $user_id = $user['id'];
            $number = Customer::numberOfCustomers($user_id);
            return $response->withJson(Utility::setSuccessMessage('', $number));
        }catch (\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('107', $e->getMessage()));
        }
    }

    public  function getNoOfConversations (Request  $request,Response $response, $args) {
        try{
            $customer_id = $args['customer_id'];
            if(isset($customer_id)) {
               $count = Customer::numberOfConversations($customer_id);
                 return $response->withJson(Utility::setSuccessMessage('', $count));
            }

        }catch (\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('107', $e->getMessage()));
        }
    }
    public function getAllCustomers(Request $request,Response $response) {
        try{
          $user = $this->user;
          $user_id = $user['id'];
          $customers = Customer::getUserCustomers($user_id);
          if($customers){
              $user_customers = $customers->toArray();
              return $response->withJson(Utility::setSuccessMessage('Fetched all customers succesfully', $user_customers));
          }
        }catch(\Exception $e){
            return $response->withJson(Utility::setErrorMessage('101',$e->getMessage()));
        }
    }

    public function addCustomer(Request $request,Response $response,$args) {
        try{
            $user = $this->user;
            $customerData = $request->getParsedBody();
            $valid = Utility::validateInput($customerData,['customer_name','phone_number','email','address']);
            if(empty($valid)) {
                $customerData['user_id'] = $user['id'];
                $newCustomer = Customer::addCustomer($customerData);
                if(!empty($newCustomer)) {
                    $customer = $newCustomer->toArray();
                    return $response->withJson(Utility::setSuccessMessage('Customer added succesfully',$customer));
                }
                else{
                    return $response->withJson(Utility::setErrorMessage('101','Customer couldn\'t be added'));
                }
            }
            else{
                return $response->withJson(Utility::setErrorMessage('101','You have to fill in all require fields'));
            }
        }catch (\Exception $e){
            return $response->withJson(Utility::setErrorMessage('101',$e->getMessage()));
        }
    }


    public  function  getCustomerDetails(Request $request, Response $response , $args) {
        try{
            $customer_id = $args['customer_id'];
            if(isset($customer_id)) {
                $customer_details = Customer::getCustomerDetails($customer_id);
                if(!empty($customer_details)) {
                    $details = $customer_details->toArray();
                    return $response->withJson(Utility::setSuccessMessage('Details fetched succesfully',$details));
                }
                else{
                    return $response->withJson(Utility::setErrorMessage('102','Couldn\'t fetch the details of the specified customer or customer doesnt exist'));
                }
            }
        }catch (\Exception $e){
            return $response->withJson(Utility::setErrorMessage('101',$e->getMessage()));
        }
    }

    public  function  deleteCustomer(Request $request, Response $response , $args) {
        try{
           $customer_id = $request->getParsedBody();
           if($customer_id) {
               $delete = Customer::deleteCustomer($customer_id);
               if($delete){
                   return $response->withJson(Utility::setSuccessMessage('Customer deleted successfully',''));
               }
               else{
                   return $response->withJson(Utility::setErrorMessage('102','Customer doesnt exist'));
               }
           }
           else{
               return $response->withJson(Utility::setErrorMessage('102','You have to specify a customer_id, to delete one'));
           }
        }catch (\Exception $e){
            return $response->withJson(Utility::setErrorMessage('101',$e->getMessage()));
        }
    }

    public  function updateCustomer(Request $request,Response $response,$args) {
        try{
            $update = $request->getParsedBody();
            if(count($update) > 0) {
                $updated = Customer::updateCustomer($update);
                    if($updated == true) {
                        return $response->withJson(Utility::setSuccessMessage('Customer updated successfully',''));
                    } else{
                        return $response->withJson(Utility::setErrorMessage('103','Couldn\'t update Customer successfully',''));
                    }
                }
                else{
                    return $response->withJson(Utility::setErrorMessage('Customer deleted successfully','You didn\'t specify any change'));
                }

            }


        catch(\Exception $e) {
            return $response->withJson(Utility::setErrorMessage('103',$e->getMessage()));
        }
    }


}