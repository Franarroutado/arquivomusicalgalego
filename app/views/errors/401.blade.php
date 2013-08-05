<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{{ trans('app.pagetitle') }}</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="{{ url('assets/lib/bootstrap/css/bootstrap.css') }}">
    
    <link rel="stylesheet" href="{{ url('assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{ url('assets/lib/font-awesome/css/font-awesome.css') }}">

    <script src="{{ url('assets/lib/jquery-1.7.2.min.js') }}"></script>


    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <style>
  img {
    -webkit-box-shadow: 5px 5px 5px #000;
    -moz-box-shadow: 5px 5px 5px #000;
    box-shadow: 5px 5px 5px #000;
  }
  </style>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 http-error"> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 http-error"> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 http-error"> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body class="http-error"> 
  <!--<![endif]-->
    
    <div class="row-fluid">
      <div class="http-error">
        <h1>{{ trans(AMG::returnRandomArrayValue(array('app.401.expresion1', 'app.401.expresion2', 'app.401.expresion3'))) }}</h1>
        <p class="info">{{ trans('app.401.message')  }} <br/>{{ HTML::image('assets/img/404/'.rand(1,3).'.gif') }}</p>

        <p><i class="icon-home"></i></p>
        <p><a href="{{ route('dashboard') }}">{{ trans('app.404.gohome')  }}</a></p>
      </div>
    </div>
    
  </body>
</html>


