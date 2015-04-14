/**
 * Created by philou on 12.11.14.
 */
/**
 * Created by philou on 11.11.14.
 */



app.controller('NavigationCtrl',
    function($scope, $modal, $http, $alert) {

        $scope.loginModal = {title: 'Login', content: 'Please enter your Email and Password'};
        this.credentials = {email: "", password:""};


        $scope.verifyLogin = function () {
            $scope.loginModalObject = this; //@psa for some reason, the modal object is not in scope. try to scope it in template

            if (angular.isUndefined(this.credentials) || this.credentials == "undefined")
            {
                $scope.loginModal = {
                    title: 'Login',
                    content: '<span class="label label-danger">Please fill out all nescessary fields</span>'
                };
            }
            else if (this.credentials.email ==  "" || this.credentials.password == "")
            {
                $scope.loginModal = {
                    title: 'Login',
                    content: '<span class="label label-danger">Please fill out all nescessary fields</span>'
                };
            }

            else
            {
                $http.post('/api.php/postLogin/', this.credentials).
                    success(function (data, status, headers, config) {
                        console.log($scope.modal);

                        if (data.status == "error") {

                           $scope.loginModal = {
                                title: 'Login not possible',
                                content: '<span class="label label-danger">Email/Passwort combination incorrect</span>'
                            };
                        }
                        else {
                            // $scope.content = '<span class="label label-success">Success</span>';
                            console.log('succ');

                            $scope.loginModal = {
                                title: 'Login  Successfull',
                                content: '<span class="label label-success">Login  Successfull</span>'
                            };
                            $scope.isAuthorized= true;
                            $scope.loginModalObject.$hide();
                        }
                    });
            }
        }
    }
);
