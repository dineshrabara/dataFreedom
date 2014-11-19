(function () {
    var app = angular.module("demo", ['dataFreedom']);

    app.controller("demoCtrl", ['$scope','dataFreedomService', function ($scope,dataFreedomService) {

        dataFreedomService.method = 'POST';        

        $scope.fetch=function(){
             dataFreedomService.fetch().then(function(data){
                $scope.data = data.data;
                $scope.total = data.total;
                $scope.totalItems = data.total;
                $scope.bigTotalItems = data.total;
                $scope.numPages = data.last_page;

                $scope.maxSize = data.per_page;

                $scope.currentPage = data.current_page;
                $scope.bigCurrentPage = data.current_page;
            },function(data){
                alert(data);
            });
        };

        $scope.pageChanged = function () {
            dataFreedomService.bigCurrentPage = $scope.bigCurrentPage;            
            $scope.fetch();
        };

        $scope.search = function (find) {            
            dataFreedomService.search = find;            
            $scope.fetch();
        };

        $scope.sort = function () {
            dataFreedomService.sort = $scope.sort;
            $scope.fetch();
        };

        $scope.fetch();

    }]);

})();