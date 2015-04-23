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
    function($scope, $http, $modal, $alert, $location, regions, students, industries, universities, languages, languageDiploma)
    {
        //initialize models so a value can be set in controller without error
        $scope.user = {};
        $scope.user.student = {} ;
        $scope.user.student.gender = {};
        $scope.user.student.gender = 'female';
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
            }
        );

        languages.getLanguages().then
        (
            function(payload)
            {
                $scope.languages = payload.data;
            }
        );

        //get Regions
        regions.getRegions().then
        (
            function(payload)
            {
                $scope.regions = payload.data;
            }
        );

        //get industries
        industries.getIndustries().then
        (
            function(payload)
            {
                $scope.industries = payload.data;
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

                    return  $scope.isNotUniqueEmail;
                }
            );
        }
        //console.log($scope.isNotUniqueEmail);
        //console.log(registerForm.$invalid);



        $scope.update = function(user)
        {
            $http.post('/api.php/postStudent/', user).
                success(function(data, status, headers, config) {

                    //post image
                    $scope.image = $scope.$flow.files[0].file;
                    $http.post('/api.php/postImage/'+$scope.user.student.email+'/0/'+$scope.image.type, $scope.image). //usertype (0) added
                        success(function(data, status, headers, config)
                        {
                            //redirect in case of success
                           $location.url('confirmation'); //todo enable
                        }).
                        error(function(data, status, headers, config)
                        {
                            $alert({
                                "title": "Bild konnte nicht hochgeladen werden:",
                                "content": data,
                                "type": "danger",
                                "duration":"20"
                            });
                        });

                    $location.path('/confirmation');
                }).
                error(function(data, status, headers, config)
                {
                    $alert({
                        "title": "Fehler:",
                        "content": data,
                        "type": "danger",
                        "duration":"30"
                    });
                });
            };

        $scope.reset = function()
        {
           /* $scope.image = $scope.$flow.files[0].file;
            console.dir($scope.image.type);

            //post image
            $http.post('/api.php/postImage/', $scope.image);
            */
            $http.get('api.php/redirect/').then
            (
                function(responeData)
                {
                 console.log(responeData.data())
                }
            );;

        };
    }
);


