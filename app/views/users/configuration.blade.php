@extends('master')

{{-- Breadcrumb --}}
@section('breadcrumbs', Breadcrumbs::render('usuariosPropiedades'))

{{-- Content --}}
@section('content')
<style>
    #compAddMaterial input {
      margin-left: 0px;
    }
    #contenedorCentros li:first-child input{
      -moz-box-shadow:    inset 0 0 3px rgb(81, 163, 81);
      -webkit-box-shadow: inset 0 0 3px rgb(81, 163, 81);
      box-shadow:         inset 0 0 3px rgb(81, 163, 81);
      background-color: #fff;
    }
    #contenedorCentros li:first-child:hover input{
      -moz-box-shadow:    inset 0 0 10px rgb(81, 163, 81);
      -webkit-box-shadow: inset 0 0 10px rgb(81, 163, 81);
      box-shadow:         inset 0 0 10px rgb(81, 163, 81);
    }
</style>
<div class="container-fluid">
  <div class="row-fluid">
    {{ Form::open(array('method' => 'POST', 'route' => array('dashboard.usuarios.configStore'))) }}
      <!-- <div class="btn-toolbar">
        <button class="btn btn-primary"><i class="icon-save"></i> {{ trans('button.save') }}</button>
        <a href="{{ route('dashboard.registros.index')  }}" class="btn">@lang('button.cancel')</a>
      </div> -->
      <div class="well">
        {{--DEFAULT LANGUAGE--}}
        <label for="cmbLang">Linguaxe por defecto</label>
        {{ Form::hidden('userId', $userId, array('id' => 'userId'))}}
        <div id="compAddCentros" class="input-append">
          {{ Form::select('cmbLang', array('' => 'Seleccione...',
                                          'es_gl' => 'GALEGO',
                                          'es_es' => 'CASTELÁN' ), $lang, array('id' => 'cmbLang')) }} 
          <button id="btnRefreshLang" class="btn btn-primary" type="button"><i class="icon-ok-sign"></i></button>
        </div>
        {{-- This line is needed for non SuperUsers --}}
        {{ Form::hidden('hidCentros', null, array('id' => 'hidCentros')) }}
        @if ($isSuperUser)
        {{-- FOLLOWING CODE IS SUPER USER ONLY --}}
          <label for="centros">Asignación de centros por usuario</label>
          <div class="well">
            <div id="compAddCentros" class="input-append">
              <select id="cbmUsuariosCentros" class="span2"></select>
              <select id="cbmCentros" class="span2"></select>         
              <button id="btnAddCentro" class="btn btn-primary" type="button"><i class="icon-plus-sign"></i></button>
            </div> {{-- compAddCentros  --}}
            <hr>
            <ul class="unstyled" id="contenedorCentros"></ul>
          </div>
          <label for="centros">Grupos</label>
          <div class="well">
          {{-- grupos --}}  
          <div id="compAddMaterial" class="input-append">
            <select id="cbmUsuarios" class="span2"></select>   
            <button id="btnAddGrupo" class="btn btn-primary" type="button"><i class="icon-plus-sign"></i></button>
          </div> {{-- compAddMaterial  --}}
          <hr>
          {{ Form::hidden('txtGrupos', $users_groups, array('id' => 'txtGrupos')) }}
          <ul class="unstyled" id="contenedorGrupos" class="container"></ul>
        </div>
        @else

          <dl>
            <dt>Roles asignados</dt>
            @foreach ($arrGroupName as $groupName)
              <dd>{{$groupName}}</dd>
            @endforeach
            <dt>Centros asignados:</dt>
            <dd>
              <ul class="unstyled" id="contenedorCentros"></ul>
            </dd>
          </dl>

        @endif
      </div>
     <!--  <div class="btn-toolbar">
        <button class="btn btn-primary"><i class="icon-save"></i> {{ trans('button.save') }}</button>
        <a href="{{ route('dashboard.registros.index')  }}" class="btn">@lang('button.cancel')</a>
        <div class="btn-group"></div>
      </div> -->
    {{ Form::close() }}
  </div> {{--row-fluid--}}
</div> {{--container-fluid--}}

{{ HTML::script('assets/lib/bootstrap/js/bootstrap.min.js') }}
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
  $(document).ready(function(){

    var colUsuarios = {{ $users }};
    var colGrupos = {{ $groups }};
    var colUsuarios_grupos = {{ $users_groups }};
    var colCentros = {{ $centros }};

    function init()
    {
      // Add this plugin in Jquery
      $.substitute = function(str, sub) {
        return str.replace(/\{(.+?)\}/g, function($0, $1) {
          return $1 in sub ? sub[$1] : $0;
        });
      };
      $.getJSON('/dashboard/rest/usuario/getCentros/'+$('#userId').val(), function(result){
        var arrCentros = result.split(',');
        $('#hidCentros').val(result);
        refreshCentrosContainer(arrCentros, $('#contenedorCentros'));
      });

      enableDragnDrop();
    }

    function initSuperUser() 
    {
      // Add this plugin in Jquery
      $.substitute = function(str, sub) {
        return str.replace(/\{(.+?)\}/g, function($0, $1) {
          return $1 in sub ? sub[$1] : $0;
        });
      };

      var options=
      { placement: "right",
        title: "Título",
        trigger: "manual",
        content: "Este es el contenido"};
      $('#btnRefreshLang').popover(options);

      // Load user combos
      var $cbmUsuarios = $('#cbmUsuarios');
      var $cbmUsuariosCentros = $('#cbmUsuariosCentros');
      var $cbmCentros = $('#cbmCentros');
      var defaultOption = $('<option value="">Seleccione...</option>');
      $cbmUsuarios.append(defaultOption);
      $cbmUsuariosCentros.append(defaultOption.clone());
      $cbmCentros.append(defaultOption.clone());
      $.each(colUsuarios, function(key, value){
        var option = $('<option></option>').attr('value', key).text(value);
        $cbmUsuarios.append(option);
        $cbmUsuariosCentros.append(option.clone());
      });
      $.each(colCentros, function(key, value){
        var option = $('<option></option>').attr('value', key).text(value);
        $cbmCentros.append(option);
      });

      // Load groups checkboxes
      $.each(colGrupos, function(key, value) {
        $('#cbmUsuarios').after(buildCheckBoxComponent(key, value));
      });

      loadUsersGroupsConfiguration();
      enableDragnDrop();
    }

    function enableDragnDrop()
    {
      $('#contenedorCentros').sortable({
        revert:true,
        stop: reorderCentrosItems
      });
    }

    function reorderCentrosItems() 
    {
      var $contenedorCentros= $('#contenedorCentros');
      var $items = $contenedorCentros.find('input'); // get the items with data

      var arrCentros= new Array();
      $.each($items, function(key, value) {
        arrCentros.push( $(value).data('key') );
      });
      $('#hidCentros').val(arrCentros.join(','));
      refreshCentrosContainer(arrCentros, $contenedorCentros);

      refreshServer();
      showMessage('success', 'Ahora o centro por defecto e ' + $items.first().val());
    }

    function refreshServer(message)
    {
      @if ($isSuperUser)
        var userId= $('#cbmUsuariosCentros').find(':selected').attr('value');
      @else
        var userId= $('#userId').val()
      @endif
      $.getJSON('/dashboard/rest/usuario/setCentros/'+userId+'/'+$('#hidCentros').val(), function(result){
        if (typeof message != 'undefined') showMessage('success', message);
      });
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
      //var txtNombreCentro = $cbmCentros.find(':selected').text();
      var txtIdCentro = $cbmCentros.find(':selected').attr('value');
      var $hidCentros = $('#hidCentros'); // get all centros avaliable

      if (txtIdCentro.length ==0 ) return alert('Seleccione'); // check if a valid option is selected

      
      if ($hidCentros.val().indexOf(txtIdCentro) != -1)
      {
        alert('ya existe uno igual');
      } else {
        if ($hidCentros.val().length >= 1) $hidCentros.val($hidCentros.val() + ','); // add a comma if there are more than one centro
        $hidCentros.val($hidCentros.val() + txtIdCentro);
       
        var arrCentros = $hidCentros.val().split(',');
        var $contenedorCentros= $('#contenedorCentros');
        $contenedorCentros.fadeOut('fast');
        refreshCentrosContainer(arrCentros, $contenedorCentros);
        $contenedorCentros.fadeIn();
        refreshServer();
      }
    });

    function buildComponentWithButton(key, value) 
    {
      @if ($isSuperUser)
        // Load the component
        var newComponent = '<li><div class="input-append">' +
          '<label style="cursor: move;" class="btn"><i class="icon-move"></i> </label>' +
          '<input class="span6" data-key="{key}" value="{value}" disabled type="text">' +
          '<button class="btn" type="button"><i class="icon-remove"></i> </button></div></li>';
      @else
        // Load the component
        var newComponent = '<li><div class="input-append">' +
          '<label style="cursor: move;" class="btn"><i class="icon-move"></i> </label>' +
          '<input class="span6" data-key="{key}" value="{value}" disabled type="text"></div></li>';
      @endif
      return $.substitute(newComponent, {key:key, value:value});
    }

    $('#btnRefreshLang').on('click', 
      function(e){ 
        var userId = $('#userId').val();
        var langSelected = $('#cmbLang').find(':selected').attr('value');
        $.getJSON('/dashboard/rest/usuario/setlang/'+userId+'/'+langSelected, function(result) {
          showMessage('success', 'Linguaxe establecido ' + $('#cmbLang').find(':selected').text());
      });
    });

    $('#cbmUsuariosCentros').on('change', function(e) {
      e.preventDefault();
      var userId = $(this).find(':selected').attr('value');
      $contenedorCentros= $('#contenedorCentros');
      $contenedorCentros.fadeOut('fast');
      $.getJSON('/dashboard/rest/usuario/getCentros/'+userId, function(result){
        var arrCentros = result.split(',');
        $('#hidCentros').val(result);
        refreshCentrosContainer(arrCentros, $contenedorCentros);
        $contenedorCentros.fadeIn();
      });
    });

    function refreshCentrosContainer(arrCentros, contenedor)
    {
      contenedor.html("");
      for (var i = 0; i < arrCentros.length; i++) 
      {
        if (arrCentros[i].toString().length >= 1) contenedor.append(buildComponentWithButton(arrCentros[i], colCentros[arrCentros[i]])); 
      }
    }

    function showMessage(type, message)
    {
      // types avaliable: success | error | warning | info
      var htmlMessage = '<div class="row-fluid"><div class="alert alert-{msgType}">' +
      '<button type="button" class="close" data-dismiss="alert">×</button>' +
      '<strong>{content}</strong></div></div>';
      htmlMessage =  $.substitute(htmlMessage, {msgType:type, content:message});
      $('#messages').append(htmlMessage);
    }

    $('#contenedorCentros').on('click', 'button', function(e){
       var idCentro = $(e.target).parent().find('input').data('key'),
          $hidCentros =  $('#hidCentros'),
          arrCentros = $hidCentros.val().split(',');
      for (var i = 0; i < arrCentros.length; i++) if (arrCentros[i] == idCentro) arrCentros.splice(i, 1);
      
      $hidCentros.val(arrCentros.join(','));
      refreshCentrosContainer(arrCentros, $('#contenedorCentros'));
    });

    @if ($isSuperUser)
      initSuperUser();
    @else
      init();
    @endif
  });
</script>
@stop