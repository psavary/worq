/**
 * Created by philou on 02.11.14.n  testskdjfsdkjfsdjfj
 *
 */

app.controller('JobprofilesCtrl',
    function($scope, $http, $modal, $alert, $location, regions, job, industries)
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
                        "title": "Speichern erfolgreich!",
                        "content": "Ihr Jobprofil wurde gspeichert",
                        "type": "success",
                        "duration":"20"
                    });
                    $location.path('jobprofileSuccess');

                }).
                error(function(data, status, headers, config) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.

                    var alert = $alert({
                        "title": "Fehler:",
                        "content": data,
                        "type": "danger",
                        "duration":"30"
                    });
                });

        };



        $scope.today = function() {
            $scope.dt = new Date();
        };
        $scope.today();

        $scope.clear = function () {
            $scope.dt = null;
        };



        $scope.toggleMin = function() {
            $scope.minDate = $scope.minDate ? null : new Date();
        };
        $scope.toggleMin();

        $scope.open = function($event) {
            $event.preventDefault();
            $event.stopPropagation();

            $scope.opened = true;
        };

        $scope.open2 = function($event) {
            $event.preventDefault();
            $event.stopPropagation();

            $scope.opened2 = true;
        };

        $scope.dateOptions = {
            formatYear: 'yy',
            startingDay: 1
        };

        $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        $scope.format = $scope.formats[2];






    }
);


