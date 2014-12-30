'use strict';


var app = angular.module('tutorialApp', ['ngAnimate','ngSanitize' ,'ngRoute','ui.bootstrap', 'mgcrea.ngStrap', 'ngCookies' ])


    app.config(function($routeProvider) {
        $routeProvider
        .when('/', { templateUrl: 'register.html' })
        .when('/filter', { templateUrl: 'filter.html' })
        .when('/register', { templateUrl: 'register.html' })
        .when('/jobprofile', { templateUrl: 'jobprofile.html' })
        .when('/about', { template: '�ber unsere Pizzeria' })
        .otherwise({ redirectTo: '/register'});
    });



    app.service('students', ['$http',function($http)
    {

        this.myservice =
        function()
        {

            //var fuck = 'bullshit';

            return $http.get('api.php/hello/');
            // console.log(response);
            //return response   ;
        };
        this.othersevice =
            function()
            {

                //var fuck = 'bullshit';

                return $http.get('api.php/hello/');
                // console.log(response);
                //return response   ;
            };

        this.postStudent =
            function (postData)
            {

            }

        //return (myservice);


    }]);

    app.service('job', ['$http',function($http)
    {
        this.getEmploymenttypes =
            function()
            {
                return $http.get('api.php/employmenttypes/');
            };

        this.getWorkloads =
            function()
            {
                return $http.get('api.php/workloads/');
            };

        this.getMobility =
            function()
            {
                return $http.get('api.php/mobility/');
            };
    }]);

    app.service('regions', ['$http',function($http)
    {
        this.getRegions =
            function()
            {
                return $http.get('api.php/regions/');
            };
    }]);


    app.service('universities', ['$http',function($http)
    {
        this.getUniversities =
            function()
            {
                return $http.get('api.php/university/');
            };
    }]);


    app.service('languages', ['$http',function($http)
    {
        this.getLanguages =
            function()
            {
                return $http.get('api.php/languages/');
            };
    }]);

    app.service('languageDiploma', ['$http',function($http)
    {
        this.languageDiploma =
            function(id)
            {
                return $http.get('api.php/languageDiploma/'+id);
            };
    }]);



    app.service('industries', ['$http',function($http)
    {
        this.getIndustries =
            function()
            {
                return $http.get('api.php/industries/');
            };
    }]);

/*
    app.service('phpCookie',['$cookieStore', function($cookieStore)
    {
        this.getCookie =
            function()
            {
                var myCookie = $cookieStore.remove('PHPSESSID');
                console.log(myCookie);
                return myCookie;
            };
    }])
    */

    app.controller('RootCtrl',
    function($scope, $http) {
        //placeHolderParentScope
        //$http.get('/api.php/getCookie/');
        //var myCookie = phpCookie.getCookie();
        //console.log(myCookie);
        $scope.isAuthorized = true;

    }   );



