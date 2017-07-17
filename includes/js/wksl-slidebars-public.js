/*
 * WK Slidebars
 * public JavaScript for frontend
 * Adds the click handlers to the slidebar trigger and overly
 */

jQuery(document).ready(function() {

  //only add handlers if slidebar is rendered
  if( jQuery('.wksl-slidebar').length > 0 ) {

    jQuery(
      '.wksl-slidebar .wksl-slidebar-trigger, '+
      '.wksl-slidebar .wksl-slidebar-overlay, '+
      '.wksl-slidebar-overlay, '+
      '.wksl-slidebar-button'
    ).click(function() {
      jQuery('html').toggleClass( 'wksl-slidebar-is-out');
    });

  }

});
