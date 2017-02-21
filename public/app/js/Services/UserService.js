/**
 * Created by itunu.babalola on 1/30/17.
 */
'use strict';
!function() {
    var userService = angular.module('ContactApp.services');
     userService.service('UserService',['$resource',function ($resource) {
         var req1 = $resource('/api/:req_action',{},{
             addCustomer : {
                 method: 'POST',
                 params :{
                     req_action :'add_customer'
                 }
             }
             ,
             allUserCustomers : {
                 method: 'GET' ,
                 isArray: false,
                 params :{
                     req_action : 'get_customer'
                 }
             },

             addTodo : {
                 method: 'POST' ,
                 isArray : false,
                 params : {
                     req_action: 'add_todo'
                 }
             },

             getColors : {
                 method: 'GET' ,
                 isArray :false,
                 params : {
                     req_action:'colors'
                 }
             },
             getUserTodos :{
                 method: 'GET' ,
                 isArray : false,
                 params : {
                     req_action :'get_user_todos'
                 }
             },
             updateCustomer : {
                 method : 'POST' ,
                 isArray : false ,
                 params : {
                     customer: '@customer',
                     req_action :'update_customer'
                 }
             },

             getNoTodos : {
                 method :'GET' ,
                 isArray : false,
                 params : {
                     req_action :'get_no_todos'
                 }
             },

             getNoAppointments : {
                 method: 'GET' ,
                 isArray : false,
                 params : {
                     req_action : 'get_no_appointments'
                 }
             },
             getNoConversation : {
                 method: 'GET' ,
                 isArray : false,
                 params : {
                     req_action : 'get_no_conversations'
                 }
             },
             getNoCustomers : {
                 method: 'GET' ,
                 isArray : false,
                 params : {
                     req_action : 'get_no_customers'
                 }
             }

         });

         var req3 = $resource('/api/todo/:todo_id/:req_action',{},{
             deleteTodo : {
                 method :'POST',
                 isArray :false,
                 params : {
                     todo_id :'@todo_id',
                     req_action:'delete'

                 }
             },

             updateTodoStatus : {
                 method :'POST' ,
                 isArray : false,
                 params : {
                     todo_id :'@todo_id',
                     req_action : 'update'
                 }
             }
         });



         var req2 = $resource('/logout' , {} ,{
             logout : {method :'GET'}
         });



         return{
             addCustomer:addCustomer,
             allCustomers:allCustomers,
             logout:logout,
             addTodo:addTodo,
             getColors:getColors,
             getUserTodos:getUserTodos,
             deleteTodo:deleteTodo,
             updateCustomer:updateCustomer,
             getNoTodos:getNoTodos,
             updateTodoStatus:updateTodoStatus,
             getNoAppointments:getNoAppointments,
             getNoConversation:getNoConversation,
             getNoCustomers:getNoCustomers
         };

         function addCustomer(params) {
             return req1.addCustomer(params).$promise;
         }
         function allCustomers() {
             return req1.allUserCustomers().$promise;
         }
         function logout() {
             return req2.logout().$promise;
         }
         function addTodo(params) {
             return req1.addTodo(params).$promise;
         }
         function getColors() {
             return req1.getColors().$promise;
         }
         function getUserTodos() {
             return req1.getUserTodos().$promise;
         }
         function deleteTodo(params) {
             return req3.deleteTodo(params).$promise;
         }
         function updateCustomer(params) {
             return req1.updateCustomer(params).$promise;
         }
         function getNoTodos() {
             return req1.getNoTodos().$promise;
         }
         function updateTodoStatus(params) {
             return req3.updateTodoStatus(params).$promise;
         }
         function getNoAppointments() {
             return req1.getNoAppointments().$promise;
         }
         function getNoConversation() {
             return req1.getNoConversation().$promise;
         }
         function getNoCustomers() {
             return req1.getNoCustomers().$promise;
         }
     }]);

}();