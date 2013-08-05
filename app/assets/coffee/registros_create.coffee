mapAutores = []
colAutores = []
mapCentros = []
colCentros = []
mapGeneros = []
colGeneros = []

client=

  init: ->
    @loadComboMaterial()
    @enableTypeaheadOnAutores()
    @enableTypeaheadOnCentros()
    @enableTypeaheadOnGeneros()
    @enableDragnDrop()
    @declareUIevents()

    # For query plugin
    $.substitute = (str, sub) ->
      str.replace /\{(.+?)\}/g, ($0, $1) ->
        (if $1 of sub then sub[$1] else $0)

  loadComboMaterial: ->  
    $.getJSON "/rest/materiales", (results) ->
      options = ''
      $.each results, (i, item) ->
        options += "<option value='#{i}'>#{item} (#{i})</option>"
        $("select#cbmMaterial").html options

  enableTypeaheadOnAutores: ->
    $.getJSON "/rest/autores", (results) ->
      $.each results, (key, item) ->
        colAutores.push item
        mapAutores[item] = key
      $("#autor").typeahead
        source: colAutores
        updater: (autor) -> 
          $('#autore_id').val mapAutores[autor]
          autor

  enableTypeaheadOnCentros: ->
    $.getJSON "/rest/centros", (results) ->
      $.each results, (key, item) ->
        colCentros.push item
        mapCentros[item] = key
      $("#centro").typeahead 
        source: colCentros
        updater: (centro) -> 
          $('#centro_id').val mapCentros[centro]
          centro

  enableTypeaheadOnGeneros: ->
    $.getJSON "/rest/generos", (results) ->
      $.each results, (key, item) ->
        colGeneros.push item
        mapGeneros[item] = key
      $("#genero").typeahead 
        source: colGeneros
        updater: (genero) -> 
          $('#genero_id').val mapGeneros[genero]
          genero
      
  enableDragnDrop: ->
    $('#materialContainer').sortable
      revert: true
      stop: @reorderJsonItems

  reorderJsonItems: ->
    $items = $('#materialContainer input') # get the items with data
    jan = {}

    $.each $items, (index, input) ->
      arr = $(input).data('material').split ':'
      jan[arr[0]] = arr[1]
    $('#material').val JSON.stringify jan

  declareUIevents: ->
    # This events clear the genre component clicked
    $('#materialContainer').on 'click', 'button', (e) ->
      $miParent = $(@).parent()
      $container = $('#materialContainer')
      material = $(e.target).parent().find('input.span4').data("material").split ":";

      $container.fadeOut ->
        $miParent.remove()
        $container.fadeIn()
        client.substractItem material[0]

    # This event create a new genre component and stores it to our JSON
    $('#btnAddMaterial').on 'click', ->
      $compMaterial = $ '#compAddMaterial' # get create material component
      $txtMaterial = $compMaterial.find '#cbmMaterial' # get combo box
      txtAbrev = $txtMaterial.val() # the te abrev material

      # prevent go any further
      if client.checkItemExists txtAbrev
        alert 'ya existe' 
        return false
      txtFulltextMaterial = $txtMaterial.find(':selected').text() #  get full text material
      chkHijosComp = $compMaterial.find 'input'
      txtContenido = []
      $.each chkHijosComp, (i, item) ->
        $item = $ item
        txtContenido.push $item.data 'text' if $item.prop 'checked'
        $item.prop 'checked', false  
      $txtMaterial.val ""
 
      # Build and add component inside the container
      txtFulltextMaterial += ": #{txtContenido.join ','}"
      jsonReadyString = "#{txtAbrev}:#{txtContenido.join ','}"
      newComponent = client.buildComponent txtFulltextMaterial, jsonReadyString
      client.addComponent newComponent

      # add the new json item
      jsonItem = {}
      jsonItem[txtAbrev] = txtContenido.join ','
      client.addItem jsonItem
      

  # Substract a item to our JSON
  substractItem: (key) ->
    myJSON = @getJsonFromInput()
    delete myJSON[key]
    @setJsonToInput myJSON

  # Stores the JSON to the lang field
  setJsonToInput: (json) ->
    $('#material').val JSON.stringify json

  # Return a genre component
  buildComponent: (content, jsonedMaterial) ->
    # Load the component
    genreComponent = '<li><div class="input-append">' +
      '<label style="cursor: move;" class="btn"><i class="icon-move"></i> </label><input class="span4" data-material="{json}" value="{text}" disabled type="text">' +
      '<button class="btn deleteGenre" type="button"><i class="icon-remove"></i> </button></div></li>'
    $.substitute genreComponent,
      text:content
      json:jsonedMaterial
      
  # Adds a component to the form
  addComponent: (component) ->
    miCont = $('#materialContainer')

    miCont.fadeOut ->
      miCont.append component
      miCont.fadeIn()

  checkItemExists: (key) ->
    myJSON = @getJsonFromInput()
    result = false
    $.each myJSON, (index, value) ->
      result = true  if index is key
    result

  # Get our JSON from the lang field
  getJsonFromInput: ->
    $txtMaterial = $ '#material'
    $.parseJSON $txtMaterial.val()

  addItem: (item) ->
    myJSON = @getJsonFromInput()
    $.extend myJSON, item # puts the new item
    @setJsonToInput myJSON

  # Substract a item to our JSON
  substractItem: (key) ->
    myJSON = @getJsonFromInput()
    delete myJSON[key]
    @setJsonToInput myJSON