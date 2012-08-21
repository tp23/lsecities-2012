jQuery(document).ready(function($) {
  var editorElement = '#postdivrich';
  if(/^pods-/.test($('#page_template').val())) {
    $(editorElement).hide();
  }
  $('#page_template').change(function(){
        if (/^pods-/.test($(this).val())) {
            $(editorElement).hide();
        } else {
            $(editorElement).show();
        }
    });
});
