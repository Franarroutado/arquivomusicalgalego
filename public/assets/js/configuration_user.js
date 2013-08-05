var client, colCentros, colGrupos, colUsuarios, colUsuarios_grupos;

colUsuarios = {};

colGrupos = {};

colUsuarios_grupos = {};

colCentros = {
  centros: ""
};

client = {
  init: function() {
    var $cbmUsuarios, $cbmUsuariosCentros;
    $.substitute = function(str, sub) {
      return str.replace(/\{(.+?)\}/g, function($0, $1) {
        if ($1 in sub) {
          return sub[$1];
        } else {
          return $0;
        }
      });
    };
    $cbmUsuarios = $('#cbmUsuarios');
    $cbmUsuariosCentros = $('#cbmUsuariosCentros');
    $.each(colUsuarios, function(key, value) {
      var option;
      option = $('<option></option>').attr('value', key).text(value);
      $cbmUsuarios.append(option);
      return $cbmUsuariosCentros.append(option.clone());
    });
    $.each(colGrupos, function(key, value) {
      return $('#cbmUsuarios').after(buildCheckBoxComponent(key, value));
    });
    this.loadUsersGroupsConfiguration();
    return this.enableDragnDrop();
  },
  enableDragnDrop: function() {
    return $('#contenedorCentros').sortable({
      revert: true
    });
  }
};
