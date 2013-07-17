@extends('master')

{{-- Breadcrumb --}}
@section('breadcrumbs', Breadcrumbs::render('centrosEdit', $centro->id))

{{-- Content --}}
@section('content')
<div class="container-fluid">
  <div class="row-fluid">
    {{ Form::model($centro, array('method' => 'PUT', 'route' => array('dashboard.centros.update', $centro->id))) }}
    <div class="btn-toolbar">
      <button class="btn btn-primary"><i class="icon-save"></i> @lang('button.save')</button>
      <a href="{{ route('dashboard.centros.index')  }}" class="btn">@lang('button.cancel')</a>
      <a href="#myModal" data-toggle="modal" class="btn btn-warning">@lang('button.delete')</a>
      <div class="btn-group"></div>
    </div>
    <div class="well">
      {{ Form::label('nombre', trans('app.schools.schoolname').":").AMG::displayErr($errors, 'nombre') }}
      {{ Form::text('nombre',null, array('class' => 'input-xxlarge')) }}
      {{ Form::label('abrev', trans('app.schools.abrev').":").AMG::displayErr($errors, 'abrev') }}
      {{ Form::text('abrev',null, array('class' => 'input-xlarge')) }}
      {{ Form::label('cuerpo', trans('app.schools.body').":").AMG::displayErr($errors, 'cuerpo') }}
      {{ Form::textarea('cuerpo',null, array('class' => 'ckeditor')) }}
      {{ Form::label('contacto', trans('app.schools.contact').":").AMG::displayErr($errors, 'contact') }}
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
      {{ Form::hidden('contacto') }}
      {{ Form::label('username', trans('app.schools.created_by').":") }}
      {{ Form::text('username', Sentry::getUser()->first_name, array('class' => 'input-xlarge', 'disabled')) }}
      {{ Form::label('created_at', trans('app.schools.created_at').":") }}
      {{ Form::text('created_at',null, array('class' => 'input-xlarge', 'disabled')) }}
    </div>
    <div class="btn-toolbar">
      <button class="btn btn-primary"><i class="icon-save"></i> @lang('button.save')</button>
      <a href="{{ route('dashboard.centros.index')  }}" class="btn">@lang('button.cancel')</a>
      <a href="#myModal" data-toggle="modal" class="btn btn-warning">@lang('button.delete')</a>
      <div class="btn-group"></div>
    </div>
    {{ Form::close() }}
</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">@lang('button.modal.barTitle')</h3>
  </div>
  <div class="modal-body">
    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>@lang('button.modal.delteMsg', array('entity' => strtolower(trans('button.author'))))</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">@lang('button.cancel')</button>
    <a class="btn btn-danger" data-method="DELETE"  href="{{ route('dashboard.centros.destroy', $centro->id)}}">@lang('button.delete')</a>
  </div>
</div>
{{-- This script is neccesary for allowing links use DELETE verb  --}}
{{ HTML::script('assets/js/restfulizer.js') }}
{{ HTML::script('ckeditor/ckeditor.js') }}
<script>
  $(document).ready(function(){

    function init() {
      checkIfContactoEmpty();
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

    function checkIfContactoEmpty() {
      if ($('#contacto').val().length == 0){
        var newJsonItem = {};
        setJsonToInput(newJsonItem);
      }
    }

    // Return a genre component
    function buildComponent(genre, lang) {
      var genreString = lang+" - "+genre;
      // Load the component
      var genreComponent = '<div class="input-append">' +
            '<input class="span4" data-lang="{lang}"  value="{text}" disabled  id="appendedInputButton" type="text">' +
            '<label class="btn deleteConctact"><i class="icon-remove"></i> </label></div>';
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