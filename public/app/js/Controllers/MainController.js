/**
 * Created by itunu.babalola on 2/3/17.
 */
'use strict';

!function () {
    var app = angular.module('ContactApp.controllers');

    app.controller('MainController', ['$scope','$sce','$rootScope','$timeout','$routeParams','UserService','ResponseService',
        function($scope,$sce,$rootScope, $timeout, $routeParams, UserService,ResponseService) {
            var vm = this;
            vm.modal_config ={
               template:'',
                data:{}
            };

            vm.alert_config = {
                message :'',
                type : 'alert-primary'
            };
            vm.show_modal = false;
            vm.show_alert = false;

            vm.onCloseBtnClicked = function() {
                vm.show_modal = false;
            };

            vm.onCloseBtnAlert = function () {
                vm.show_alert = false;
                $timeout(
                    $window.location.reload(),1000000000
                );
            };

            $rootScope.$on('modal',function (event,args) {
                console.log("modal  input" , args);
                // the show modal would only be true if,show is true and a template is specified
                vm.show_modal = typeof args.data != 'undefined' &&  args.template != null;
                vm.modal_config.template = args.template;
                vm.modal_config.data = args.data;
                vm.modal_config.buttons = args.buttons;
            });


            $rootScope.$on('alert', function (event,args) {
                vm.show_alert = typeof args.show == 'undefined' ?false : args.show ;
                if(vm.show_alert) {
                    vm.alert_config.message = $sce.trustAsHtml(args.message);
                    if(args.config && 'autoClose' in args.config && args.config.autoClose){
                        var timeout = typeof args.config.timeout == 'undefined' ? 5000 :args.config.timeout;
                        $timeout(
                            function () {
                                vm.show_alert = false;
                                if(typeof  args.config.onClose == 'function') {
                                    args.config.onClose();
                                }

                            }
                       ,timeout )
                    }
                    if( args.config && 'type' in args.config) {
                        vm.alert_config.type = 'alert-'+(typeof  args.config.type == 'undefined' ? 'primary' : args.config.type);
                    }
                }

            })





        }]);

}();

