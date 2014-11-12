/**
 * Created by philou on 02.11.14.
 */
/**
 * Created by philou on 02.11.14.
 */



app.controller('RegisterCtrl',
    function($scope, $http, $alert, regions, students, industries, universities, languages, languageDiploma)
    {


        $scope.dropdown = [
            {
                "text": "<i class=\"fa fa-download\"></i>&nbsp;Another action",
                "href": "#anotherAction"
            },
            {
                "text": "<i class=\"fa fa-globe\"></i>&nbsp;Display an alert",
                "click": "$alert(\"Something else!\")"
            },
            {
                "text": "<i class=\"fa fa-external-link\"></i>&nbsp;External link",
                "href": "/auth/facebook",
                "target": "_self"
            },
            {
                "divider": true
            },
            {
                "text": "Separated link",
                "href": "#separatedLink"
            }
        ];
        $scope.tooltip = {title: 'Hello Tooltip<br />This is a multiline message!', checked: false};

        $scope.alert = {title: 'Holy guacamole!', content: 'Best check yo self, you\'re not looking too good.', type: 'info'};
        //angularstrap example end



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
                //console.log($scope.regions)
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


        $scope.update = function(user) {
           // $scope.master = angular.copy(user);

            students.postStudent(user);
            console.dir(user);

        };


        $scope.reset = function() {
          //  $scope.user = angular.copy($scope.master);
        };

    }
);


