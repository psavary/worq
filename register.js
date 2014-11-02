/**
 * Created by philou on 02.11.14.
 */
/**
 * Created by philou on 02.11.14.
 */



app.controller('RegisterCtrl',
    function($scope, $http, regions, students, industries, universities, languages, languageDiploma)
    {
        $scope.languageDiploma = {};
        $scope.changeLang = function(langNo,id) {

            $scope.currentLangNo = langNo;
            console.log($scope.currentLangNo);
            languageDiploma.languageDiploma(id).then
            (
                function(payload, langNo)
                {
                    $scope.languageDiploma.push({"id": $scope.currentLangNo, "name": payload.data}); //@psa todo figure this out!
                    console.log($scope.languageDiploma);

                    //console.log($scope.regions)
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
        )


        languages.getLanguages().then
        (
            function(payload)
            {

                $scope.languages = payload.data;
                //console.log($scope.regions)
            }
        )

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
            $scope.master = angular.copy(user);
        };

        $scope.reset = function() {
            $scope.user = angular.copy($scope.master);
        };

    }
);


