(function() {
  $(function() {
    return $('[data-method]').append(function() {
      return "\n" + "<form id='restForm'  action='" + $(this).attr('href') + "' method='POST' style='display:none'>\n" + " <input type='hidden' name='_method' value='" + $(this).attr('data-method') + "'>\n" + "</form>\n";
    }).removeAttr('href').attr('style', 'cursor:pointer;').attr('onclick', '$(this).find("form").submit();');
  });

}).call(this);
