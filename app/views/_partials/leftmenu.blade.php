<a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>{{ trans('menu.dashboard') }}</a>
<ul id="dashboard-menu" class="nav nav-list collapse in">
    <li ><a href="calendar.html">{{ trans('menu.files') }}</a></li>
    <li>{{ link_to_route('dashboard.autores.store', trans('menu.authors')) }}</li>
    <li ><a href="users.html">{{ trans('menu.schools') }}</a></li>
    <li >{{ link_to_route('dashboard.generos.store', trans('menu.genres')) }}</li>
    <li >{{ link_to_route('dashboard.materiales.store', trans('menu.instruments')) }}</li>
    
</ul>

<a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i>{{ trans('menu.account') }}<span class="label label-info">+3</span></a>
<ul id="accounts-menu" class="nav nav-list collapse">
    <li >{{ link_to_route('logout', trans('menu.signout')) }}</li>
    <li ><a href="sign-up.html">{{ trans('menu.settings') }}</a></li>
    <li ><a href="reset-password.html">{{ trans('menu.restePassword') }}</a></li>
</ul>

<a href="help.html" class="nav-header" ><i class="icon-question-sign"></i>{{ trans('menu.help') }}</a>
<a href="faq.html" class="nav-header" ><i class="icon-comment"></i>{{ trans('menu.faq') }}</a>