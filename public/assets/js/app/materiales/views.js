/*
  MAIN APP
*/

var _ref, _ref1, _ref2,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.Views.App = (function(_super) {
  __extends(App, _super);

  function App() {
    this.reorderCollection = __bind(this.reorderCollection, this);
    this.enableDragnDrop = __bind(this.enableDragnDrop, this);
    _ref = App.__super__.constructor.apply(this, arguments);
    return _ref;
  }

  App.prototype.el = '#compAddMaterial';

  App.prototype.initialize = function() {
    var selectedMaterialsView;
    this.enableDragnDrop();
    this.comboMaterials = this.$el.find('#cbmMaterial');
    this.loadMaterials();
    this.selectedMaterial = new window.App.Collections.RenderMaterials;
    return selectedMaterialsView = new window.App.Views.Materials({
      collection: this.selectedMaterial
    });
  };

  App.prototype.events = {
    'click button#btnAdd': 'addMaterial'
  };

  App.prototype.enableDragnDrop = function() {
    return this.$el.find('#materialContainer').sortable({
      revert: true,
      stop: this.reorderCollection
    });
  };

  App.prototype.reorderCollection = function() {
    var inputs, models,
      _this = this;
    inputs = this.$el.find('#materialContainer').find('input');
    models = [];
    $(inputs).each(function(index, input) {
      return models.push({
        material: $(input).data('material'),
        shortMaterial: $(input).data('shortmaterial'),
        extras: $(input).data('extras')
      });
    });
    return this.selectedMaterial.reset(models);
  };

  App.prototype.addMaterial = function() {
    var checkBoxItems, selectedContents;
    checkBoxItems = this.$el.find('input');
    selectedContents = checkBoxItems.map(function(index, checkBox) {
      var $checkBox, txtResult;
      $checkBox = $(checkBox);
      if ($checkBox.prop('checked')) {
        txtResult = $checkBox.data('text');
        $checkBox.prop('checked', false);
      }
      return txtResult;
    });
    return this.selectedMaterial.add({
      material: this.comboMaterials.find(':selected').text(),
      shortMaterial: this.comboMaterials.find(':selected').val(),
      extras: selectedContents.toArray().join(' ')
    });
  };

  App.prototype.loadMaterials = function() {
    var _this = this;
    return this.collection.each(function(item, value) {
      var key;
      key = _.keys(item.toJSON());
      value = _.values(item.toJSON());
      return _this.comboMaterials.append("<option value='" + key[0] + "'>" + value[0] + " (" + key[0] + ")</option>");
    });
  };

  return App;

})(Backbone.View);

/*
  Collections view for the created materials
*/


App.Views.Materials = (function(_super) {
  __extends(Materials, _super);

  function Materials() {
    this.addOne = __bind(this.addOne, this);
    _ref1 = Materials.__super__.constructor.apply(this, arguments);
    return _ref1;
  }

  Materials.prototype.el = '#materialContainer';

  Materials.prototype.initialize = function() {
    var _this = this;
    this.collection.on('add', this.addOne);
    this.collection.on('all', function() {
      return vent.trigger('collection:output', _this.collection);
    });
    return this.collection.on('reset', function() {
      _this.$el.find('li').remove();
      return _this.render();
    });
  };

  Materials.prototype.render = function() {
    this.collection.each(this.addOne);
    return this;
  };

  Materials.prototype.addOne = function(material) {
    var materialRow;
    materialRow = new App.Views.MaterialRow({
      model: material
    });
    return this.$el.append(materialRow.render().el);
  };

  return Materials;

})(Backbone.View);

/*
 View for a new created material
*/


App.Views.MaterialRow = (function(_super) {
  __extends(MaterialRow, _super);

  function MaterialRow() {
    _ref2 = MaterialRow.__super__.constructor.apply(this, arguments);
    return _ref2;
  }

  MaterialRow.prototype.tagName = 'li';

  MaterialRow.prototype.initialize = function() {
    var _this = this;
    return this.model.on('destroy', function() {
      return _this.remove();
    });
  };

  MaterialRow.prototype.events = {
    'click button': 'deleteMaterial'
  };

  MaterialRow.prototype.template = template('itemMaterial');

  MaterialRow.prototype.deleteMaterial = function() {
    return this.model.destroy();
  };

  MaterialRow.prototype.render = function() {
    this.$el.html(this.template(this.model.toJSON()));
    return this;
  };

  return MaterialRow;

})(Backbone.View);
