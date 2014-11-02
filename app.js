'use strict';

var app = angular.module('tutorialApp', ['ngAnimate', 'ngRoute'])
    app.config(function($routeProvider) {
        $routeProvider
        .when('/', { templateUrl: 'register.html' })
        .when('/filter', { templateUrl: 'filter.html' })
        .when('/register', { templateUrl: 'register.html' })
        .when('/about', { template: '�ber unsere Pizzeria' })
        .otherwise({ redirectTo: 'register.html'});
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


    app.controller('ArticlesCtrl',
    function($scope, $http, students) {
       // console.log(students.myservice());
/* move the whole thing to studyctrl

*/

    });


    //Controller for whole filtermanagement
    app.controller('FilterCtrl',
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

            //experimental code to trigger mysql select onChange of any dropbox field
            $scope.change = function(variable)
            {
                if (!angular.isUndefined($scope.mymodel)) //only do somethin as long it is not undefined
                {
                    console.log($scope.mymodel.name);
                }
                console.log($scope.othermodel.name);

                $scope.counter++;
                $scope.variable = variable;
            };


            //array of students
            students.myservice().then(
                function(payload){
                    $scope.articles = payload.data;
                }
            );
            //end do this in the onchangefunction


            //models needed for input and selectfields!?

            //console.dir($scope.industriesData);

            //console.log($scope.industries);






        }
    );
