jQuery(document).ready(function($) {
  var editorElement = '#postdivrich';
  var podsPrefix = /^pods-/;
  
  function hideElementIfUnused(element, match, val) {
    if(match.test(val)) {
      $(element).hide();
    } else {
      $(element).show();
    }
  }
  
  hideElementIfUnused(editorElement, podsPrefix, $('#page_template').val());
  $('#page_template').change(function() {
    hideElementIfUnused(editorElement, podsPrefix, $(this).val());
  });
});
