/**
 * Created by philou on 02.11.14.
 */
/**
 * Created by philou on 02.11.14.
 */



app.controller('RegisterCtrl',
    function($scope, $http, $modal, $alert, regions, students, industries, universities, languages, languageDiploma)
    {

        $scope.languageDiploma = {}; //this has to be initialized to make the scope an array

        $scope.changeLang = function(langNo,id) {

            $scope.currentLangNo = langNo;

            languageDiploma.languageDiploma(id).then
            (
                function(payload)
                {
                    $scope.languageDiploma[$scope.currentLangNo]= payload.data; //now, we fill the array.
                    //console.dir($scope.languageDiploma);
                }
            )
            console.log($scope.languageDiploma);

        };



        $http.get('api.php/study/').then
        (
            function(studyResponse)
            {
                $scope.studys = studyResponse.data;
            }
        );



        universities.getUniversities().then
        (
            function(payload)
            {

                $scope.universities = payload.data;
                console.log($scope.universities)
            }
        );


        languages.getLanguages().then
        (
            function(payload)
            {

                $scope.languages = payload.data;
                //console.log($scope.regions)
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

        $scope.checkUnique = function(user)
        {

            $scope.isNotUniqueEmail = false;
            var email = $scope.user.student.email;
            $http.get('api.php/getStudentEmailUnique/'+email).then
            (
                function(responeData)
                {
                    var emailExists = responeData.data;
                    $scope.isNotUniqueEmail = !emailExists.response;

                    console.log($scope.isNotUniqueEmail);

                    //if ($scope.isNotUniqueEmail)
                    //{
                     //   $scope.registerForm.email.$setValidity('validEmail', false);
                    //};
                    return  $scope.isNotUniqueEmail;
                }
            );


        }
        console.log($scope.isNotUniqueEmail);
        console.log(registerForm.$invalid);

        $scope.update = function(user) {
           // $scope.master = angular.copy(user);


            // Simple POST request example (passing data) :
        $http.post('/api.php/postStudent/', user).
            success(function(data, status, headers, config) {

            }).
            error(function(data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
            });
            console.dir(user);
            console.log('i did it!');
            var alert = $alert({
                "title": "Holy guacamole!",
                "content": "Student Saved.",
                "type": "success",
                "duration":"5"
            });
        };


        $scope.reset = function() {
            console.log('reset');
            // this callback will be called asynchronously
            // when the response is available


            //  $scope.user = angular.copy($scope.master);
        };

    }
);


