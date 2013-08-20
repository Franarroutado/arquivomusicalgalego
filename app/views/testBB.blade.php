@extends('master')

@section('breadcrumbs', Breadcrumbs::render('dashboard'))

@section('content')

  <style>
    #compAddMaterial input {
      margin-left: 0px;
    }

    ul#materialContainer li {
      display: block;
    }
  </style>

  {{ Form::textarea('txtTexto', null, ['id' => 'txtTexto']) }}
  <label for="centros">Prueba de materiales</label>
  <div class="well">
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
      <button id="btnAdd" class="btn btn-primary" type="button"><i class="icon-plus-sign"></i></button>
      <hr>
      <ul id="materialContainer"></ul>
    </div> {{-- compAddMaterial  --}}
  </div>

  <script id="itemMaterial" type="text/template">
    <div class="input-append">
      <label style="cursor: move;" class="btn btn-primary"><i class="icon-move"></i> </label>
      <input class="span6" data-shortmaterial="<%= shortMaterial  %>" data-material="<%= material %>" data-extras="<%= extras %>" value="<%= material  %>: <%= extras %>" disabled type="text">
      <button class="btn btn-primary" type="button"><i class="icon-remove"></i> </button>
    </div>
  </script>

  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  {{ HTML::script('assets/lib/bootstrap/js/bootstrap.min.js') }}
  {{ HTML::script('assets/js/underscore.js') }}
  {{ HTML::script('assets/js/backbone.js') }}
  {{ HTML::script('assets/js/app/materiales/main.js') }}
  {{ HTML::script('assets/js/app/materiales/models.js') }}
  {{ HTML::script('assets/js/app/materiales/collections.js') }}
  {{ HTML::script('assets/js/app/materiales/views.js') }}
  {{ HTML::script('assets/js/app/materiales/router.js') }}

  <script>
    new App.Router;
    Backbone.history.start();

    App.materiales = new App.Collections.Materials;
    App.materiales.fetch().then(function() {
      new App.Views.App({ collection: App.materiales });
    });


    outputCollection = function(collection) {
      var myMaterials = {};
      collection.each( function(material, index) {
          myMaterials[material.get('shortMaterial')] = material.get('extras');
      });
      $('#txtTexto').val(JSON.stringify(myMaterials));
    };

    vent.on('collection:output', outputCollection, this);

  </script>
@stop