colUsuarios={}
colGrupos={}
colUsuarios_grupos={}
colCentros=
  centros: ""

client=
  init: ->
    # For query plugin
    $.substitute = (str, sub) ->
      str.replace /\{(.+?)\}/g, ($0, $1) ->
        (if $1 of sub then sub[$1] else $0)

    # Load user combos
    $cbmUsuarios = $ '#cbmUsuarios'
    $cbmUsuariosCentros = $ '#cbmUsuariosCentros'
    $.each colUsuarios, (key, value) ->
      option = $('<option></option>').attr('value', key).text value
      $cbmUsuarios.append option
      $cbmUsuariosCentros.append option.clone()
    

    # Load groups checkboxes
    $.each colGrupos, (key, value) ->
      $('#cbmUsuarios').after buildCheckBoxComponent key, value

    @loadUsersGroupsConfiguration()
    @enableDragnDrop()

  enableDragnDrop: ->
    $('#contenedorCentros').sortable
        revert:true
        # stop: reorderJsonItems
      


    # function loadUsersGroupsConfiguration()
    # {
    #   var $contenedorGrupos = $('#contenedorGrupos');
    #   $contenedorGrupos.children().remove();
    #   $.each(colUsuarios_grupos, function(key, value){
    #     var newKey = key + ":"  + value;
    #     var newValue = colUsuarios[key] + " (" + colGrupos[value] + ")";
    #     var newComponent = buildComponentWithoutButton(newKey, newValue);
    #     $contenedorGrupos.append(newComponent);
    #   });
    # }

    # function buildCheckBoxComponent(key, value) 
    # {
    #   var newCheckbox = '<label class="checkbox btn">' +
    #     '<input data-key="{key}" type="radio" name="optionsRadios">&nbsp;{value}</label>';
    #   return $.substitute(newCheckbox, {key:key, value:value});
    # }

    # function buildComponentWithoutButton(key, value) 
    # {
    #   // Load the component
    #   var newComponent = '<li><div class="input-append">' +
    #     '<input class="span4" data-key="{key}" value="{value}" disabled type="text"></div></li>';
    #   return $.substitute(newComponent, {key:key, value:value});
    # }

    # $('#btnAddGrupo').on('click', function() {
    #   var $cbmUsuarios = $('#cbmUsuarios');
    #   var txtUsuario = $cbmUsuarios.find(':selected').text();
    #   var txtIdUsuario = $cbmUsuarios.find(':selected').attr('value');
    #   var chkHijos = $(this).parent().find('input');
      
    #   var arrGruposSel = [];
    #   $.each(chkHijos, function(index, item){
    #     var $ckbox = $(item);
    #     if ($ckbox.prop('checked')) arrGruposSel.push($ckbox.data('key'));
    #     $ckbox.prop('checked', false); 
    #   });

    #   // Make the changes into the collection
    #   colUsuarios_grupos[txtIdUsuario] = arrGruposSel.join(',');

    #   loadUsersGroupsConfiguration();

    #   refreshHiddentxtGrupos();
    # });

    # function refreshHiddentxtGrupos()
    # {
    #   $('#txtGrupos').val(JSON.stringify(colUsuarios_grupos));
    # }

    # $('#btnAddCentro').on('click', function() {
    #   var $cbmCentros = $('#cbmCentros');
    #   var txtNombreCentro = $cbmCentros.find(':selected').text();
    #   var txtIdCentro = $cbmCentros.find(':selected').attr('value');

    #   if (txtIdCentro.length ==0 ) return alert('Seleccione');
 
    #   arrCentros = [];
    #   if (colCentros['centros'].length) arrCentros = colCentros['centros'].split(',');
    #   if ($.inArray(txtIdCentro, arrCentros) == -1) 
    #   {
    #     arrCentros.push(txtIdCentro);
    #     colCentros['centros'] = arrCentros.join(',');
    #   }

    #   $('#contenedorCentros').append(buildComponentWithButton(txtIdCentro, txtNombreCentro));

    # });

    # function buildComponentWithButton(key, value) 
    # {
    #   // Load the component
    #   var newComponent = '<li><div class="input-append">' +
    #     '<label style="cursor: move;" class="btn"><i class="icon-move"></i> </label>' +
    #     '<input class="span6" data-key="{key}" value="{value}" disabled type="text">' +
    #     '<button class="btn deleteGenre" type="button"><i class="icon-remove"></i> </button></div></li>';
    #   return $.substitute(newComponent, {key:key, value:value});
    # }