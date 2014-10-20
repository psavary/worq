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
        this.othersevice =
            function()
            {

                //var fuck = 'bullshit';

                return $http.get('api.php/hello/mu');
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


    app.service('industries', ['$http',function($http)
    {
        this.getIndustries =
            function()
            {
                return $http.get('api.php/industries/');
            };
    }]);


    app.controller('ArticlesCtrl',
    function($scope, $http, students) {
       // console.log(students.myservice());
/* move the whole thing to studyctrl

*/

    });


    app.controller('StudyCtrl',
        function($scope, $http, regions, students, industries)
        {


            $http.get('api.php/study/').then
            (
                function(studyResponse)
                {
                    $scope.studys = studyResponse.data;
                }
            );


            //get Regions
            regions.getRegions().then
            (
                function(payload)
                {

                    $scope.regions = payload.data;
                    //console.log($scope.regions)
                }
            );


            //get industries
            industries.getIndustries().then
            (
                function(payload)
                {

                    $scope.industries = payload.data;
                    //console.log($scope.industriesData)

                }
            );



            //array of students
            students.myservice().then(
                function(payload){
                    $scope.articles = payload.data;
                }
            );


            //models needed for input and selectfields!?

            //console.dir($scope.industriesData);

            //console.log($scope.industries);






        }
    );
