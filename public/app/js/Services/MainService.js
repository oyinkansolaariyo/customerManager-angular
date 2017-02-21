/**
 * Created by itunu.babalola on 2/3/17.
 */
'use strict';
!function() {
    var mainService = angular.module('ContactApp.services');
    mainService.service('MainService',['$resource','$rootScope',function ($resource,$rootScope) {

        return {
            Modal:Modal,
            Alert:Alert
        };


        function Modal() {
            return {
                open:function (template_url,data,buttons) {
                    if(typeof  template_url != 'undefined' &&  buttons.length > 0   ){
                        $rootScope.$broadcast('modal',{template:template_url,data :data, buttons: buttons});
                    }
                    else{
                        $rootScope.$broadcast('modal',{template:template_url,data :data});
                    }
                },
                close:function () {
                    $rootScope.$broadcast('modal',{template:null,data:null});
                }
            }
        }


        function Alert() {
            return {
                open : function (message,config) {
                    if(typeof message != 'undefined' && typeof message != 'object' && message.trim().length > 0) {
                        $rootScope.$broadcast('alert' ,{message: message,config:config,show:true})
                    }

                },
                close : function (alert_id) {
                    $rootScope.$broadcast('alert',{show:false})
                }
            }
        }
    }]);
}();