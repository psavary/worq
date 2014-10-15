'use strict';

var app = angular.module('tutorialApp', ['ngAnimate', 'ngRoute'])
    app.config(function($routeProvider) {
        $routeProvider
        .when('/', { templateUrl: 'filter.html' })
        .when('/about', { template: '�ber unsere Pizzeria' })
        .otherwise({ redirectTo: '/'});
    });


    app.service('students', ['$http',function($http)
    {

         this.myservice =
            function()
            {

                //var fuck = 'bullshit';

                return $http.get('api.php/hello/me');
                // console.log(response);
               //return response   ;
            };
        //return (myservice);


    }]);


    app.service('regions', ['$http',function($http)
    {
        this.getRegions =
            function()
            {
                return $http.get('api.php/regions/');
            };
    }]);


    app.controller('ArticlesCtrl',
    function($scope, $http, students) {
       // console.log(students.myservice());

       students.myservice().then(
            function(payload){
                $scope.articles = payload.data;
            }
       );
    });


    app.controller('StudyCtrl',
        function($scope, $http, regions)
        {
            $http.get('api.php/study/').then
            (
                function(studyResponse)
                {
                    $scope.studys = studyResponse.data;
                }
            );

            regions.getRegions().then
            (
                function(payload)
                {

                    $scope.regions = payload.data;
                    console.log($scope.regions)
                }
            );


            console.log($scope.regions)

            //models needed for input and selectfields!?
            $scope.mymodel = $scope.studys;
            $scope.othermodel = $scope.regions;


            $scope.$watchGroup(['mymodel','othermodel'],
                function(newValues,oldValues)
                {
                    console.log(oldValues[0].name);
                    console.log(newValues);


                });

        }
    );
