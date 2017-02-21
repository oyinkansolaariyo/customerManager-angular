'use strict';

!function () {

    var controllers = angular.module('ContactApp.controllers', []);
    var services = angular.module('ContactApp.services', []);
    var components = angular.module('ContactApp.components',[]);
    var filters = angular.module('ContactApp.filters',[]);
    var app  = angular.module('ContactApp',['ngRoute','angularMoment','ContactApp.filters','ContactApp.components','ContactApp.services','ContactApp.controllers','ngResource']);
    app.config(['$routeProvider', '$httpProvider', '$locationProvider', '$interpolateProvider',  function($routeProvider, $httpProvider, $locationProvider, $interpolateProvider){

        $routeProvider.when('/dashboard',{
            templateUrl :'/app/templates/dashboard.phtml'
        });
        $routeProvider.when('/customers' ,{
            templateUrl :'/app/templates/customers.phtml'
        });

        $routeProvider.when('/customer/:customer_id/details',{
            templateUrl :'/app/templates/customer-detail.phtml'
        });

        $routeProvider.when('/conversation/:conversation_id/details' ,{
            templateUrl :'/app/templates/conversation_details.phtml'
        });
        $routeProvider.when('/todos',{
           templateUrl :'/app/templates/todo.phtml'
        });
        $routeProvider.otherwise({
            redirectTo :'/dashboard'
        });

        $locationProvider.html5Mode(true);


    }]);
}();


