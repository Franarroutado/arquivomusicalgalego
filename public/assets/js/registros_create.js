var client, colAutores, colCentros, colGeneros, mapAutores, mapCentros, mapGeneros;

mapAutores = [];

colAutores = [];

mapCentros = [];

colCentros = [];

mapGeneros = [];

colGeneros = [];

client = {
  init: function() {
    this.loadComboMaterial();
    this.enableTypeaheadOnAutores();
    this.enableTypeaheadOnCentros();
    this.enableTypeaheadOnGeneros();
    this.enableDragnDrop();
    this.declareUIevents();
    return $.substitute = function(str, sub) {
      return str.replace(/\{(.+?)\}/g, function($0, $1) {
        if ($1 in sub) {
          return sub[$1];
        } else {
          return $0;
        }
      });
    };
  },
  loadComboMaterial: function() {
    return $.getJSON("/rest/materiales", function(results) {
      var options;
      options = '';
      return $.each(results, function(i, item) {
        options += "<option value='" + i + "'>" + item + " (" + i + ")</option>";
        return $("select#cbmMaterial").html(options);
      });
    });
  },
  enableTypeaheadOnAutores: function() {
    return $.getJSON("/rest/autores", function(results) {
      $.each(results, function(key, item) {
        colAutores.push(item);
        return mapAutores[item] = key;
      });
      return $("#autor").typeahead({
        source: colAutores,
        updater: function(autor) {
          $('#autore_id').val(mapAutores[autor]);
          return autor;
        }
      });
    });
  },
  enableTypeaheadOnCentros: function() {
    return $.getJSON("/rest/centros", function(results) {
      $.each(results, function(key, item) {
        colCentros.push(item);
        return mapCentros[item] = key;
      });
      return $("#centro").typeahead({
        source: colCentros,
        updater: function(centro) {
          $('#centro_id').val(mapCentros[centro]);
          return centro;
        }
      });
    });
  },
  enableTypeaheadOnGeneros: function() {
    return $.getJSON("/rest/generos", function(results) {
      $.each(results, function(key, item) {
        colGeneros.push(item);
        return mapGeneros[item] = key;
      });
      return $("#genero").typeahead({
        source: colGeneros,
        updater: function(genero) {
          $('#genero_id').val(mapGeneros[genero]);
          return genero;
        }
      });
    });
  },
  enableDragnDrop: function() {
    return $('#materialContainer').sortable({
      revert: true,
      stop: this.reorderJsonItems
    });
  },
  reorderJsonItems: function() {
    var $items, jan;
    $items = $('#materialContainer input');
    jan = {};
    $.each($items, function(index, input) {
      var arr;
      arr = $(input).data('material').split(':');
      return jan[arr[0]] = arr[1];
    });
    return $('#material').val(JSON.stringify(jan));
  },
  declareUIevents: function() {
    $('#materialContainer').on('click', 'button', function(e) {
      var $container, $miParent, material;
      $miParent = $(this).parent();
      $container = $('#materialContainer');
      material = $(e.target).parent().find('input.span4').data("material").split(":");
      return $container.fadeOut(function() {
        $miParent.remove();
        $container.fadeIn();
        return client.substractItem(material[0]);
      });
    });
    return $('#btnAddMaterial').on('click', function() {
      var $compMaterial, $txtMaterial, chkHijosComp, jsonItem, jsonReadyString, newComponent, txtAbrev, txtContenido, txtFulltextMaterial;
      $compMaterial = $('#compAddMaterial');
      $txtMaterial = $compMaterial.find('#cbmMaterial');
      txtAbrev = $txtMaterial.val();
      if (client.checkItemExists(txtAbrev)) {
        alert('ya existe');
        return false;
      }
      txtFulltextMaterial = $txtMaterial.find(':selected').text();
      chkHijosComp = $compMaterial.find('input');
      txtContenido = [];
      $.each(chkHijosComp, function(i, item) {
        var $item;
        $item = $(item);
        if ($item.prop('checked')) {
          txtContenido.push($item.data('text'));
        }
        return $item.prop('checked', false);
      });
      $txtMaterial.val("");
      txtFulltextMaterial += ": " + (txtContenido.join(','));
      jsonReadyString = "" + txtAbrev + ":" + (txtContenido.join(','));
      newComponent = client.buildComponent(txtFulltextMaterial, jsonReadyString);
      client.addComponent(newComponent);
      jsonItem = {};
      jsonItem[txtAbrev] = txtContenido.join(',');
      return client.addItem(jsonItem);
    });
  },
  substractItem: function(key) {
    var myJSON;
    myJSON = this.getJsonFromInput();
    delete myJSON[key];
    return this.setJsonToInput(myJSON);
  },
  setJsonToInput: function(json) {
    return $('#material').val(JSON.stringify(json));
  },
  buildComponent: function(content, jsonedMaterial) {
    var genreComponent;
    genreComponent = '<li><div class="input-append">' + '<label style="cursor: move;" class="btn"><i class="icon-move"></i> </label><input class="span4" data-material="{json}" value="{text}" disabled type="text">' + '<button class="btn deleteGenre" type="button"><i class="icon-remove"></i> </button></div></li>';
    return $.substitute(genreComponent, {
      text: content,
      json: jsonedMaterial
    });
  },
  addComponent: function(component) {
    var miCont;
    miCont = $('#materialContainer');
    return miCont.fadeOut(function() {
      miCont.append(component);
      return miCont.fadeIn();
    });
  },
  checkItemExists: function(key) {
    var myJSON, result;
    myJSON = this.getJsonFromInput();
    result = false;
    $.each(myJSON, function(index, value) {
      if (index === key) {
        return result = true;
      }
    });
    return result;
  },
  getJsonFromInput: function() {
    var $txtMaterial;
    $txtMaterial = $('#material');
    return $.parseJSON($txtMaterial.val());
  },
  addItem: function(item) {
    var myJSON;
    myJSON = this.getJsonFromInput();
    $.extend(myJSON, item);
    return this.setJsonToInput(myJSON);
  },
  substractItem: function(key) {
    var myJSON;
    myJSON = this.getJsonFromInput();
    delete myJSON[key];
    return this.setJsonToInput(myJSON);
  }
};
