/**
 * Created by itunu.babalola on 1/30/17.
 */
'use strict';

!function () {
    var app = angular.module('ContactApp.controllers');

    app.controller('navController', ['$scope','$timeout','$window','$routeParams','UserService','ResponseService','MainService',
        function($scope, $timeout,$window, $routeParams, UserService,ResponseService,MainService) {
            var vm = this;
            vm.user = __User;

            vm.logout = logout;



            function logout() {
                UserService.logout().then(function (response) {
                    var resp = ResponseService.Brew(response);
                    if(resp.isOk()) {
                        $window.location.href = 'http://dev.customermanager-angular.it/login';
                    }
                })
            }


        }]);

}();

