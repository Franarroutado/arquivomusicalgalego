###
  MAIN APP
###
class App.Views.App extends Backbone.View
  el: '#compAddMaterial'

  initialize: ->
    @enableDragnDrop() # enable Drag'n'Drop
    @comboMaterials = @$el.find '#cbmMaterial'
    @loadMaterials() # Load materials into the comboBox
    # Initialize internal conllection to store selected material
    @selectedMaterial = new window.App.Collections.RenderMaterials
    selectedMaterialsView = new window.App.Views.Materials( collection: @selectedMaterial )

  events: 
    'click button#btnAdd': 'addMaterial'

  enableDragnDrop: =>
    @$el.find('#materialContainer').sortable(
      revert:true
      stop: @reorderCollection
    )

  reorderCollection: => 
    inputs = @$el.find('#materialContainer').find 'input'
    # Reorder the reorderCollection based on the created materials order
    models = []
    $(inputs).each (index, input) =>
      models.push(
        material: $(input).data 'material'
        shortMaterial: $(input).data 'shortmaterial'
        extras: $(input).data 'extras'
      )
    @selectedMaterial.reset models

  addMaterial: ->
    # Get the extra info for the new file (pral, 1, 2, 3 and 4)
    checkBoxItems = @$el.find 'input'
    selectedContents = checkBoxItems.map (index, checkBox) ->
      $checkBox = $ checkBox
      if $checkBox.prop 'checked'
        txtResult = $checkBox.data 'text'
        $checkBox.prop 'checked',false 
      txtResult

    @selectedMaterial.add(
      material: @comboMaterials.find(':selected').text()
      shortMaterial: @comboMaterials.find(':selected').val()
      extras: selectedContents.toArray().join(' ')
    )

  loadMaterials: ->
    @collection.each (item, value)=>
      key = _.keys item.toJSON()
      value = _.values item.toJSON()
      @comboMaterials.append "<option value='#{key[0]}'>#{value[0]} (#{key[0]})</option>"

###
  Collections view for the created materials
###
class App.Views.Materials extends Backbone.View
  el: '#materialContainer'

  initialize: ->
    @collection.on 'add', @addOne
    @collection.on 'all', => vent.trigger 'collection:output', @collection
    @collection.on 'reset', =>
      @$el.find('li').remove()
      @render()

  render: ->
    @collection.each @addOne
    @   

  addOne: (material) =>
    materialRow = new App.Views.MaterialRow model: material
    @$el.append materialRow.render().el

###
 View for a new created material
###
class App.Views.MaterialRow extends Backbone.View
  tagName: 'li'

  initialize: ->
    @model.on 'destroy', => @remove()
  
  events: 
    'click button': 'deleteMaterial'

  template: template 'itemMaterial'

  deleteMaterial: ->
    @model.destroy()

  render: ->
    @$el.html @template @model.toJSON()
    @