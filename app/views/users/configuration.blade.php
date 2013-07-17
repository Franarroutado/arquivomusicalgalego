@extends('master')

{{-- Breadcrumb --}}
@section('breadcrumbs', Breadcrumbs::render('usuariosPropiedades'))

{{-- Content --}}
@section('content')
<style>
    #compAddMaterial input {
      margin-left: 0px;
    }
    ul.container li {
      display: block;
    }
</style>
<div class="container-fluid">
  <div class="row-fluid">
    {{ Form::open(array('method' => 'POST', 'route' => array('dashboard.usuarios.configStore'))) }}
      <div class="btn-toolbar">
        <button class="btn btn-primary"><i class="icon-save"></i> {{ trans('button.save') }}</button>
        <a href="{{ route('dashboard.registros.index')  }}" class="btn">@lang('button.cancel')</a>
      </div>
      <div class="well">
        {{--DEFAULT LANGUAGE--}}
        <label for="txtLang">Linguaxe por defecto</label>
        {{ Form::text('txtLang', null, ['class'=>'input-small']) }}
        
        <?php $user = Sentry::getUser() ?>
        @if ($user->isSuperUser())
        {{-- FOLLOWING CODE IS SUPER USER ONLY --}}
          <label for="centros">Centros</label>
          {{ Form::hidden('centros') }}
          <div class="well">
            <div id="compAddCentros" class="input-append">
              <select id="cbmCentros" class="span2">
                <option value="">Seleccione...</option>
                @foreach($centros as $centro)
                  <option value="{{ $centro->id }}">{{ $centro->nombre }}</option>
                @endforeach
              </select>         
              <button id="btnAddCentro" class="btn" type="button"><i class="icon-plus-sign"></i></button>
            </div> {{-- compAddCentros  --}}
            <hr>
            <ul id="contenedorCentros"></ul>
          </div>
          <label for="centros">Grupos</label>
          <div class="well">
          {{-- grupos --}}  
          <div id="compAddMaterial" class="input-append">
            <select id="cbmUsuarios" class="span2"></select>   
            <button id="btnAddGrupo" class="btn" type="button"><i class="icon-plus-sign"></i></button>
          </div> {{-- compAddMaterial  --}}
          <hr>
          {{ Form::hidden('txtGrupos', $users_groups, ['id' => 'txtGrupos']) }}
          <ul id="contenedorGrupos" class="container"></ul>
        </div>
        @else
          Mostra grupos y centros
        @endif
      </div>
      <div class="btn-toolbar">
        <button class="btn btn-primary"><i class="icon-save"></i> {{ trans('button.save') }}</button>
        <a href="{{ route('dashboard.registros.index')  }}" class="btn">@lang('button.cancel')</a>
        <div class="btn-group"></div>
      </div>
    {{ Form::close() }}
  </div> {{--row-fluid--}}
</div> {{--container-fluid--}}
<script>
  $(document).ready(function(){

    var colUsuarios = {{ $users }};
    var colGrupos = {{ $groups }};
    var colUsuarios_grupos = {{ $users_groups }};
    var colCentros = {centros:""};

    function init() 
    {
      // Add this plugin in Jquery
      $.substitute = function(str, sub) {
          return str.replace(/\{(.+?)\}/g, function($0, $1) {
              return $1 in sub ? sub[$1] : $0;
          });
      };

      // Load user combo
      var $cbmUsuarios = $('#cbmUsuarios');
      $.each(colUsuarios, function(key, value){
        $cbmUsuarios.append($('<option></option>').attr('value', key).text(value));
      });

      // Load groups checkboxes
      $.each(colGrupos, function(key, value) {
        $('#cbmUsuarios').after(buildCheckBoxComponent(key, value));
      });

      loadUsersGroupsConfiguration();
    }

    function loadUsersGroupsConfiguration()
    {
      var $contenedorGrupos = $('#contenedorGrupos');
      $contenedorGrupos.children().remove();
      $.each(colUsuarios_grupos, function(key, value){
        var newKey = key + ":"  + value;
        var newValue = colUsuarios[key] + " (" + colGrupos[value] + ")";
        var newComponent = buildComponentWithoutButton(newKey, newValue);
        $contenedorGrupos.append(newComponent);
      });
    }

    function buildCheckBoxComponent(key, value) 
    {
      var newCheckbox = '<label class="checkbox btn">' +
        '<input data-key="{key}" type="radio" name="optionsRadios">&nbsp;{value}</label>';
      return $.substitute(newCheckbox, {key:key, value:value});
    }

    function buildComponentWithoutButton(key, value) 
    {
      // Load the component
      var newComponent = '<li><div class="input-append">' +
        '<input class="span4" data-key="{key}" value="{value}" disabled type="text"></div></li>';
      return $.substitute(newComponent, {key:key, value:value});
    }


    $('#btnAddGrupo').on('click', function() {
      var $cbmUsuarios = $('#cbmUsuarios');
      var txtUsuario = $cbmUsuarios.find(':selected').text();
      var txtIdUsuario = $cbmUsuarios.find(':selected').attr('value');
      var chkHijos = $(this).parent().find('input');
      
      var arrGruposSel = [];
      $.each(chkHijos, function(index, item){
        var $ckbox = $(item);
        if ($ckbox.prop('checked')) arrGruposSel.push($ckbox.data('key'));
        $ckbox.prop('checked', false); 
      });

      // Make the changes into the collection
      colUsuarios_grupos[txtIdUsuario] = arrGruposSel.join(',');

      loadUsersGroupsConfiguration();

      refreshHiddentxtGrupos();
    });

    function refreshHiddentxtGrupos()
    {
      $('#txtGrupos').val(JSON.stringify(colUsuarios_grupos));
    }

    $('#btnAddCentro').on('click', function() {
      var $cbmCentros = $('#cbmCentros');
      var txtNombreCentro = $cbmCentros.find(':selected').text();
      var txtIdCentro = $cbmCentros.find(':selected').attr('value');

      if (txtIdCentro.length ==0 ) return alert('Seleccione');

      console.log(colCentros);
      var arrCentros = colCentros['centros'].split(',');
      if ($.inArray(txtIdCentro, arrCentros) == -1) 
      {
        arrCentros.push(txtIdCentro);
        colCentros['centros'] = arrCentros.join(',');
      }
      console.log(colCentros);
      //$('#contenedorCentros').append(buildComponentWithButton(txtIdCentro, txtNombreCentro));

    });

    function buildComponentWithButton(key, value) 
    {
      // Load the component
      var newComponent = '<li><div class="input-append">' +
        '<label style="cursor: move;" class="btn"><i class="icon-move"></i> </label>' +
        '<input class="span6" data-key="{key}" value="{value}" disabled type="text">' +
        '<button class="btn deleteGenre" type="button"><i class="icon-remove"></i> </button></div></li>';
      return $.substitute(newComponent, {key:key, value:value});
    }

    init();
  });
</script>
@stop