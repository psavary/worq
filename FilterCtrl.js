/**
 * Created by philou on 11.11.14.
 */
    //Controller for whole filtermanagement
app.controller('FilterCtrl',
    function($scope, $http, $animate, $modal, $alert, regions, students, industries)
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
        students.getStudentList().then(
            function(payload){
                $scope.students = payload.data;
            },
            function(error)
                {
                    var message = error.data;
                    console.log(message);

                    $alert({
                        "title": "Fehler: ",
                        "content":  message,
                        "type": "danger",
                        "duration":"30"
                    });
                }
        );



        $scope.showDetails = function(student)
        {
            $scope.studentDetailmodal = {title: 'Studentendetails'};

            $http.get('api.php/getStudentJobprofile/'+student.id).then
            (
                function(studyResponse)
                {
                    $scope.user = studyResponse.data;
                }
            );
          //  $('#filter-jobprofile').find('input, textarea, button, select').attr('disabled','disabled'); //todo load jquery to do that


            $scope.contactFormVisible = false;
            $scope.showContactButton = true;

        };

        $scope.showContactForm = function(student)
        {

            $scope.contactFormVisible = true;
            $scope.showContactButton = false;

            //console.dir(student)

        };

        $scope.saveContact = function ()
        {
            $http.post(''
        }





    }
);

app.directive('filterJobprofile', function() {
    return {
        restrict: 'A',
        replace: 'true',
        templateUrl: 'templates/filterJobprofile.html'
    };
});