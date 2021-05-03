angular.module('roboat').controller('controleRemotoCtrl', function ($scope, $ionicModal, $http, config, $interval) {

    $scope.inputs = {
        c1: false,
        c2: false,
        c3: false,
        c4: false,
        joy: false,
        light: 50,
        vert: 50,
        horiz: 50
    };

    $interval(function () {
        _postData = {
            c1: $scope.inputs.c1 * 1,
            c2: $scope.inputs.c2 * 1,
            c3: $scope.inputs.c3 * 1,
            c4: $scope.inputs.c4 * 1,
            joy: $scope.inputs.joy * 1,
            light: 50,
            vert: 50,
            horiz: 50
        }

        $http.post(config.serverBaseUrl + "updateController.php", _postData)
            .then(function (response) {

            })
            .catch(function (error) {


            });

        /*$http.get(config.serverBaseUrl + "loadAlerts.php")
            .then(function (response) {
                //$scope.variables.actual = response.data;

            })
            .catch(function (error) {


            });*/

    }, 400);     

    // Executes the token check everytime it opens a page
    $scope.$on('$ionicView.enter', function (e) {
        // Access Token
        var _token = {
            token: localStorage.getItem('roboat')
        }
        _checkToken(_token);
    });

    // Check validity of the token
    var _checkToken = function (_token) {
        $http.post(config.serverBaseUrl + "checkToken.php", _token)
            .then(function (response) {
                if (typeof (response.data) == "object") {
                    if (response.data.name != "") {
                        $scope.accessLevel = _token.token.slice(7, 8);
                        $scope.name = response.data.name;
                    }
                    else {
                        $scope.accessLevel = 3;
                        $scope.name = '';
                        $scope.modal.show();
                    }
                }
                else {
                    $scope.accessLevel = 3;
                    $scope.name = '';
                    $scope.modal.show();
                }
            })
            .catch(function (error) { // Error handling
                $scope.accessLevel = 3;
                $scope.name = '';
                $scope.modal.show();
            });
    };
});