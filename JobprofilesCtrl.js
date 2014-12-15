/**
 * Created by philou on 02.11.14.n  testskdjfsdkjfsdjfj
 * hhjjhbhjhjjhjjbmmmbmbm
 */

app.controller('JobprofilesCtrl',
    function($scope, $http, $modal, $alert, regions, job, industries)
    {
        //get Regions
        regions.getRegions().then
        (
            function(payload)
            {
                $scope.regions = payload.data;
                //console.log($scope.regions)
            }
        );

        //get Regions
        job.getEmploymenttypes().then
        (
            function(payload)
            {
                $scope.employmenttypes = payload.data;
                //console.log($scope.regions)
            }
        );

        //get Regions
        job.getWorkloads().then
        (
            function(payload)
            {
                $scope.workloads = payload.data;
                //console.log($scope.regions)
            }
        );

        job.getMobility().then
        (
            function(payload)
            {
                $scope.mobility = payload.data;
                //console.log($scope.regions)
            }
        );


        industries.getIndustries().then
        (
            function(payload)
            {
                $scope.industries = payload.data;
                //console.log($scope.regions)
            }
        );

        $scope.update = function(user) {
            // $scope.master = angular.copy(user);


            // Simple POST request example (passing data) :
            $http.post('/api.php/postJobprofile/', user).
                success(function(data, status, headers, config) {
                    var alert = $alert({
                        "title": "Täschbäng!",
                        "content": "lslsl",
                        "type": "success",
                        "duration":"15"
                    });
                    console.log(headers);

                }).
                error(function(data, status, headers, config) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.

                    var alert = $alert({
                        "title": "Damn it!!! Shit's fucked up!",
                        "content": data,
                        "type": "error",
                        "duration":"30"
                    });
                });
           // console.dir(user);
            console.log('i did it!');

        };



    }
);


