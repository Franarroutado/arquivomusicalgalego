<a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>{{ trans('menu.dashboard') }}</a>
<ul id="dashboard-menu" class="nav nav-list collapse in">
    <li ><a href="calendar.html">{{ trans('menu.files') }}</a></li>
    <li><a href="index.html">{{ trans('menu.authors') }}</a></li>
    <li ><a href="users.html">{{ trans('menu.schools') }}</a></li>
    <li ><a href="user.html">{{ trans('menu.genres') }}</a></li>
    <li ><a href="media.html">{{ trans('menu.instruments') }}</a></li>
    
</ul>

<a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i>{{ trans('menu.account') }}<span class="label label-info">+3</span></a>
<ul id="accounts-menu" class="nav nav-list collapse">
    <li ><a href="sign-in.html">{{ trans('menu.signin') }}</a></li>
    <li ><a href="sign-up.html">{{ trans('menu.signout') }}</a></li>
    <li ><a href="sign-up.html">{{ trans('menu.settings') }}</a></li>
    <li ><a href="reset-password.html">{{ trans('menu.restePassword') }}</a></li>
</ul>

<a href="help.html" class="nav-header" ><i class="icon-question-sign"></i>{{ trans('menu.help') }}</a>
<a href="faq.html" class="nav-header" ><i class="icon-comment"></i>{{ trans('menu.faq') }}</a>