/**
 * Created by itunu.babalola on 2/10/17.
 */
'use strict';
 !function () {
    var app = angular.module('ContactApp.filters');

    app.filter('toTime',['moment' , function (moment) {
        return function (date_time) {
            return moment(date_time).format("h:mm:ss a");
        };
    }]);

    app.filter('toDateTime',['moment' , function (moment) {
        return function (date_time) {
            return moment(date_time).format("YYYY-MM-DD | h:mm:ss a");
        }
    }]);

    app.filter('pluralize', [function () {
        return function (length,singular,plural) {
            return length<=1 ? singular:plural;
        }
    }])
}();