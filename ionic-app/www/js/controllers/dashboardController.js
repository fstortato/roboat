angular.module('roboat').controller('dashboardCtrl', function ($scope, $ionicModal, $interval, $http, config) {

    $interval(function () {

        $http.get(config.serverBaseUrl + "loadLastMeasure.php")
            .then(function (response) {
                $scope.measure = response.data;
            })
            .catch(function (error) {

            });

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