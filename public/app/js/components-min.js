/*! customer-manager-angular 2017-02-02 */
"use strict";angular.module("myApp.version",["myApp.version.interpolate-filter","myApp.version.version-directive"]).value("version","0.1");"use strict";angular.module("myApp.version.version-directive",[]).directive("appVersion",["version",function(version){return function(scope,elm,attrs){elm.text(version)}}]);"use strict";angular.module("myApp.version.interpolate-filter",[]).filter("interpolate",["version",function(version){return function(text){return String(text).replace(/\%VERSION\%/gm,version)}}]);