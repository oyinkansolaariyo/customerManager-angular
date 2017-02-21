/**
 * Created by itunu.babalola on 2/5/17.
 */
'use strict';
!function () {
    var app = angular.module('ContactApp.controllers');
  app.controller('ConversationController',['$scope','$timeout','$window','$routeParams','ConversationService','ResponseService','MainService',
      function ($scope,$timeout,$window,$routeParams,ConversationService,ResponseService,MainService) {
      var vm = this;
      vm.actionStates = {
              ADD:'Add',
              UPDATE:'Update'
          };
      vm.btnAction = vm.actionStates.ADD;
      vm.addDetail = addDetail;
      vm.getAConversationsDetailByCategory = getAConversationsDetailByCategory;
      vm.getAConversationsDetails = getAConversationsDetails;
      vm.deleteDetails = deleteDetails;
      vm.updateDetailsCategory = updateDetailsCategory;
      vm.bookAppointment = bookAppointment;
      vm.showAppointments = showAppointments;
      vm.updateAppointmentStatus = updateAppointmentStatus;
      vm.updateDetails = updateDetails;

      vm.conversation_id = $routeParams.conversation_id;
      vm.conversation =[];
      vm.new_detail = {};
      vm.categories =[];
      vm.details =[];
      vm.checked_conversations = [];
      vm.checked_id = [];
      vm.checked_length = 0;
      vm.check_all = 0;
      vm.appointment = {};
      vm.conversation_appointments = [];
      vm.all_conversation_appointments = [];

      $timeout(function () {
          getAConversation();
          getAConversationsDetails();
          getAllCategories();
      },10);

      function addDetail() {
          if(vm.btnAction == vm.actionStates.ADD){
              if(vm.conversation_id && vm.new_detail != null) {
                  ConversationService.addDetail({conversation_id:vm.conversation_id,category_id:vm.new_detail.category_id,text:vm.new_detail.text}).then(function (response) {
                      var resp = ResponseService.Brew(response);
                      if(resp.isOk()) {
                          vm.new_detail = {};
                          vm.details.push(resp.getData());
                          MainService.Alert().open('Detail added successfully' , {type: 'primary' , autoClose : true , timeout :7000});
                      }
                      else{
                          MainService.Alert().open(resp.getError(),{type: 'danger' , autoClose : true , timeout :7000});
                      }
                  })
              }
          }else if (vm.btnAction == vm.actionStates.UPDATE){
              update(vm.new_detail);
          }


      }


      function updateDetails(detail) {
          vm.btnAction = vm.actionStates.UPDATE;
          console.log(vm.btnAction);
          if(detail != null) {
              vm.new_detail = angular.copy(detail);
          }
      }
      
      function update(detail) {
          if(detail != null) {
              vm.new_detail = angular.copy(detail);
           ConversationService.updateDetails({detail:vm.new_detail,conversation_id:vm.conversation_id}).then(function (response) {
               var resp = ResponseService.Brew(response);
               if(resp.isOk()) {
                   MainService.Alert().open(resp.getData() , {type: 'primary' , autoClose : true , timeout :7000});
               }
               else{
                   MainService.Alert().open(resp.getError() , {type: 'primary' , autoClose : true , timeout :7000});
               }
           });
          }
      }



      $scope.$watch(function () {
          return vm.check_all;
      },function (newValue) {
          for(var d in vm.details) {
              vm.details[d].checked = newValue;
          }
      },true);

      $scope.$watch(function () {
          return vm.details;
      },function (newValue) {
          checkConversations(newValue);
      },true);


      function checkConversations(value) {
          vm.checked_length = 0;
          for(var d in value) {
              vm.checked_length += value[d].checked;
          }
          vm.check_all = vm.details.length == vm.checked_length ? 1 : 0;
      }


     function getCheckedDetails() {
          if(vm.checked_length > 0) {
              for(var detail in vm.details) {
                  if(vm.details[detail].checked == 1) {
                    vm.checked_conversations.push(vm.details[detail]);
                    vm.checked_id.push(vm.details[detail].id);
                  }
              }
          }

      }


      function showAppointments() {
          allAppointments();
          MainService.Modal().open('/app/templates/modal-templates/all_appointments.html' ,
              {
                  title: 'All Appointments' ,
                  showDefaultButtons : false ,
                  mscope : vm,
                  appointments : vm.conversation_appointments
              } ,
              [
                  {
                     label :' Close',
                      name: 'close' ,
                      onClick : function () {
                          MainService.Modal().close();
                      }
                  }
              ]
          );
      }


      function allAppointments() {
          if(vm.conversation_id) {
              ConversationService.allAppointments({conversation_id:vm.conversation_id}).then(function (response) {
                  var resp =ResponseService.Brew(response);
                  if(resp.isOk()) {
                      vm.all_conversation_appointments = resp.getData();
                      MainService.Alert().open('Appointments fetched succesfully',{type:'success',autoClose:true,timeout:7000});

                  }
                  else{
                      MainService.Alert().open(resp.getError(),{type:'danger',autoClose:true,timeout:7000});
                  }
              });
          }

      }


      function updateAppointmentStatus(appointment_id,new_status) {

          ConversationService.updateAppointment({id:appointment_id,status_id:new_status,conversation_id:vm.conversation_id}).then(function (response) {
              var resp =ResponseService.Brew(response);
              if(resp.isOk()) {
                  MainService.Alert().open(resp.getData(),{type:'success',autoClose:true,timeout:7000});
                  $window.location.reload();

              }
              else{
                  MainService.Alert().open(resp.getError(),{type:'danger',autoClose:true,timeout:7000});
              }
          });

      }

          function bookAppointment() {
              MainService.Modal().open('/app/templates/modal-templates/appointment_form.html',
                  {
                      title:'Book Appointment',
                      showDefaultButtons:true,
                      mscope:vm,
                      appointment : vm.appointment

                  },
                  [
                      {
                          label:'Continue',
                          name : 'proceed',
                          onClick : function (params) {
                              ConversationService.bookAppointment({conversation_id:vm.conversation_id,
                                  from_time:moment(params.appointment.from_time).format("h:mm:ss a"),
                                   to_time: moment(params.appointment.to_time).format("h:mm:ss a"),
                                   appointment_date:moment(params.appointment.appointment_date).format("YYYY-MM-DD"),
                                   description : params.appointment.description,
                                   whom_to_see: params.appointment.whom_to_see}).
                              then(function (response) {
                                  var resp =ResponseService.Brew(response);
                                  if(resp.isOk()) {
                                      MainService.Alert().open(resp.getData(),{type:'success',autoClose:true,timeout:7000});

                                  }
                                  else{
                                      MainService.Alert().open(resp.getError(),{type:'danger',autoClose:true,timeout:7000});
                                  }

                              });


                          }
                      }
                  ]
              );
          }
      
      
      function deleteDetails() {
          getCheckedDetails();
          if(vm.checked_id) {
              MainService.Modal().open('/app/templates/modal-templates/confirm.html',
                  {
                      title: 'Confirmation',
                      showDefaultButtons : true ,
                      mscope: vm
                  } ,
                  [
                      {
                          label: 'Continue',
                          name:'proceed',
                          onClick : function () {
                              ConversationService.bulkDeleteDetails({conversation_id:vm.conversation_id,details_id:vm.checked_id}).then(function (response) {
                                  var resp =ResponseService.Brew(response);
                                  if(resp.isOk()) {
                                      MainService.Alert().open(resp.getData(),{type:'success',autoClose:true,timeout:7000});
                                      $window.location.reload();

                                  }
                                  else{
                                      MainService.Alert().open(resp.getError(),{type:'danger',autoClose:true,timeout:7000});
                                  }
                              });
                          }
                      }
                  ]
              );
          }
      }


      function updateDetailsCategory(category_id) {
          getCheckedDetails();
          if(vm.checked_id) {
              ConversationService.bulkUpdateDetailsCategory({conversation_id:vm.conversation_id,details_id:vm.checked_id, category_id:category_id}).then(function (response) {
                  var resp =ResponseService.Brew(response);
                  if(resp.isOk()) {
                      MainService.Alert().open(resp.getData(),{type:'success',autoClose:true,timeout:7000});
                      $window.location.reload();

                  }
                  else{
                      MainService.Alert().open(resp.getError(),{type:'danger',autoClose:true,timeout:7000});
                  }
              });
          }
      }


      function getAConversation() {
          if(vm.conversation_id) {
              ConversationService.getOneConversation({conversation_id:vm.conversation_id}).then(function (response) {
                  var resp = ResponseService.Brew(response);
                  if(resp.isOk()) {
                      vm.conversation = resp.getData();
                  }
                  else{

                  }
              });
          }
      }

      function getAConversationsDetails() {
          if(vm.conversation_id) {
              ConversationService.getAConversationsDetails({conversation_id:vm.conversation_id}).then(function (response) {
                  var resp = ResponseService.Brew(response);
                  if(resp.isOk()) {
                      vm.details = resp.getData();
                  }
                  else{
                      console.log(resp.getError());
                  }
              })
          }
      }

      function getAConversationsDetailByCategory(category_id) {
          if(vm.conversation_id) {
              ConversationService.getDetailsByCategory({conversation_id:vm.conversation_id,category_id:category_id}).then(function (response) {
                  var resp = ResponseService.Brew(response);
                  if(resp.isOk()) {
                      vm.details = resp.getData();
                  }
                  else{
                      console.log(resp.getError());
                  }
              })
          }
      }

      function getAllCategories() {
          if(vm.conversation_id) {
              ConversationService.allCategories().then(function (response) {
                  var resp = ResponseService.Brew(response);
                  if(resp.isOk()) {
                      vm.categories = resp.getData();
                  }
                  else{
                      console.log(resp.getError());
                  }
              })
          }
      }

  }
  ]);
}();