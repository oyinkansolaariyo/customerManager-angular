/**
 * Created by itunu.babalola on 2/1/17.
 */
'use strict';

!function () {
    var app = angular.module('ContactApp.controllers');

    app.controller('DashboardController', ['$scope','$timeout','$routeParams','UserService','ResponseService',
        function($scope, $timeout, $routeParams, UserService,ResponseService) {
            var vm = this;
            vm.user = __User;
            vm.appointment_count = null;
            vm.todo_count = null;
            vm.conversation_count = null;
            vm.customer_count = null;


            $timeout(
                function () {
                    getNoOfAppointments();
                    getNoOfTodos();
                    getNoConversation();
                    getNoCustomers();
                },200
            );



            function getNoOfTodos() {
                UserService.getNoTodos().then(function (response) {
                    var resp = ResponseService.Brew(response);
                    if(response.status == 'success') {
                        console.log(response);
                        vm.todo_count = response.data.response;
                    }
                    else{
                        //// console.log(response.getError());
                    }
                });
            }

            function getNoOfAppointments() {
                UserService.getNoAppointments().then(function (response) {
                    var resp = ResponseService.Brew(response);
                    if(resp.isOk()) {
                        console.log(resp.getData());

                        vm.appointment_count = resp.getData();
                        console.log(vm.appointment_count);
                    }
                    else{
                        console.log(response.getError());
                    }
                });
            }


            function getNoConversation() {
                UserService.getNoConversation().then(function (response) {

                    var resp = ResponseService.Brew(response);
                    if(response.status == 'success') {
                        console.log(response);
                        vm.conversation_count = response.data.response;
                    }
                    else{
                       //// console.log(response.getError());
                    }
                });
            }


            function getNoCustomers() {
                UserService.getNoCustomers().then(function (response) {
                    var resp = ResponseService.Brew(response);
                    if(response.status == 'success') {
                        vm.customer_count = response.data.response;
                    }
                    else{
                       // console.log(response.getError());
                    }
                });
            }
        }]);

}();

