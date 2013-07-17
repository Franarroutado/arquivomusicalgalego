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
<br>

    <form style="border: 1px solid gray;" class="form-inline">
      <select class="span2">
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
      </select>         
      <label class="checkbox">Pral</label>
      <input type="checkbox"> 
      <label class="checkbox">1º</label>
      <input type="checkbox"/> 
      <label class="checkbox">2º</label>
      <input type="checkbox"/> 
      <label class="checkbox">3º</label>
      <input type="checkbox"/> 
      <label class="checkbox">4º</label>
      <input type="checkbox"/> 
    </form>


   

  <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  {{ HTML::script('assets/lib/bootstrap/js/bootstrap.js')  }} 

  <script>
    $(document).ready(function(){

    }
  </script>

</body>
</html>