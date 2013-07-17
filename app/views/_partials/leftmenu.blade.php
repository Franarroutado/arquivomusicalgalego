<a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>{{ trans('menu.dashboard') }}</a>
<ul id="dashboard-menu" class="nav nav-list collapse in">

    <?php  $user = Sentry::getUser() ?>
    @if ($user->hasAccess('dashboard.registros.index'))
      <li>{{ link_to_route('dashboard.registros.index', trans('menu.files')) }}</li>
    @endif
    @if ($user->hasAccess('dashboard.autores.index'))
      <li>{{ link_to_route('dashboard.autores.index', trans('menu.authors')) }}</li>
    @endif
    @if ($user->hasAccess('dashboard.centros.index'))
      <li>{{ link_to_route('dashboard.centros.index', trans('menu.schools')) }}</li>
    @endif
    @if ($user->hasAccess('dashboard.generos.index'))
      <li>{{ link_to_route('dashboard.generos.index', trans('menu.genres')) }}</li>
    @endif
    @if ($user->hasAccess('dashboard.materiales.index'))
      <li>{{ link_to_route('dashboard.materiales.index', trans('menu.instruments')) }}</li>
    @endif
    
</ul>

<a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i>{{ trans('menu.account') }}<span class="label label-info">+3</span></a>
<ul id="accounts-menu" class="nav nav-list collapse">
    <li >{{ link_to_route('logout', trans('menu.signout')) }}</li>
    <li >{{ link_to_route('dashboard.usuarios.config', trans('menu.settings')) }}</li>
    <li ><a href="reset-password.html">{{ trans('menu.restePassword') }}</a></li>
</ul>

<a href="help.html" class="nav-header" ><i class="icon-question-sign"></i>{{ trans('menu.help') }}</a>
<a href="faq.html" class="nav-header" ><i class="icon-comment"></i>{{ trans('menu.faq') }}</a>