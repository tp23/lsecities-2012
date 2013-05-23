/**
 * When on a Page edit screen with a Pods template selected for the
 * page, hide main content entry textarea to avoid confusing users.
 * As the page's own content is not used on any of our Pods templates,
 * accidentally inserting content there might lead editors to worry
 * about this content not appearing on the rendered pages.
 */
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
