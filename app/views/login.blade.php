<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>@lang('app.pagetitle')</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="{{ url('assets/lib/bootstrap/css/bootstrap.css') }}">
    
    <link rel="stylesheet" href="{{ url('assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{ url('assets/lib/font-awesome/css/font-awesome.css') }}">

    <script src="{{ url('assets/lib/jquery-1.7.2.min.js') }}"></script>

    <!-- Demo page code -->

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>

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

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body class=""> 
  <!--<![endif]-->
    
    <div class="navbar">
        <div class="navbar-inner">
                <ul class="nav pull-right">
                    
                </ul>
                <a class="brand" href="index.html">
                    <span class="first"> @lang('app.title') </span> 
                    <span class="second"> @lang('app.login.title') </span>
                </a>
        </div>
    </div>

    <div class="row-fluid">
    <div class="dialog">

        @include('_partials.displayMessages')
        
        <div class="block">
            <p class="block-heading">@lang('app.login.signin')</p>
            <div class="block-body">
                {{ Form::open(array('route' => 'post.login')) }}
                    <label>@lang('app.login.username')                        
                         {{ AMG::displayErr($errors, 'username') }}
                    </label>
                    {{ Form::text('username', null, array('class' => 'span12')) }}
                    <label>@lang('app.login.password') 
                        {{ AMG::displayErr($errors, 'password') }}
                    </label>
                    {{ Form::password('password', array('class' => 'span12')) }}
                    {{ Form::submit( trans('app.login.signin'), array('class' => 'btn btn-primary pull-right')) }}
                    <label class="remember-me">{{ Form::checkbox('rememberme') }} @lang('app.login.rememberme')</label>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
        <p class="pull-right" style=""><a href="http://www.portnine.com" target="blank">Theme by Portnine</a></p>
        <p><a href="reset-password.html">@lang('app.msg.forgot_your_password')</a></p>
    </div>
</div>


    


    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  </body>
</html>


