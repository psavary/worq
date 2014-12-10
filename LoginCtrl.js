/**
 * Created by philou on 11.11.14.
 */
app.controller('LoginCtrl',
    function($scope, $modal, $http, $alert)
    {


        //angularstrap example start
       // $scope.modal = {};
        $scope.title = "scopetitle";
        $scope.content = 'Hello Modal<br />This is a multiline message!';
        // Pre-fetch an external template populated with a custom scope
        var myOtherModal = $modal({scope: $scope, template: './templates/login.html', show: false,title: $scope.title, content: $scope.content});
        // Show when some event occurs (use $promise property to ensure the template has been loaded)
        $scope.showModal = function() {
            myOtherModal.$promise.then(myOtherModal.show);
        };
        console.dir(myOtherModal);

        $scope.doseomething = function(credentials) {
            // $scope.master = angular.copy(user);
            // Simple POST request example (passing data) :
            $http.post('/api.php/postLogin/', credentials).
                success(function(data, status, headers, config)
                {
                    console.log($scope.modal);

                    if (data.status == "error")
                    {
                        console.log('errk');
                        $scope.title = 'gagaga';
                       // myOtherModal.$scope.$parent.content = 'bababa';

                        //$scope.content = '<span class="label label-danger">bad</span>';
                       // $scope.myOtherModal = {scope: $scope, template: './templates/login.html', title: $scope.title, content: };
                    }
                    else
                    {
                       // $scope.content = '<span class="label label-success">Success</span>';
                        console.log('succ');
                        $scope.title = 'gagaga';
                       // myOtherModal.$scope.$parent.content = 'bababa';
                       //myOtherModal.$promise.then(myOtherModal.show);
                      //  myOtherModal.$scope.$parent.showModal();

                        //$scope.myOtherModal.title = 'good'; //= {scope: $scope, template: './templates/login.html', title: 'good', content: };
                        //this.hide();
                        //myOtherModal.$promise.then(myOtherModal.hide);
                    }
                });
        };
    }
);
