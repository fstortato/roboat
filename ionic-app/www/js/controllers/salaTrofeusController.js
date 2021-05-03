angular.module('roboat').controller('salaTrofeusCtrl', function ($scope, $ionicModal, $timeout, $http, config, $ionicPopup) {

    $scope.cards = [{}];

    $scope.trophyPicturesPath = [
        'img/trophy-screen/trophy-gold.png',
        'img/trophy-screen/trophy-silver.png',
        'img/trophy-screen/trophy-bronze.png',
        'img/trophy-screen/trophy-white.png'
    ];

    // Executes the token check everytime it opens a page
    $scope.$on('$ionicView.enter', function (e) {
        // Access Token
        var _token = {
            token: localStorage.getItem('roboat')
        }
        _checkToken(_token);
        _loadCards();
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

    var _loadCards = function () {

        $http.get(config.serverBaseUrl + "loadCompetitionsAllInfos.php")
            .then(function (response) {
                console.log(response.data);
                $scope.cards = response.data;
            })
            .catch(function (error) {

            });
    };

    $scope.moreInfo = function (card) {
        this.buildTemplate = function () {
            cardText = '<ul>';
            cardText += '<li><b>Lugar: </b>' + card.competitionCity + ' - ' + card.competitionState + '</li>';
            cardText += '<li><b>Capitão: </b>' + card.competitionCaptain + '</li>';
            cardText += '<li><b>Tenente: </b>' + card.competitionLieutenant + '</li>';
            cardText += '<li><b>Orientador: </b>' + card.competitionAdvisor + '</li>'
            cardText += '<li><b>Integrantes: </b></li>';
            cardText += '<ul style="list-style-type:disc; padding-left: 10%;">';
            for (i = 0; i < card.competitionMembers.length; i++) {
                cardText += "<li>" + card.competitionMembers[i] + "</li>";
            }
            cardText += '</ul>';
            cardText += '<li><b>Provas: </b></li>';
            cardText += '<ul style="list-style-type:disc; padding-left: 10%;">';
            for (j = 0; j < card.competitionEvents.length; j++) {
                cardText += '<li>' + card.competitionEvents[j] + ': ' + card.competitionEventRanks[j] + 'º lugar </li>';
            }
            cardText += '</ul>';
            cardText += '<li><b>Comentários: </b>' + card.competitionComments + '</li>'
            cardText += '</ul>';
            return cardText;
        }

        var myPopup = $ionicPopup.confirm({
            title: card.competitionName + ' ' + card.competitionYear,
            template: this.buildTemplate(),
            scope: $scope,
            buttons: [
                {
                    text: 'Fechar',
                    type: 'button-dark',
                }
            ]
        });
    };

});