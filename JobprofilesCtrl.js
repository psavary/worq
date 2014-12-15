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




    }
);


