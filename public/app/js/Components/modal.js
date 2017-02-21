/**
 * Created by itunu.babalola on 2/4/17.
 */
!function () {
    var app = angular.module('ContactApp.components');

    app.component('modal', {
        templateUrl : '/app/templates/modal-templates/generic_modal.phtml',
        bindings : {
            data : '<',
            buttons: '<',
            template : '<',
            onCloseBtnClicked : '&'
        },
        controller : ['$scope', '$templateRequest', '$sce', '$compile','$route','$window', function( $scope, $templateRequest, $sce, $compile, $route,$window) { //Put in all dependencies.
            var ctrl = this;
            $scope.safeApply = function(fn, args) {
                var phase = this.$root.$$phase;
                if(phase == '$apply' || phase == '$digest') {
                    if(fn && (typeof(fn) === 'function')) {
                        fn(args);
                    }
                } else {
                    this.$apply(fn, args);
                }
            };

            var btn_fxn_map = {};
            var btn_fxn_props = {};
            ctrl.showDefaultButtons = false;

            ctrl.$onInit = function() {

            };

            ctrl.$onChanges = function(currentValue ) {
                console.log("Modal Change" , currentValue);
                try{
                    if(typeof currentValue.data != 'undefined' && typeof currentValue.data.currentValue != 'undefined' &&
                        typeof currentValue.template != 'undefined' && currentValue.template.currentValue.length > 0) {
                        ctrl.cardData = currentValue.data.currentValue;
                        ctrl.template = currentValue.template.currentValue;
                        ctrl.buttons = currentValue.buttons.currentValue;// typeof ctrl.cardData.buttons == 'undefined'? (typeof currentValue.buttons.currentValue.length > 0 ? currentValue.buttons.currentValue : []) : ctrl.cardData.buttons;

                        ctrl.showDefaultButtons = typeof ctrl.cardData.showDefaultButtons == 'undefined'? false : ctrl.cardData.showDefaultButtons;
                        renderModal({template:ctrl.template,data:ctrl.cardData, buttons:ctrl.buttons,scope:ctrl.cardData.mscope});
                    }
                }catch(e) {
                    //console.log(e);
                }

            };

            ctrl.closeModal = function () {
                ctrl.cardData = null;
                ctrl.template = null;
                $window.location.reload();
                ctrl.onCloseBtnClicked();
            };

            ctrl.buttonClicked = function (name) {
                if(name in btn_fxn_map && typeof btn_fxn_map[name] == 'function') {
                    var fxn = btn_fxn_map[name];
                    var btn  = btn_fxn_props[name];
                    if( btn.hasOwnProperty('hideOnClick') && btn.hideOnClick) {
                        $('#btn_' + name).addClass('hide');
                    }
                    $scope.safeApply(fxn, ctrl.cardData);
                }
            };

            function renderModal(params) {
                var templateUrl = $sce.getTrustedResourceUrl(params.template + '?itunu=' + Math.random() * 10000);
                if(templateUrl.toString().trim().length > 0) {
                    $templateRequest(templateUrl).then(function(template) {
                        // template is the HTML template as a string
                        $compile($("#modal_body").html(template).contents())($scope);
                        console.log(params);
                        if(params.buttons.length > 0) {
                            console.log(params.buttons);
                            var btns = [];
                            var css_class;
                            for(var btn in params.buttons) {
                                css_class = typeof params.buttons[btn].class == 'undefined' ? 'btn-primary' : params.buttons[btn].class;
                                btns.push("<button type='button' id='btn_"+params.buttons[btn].name+"' ng-click='$ctrl.buttonClicked(\""+params.buttons[btn].name+"\")' class='btn "+css_class+"'>"+params.buttons[btn].label+"</button>");
                                btn_fxn_map[params.buttons[btn].name] = params.buttons[btn].onClick;
                                btn_fxn_props[params.buttons[btn].name] = params.buttons[btn];
                                css_class = '';
                            }
                            var btn_template = btns.join('');
                            $compile($("#buttons_holder").html(btn_template).contents())($scope);
                        }
                    }, function() {
                        // An error has occurred here
                        alert('error loading template');
                    });
                }
            }
        }]
    });
}();