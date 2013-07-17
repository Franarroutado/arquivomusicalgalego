@extends('master')

{{-- Breadcrumb --}}
@section('breadcrumbs', Breadcrumbs::render('generosCreate'))

{{-- Content --}}
@section('content')
  <style>
    #compAddMaterial input {
      margin-left: 0px;
    }

    ul#materialContainer li {
      display: block;
    }
  </style>
  <div class="container-fluid">
    <div class="row-fluid">
      {{ Form::open(array('method' => 'POST', 'route' => array('dashboard.registros.store'))) }}
        <div class="btn-toolbar">
          <button class="btn btn-primary"><i class="icon-save"></i> {{ trans('button.save') }}</button>
          <a href="{{ route('dashboard.registros.index')  }}" class="btn">@lang('button.cancel')</a>
          <div class="btn-group"></div>
        </div>
        <div class="well">
              {{ Form::label('nombre', trans('app.files.title').":").AMG::displayErr($errors, 'nombre') }}
              {{ Form::text('nombre', null, array('class' => 'input-xlarge')) }}
              {{ Form::label('autore_id', trans('app.files.author').":").AMG::displayErr($errors, 'autore_id') }}
              {{ Form::text('autor', null, array('autocomplete'=>'off', 'class' => 'input-xlarge', 'id' => 'autor')) }}
              {{ Form::hidden('autore_id') }}
              {{ Form::label('genero_id', trans('app.files.genre').":").AMG::displayErr($errors, 'genero_id') }}
              {{ Form::text('genero', null, array('autocomplete'=>'off', 'class' => 'input-xlarge', 'id' => 'genero')) }}
              {{ Form::hidden('genero_id') }}
              {{ Form::label('arreglista', trans('app.files.fixer').":") }}
              {{ Form::checkbox('arreglista') }}
              {{ Form::label('tipo', trans('app.files.type').":") }}
              {{ Form::select('tipo', array('-1' => 'Elixa un tipo',
                                        'ORIXINAL' => 'ORIXINAL',
                                        'COPIA' => 'COPIA',
                                        'ARRANXO' => 'ARRANXO',
                                        'TRANSCRICIÓN' => 'TRANSCRICIÓN', )) }} 
              {{ Form::label('fecha', trans('app.files.date').":").AMG::displayErr($errors, 'fecha') }}
              {{ Form::text('fecha', null, array('class' => 'input-xlarge')) }}
              {{ Form::label('centro_id', trans('app.files.school').":").AMG::displayErr($errors, 'centro_id') }}
              {{ Form::text('centro', null, array('autocomplete'=>'off','class' => 'input-xlarge', 'id' => 'centro')) }}
              {{ Form::hidden('centro_id') }}
              {{ Form::label('material', trans('app.files.material').":").AMG::displayErr($errors, 'lang') }}
              {{ Form::textarea('material', '{}') }}
              <div class="well">
                <div id="newGenreContainer">
                  <div id="compAddMaterial" class="input-append">
                    <select id="cbmMaterial" class="span2"></select>         
                    <label class="checkbox btn">
                      <input id="chkPral" data-text="Pral." type="checkbox"> Pral.
                    </label>
                    <label class="checkbox btn">
                      <input id="chk1" data-text="1º" type="checkbox"> 1º
                    </label>
                    <label class="checkbox btn">
                      <input id="chk2" data-text="2º" type="checkbox"> 2º
                    </label>
                    <label class="checkbox btn">
                      <input id="chk3" data-text="3º" type="checkbox"> 3º
                    </label>
                    <label class="checkbox btn">
                      <input id="chk4" data-text="4º" type="checkbox"> 4º
                    </label>
                    <button id="btnAddMaterial" class="btn" type="button"><i class="icon-plus-sign"></i></button>
                  </div> {{-- compAddMaterial  --}}
                </div> {{-- newGenreContainer --}}
                <hr>
                <ul id="materialContainer"></ul>
              </div>
              {{ Form::label('fondo', trans('app.files.location').":") }}
              {{ Form::text('fondo', null, array('class' => 'input-xlarge')) }}
              {{ Form::label('edicion', trans('app.files.edition').":") }}
              {{ Form::text('edicion', null, array('class' => 'input-xlarge')) }}
              {{ Form::label('comentarios', trans('app.files.comments').":") }}
              {{ Form::textarea('comentarios', null, array('class' => 'input-xlarge', 'class' => 'ckeditor')) }}
              {{ Form::label('username', trans('app.genres.created_by').":") }}
              {{ Form::text('username', Sentry::getUser()->first_name, array('class' => 'input-xlarge', 'disabled')) }}
              {{ Form::label('created_at', trans('app.genres.created_at').":") }}
              {{ Form::text('created_at',null, array('class' => 'input-xlarge', 'disabled')) }}
        </div>
        <div class="btn-toolbar">
          <button class="btn btn-primary"><i class="icon-save"></i> {{ trans('button.save') }}</button>
          <a href="{{ route('dashboard.registros.index')  }}" class="btn">@lang('button.cancel')</a>
          <div class="btn-group"></div>
        </div>
      </form>
    </div>
  </div>
  {{ HTML::script('ckeditor/ckeditor.js') }}
  {{ HTML::script('assets/lib/bootstrap/js/bootstrap.min.js') }}
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script>

    $(document).ready(function(){

      var mapAutores = [];
      var colAutores = [];
      var mapCentros = [];
      var colCentros = [];
      var mapGeneros = [];
      var colGeneros = [];

      function init() {

        loadComboMaterial();
        enableTypeaheadOnAutores();
        enableTypeaheadOnCentros();
        enableTypeaheadOnGeneros();

        // Add this plugin in Jquery
        $.substitute = function(str, sub) {
            return str.replace(/\{(.+?)\}/g, function($0, $1) {
                return $1 in sub ? sub[$1] : $0;
            });
        };

        enableDragnDrop();
      }

      function loadComboMaterial()
      {
        $.getJSON("/rest/materiales", function( results ){
          var options = '';
          $.each(results, function(i, item) {
            options += '<option value="' + i  + '">' + item + ' (' + i  +  ')</option>';
          });
          $("select#cbmMaterial").html(options);
        });

      }

      function enableTypeaheadOnAutores()
      {
        $.getJSON("/rest/autores", function( results ){
          $.each(results, function(key, item) {
            colAutores.push(item);
            mapAutores[item] = key;
          });
          $("#autor").typeahead({ 
            source: colAutores,
            updater: function(autor) 
            { $('#autore_id').val(mapAutores[autor]);
              return autor; }
          });
        });    
      }

      function enableTypeaheadOnCentros(){
        $.getJSON("/rest/centros", function( results ){
          $.each(results, function(key, item) {
            colCentros.push(item);
            mapCentros[item] = key;
          });
          $("#centro").typeahead({ 
            source: colCentros,
            updater: function(centro) 
            { $('#centro_id').val(mapCentros[centro]);
              return centro; }
          });
        });   
      }

      function enableTypeaheadOnGeneros()
      {
        $.getJSON("/rest/generos", function( results ){
          $.each(results, function(key, item) {
            colGeneros.push(item);
            mapGeneros[item] = key;
          });
          $("#genero").typeahead({ 
            source: colGeneros,
            updater: function(genero) 
            { $('#genero_id').val(mapGeneros[genero]);
              return genero; }
          });
        });   
      }

      function reorderJsonItems()
      {
        var $items = $('#materialContainer input'); // get the items with data
        var jan = {};

        $.each($items, function (index, input){
          var arr = $(input).data('material').split(':');
          jan[arr[0]] = arr[1];
        });

        $('#material').val(JSON.stringify(jan));
      }

      function enableDragnDrop()
      {
        $('#materialContainer').sortable({
          revert:true,
          stop: reorderJsonItems
        });
      }


      // Return a genre component
      function buildComponent(content, jsonedMaterial) {
        // Load the component
        var genreComponent = '<li><div class="input-append">' +
                '<label style="cursor: move;" class="btn"><i class="icon-move"></i> </label><input class="span4" data-material="{json}" value="{text}" disabled type="text">' +
                '<button class="btn deleteGenre" type="button"><i class="icon-remove"></i> </button></div></li>';
        return $.substitute(genreComponent, {text:content, json:jsonedMaterial});
      }

      // Adds a component to the form
      function addComponent(component) {
        var miCont = $('#materialContainer');

        miCont.fadeOut(function(){
          miCont.append(component);
          miCont.fadeIn();
        });
      }

      // This events clear the genre component clicked
      $(document).on('click', '.deleteGenre',function(e){
        var $miParent = $(this).parent();
        var $container = $('#materialContainer');
        var material = $(e.target).parent().find('input.span4').data("material").split(":");

        $container.fadeOut(function() {
          $miParent.remove();
          $container.fadeIn();
          substractItem(material[0]);
        });
      });

      // Substract a item to our JSON
      function substractItem(key) {
        var myJSON = getJsonFromInput();
        delete myJSON[key];
        setJsonToInput(myJSON);
      } 

      // Stores the JSON to the lang field
      function setJsonToInput(json) {
        $('#material').val(JSON.stringify(json));
      }

      // This event create a new genre component and stores it to our JSON
      $('#btnAddMaterial').on('click', function()
      {

        var $compMaterial = $('#compAddMaterial'); // get create material component
        var $txtMaterial = $compMaterial.find('#cbmMaterial'); // get combo box
        var txtAbrev = $txtMaterial.val(); // the te abrev material

        // prevent go any further
        if (checkItemExists(txtAbrev)) 
        {
          alert('ya existe'); return false;
        }

        var txtFulltextMaterial = $txtMaterial.find(':selected').text(); // get full text material
        var chkHijosComp = $compMaterial.find('input');
        var txtContenido = [];
        $.each(chkHijosComp, function(i, item){
          $item = $(item);
          if($item.prop('checked')) txtContenido.push($item.data('text'));
          $item.prop('checked',false)
        });
        $txtMaterial.val("");

        // Build and add component inside the container
        txtFulltextMaterial += ": " + txtContenido.join(',');
        var jsonReadyString = txtAbrev + ':'+txtContenido.join(',');
        var newComponent = buildComponent(txtFulltextMaterial, jsonReadyString);
        addComponent(newComponent);

        // add the new json item
        var jsonItem = {};
        jsonItem[txtAbrev] = txtContenido.join(',');
        addItem(jsonItem);
      });

      // Returns true if our key exists
      function checkItemExists(key) {
        var myJSON = getJsonFromInput();
        var result = false;
        $.each(myJSON, function(index, value){
          if (index === key) result =  true;
        });
        return result;
      }

      // Get our JSON from the lang field
      function getJsonFromInput() {
        var $txtMaterial = $('#material');
        return jQuery.parseJSON($txtMaterial.val());
      }

      // Puts new item into JSON object
      function addItem(item) {
        var myJSON = getJsonFromInput();
        $.extend(myJSON, item); // puts the new item
        setJsonToInput(myJSON);
      } 

      init();

    });
  </script>
@stop