/**
 * Created by itunu.babalola on 2/2/17.
 */
!function() {
    var customerService = angular.module('ContactApp.services');

    customerService.service('CustomerService',['$resource',function ($resource) {
        var req1 = $resource('/api/customer/:customer_id/:req_action',{},{
            getDetails : {
                method: 'GET',
                isArray:false,
                params:{
                customer_id:'@customer_id',
                req_action: 'details'
                }
            },
            deleteCustomer: {
                method : 'POST',
                isArray:false,
                params : {
                    customer_id : '@customer_id',
                    req_action : 'delete'
                }

            },
            addConversation : {
                method: 'POST',
                isArray: false,
                params :{
                    customer_id :'@customer_id',
                    conversation :'@conversation',
                    req_action : 'add_conversation'
                }
            },
            getConversations :{
                method :'GET',
                isArray:false ,
                params :{
                    customer_id :'@customer_id',
                    req_action :'get_conversation'
                }
            },
            updateConversation : {
                method :'POST' ,
                isArray :false ,
                params : {
                    conversation : '@conversation' ,
                    customer_id :'@customer_id',
                    req_action :'update_conversation'
                }
            },
            getNoOfConversations : {
                method: 'GET' ,
                isArray : false,
                params : {
                    customer_id :'@customer_id',
                    req_action :'get_no_of_conversations'
                }
            }

        });

        return{
            getDetails:getDetails,
            deleteCustomer:deleteCustomer,
            addConversation:addConversation,
            getConversations:getConversations,
            updateConversation:updateConversation,
            getNoOfConversations:getNoOfConversations
        };

        function getDetails(params) {
            return req1.getDetails(params).$promise;
        }
         function  deleteCustomer(params) {
            return req1.deleteCustomer(params).$promise;
         }
         function addConversation(params) {
             return req1.addConversation(params).$promise;
         }
         function getConversations(params) {
             return req1.getConversations(params).$promise;
         }
         function updateConversation(params) {
             return req1.updateConversation(params).$promise;
         }
         function getNoOfConversations(params) {
             return req1.getNoOfConversations(params).$promise;
         }

    }]);
}();