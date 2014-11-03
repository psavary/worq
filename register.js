/**
 * Created by philou on 02.11.14.
 */
/**
 * Created by philou on 02.11.14.
 */



app.controller('RegisterCtrl',
    function($scope, $http, regions, students, industries, universities, languages, languageDiploma)
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


