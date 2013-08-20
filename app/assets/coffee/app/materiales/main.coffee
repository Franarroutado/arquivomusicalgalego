(->
  window.App =
    Models: {}
    Collections: {}
    Views: {}
    Router: {}

  window.vent = _.extend {}, Backbone.Events

  window.template = (id)->
    _.template $('#'+id).html()
)()