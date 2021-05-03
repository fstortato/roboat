angular.module('roboat').config(function ($stateProvider, $urlRouterProvider) {
    $stateProvider

    .state('app', {
        url: '/app',
        abstract: true,
        templateUrl: 'templates/menu.html',
        controller: 'sideMenuCtrl'
    })
    .state('app.dashboard', {
        url: '/dashboard',
        views: {
            'menuContent': {
                templateUrl: 'templates/dashboard.html',
                controller: 'dashboardCtrl'
            }
        }
    })
    .state('app.controle-remoto', {
        url: '/controle-remoto',
        views: {
            'menuContent': {
                templateUrl: 'templates/controle-remoto.html',
                controller: 'controleRemotoCtrl'
            }
        }
    })
    .state('app.sala-trofeus', {
        url: '/sala-trofeus',
        views: {
            'menuContent': {
                templateUrl: 'templates/sala-trofeus.html',
                controller: 'salaTrofeusCtrl'
            }
        }
    })
    .state('app.configuracoes', {
        url: '/configuracoes',
        views: {
            'menuContent': {
                templateUrl: 'templates/configuracoes.html',
                controller: 'configuracoesCtrl'
            }
        }
    });

// if none of the above states are matched, use this as the fallback
    $urlRouterProvider.otherwise('/app/dashboard');
});

