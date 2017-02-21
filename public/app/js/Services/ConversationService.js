/**
 * Created by itunu.babalola on 2/5/17.
 */
'use strict';
!function () {
    var conversationService = angular.module('ContactApp.services');
    conversationService.service('ConversationService',['$resource', function ($resource) {
        var req1 = $resource('/api/conversation/:conversation_id/:req_action',{},{
            addDetail: {
                method: 'POST',
                isArray: false,
                params: {
                    conversation_id: '@conversation_id',
                    text:'@text',
                    category_id :'@category_id',
                    req_action: 'add_detail'
                }
            },

            getOneConversation :{
                method :'GET',
                isArray: false,
                params :{
                    conversation_id: '@conversation_id',
                    req_action: 'details'
                }
            },

            getAConversationsDetails :{
                method :'GET',
                isArray : false,
                params :{
                    conversation_id: '@conversation_id',
                    req_action: 'conversation_details'
                }
            },
            getDetailsByCategory : {
                method: 'POST' ,
                isArray : false ,
                params : {
                    category_id:'@category_id',
                    conversation_id: '@conversation_id',
                    req_action: 'category_conversation_details'
                }
            },

            bulkDeleteDetails : {
                method :'POST' ,
                isArray : false,
                params :{
                    details_id :'@details_id' ,
                    conversation_id: '@conversation_id',
                    req_action :'bulk_delete'
                }
            },

            bulkUpdateDetailsCategory : {
                method:'POST',
                isArray :false,
                params :{
                    details_id : '@details_id',
                    conversation_id :'@conversation_id',
                    category_id :'@category_id',
                    req_action :'bulk_update'
                }
            },

            bookAppointment : {
                method : 'POST',
                isArray : false,
                params : {
                    conversation_id :'@conversation_id',
                    appointment:'@appointment',
                    req_action :'book_appointment'
                }
            },

            allAppointments : {
                method: 'POST' ,
                isArray : false,
                params : {
                    conversation_id :'@conversation_id',
                    req_action : 'all_conversation_appointments'
                }
            },

            updateAppointment : {
                method :'POST' ,
                params : {
                    id :'@id',
                    status_id :'@status',
                    conversation_id: '@conversation_id',
                    req_action : 'update_appointment_status'
                }
            } ,
            updateDetails : {
                method : 'POST' ,
                params : {
                    conversation_id :'@conversation_id',
                    detail: '@detail',
                    req_action : 'update_detail'
                }
            }

        });

        var categories = $resource('/api/categories',{},{
           allCategories : {
               method:'GET',
               isArray: false,
               params: {

               }
           }
        });

        return{
            addDetail:addDetail,
            getOneConversation:getOneConversation,
            getAConversationsDetails:getAConversationsDetails,
            allCategories:allCategories,
            getDetailsByCategory:getDetailsByCategory,
            bulkDeleteDetails:bulkDeleteDetails,
            bulkUpdateDetailsCategory:bulkUpdateDetailsCategory,
            bookAppointment:bookAppointment,
            allAppointments: allAppointments,
            updateAppointment: updateAppointment,
            updateDetails:updateDetails
        };

        function addDetail(params) {
            return req1.addDetail(params).$promise;
        }

        function getOneConversation(params) {
           return req1.getOneConversation(params).$promise;
        }

         function getAConversationsDetails(params) {
             return req1.getAConversationsDetails(params).$promise;
         }

         function allCategories() {
             return categories.allCategories().$promise;
         }

         function getDetailsByCategory(params) {
             return req1.getDetailsByCategory(params).$promise;
         }

         function bulkDeleteDetails(params) {
            return req1.bulkDeleteDetails(params).$promise;
         }
         function bulkUpdateDetailsCategory(params) {
             return req1.bulkUpdateDetailsCategory(params).$promise;
         }

         function bookAppointment(params) {
             return req1.bookAppointment(params).$promise;
         }
         function allAppointments(params) {
             return  req1.allAppointments(params).$promise;
         }
         function updateAppointment(params) {
             return  req1.updateAppointment(params).$promise;
         }

         function updateDetails(params) {
             return req1.updateDetails(params).$promise;
         }
    }]);
}();