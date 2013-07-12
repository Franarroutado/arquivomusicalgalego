<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Drag'n'Drop Labs</title>
  
  {{ HTML::style('assets/lib/bootstrap/css/bootstrap.css') }}

  {{ HTML::style('assets/css/theme.css') }}
  {{ HTML::style('assets/lib/font-awesome/css/font-awesome.css') }}
  <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  
  <style>
    li {
      display: block;
      color: #CEF0B7;
      padding-left: 15px;
      padding-right: 15px;
      margin-bottom: 1px;
      border-top: 1px dotted gray;
      border-bottom: 1px dotted gray;
      background-color: #0B486B;
      line-height: 35px;
      height: 35px;
    }
  </style>
  
</head>
<body>

  <div class="row">
    <div class="span4">hola
      <div id="origen">
        <h1 class="ui-widget-header">Materiales disponibles</h1>
        <div class="ui-widget-content">
          <ul>
            <li><i data-value="12" class="icon-move"></i>Piano</li>
            <li><i data-value="22" class="icon-move"></i>Trompeta</li>
            <li><i data-value="32" class="icon-move"></i>Trombon</li>
          </ul>
        </div>
      </div>
    
    </div>

    <div class="span8">

      <div id="trash" class="ui-widget-content ui-state-default">
        <h4 class="ui-widget-header"><span class="ui-icon ui-icon-trash">Trash</span> Trash</h4>
      </div>

      <div id="destino">
        <h1 class="ui-widget-header">Shopping Cart</h1>
        <div class="ui-widget-content">
          <ul>
            <li class="placeholder">Materiales</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div>
    <input id="txtGenero"  type="text">
    <input type="" id="txtLang" value="es_gl"></value><button id="btnNuevo">Añadir</button>
    <br>
    <textarea id="txtResultado" type="text"></textarea>
    <ul id="miLista"></ul>
  </div>

  <div id="contenedor">
  </div>

    <div class="input-append">
        <input class="span2" id="appendedInputButton" type="text">
        <button class="btn deleteGenre" type="button">X</button>
    </div>

   

  <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  {{ HTML::script('assets/lib/bootstrap/js/bootstrap.js')  }} 

  <script>
    $(document).ready(function(){

      $.substitute = function(str, sub) {
          return str.replace(/\{(.+?)\}/g, function($0, $1) {
              return $1 in sub ? sub[$1] : $0;
          });
      };

      // usage:
      var miValor = $.substitute('Esto es una {foo}', {foo:'PaSaDa'});

      var miComponente = '<div class="input-append">' +
        '<input class="span2" data-lang="{lang}" value="{text}" disabled  id="appendedInputButton" type="text">' +
        '<button class="btn deleteGenre" type="button">X</button></div>';
      var miDato = "Fátima";
      var miComponenteMod = $.substitute(miComponente, {text:miDato, lang:"es_gl"});
      $('#contenedor').append(miComponenteMod);
      $('#contenedor').append(miComponenteMod);
      $('#contenedor').append(miComponenteMod);

      $('#origen li').draggable({
         appendTo: "body",
        helper: "clone"
      });
      $('#destino').droppable({
        activeClass: "ui-state-default",
        hoverClass: "ui-state-hover",
        accept: ":not(.ui-sortable-helper)",
        drop: function( event, ui ) {
          $( this ).find( ".placeholder" ).remove();
          console.log(ui.draggable);      
          $( "<li><i class='icon-move'></i>"+ui.draggable.text() +"</li>" ).appendTo( $( this ).find('ul') );
          
          // $( "<li></li>" ).text( ui.draggable.text() ).appendTo( $( this ).find('ul') );
        }  
      }).sortable({
        items: "li:not(.placeholder)",
        sort: function() {
        // gets added unintentionally by droppable interacting with sortable
        // using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
        $( this ).removeClass( "ui-state-default" );
        }});

      $('#btnNuevo').on('click', function() {
        var txtGen = $('#txtGenero').val();
        var txtLan = $('#txtLang').val();
        var ips = {};
        ips[txtLan] = txtGen;
        if (txtGen.length > 0 && txtLan.length > 0)
        { 
          $.extend(miGenero, ips);
          $('#txtResultado').val(JSON.stringify(miGenero));
          var miCont = $('#contenedor');
          miCont.fadeOut(function(){
            miCont.append(miComponenteMod);
            miCont.fadeIn();
          });
        } else {
          alert('falta');
        }
      });

      $(document).on('click', '.btn',function(){
        var $miParent = $(this).parent();
        console.log($miParent);
        $miParent.fadeOut(function() {
          $miParent.remove();
        });

      });

      var miGenero = {"es_gl":"ALBORADA","es_ES":"ALBORADA"};

      var nuevoGenero = {"en_EN":"PERRITO"};

      $.extend(miGenero, nuevoGenero);

      var $miLista = $('#miLista');

      $.each(miGenero, function(index, value){
        $('<li></li>').text(index+" tiene: "+ value).appendTo($miLista);
      });


      $('#txtResultado').val(JSON.stringify(miGenero));
    });
  </script>

</body>
</html>