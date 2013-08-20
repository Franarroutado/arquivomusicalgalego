var _ref,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.Models.Material = (function(_super) {
  __extends(Material, _super);

  function Material() {
    _ref = Material.__super__.constructor.apply(this, arguments);
    return _ref;
  }

  return Material;

})(Backbone.Model);
