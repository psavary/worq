/**
 * Created by philou on 11.11.14.
 */
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