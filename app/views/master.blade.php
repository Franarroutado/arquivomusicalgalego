<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>@lang('app.pagetitle')</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    {{ HTML::style('assets/lib/bootstrap/css/bootstrap.css') }}
    
    {{ HTML::style('assets/css/theme.css') }}
    {{ HTML::style('assets/lib/font-awesome/css/font-awesome.css') }}

    {{-- HTML::script('assets/lib/jquery-1.7.2.min.js')  --}}
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

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
                
                <li>{{ link_to_route('dashboard.usuarios.config', trans('menu.settings'), null, array('role' => 'button','class' => 'hidden-phone visible-tablet visible-desktop')) }}</li>
                <li id="fat-menu" class="dropdown">
                    <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user"></i> {{ Sentry::getUser()->first_name  }}
                        <i class="icon-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>{{ link_to_route('dashboard.usuarios.config', trans('menu.settings'), null, array('tabindex' => '-1')) }}</li>
                        <li class="divider visible-phone"></li>
                        <li>{{ link_to_route('logout', trans('menu.signout'), null, array('tabindex' => -1)) }}</li>
                    </ul>
                </li>
                
            </ul>
            <a class="brand" href="index.html">
              <span class="first">@lang('app.title')</span> 
              <span class="second">{{ AMG::returnDefaultCenterName(Sentry::getUser()->id) }}</span>
            </a>
        </div> <!-- navbar-inner -->
    </div> <!-- navbar -->
    
    <div class="sidebar-nav">
      @include('_partials.leftmenu')
    </div>

    <div class="content">
        
        @include('_partials.header')

        @yield('breadcrumbs')

        <div class="container-fluid">

            @include('_partials.displayMessages')

            @yield('content')

            @include('_partials.footer')
        </div> <!-- container-fluid -->
    </div> <!-- content -->
    {{ HTML::script('assets/lib/bootstrap/js/bootstrap.js') }}
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  </body>
</html>