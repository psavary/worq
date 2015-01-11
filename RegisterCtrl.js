/**
 * Created by philou on 02.11.14.
 */
/**
 * Created by philou on 02.11.14.
 */

app.config(['flowFactoryProvider', function (flowFactoryProvider) {
    flowFactoryProvider.defaults = {
        target: '',
        permanentErrors: [500, 501],
        maxChunkRetries: 1,
        chunkRetryInterval: 5000,
        simultaneousUploads: 1
    };
    flowFactoryProvider.on('catchAll', function (event) {
        console.log('catchAll', arguments);
    });
    // Can be used with different implementations of Flow.js
    //flowFactoryProvider.factory = fustyFlowFactory;
}]);


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

        $scope.update = function(user)
        {
           // $scope.master = angular.copy(user);


                // Simple POST request example (passing data) :
            $http.post('/api.php/postStudent/', user).
                success(function(data, status, headers, config) {
                    console.log(data);
                    var alert = $alert({
                        "title": "Holy guacamole!",
                        "content": "Student Saved.",
                        "type": "success",
                        "duration": "5"
                    })
                }).
                error(function(data, status, headers, config)
                {
                    var alert = $alert({
                        "title": "Holy guacamole!",
                        "content": "Something went wrong",
                        "type": "danger",
                        "duration":"5"
                    });
                });

            //post image
            $scope.image = $scope.$flow.files[0].file;

            $http.post('/api.php/postImage/'+$scope.user.student.email+'/'+$scope.image.type, $scope.image).
                success(function(data, status, headers, config) {

                    var alert = $alert({
                        "title": "Image processed!",
                        "content": "Student Saved.",
                        "type": "success",
                        "duration": "5"
                    })
                }).
                error(function(data, status, headers, config)
                {
                    var alert = $alert({
                        "title": "Image not processed!",
                        "content": "Something went wrong",
                        "type": "danger",
                        "duration":"5"
                    });
                });
            $scope.user.image = $scope.$flow.files[0].file;

            console.dir(user);


            };


        $scope.reset = function()
        {
            $scope.image = $scope.$flow.files[0].file;
            console.dir($scope.image.type);

            //post image
            $http.post('/api.php/postImage/', $scope.image).
                success(function(data, status, headers, config) {

                    var alert = $alert({
                        "title": "Image processed!",
                        "content": "Student Saved.",
                        "type": "success",
                        "duration": "5"
                    })
                }).
                error(function(data, status, headers, config)
                {
                    var alert = $alert({
                        "title": "Image not processed!",
                        "content": "Something went wrong",
                        "type": "danger",
                        "duration":"5"
                    });
                });



        };
        //console.dir($scope.obj.flow);



    }
);


