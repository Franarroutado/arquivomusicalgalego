template = (name) ->
  Mustache.compile $('#'+name+'-template').html()

class Router extends Backbone.Router
  initialize: (options) ->
    @$el = options.$el
  routes:
    "": "index"

  index: ->
    @$el.html "Hello unobtrusive application"

window.Application =
  boot: ($el) ->
    # {$el} -> coffeescript shortcut instead of {$el: $el}
    router = new Router({$el})
    Backbone.history.start()


# create an unobtrusive boot for the widgedtized component
$ ->
  $("[data-application='true']").each ->
    $this = $ this
    Application.boot $this