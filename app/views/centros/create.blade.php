@extends('master')

{{-- Breadcrumb --}}
@section('breadcrumbs', Breadcrumbs::render('centrosCreate'))

{{-- Content --}}
@section('content')
  <div class="container-fluid">
    <div class="row-fluid">
      {{ Form::open(array('method' => 'POST', 'route' => array('dashboard.centros.store'))) }}
        <div class="btn-toolbar">
          <button class="btn btn-primary"><i class="icon-save"></i> {{ trans('button.save') }}</button>
          <a href="{{ route('dashboard.centros.index')  }}" class="btn">@lang('button.cancel')</a>
          <div class="btn-group"></div>
        </div>
        <div class="well">
          {{ Form::label('nombre', trans('app.schools.schoolname').":").AMG::displayErr($errors, 'nombre') }}
          {{ Form::text('nombre',null, ['class' => 'input-xlarge']) }}
          {{ Form::label('abrev', trans('app.schools.abrev').":").AMG::displayErr($errors, 'abrev') }}
          {{ Form::text('abrev',null, ['class' => 'input-xlarge']) }}
          {{ Form::label('cuerpo', trans('app.schools.body').":").AMG::displayErr($errors, 'cuerpo') }}
          {{ Form::textarea('cuerpo',null, ['class' => 'ckeditor']) }}
          {{ Form::label('contact', trans('app.schools.contact').":").AMG::displayErr($errors, 'contact') }}
          <div class="well">
            <div id="newGenreContainer">
              <div class="input-append">
                <input id="txtKey" style="width: 60px" type="text" placeholder="@lang('app.schools.insertKey')">
                <input id="txtValue" style="width: 240px" type="text" placeholder="@lang('app.schools.insertValue')">
                <button id="btnAddContact" class="btn" type="button"><i class="icon-plus-sign"></i></button>
              </div>
            </div>
            <hr>
            <div id="genreContainer"></div>
          </div>
          {{ Form::hidden('contacto', '{}', ['id' => 'contacto']) }}
          {{ Form::label('username', trans('app.schools.created_by').":") }}
          {{ Form::text('username', Sentry::getUser()->first_name, ['class' => 'input-xlarge', 'disabled']) }}
          {{ Form::label('created_at', trans('app.schools.created_at').":") }}
          {{ Form::text('created_at',null, ['class' => 'input-xlarge', 'disabled']) }}
        </div>
        <div class="btn-toolbar">
          <button class="btn btn-primary"><i class="icon-save"></i> {{ trans('button.save') }}</button>
          <a href="{{ route('dashboard.centros.index')  }}" class="btn">@lang('button.cancel')</a>
          <div class="btn-group"></div>
        </div>
      </form>
    </div>
  </div>
  {{ HTML::script('ckeditor/ckeditor.js') }}
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
        var myJSON = jQuery.parseJSON($('#contacto').val());
        // Iterate the JSON creating the genres components
        $.each(myJSON, function(index, value){
          var miComponenteMod = buildComponent(value, index);
          addComponent(miComponenteMod);
        });
      }

      // Return a genre component
      function buildComponent(genre, lang) {
        var genreString = genre+" - "+lang;
        // Load the component
        var genreComponent = '<div class="input-append">' +
              '<input class="span4" data-lang="{lang}"  value="{text}" disabled  id="appendedInputButton" type="text">' +
              '<button class="btn deleteConctact" type="button">X</button></div>';
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
      $(document).on('click', '.deleteConctact',function(e){
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
        $('#contacto').val(JSON.stringify(json));
      }

      // This event create a new genre component and stores it to our JSON
      $('#btnAddContact').on('click', function(){
        var $txtKey = $('#txtKey');
        var txtKey = $txtKey.val();
        var $txtValue = $('#txtValue');
        var txtValue = $txtValue.val();

        if (checkItemExists(txtKey)) 
        {
          alert("{{ trans('app.schools.exists1') }}"+txtKey+"{{ trans('app.schools.exists2') }}");
          return false;
        }

        if (txtKey.length > 0 && txtValue.length > 0)
        { 
          var newJsonItem = {};
          console.log(txtValue);
          newJsonItem[txtKey] = txtValue;
          addItem(newJsonItem);
          var newComponent = buildComponent(txtKey, txtValue);
          addComponent(newComponent);
          $txtKey.val("");
          $txtValue.val("");
        } else {
          alert(" @lang('app.schools.newConfail')
           ");
        }
      });

      // Puts new item into JSON object
      function addItem(item) {
        var myJSON = getJsonFromInput();
        $.extend(myJSON, item); // puts the new item
        setJsonToInput(myJSON);
      } 

      // Get our JSON from the lang field
      function getJsonFromInput() {
        var $txtLang = $('#contacto');
        return jQuery.parseJSON($txtLang.val());
      }

      // Returns true if our key exists
      function checkItemExists(key) {
        var myJSON = getJsonFromInput();
        var result = false;
        $.each(myJSON, function(index, value){
          if (index === key) result =  true;
        });
        return result;
      }

      init();

    });
  </script>
@stop