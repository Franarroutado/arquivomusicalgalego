class App.Collections.Materials extends Backbone.Collection
  model: App.Models.Material
  url: '/api/v1/materiales'

class App.Collections.RenderMaterials extends Backbone.Collection
  model: App.Models.Material

  add: (material)->
    
    # Implement INIQUE index on shortMaterial
    exists = @where( shortMaterial: material.shortMaterial )
    return if exists.length > 0

    # Resume adding
    Backbone.Collection.prototype.add.call(this, material)