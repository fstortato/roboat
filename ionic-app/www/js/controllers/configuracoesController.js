angular.module('roboat').controller('configuracoesCtrl', function ($scope, $ionicModal, $timeout, $http, config, $ionicPopup) {

    $scope.newUserData = {};
    $scope.userData = {};
    $scope.newTrophyData = {};
    $scope.trophyData = {};
    $scope.limitsData = {};

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

    var _saveNewUser = function (userData) {
        $http.post(config.serverBaseUrl + "insertUser.php", userData)
            .then(function (response) {

            })
            .catch(function (error) { // Error handling

            });

    };

    var _deleteUser = function (userData) {
        $http.post(config.serverBaseUrl + "deleteUser.php", userData)
            .then(function (response) {
                
            })
            .catch(function (error) { // Error handling

            });

    };

    var _saveTrophy = function (trophyData) {
        $http.post(config.serverBaseUrl + "insertTrophy.php", trophyData)
            .then(function (response) {
            })
            .catch(function (error) { // Error handling
            });
    };

    var _deleteTrophy = function (trophyData) {
        $http.post(config.serverBaseUrl + "deleteTrophy.php", trophyData)
            .then(function (response) {
            })
            .catch(function (error) { // Error handling
            });
    };

    var _updateLimits = function (limitsData) {
        $http.post(config.serverBaseUrl + "updateLimits.php", limitsData)
            .then(function (response) {
            })
            .catch(function (error) { // Error handling
            });
    };

    //Popup de novo usuário
    $scope.newUser = function () {
        var myPopup = $ionicPopup.show({
            template: '<input type="text" ng-model="newUserData.name" placeholder="Primeiro nome" style="padding: 10px;">' + '<div class="spacer" style="height: 2px;"></div>' + '<input type="text" ng-model="newUserData.username" placeholder="Nome de usuário" style="padding: 10px;">' + '<div class="spacer" style="height: 2px;"></div>' + '<div class="list"><label class="item item-input item-select" style="padding: 10px"><div class="input-label" style="font-size: 14px; color: darkgray">Tipo de usuário</div><select style="font-size: 14px; color: black" ng-model="newUserData.type"><option style="font-size: 12px; color: #1D97FA">Admin</option><option style="font-size: 12px; color: #1D97FA">Piloto</option><option style="font-size: 12px; color: #1D97FA">Equipe</option><option style="font-size: 12px; color: #1D97FA">Visitante</option></select></label></div>',
            title: 'Insira os dados do novo usuário',
            scope: $scope,
            buttons: [
                {
                    text: 'Salvar',
                    type: 'button-positive',
                    onTap: function (e) {
                        switch ($scope.newUserData.type) {
                            case 'Admin':
                                $scope.newUserData.type = 0;
                                break;
                            case 'Piloto':
                                $scope.newUserData.type = 1;
                                break;
                            case 'Equipe':
                                $scope.newUserData.type = 2;
                                break;
                            case 'Visitante':
                                $scope.newUserData.type = 3;
                                break;
                            default:
                                $scope.newUserData.type = 4;
                        }
                        _saveNewUser($scope.newUserData);
                        $scope.newUserData = {};
                    }
                },
                {
                    text: 'Cancelar',
                    type: 'button-assertive'
                }
            ]
            });
    };

    $scope.deleteUser = function () {

        $http.get(config.serverBaseUrl + "loadUsernames.php")
            .then(function (response) {
                $scope.names = response.data;
            })
            .catch(function (error) {

            });

        var myPopup = $ionicPopup.show({
            template: '<div class="list"><label class="item item-input item-select" style="padding: 10px"><div class="input-label" style="font-size: 14px; color: darkgray">Username</div><select style="font-size: 14px; color: black" ng-model="userData.username"><option ng-repeat="name in names" style="font-size: 12px; color: #1D97FA">{{name}}</option></select></label></div>',
            title: 'Selecione o usuário a ser apagado',
            scope: $scope,
            buttons: [
                {
                    text: 'Apagar',
                    type: 'button-positive',
                    onTap: function (e) {
                        _deleteUser($scope.userData);
                        $scope.userData = {
                            username: ''
                        };
                    }
                },
                {
                    text: 'Cancelar',
                    type: 'button-assertive'
                }
            ]
        });
    };

    $scope.newTrophy = function () {
        var myPopup = $ionicPopup.show({
            template: '<label>Competição:</label><input type="text" ng-model="newTrophyData.competitionName" placeholder="DUNA" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Ano:</label><input type="number" ng-model="newTrophyData.competitionYear" placeholder="2010" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Posição Geral:</label><input type="number" ng-model="newTrophyData.competitionRank" placeholder="1" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Número de equipes:</label><input type="number" ng-model="newTrophyData.competitionNTeams" placeholder="20" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Cidade:</label><input type="text" ng-model="newTrophyData.competitionCity" placeholder="Joinville" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Estado:</label><input type="text" ng-model="newTrophyData.competitionState" placeholder="SC" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Capitão:</label><input type="text" ng-model="newTrophyData.competitionCaptain" placeholder="João" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Tenente:</label><input type="text" ng-model="newTrophyData.competitionLieutenant" placeholder="José" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Integrantes:</label><input type="text" ng-model="newTrophyData.competitionMembers" placeholder="João, José" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Orientador:</label><input type="text" ng-model="newTrophyData.competitionAdvisor" placeholder="Daniela" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Provas:</label><input type="text" ng-model="newTrophyData.competitionEvents" placeholder="Barcaça-3, Cabo de Guerra-1" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Comentários:</label><input type="text" ng-model="newTrophyData.competitionComments" placeholder="Melhorar desempenho nas curvas." style="padding: 10px;">',
            title: 'Insira os dados da competição',
            scope: $scope,
            buttons: [
                {
                    text: 'Salvar',
                    type: 'button-positive',
                    onTap: function (e) {
                        _saveTrophy($scope.newTrophyData);
                        $scope.newTrophyData = {};
                    }
                },
                {
                    text: 'Cancelar',
                    type: 'button-assertive'
                }
            ]
        });
    };

    $scope.deleteTrophy = function () {

        $http.get(config.serverBaseUrl + "loadCompetitionBasics.php")
            .then(function (response) {
                $scope.competitions = response.data;
            })
            .catch(function (error) {

            });

        var myPopup = $ionicPopup.show({
            template: '<div class="list"><label class="item item-input item-select" style="padding: 10px"><div class="input-label" style="font-size: 14px; color: darkgray">Competição</div><select style="font-size: 14px; color: black" ng-model="trophyData.competitionId"><option ng-repeat="competition in competitions" style="font-size: 12px; color: #1D97FA">{{competition}}</option></select></label></div>',
            title: 'Selecione a competição a ser apagada',
            scope: $scope,
            buttons: [
                {
                    text: 'Apagar',
                    type: 'button-positive',
                    onTap: function (e) {
                        var _indexOfHyphen = $scope.trophyData.competitionId.indexOf("-");
                        $scope.trophyData.competitionId = $scope.trophyData.competitionId.slice(0, _indexOfHyphen);
                        _deleteTrophy($scope.trophyData);
                    }
                },
                {
                    text: 'Cancelar',
                    type: 'button-assertive'
                }
            ]
        });
    };

    $scope.changeLimits = function () {

        $http.get(config.serverBaseUrl + "loadLimits.php")
            .then(function (response) {
                $scope.limits = response.data;
                $scope.limits.voltageCells = $scope.limits.voltageCells * 1;
                $scope.limits.currentMotors = $scope.limits.currentMotors * 1;
                $scope.limits.temperatureControllers = $scope.limits.temperatureControllers * 1;
                $scope.limits.temperatureMotors = $scope.limits.temperatureMotors * 1;
                $scope.limits.waterFlow = $scope.limits.waterFlow * 1;
                $scope.limits.waterLevel = $scope.limits.waterLevel * 1;
            })
            .catch(function (error) {

            });

        var myPopup = $ionicPopup.show({
            template: '<label>Tensão por célula:</label><input type="number" ng-model="limits.voltageCells" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Corrente em cada motor:</label><input type="number" ng-model="limits.currentMotors" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Temperatura em cada controlador:</label><input type="number" ng-model="limits.temperatureControllers" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Temperatura em cada motor:</label><input type="number" ng-model="limits.temperatureMotors" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Fluxo de água:</label><input type="text" ng-model="limits.waterFlow" style="padding: 10px;">' +
            '<div class="spacer" style="height: 5px;"></div>' +
            '<label>Nível de água:</label><input type="text" ng-model="limits.waterLevel" style="padding: 10px;">',
            title: 'Insira os limites de cada variável medida',
            scope: $scope,
            buttons: [
                {
                    text: 'Salvar',
                    type: 'button-positive',
                    onTap: function (e) {
                        _updateLimits($scope.limits);

                    }
                },
                {
                    text: 'Cancelar',
                    type: 'button-assertive'
                }
            ]
        });



    }
});