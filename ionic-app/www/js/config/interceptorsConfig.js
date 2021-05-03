// Interceptors' configuration for $httpProvider

angular.module("roboat").config(function ($httpProvider) {
    $httpProvider.interceptors.push("timestampInterceptor");
});