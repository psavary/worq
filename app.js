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
    app.controller('ArticlesCtrl',
    function($scope, $http, students) {
       // console.log(students.myservice());

       students.myservice().then(
            function(payload){
                //  return res.data;
                $scope.articles = payload.data;

            });
        console.log($scope.articles);

        //console.log($scope.articles);
             //$scope.articles = datas   ;
       
    });
    app.controller('StudyCtrl', function($scope, $http){
        $http.get('api.php/study/').then(function(studyResponse) {
            $scope.studys = studyResponse.data;
        });
        
        $scope.mymodel = $scope.studys;
    });
