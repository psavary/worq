
/**
 * Created by philou on 02.11.14.n  testskdjfsdkjfsdjfj
 */





app.controller('JobprofileCtrl',
    function($scope, $http, $modal, $alert, regions, job)
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


    }
);


