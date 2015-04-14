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


app.controller('RegistercompanyCtrl',
    function($scope, $http, $modal, $alert, $location)
    {
        //initialize models so a value can be set in controller without error
        $scope.user = {};
        $scope.user.company = {} ;
        $scope.user.company.gender = {};
        $scope.user.company.gender = 'female';


        $scope.checkUnique = function(user)
        {
            $scope.isNotUniqueEmail = false;
            var email = $scope.user.company.email;
            $http.get('api.php/getCompanyEmailUnique/'+email).then
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
            $http.post('/api.php/postCompany/', user).
                success(function(data, status, headers, config) {

                    //post image
                    $scope.image = $scope.$flow.files[0].file;
                    $http.post('/api.php/postImage/'+$scope.user.company.email+'/'+$scope.image.type, $scope.image);

                   /*
                    $alert({
                        "title": "Holy guacamole!",
                        "content": "Student Saved.",
                        "type": "success",
                        "duration": "5"
                    });
                    */
                    //$location.path('/confirmation');
                }).
                error(function(data, status, headers, config)
                {
                    $alert({
                        "title": "Holy guacamole!",
                        "content": "Something went wrong",
                        "type": "danger",
                        "duration":"5"
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


