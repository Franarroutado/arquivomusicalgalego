var _ref, _ref1,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.Collections.Materials = (function(_super) {
  __extends(Materials, _super);

  function Materials() {
    _ref = Materials.__super__.constructor.apply(this, arguments);
    return _ref;
  }

  Materials.prototype.model = App.Models.Material;

  Materials.prototype.url = '/api/v1/materiales';

  return Materials;

})(Backbone.Collection);

App.Collections.RenderMaterials = (function(_super) {
  __extends(RenderMaterials, _super);

  function RenderMaterials() {
    _ref1 = RenderMaterials.__super__.constructor.apply(this, arguments);
    return _ref1;
  }

  RenderMaterials.prototype.model = App.Models.Material;

  RenderMaterials.prototype.add = function(material) {
    var exists;
    exists = this.where({
      shortMaterial: material.shortMaterial
    });
    if (exists.length > 0) {
      return;
    }
    return Backbone.Collection.prototype.add.call(this, material);
  };

  return RenderMaterials;

})(Backbone.Collection);
