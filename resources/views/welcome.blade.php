<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <!-- Styles -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/ng-img-crop.min.css" rel="stylesheet" type="text/css">
        <style>
            body, html {
                height: 100%;
                font-family: 'Nunito', sans-serif;
            }
            body {
                padding-top: 65px;
                margin: 0;
                background-repeat: no-repeat;
                background-attachment: fixed;
            }
            .panel-default {
                /*opacity: .9;*/
                border-radius: 0px;
            }
            .panel-default>.panel-heading {
                border-radius: 0;
                background-color: #fff;
                border: 0;
            }
            .form-control {
                border-radius: 0px;
            }
            .btn {
                border-radius: 0px;
            }
            #login-dp{
                min-width: 250px;
                padding: 14px 14px 0;
                overflow:hidden;
                background-color:rgba(255,255,255,.8);
            }
            #login-dp .help-block{
                font-size:12px
            }
            #login-dp .bottom{
                background-color:rgba(255,255,255,.8);
                border-top:1px solid #ddd;
                clear:both;
                padding:14px;
            }
            #login-dp .social-buttons{
                margin:12px 0
            }
            #login-dp .social-buttons a{
                width: 49%;
            }
            #login-dp .form-group {
                margin-bottom: 10px;
            }
            .btn-fb{
                color: #fff;
                background-color:#3b5998;
            }
            .btn-fb:hover{
                color: #fff;
                background-color:#496ebc
            }
            .btn-tw{
                color: #fff;
                background-color:#55acee;
            }
            .btn-tw:hover{
                color: #fff;
                background-color:#59b5fa;
            }
            @media(max-width:768px){
                #login-dp{
                    background-color: inherit;
                    color: #fff;
                }
                #login-dp .bottom{
                    background-color: inherit;
                    border-top:0 none;
                }
            }
            .profile-img {
                margin-top: -5px;
                margin-right: 5px;
                float: left;
                background: url(example.jpg) 50% 50% no-repeat; /* 50% 50% centers image in div */
                background-size: auto 100%; /* Interchange this value depending on prefering width vs. height */
                width: 30px;
                height: 30px;
            }
            .btn-media {
                border-top: 0;
            }
            .btn-social {
                border: 0;
            }
            .img-preview {
                max-width: 100px;
            }
            .btn-file {
                position: relative;
                overflow: hidden;
                border-top: 0;
            }
            .btn-file input[type=file] {
                position: absolute;
                top: 0;
                right: 0;
                min-width: 100%;
                min-height: 100%;
                font-size: 100px;
                text-align: right;
                filter: alpha(opacity=0);
                opacity: 0;
                outline: none;
                background: white;
                cursor: inherit;
                display: block;
            }
            .cropArea {
                background: #E4E4E4;
                overflow: hidden;
                width:250px;
                height:200px;
            }
        </style>
    </head>
    <body ng-app="memefyApp" ng-controller="AuthController" >
        <div id="nav-menu" class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="#">Nameless</a>
                    <button type="button" class="navbar-toggle" ng-click="isNavCollapsed = !isNavCollapsed">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse navbar-menubuilder" ng-init="isNavCollapsed = true" uib-collapse="isNavCollapsed">
                    <ul class="nav navbar-nav navbar-right">
                        <li ng-show="!isAuthenticated()"><a ui-sref="register"><b>Create account</b></a></li>
                        <li uib-dropdown ng-show="!isAuthenticated()">
                            <a uib-dropdown-toggle><b>Login</b> <span class="caret"></span></a>
                            <ul uib-dropdown-menu id="login-dp" ng-click="$event.stopPropagation()">
                                <li>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form ng-submit="login()" id="login-nav">
                                                <div class="form-group">
                                                    <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email address" ng-model="login.email" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                    <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" ng-model="login.password" required>
                                                    <div class="help-block text-right"><a href="">Forget the password ?</a></div>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                                </div>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"> keep me logged-in
                                                    </label>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="bottom text-center">
                                            New here ? <a href="#"><b>Join Us</b></a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li ng-show="isAuthenticated()"><a href ><i class="fa fa-fw fa-home fa-lg"></i></a></li>
                        <li ng-show="isAuthenticated()"><a href="/#/perfil"><b><img ng-src="storage/@{{ user.image }}" class="profile-img img-rounded">@{{ user.name }}</b></a></li>
                        <li ng-show="isAuthenticated()"><a href="/#!/logout"><i class="fa fa-fw fa-sign-out"></i> <b>Logout</b></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- main container -->
        <div class="container">
            <div ui-view></div>
        </div>
        <!-- /main container -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular-animate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular-cookies.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular-messages.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular-touch.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/1.0.3/angular-ui-router.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/satellizer/0.14.1/satellizer.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.5.0/ui-bootstrap.min.js"></script>
        <script src="js/ng-file-upload.min.js"></script>
        <script src="js/ng-file-upload-shim.min.js"></script>
        <script src="js/ng-img-crop.min.js"></script>
        <script src="js/ng-remote-validate.min.js"></script>
        <script src="{{ asset('app/app.js') }}"></script>
    </body>
</html>
