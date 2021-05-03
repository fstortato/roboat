angular.module('roboat').controller('sideMenuCtrl', function ($scope, $ionicModal, $timeout, $http, config) {

    // Form data for the login modal
    $scope.loginData = {
        userName: '',
        password: ''
    };

    $scope.showLoading = false;
    $scope.showWarning = false;
    $scope.backgroundColor = 'dark-background';
    $scope.warningText = '';

    // Create the login modal that we will use later
    $ionicModal.fromTemplateUrl('templates/login.html', {
        scope: $scope
    }).then(function (modal) {
        $scope.modal = modal;
    });

    // Triggered in the login modal to close it
    $scope.hideLogin = function() {
        $scope.modal.hide();
    };

    // Open the login modal
    $scope.showLogin = function() {
        $scope.modal.show();
    };

    // Access Token
    var _token = {
        token: localStorage.getItem('roboat')
    }

    // Perform the login action when the user submits the login form
    $scope.doLogin = function () {
        var _hide = false;
        $scope.showLoading = true;
        // Try to login and save the new token
        $http.post(config.serverBaseUrl + "login.php", $scope.loginData)
            .then(function (response) {
                if (response.data.startsWith("Authentication error")) {
                    $scope.backgroundColor = 'error-background';
                    $scope.warningText = 'Login não realizado. Verifique os dados e tente novamente.';
                    localStorage.setItem('roboat', '');
                }
                else {
                    $scope.backgroundColor = 'success-background';
                    $scope.warningText = 'Login realizado com sucesso.';
                    localStorage.setItem('roboat', response.data);
                    _hide = true;
                }
            })
            .catch(function (error) {
                $scope.showWarning = true;
                $scope.backgroundColor = 'error-background';
                $scope.warningText = 'Erro de conexão inesperado. Verifique se você está na rede Roboat.';
                localStorage.setItem('roboat', '');
            });
        // Simulate a login delay
        $timeout(function() {
            $scope.showLoading = false;
            $scope.showWarning = true;
            $timeout(function () {
                $scope.showWarning = false;
                if (_hide) $scope.hideLogin();
            }, 2000);
        }, 1000);
    };

    // Check validity of the token
    var _checkToken = function () {
        $http.post(config.serverBaseUrl + "checkToken.php", _token)
            .then(function (response) {
                console.log(response);
                if (typeof (response.data) == "object") {
                    if (response.data.name != "") {
                        $scope.accessLevel = _token.token.slice(7, 8);
                        $scope.name = response.data.name;
                        console.log(response.data.name);
                        console.log($scope.accessLevel)
                    }
                    else {
                        $scope.accessLevel = 3;
                        $scope.name = '';
                    }
                }
                else {
                    $scope.accessLevel = 3;
                    $scope.name = '';
                }
            })
            .catch(function (error) { // Error handling
                $scope.accessLevel = 3;
                $scope.name = '';
            });
    };
});