/**
 * Created by itunu.babalola on 2/2/17.
 */

'use strict';

!function () {
    var app = angular.module('ContactApp.controllers');

    app.controller('CustomerController', ['$scope','$timeout','$routeParams','$window','CustomerService','ResponseService','UserService','MainService','ConversationService',
        function($scope, $timeout, $routeParams,$window, CustomerService,ResponseService,UserService,MainService,ConversationService) {
            var vm = this;
            vm.user = __User;
            vm.customer = [];
            vm.customer_id = $routeParams.customer_id;
            vm.details = [];
            vm.customers = [];
            vm.new_customer = {};
            vm.conversation_subject ='';
            vm.conversation_count = null;
            vm.customer_conversations =[];
            vm.conversation_details = [];
            vm.customer_edit = {};
            vm.selectedIndex = null;
            vm.conversation_edit = {};
            vm.deleteCustomer = deleteCustomer;
            vm.addConversation = addConversation;
            vm.getConversations = getConversations;
            vm.addNewCustomer = addNewCustomer;
            vm.editCustomer = editCustomer;
            vm.editConversation = editConversation;

            $timeout( function () {
               getUserCustomers();
                getCustomerDetails();
                getConversations();
                getNoOfConversations();

            },10);


            function addNewCustomer() {
                UserService.addCustomer(vm.new_customer).then(function (response) {
                    var resp = ResponseService.Brew(response);
                    if(resp.isOk()) {
                        vm.new_customer = {};
                        vm.customers.push(resp.getData());
                        MainService.Alert().open('Customer added successfully',{type:'success',autoClose :true, timeout : 7000});
                    }
                    else{
                        MainService.Alert().open(resp.getError(),{type:'danger', autoClose: true, timeout :7000});
                    }
                } , function () {

                });

            }


            function editCustomer(customer, index) {
               if(customer != null) {
                   vm.customer_edit = angular.copy(customer);
                   vm.selectedIndex = index;
                  MainService.Modal().open('/app/templates/modal-templates/customer_edit.html',
                      {
                          title: 'Edit Customer',
                      showDefaultButtons: true,
                      mscope:vm,
                       customer:customer
                      },
                  [
                      {
                         label:'Update',
                          name:'Proceed',
                          onClick : function (params) {
                        UserService.updateCustomer({customer: vm.customer_edit}).then(function (response) {
                            var  resp = ResponseService.Brew(response);
                            if(resp.isOk()) {
                                MainService.Modal().close();
                                MainService.Alert().open('Customer edited successfully',{type:'success',autoClose :true, timeout : 7000});
                            }
                            else{
                                MainService.Alert().open(resp.getError(),{type:'danger', autoClose: true, timeout :7000});
                            }
                        });
                          }
                      }
                  ])
               }
            }

            function getAConversationsDetails(conversation_id) {
                if(conversation_id) {
                    ConversationService.getAConversationsDetails({conversation_id:conversation_id}).then(function (response) {
                        var resp = ResponseService.Brew(response);
                        if(resp.isOk()) {
                            vm.conversation_details = resp.getData();
                        }
                        else{
                            console.log(resp.getError());
                        }
                    })
                }
            }


            function getUserCustomers() {
                UserService.allCustomers().then(function (response) {
                    var resp = ResponseService.Brew(response);
                    var customers_details = resp.getData();
                    if(resp.isOk()) {
                        for(var customer in  customers_details) {
                            vm.customers.push(customers_details[customer]);
                        }
                    }
                    else{

                    }

                } , function () {

                });



            }

            function getCustomerDetails() {
                    CustomerService.getDetails({customer_id :vm.customer_id}).then(function (response) {
                      var  resp = ResponseService.Brew(response);
                      if(resp.isOk()){
                          vm.details = resp.getData();
                      }
                      else{

                      }
                    }, function () {

                    });

            }

            function  deleteCustomer(customer_id) {
                MainService.Modal().open('/app/templates/modal-templates/confirm.html',
                    { title: 'Confirmation',
                        showDefaultButtons:true
                    },
                [

                    {
                        label:'Continue',
                        name: 'proceed',
                        onClick: function (params) {
                            MainService.Modal().close();
                            CustomerService.deleteCustomer({customer_id:customer_id}).then(function (response) {

                                 console.log(response);
                                 var resp = ResponseService.Brew(response);
                                 if(resp.isOk()){
                                     $window.location.reload();
                                 }
                                 else {
                                     MainService.Alert().open(resp.getError(),{type:'danger',autoClose:true, timeout:7000});
                                 }
                             }, function () {});

                        }

                    }
                ]
                );

            }



            function addConversation() {
                console.log(vm.conversation_subject);
                CustomerService.addConversation({subject:vm.conversation_subject,customer_id:vm.customer_id}).then(function (response) {
                    var resp = ResponseService.Brew(response);
                    if(resp.isOk()){
                        vm.conversation_subject ='';
                        vm.customer_conversations.push(resp.getData());
                        MainService.Alert().open(resp.getError(),{type:'primary',autoClose: true , timeout: 7000});
                    }
                    else{
                        MainService.Alert().open(resp.getError(),{type:'danger',autoClose: true, timeout :7000});
                    }
                }, function () {

                });

            }

            function editConversation(conversation) {
                if(conversation != null) {
                    vm.conversation_edit = angular.copy(conversation);
                    MainService.Modal().open('/app/templates/modal-templates/conversation_edit.html',
                        {
                            title: 'Edit Conversation',
                            showDefaultButtons: true,
                            mscope:vm,
                            conversation_edit:vm.conversation_edit
                        },
                        [
                            {
                                label:'Update',
                                name:'Procced',
                                onClick : function (params) {
                                    CustomerService.updateConversation({conversation: vm.conversation_edit,customer_id:vm.customer_id}).then(function (response) {
                                        var  resp = ResponseService.Brew(response);
                                        if(resp.isOk()) {
                                            MainService.Modal().close();
                                            MainService.Alert().open('Conversation edited successfully',{type:'success',autoClose :true, timeout : 7000});
                                        }
                                        else{
                                            MainService.Alert().open(resp.getError(),{type:'danger', autoClose: true, timeout :7000});
                                        }
                                    });
                                }
                            }
                        ])
                }
            }
            
            
            function getConversations() {
                if (vm.customer_id) {
                    CustomerService.getConversations({customer_id: vm.customer_id}).then(function (response) {
                        var resp = ResponseService.Brew(response);
                        var customer_conversations = resp.getData();
                        if (resp.isOk()) {
                            for (var conversation in  customer_conversations) {
                                vm.customer_conversations.push(customer_conversations[conversation]);
                            }
                        }
                        else {
                            MainService.Alert().open(resp.getError(),{type:'danger',autoClose: true, timeout :7000});
                        }
                    }, function () {

                    })
                }
            }


            function getNoOfConversations() {
                if(vm.customer_id) {
                    CustomerService.getNoOfConversations({customer_id: vm.customer_id}).then(function (response) {
                        var resp = ResponseService.Brew(response);
                        console.log(response);
                        if(response.status == 'success') {
                            vm.conversation_count = response.data.response;
                        }
                        else {
                            MainService.Alert().open(resp.getError(),{type:'danger',autoClose: true, timeout :7000});
                        }
                    });
                }
            }
        }]);

}();