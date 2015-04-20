'use strict';


var app = angular.module('tutorialApp', ['ngAnimate','ngSanitize' ,'ngRoute','ui.bootstrap', 'mgcrea.ngStrap', 'ngCookies', 'flow' ])


    app.config(function($routeProvider) {
        $routeProvider
        .when('/', { templateUrl: 'registercompany.html' })
        .when('/confirmation',{templateUrl: 'confirmation.html'})
        .when('/jobprofileSuccess',{templateUrl: 'jobprofileSuccess.html'})
        .when('/filter', { templateUrl: 'filter.html' })
        .when('/register', { templateUrl: 'register.html' })
            .when('/message', { templateUrl: 'message.html' })

            .when('/registercompany', { templateUrl: 'registercompany.html' })

            .when('/jobprofile', { templateUrl: 'jobprofile.html' })
        .when('/about', { template: '�ber unsere Pizzeria' })
        .otherwise({ redirectTo: '/register'});
    });

    app.config(function($modalProvider) {
        angular.extend($modalProvider.defaults, {
            html: true
        });
    });

    //todo not really needed atm
    app.config(function($asideProvider) {
        angular.extend($asideProvider.defaults, {
            container: 'body',
            html: true
        });
    });


    app.service('students', ['$http',function($http)
    {

        this.getStudentList =
        function()
        {

            return $http.get('api.php/hello/');
        };
        this.getStudentDetails =
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



    app.controller('RootCtrl',
    function($scope, $http, $cookies) {

        console.log($cookies.PHPSESSID);
        var sessionId = $cookies.PHPSESSID;
        $http.get('/api.php/getSession/'+sessionId).then
        (
            function(payload)
            {
                var response = payload.data;
                console.log(response);
                if (response != 0)
                {
                    $scope.isAuthorized = true;

                    $scope.userdata = response;
                }
                else
                {
                    $scope.isAuthorized = false;
                }
            }
        );



        //$scope.isAuthorized = true;

    }   );



