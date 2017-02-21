/**
 * Created by itunu.babalola on 2/2/17.
 */
'use strict';
!function() {
    var userService = angular.module('ContactApp.services');
    userService.service('ResponseService',['$rootScope',function ($rootScope) {

        return {
            Brew: Brew
        };

        function Brew(response) {
            return {
                isOk:isOk,
                getData:getData,
                getError:getError
            };

            function isOk() {
                return (response.status == 'success' &&
                response.data &&
                ( response.data.response || response.data.message)
                ) ? true : false;
            }

            function getData() {
                if(isOk()) {

                    return response.data.response || response.data.message;
                }
                return false;
            }

            function getError() {
                if(!isOk()) {
                   return response.data.message;
                }
                return "A network error has occured";
            }
        }
    }]);
}();