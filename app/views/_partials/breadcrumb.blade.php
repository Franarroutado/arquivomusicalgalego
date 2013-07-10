<ul class="breadcrumb">
     <!-- TODO -> esta manera de breadcrub es muy chapu -->
    @if (Request::path() == 'dashboard')
      <li class="active">Dashboard</li>
    @elseif(Request::path() == 'dashboard/autores')
      <li><a href="{{ route('dashboard') }}">Dashboard</a> <span class="divider">/</span></li>
      <li class="active">Autores</li>
    @elseif(Request::path() == 'dashboard/autores')
      <li><a href="{{ route('dashboard') }}">Dashboard</a> <span class="divider">/</span></li>
      <li class="active">Autores</li>
    @endif
</ul>