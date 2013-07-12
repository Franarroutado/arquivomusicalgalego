@extends('master')

{{-- Breadcrumb --}}
@section('breadcrumbs', Breadcrumbs::render('materialesCreate'))

{{-- Content --}}
@section('content')
  <div class="container-fluid">
    <div class="row-fluid">
      {{ Form::open(array('method' => 'POST', 'route' => array('dashboard.materiales.store'))) }}
        <div class="btn-toolbar">
          <button class="btn btn-primary"><i class="icon-save"></i> {{ trans('button.save') }}</button>
          <a href="{{ route('dashboard.materiales.index')  }}" class="btn">@lang('button.cancel')</a>
          <div class="btn-group"></div>
        </div>
        <div class="well">
          {{ Form::label('abrev', trans('app.materials.abrev').":").AMG::displayErr($errors, 'abrev') }}
          {{ Form::text('abrev', null, ['class' => 'input-xlarge']) }} 
          {{ Form::label('lang', trans('app.materials.lang').":") . AMG::displayErr($errors, 'lang') }}
          <div class="well">
            <div id="newGenreContainer" style="height: 30px; width: 360px; margin-bottom:5px;">
              <div class="input-append">
                <input id="txtGen" style="width: 240px" type="text" placeholder="@lang('app.materials.insertLang')">
                <input id="txtLan" style="width: 40px" value="es_gl"  type="text">
                <button id="btnAddGenre" class="btn" type="button"><i class="icon-plus-sign"></i></button>
              </div>
            </div>
            <hr>
            <div id="genreContainer"></div>
          </div>
          {{ Form::hidden('lang', '{}') }}
          {{ Form::label('username', trans('app.materials.created_by').":") }}
          {{ Form::text('username', Sentry::getUser()->first_name, ['class' => 'input-xlarge', 'disabled']) }}
          {{ Form::label('created_at', trans('app.materials.created_at').":") }}
          {{ Form::text('created_at',null, ['class' => 'input-xlarge', 'disabled']) }}
        </div>
        <div class="btn-toolbar">
          <button class="btn btn-primary"><i class="icon-save"></i> {{ trans('button.save') }}</button>
          <a href="{{ route('dashboard.materiales.index')  }}" class="btn">@lang('button.cancel')</a>
          <div class="btn-group"></div>
        </div>
      </form>
    </div>
  </div>
  <script>
    $(document).ready(function(){

      function init() {
        $('#newGenreComponent').hide();
        // Add this plugin in Jquery
        $.substitute = function(str, sub) {
            return str.replace(/\{(.+?)\}/g, function($0, $1) {
                return $1 in sub ? sub[$1] : $0;
            });
        };
        // Parse the recieved JSON
        var myJSON = jQuery.parseJSON($('#lang').val());
        // Iterate the JSON creating the genres components
        $.each(myJSON, function(index, value){
          var miComponenteMod = buildComponent(value, index);
          addComponent(miComponenteMod);
        });
      }

      // Return a genre component
      function buildComponent(genre, lang) {
        var genreString = genre+" ("+lang+")";
        // Load the component
        var genreComponent = '<div class="input-append">' +
              '<input class="span4" data-lang="{lang}"  value="{text}" disabled  id="appendedInputButton" type="text">' +
              '<button class="btn deleteGenre" type="button">X</button></div>';
        return $.substitute(genreComponent, {text:genreString, lang:lang});
      }

      // Adds a component to the form
      function addComponent(component) {
        var miCont = $('#genreContainer');

        miCont.fadeOut(function(){
          miCont.append(component);
          miCont.fadeIn();
        });
      }

      // This events clear the genre component clicked
      $(document).on('click', '.deleteGenre',function(e){
        var $miParent = $(this).parent();
        var $container = $('#genreContainer');
        var key = $(e.target).parent().find('input.span4').data("lang");

        $container.fadeOut(function() {
          $miParent.remove();
          $container.fadeIn();
          substractItem(key);
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
        $('#lang').val(JSON.stringify(json));
      }

      // This event create a new genre component and stores it to our JSON
      $('#btnAddGenre').on('click', function(){
        var $txtGen = $('#txtGen');
        var txtGen = $txtGen.val();
        var txtLan = $('#txtLan').val();
        
        if (checkItemExists(txtLan)) 
        {
          alert("Ya existe ese lenguaje");
          return false;
        }

        if (txtGen.length > 0 && txtLan.length > 0)
        { 
          var newJsonItem = {};
          newJsonItem[txtLan] = txtGen;
          addItem(newJsonItem);
          var newComponent = buildComponent(txtGen, txtLan);
          addComponent(newComponent);
          $txtGen.val("");
        } else {
          alert(" @lang('app.materials.newgenfail')
           ");
        }
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
        var $txtLang = $('#lang');
        return jQuery.parseJSON($txtLang.val());
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