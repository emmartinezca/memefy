var app = angular.module('memefyApp',['ui.router','satellizer','ngAnimate','ngMessages','ngCookies','ui.bootstrap','ngFileUpload','ngImgCrop','remoteValidation']);
app.config(function($stateProvider, $urlRouterProvider, $authProvider) {

    $authProvider.loginUrl = '/api/authenticate';

    $urlRouterProvider.otherwise('/');

    /**
     * Helper auth functions
     */
    var skipIfLoggedIn = ['$q', '$auth', function($q, $auth) {
        var deferred = $q.defer();
        if ($auth.isAuthenticated()) {
            deferred.reject();
        } else {
            deferred.resolve();
        }
        return deferred.promise;
    }];

    var loginRequired = ['$q', '$location', '$auth', function($q, $location, $auth) {
        var deferred = $q.defer();
        if ($auth.isAuthenticated()) {
            deferred.resolve();
        } else {
            $location.path('/login');
        }
        return deferred.promise;
    }];

    $stateProvider
        .state('index', {
            url: '/',
            templateUrl: 'app/views/index.html',
            controller: 'IndexController as Index'
        })
        .state('memefy', {
            url: '/memefy',
            templateUrl: 'app/views/memefy.html',
            controller: 'MemefyController as Memefy',
            resolve: {
                loginRequired: loginRequired
            }
        })
        /*.state('auth', {
            url: '/auth',
            templateUrl: 'app/views/login.html',
            controller: 'AuthController as Auth'
        })*/
        .state('profile', {
            url: '/me',
            templateUrl: '/app/views/profile.html',
            controller: 'ProfileController as Profile',
            resolve: {
                loginRequired: loginRequired
            }
        })
        .state('register', {
            url: '/register',
            templateUrl: 'app/views/register.html',
            controller: 'RegisterController as Register',
            resolve: {
                skipIfLoggedIn: skipIfLoggedIn
            }
        })
        .state('passwordForgot', {
            url: '/forgot-password',
            templateUrl: 'app/views/password-forgot.html',
            controller: 'PasswordForgotController as PasswordForgot',
            resolve: {
                skipIfLoggedIn: skipIfLoggedIn
            }
        })
        .state('logout', {
            url: '/logout',
            templateUrl: null,
            controller: 'LogoutController as Logout'
        });
});

app.controller('IndexController', function($scope, $state) {
    $scope.randGradientBG = function() {
        $scope.style = {
            background: "linear-gradient(to bottom right, #"+(Math.random()*0xFFFFFF<<0).toString(16)+", #"+(Math.random()*0xFFFFFF<<0).toString(16)+")"
        };
    };

    $scope.randGradientBG();
});

app.controller('AuthController', function($scope, $auth, $state, $rootScope, $http) {
    $scope.randBG = function() {
        $scope.style = {
            background: "linear-gradient(to bottom right, #"+(Math.random()*0xFFFFFF<<0).toString(16)+", #"+(Math.random()*0xFFFFFF<<0).toString(16)+")"
        };
    };

    $scope.randBG();

    $scope.getProfile = function() {
        $http.get('/api/me/data')
        .then(function(data) {
            $scope.user = data.data.user;
            //console.log(data.data.user);
        })
        .catch(function(error) {
            console.log(error);
        });
    };

    $scope.login = function() {
        var credentials = {
            email: $scope.login.email,
            password: $scope.login.password
        };

        $auth.login(credentials)
            .then(function(data) {
                $scope.email = $scope.password = '';
                $scope.getProfile();
                $scope.isNavCollapsed = true;
                $state.go('memefy',{});
                //toaster.success({title: 'Bienvenido', body: $scope.user});
            })
            .catch(function(error) {
                if(error.status == 401) {
                    //toaster.error({title: 'Error', body: 'El usuario o la contraseña son incorrectos'});
                }
            });
    };

    $scope.isAuthenticated = function() {
        return $auth.isAuthenticated();
    };

    if($scope.isAuthenticated()) {
        $scope.getProfile();
    }
});

app.controller('MemefyController', function($scope, $auth, $state, $http, Upload, $timeout) {
    var getPosts = function() {
        $http.get('/api/posts')
        .then(function(data) {
            $scope.posts = data.data;
            console.log($scope.posts);
        })
        .catch(function(error) {
            console.log('Error while retrieving posts');
        });
    };

    $scope.likes = function(postId) {
        
    };

    $scope.createPost = function(file) {
        file.upload = Upload.upload({
            url: 'api/posts',
            data: $scope.post,
        });

        file.upload.then(function (response) {
            $timeout(function () {
                file.result = response.data;
                $scope.post = {
                    content: '',
                    picture: ''
                };
                getPosts();
            });
        }, function (response) {
            if (response.status > 0)
            $scope.errorMsg = response.status + ': ' + response.data;
        }, function (evt) {
            // Math.min is to fix IE which reports 200% sometimes
            file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
        });
    };

    getPosts();
});

app.controller('ProfileController', function() {

});

app.controller('RegisterController', function($scope, $http, $auth, $state, Upload, $timeout) {
    $scope.submitted = false;
    var login = function(data) {
        var credentials = {
            email: data.email,
            password: data.password
        };

        $auth.login(credentials)
            .then(function(data) {
                $scope.email = $scope.password = '';
                $scope.getProfile();
                $scope.isNavCollapsed = true;
                $state.go('memefy',{});
                //toaster.success({title: 'Bienvenido', body: $scope.user});
            })
            .catch(function(error) {
                if(error.status == 401) {
                    //toaster.error({title: 'Error', body: 'El usuario o la contraseña son incorrectos'});
                }
            });
    };

    $scope.register = function(isValid) {
        $scope.submitted = true;
        if(isValid) {
            Upload.upload({
                url: 'api/users',
                data: {
                    name: $scope.regData.name,
                    email: $scope.regData.email,
                    password: $scope.regData.password,
                    picture: Upload.dataUrltoBlob($scope.croppedDataUrl, $scope.regData.picture)
                },
            }).then(function (response) {
                $timeout(function () {
                    $scope.result = response.data;
                    login($scope.regData);
                });
            }, function (response) {
                if (response.status > 0) $scope.errorMsg = response.status + ': ' + response.data;
            }, function (evt) {
                $scope.progress = parseInt(100.0 * evt.loaded / evt.total);
            });
        }
    };
});

app.controller('PasswordForgotController', function() {
    $scope.recoverPassword = function() {
    };
});

app.controller('LogoutController', function($scope, $auth, $state) {
    if (!$auth.isAuthenticated()) { return; }
    $auth.logout()
        .then(function() {
            $scope.isNavCollapsed = true;
            $state.go('index');
        });
});
