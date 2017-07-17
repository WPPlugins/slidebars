/**
 * WebKinder WordPress Select Setting
 * Converts a regular text setting into a dynamic select setting where the user can
 * click options or search them with a search field
 *
 * @param selectors, Object of valid jQuery selectors containing
 *          .container,
 *          .option
 *          .valueContainer
 *          .optionsContainer
 *          .searchField
 *
 */

function wk_select_setting( selectors ) {

  highlightCurrent();

  function highlightCurrent() {
    jQuery(selectors.container).find(selectors.option + '.active').removeClass('active');
    var currentValue = jQuery(selectors.container).find(selectors.valueContainer).val();
    jQuery(selectors.container).find(selectors.option + '[data-value="'+currentValue+'"]').addClass('active');
  }

  function selectElement( dataValue ) {
    jQuery(selectors.container).find(selectors.option + '.active').removeClass('active');
    jQuery(selectors.container).find(selectors.option+'[data-value="'+dataValue+'"]').addClass('active');
    jQuery(selectors.container).find(selectors.valueContainer).val(dataValue);
  }

  function jumpToActiveElement(offset) {
    var scrollToActive = jQuery('.active').offset().top - jQuery(selectors.optionsContainer).offset().top - offset;
    jQuery(selectors.optionsContainer).scrollTop(scrollToActive);
  }

  jQuery(selectors.container).find(selectors.valueContainer).change(function(){
    highlightCurrent();
  });


  //reset view on click
  jQuery(selectors.container).find(selectors.option).click(function() {
    selectElement( jQuery(this).attr('data-value') );

    //reload view if method search was used
    if (jQuery(selectors.optionsContainer).hasClass('method-search')) {
      jQuery(selectors.option).each(function () {
            jQuery(this).show()
          }
      );

      jumpToActiveElement(0);
      jQuery(selectors.optionsContainer).removeClass('method-search');
    }
  });


  //on reload
  if( jQuery(selectors.container).find(selectors.option + '.active').length > 0 ) {
    jumpToActiveElement(70);
  }

  //delay between typing
  var delay = (function(){
    var timer = 0;
    return function(callback, ms){
      clearTimeout (timer);
      timer = setTimeout(callback, ms);
    };
  })();

  //kill enter key just kill it!
  jQuery(selectors.container).find(selectors.searchField).on( 'keyup keypress', function( e ){
    var charCode = ( e.which ) ? e.which : e.keyCode;
    if( charCode == 13 ){
      e.preventDefault();
      return false;
    }
  } );

  //search box for icons
  jQuery(selectors.container).find(selectors.searchField).keyup(function (e) {

    //add icon select method
    if(!jQuery(selectors.optionsContainer).hasClass("method-search")){
      jQuery(selectors.optionsContainer).addClass("method-search");
    }

    //remove method search if no search term was typed
    if(jQuery(selectors.container).find(selectors.valueContainer).val().length <= 0){
      jQuery(selectors.optionsContainer).removeClass("method-search");
    }


    delay( function () {

      var searchTerm = jQuery(selectors.container).find(selectors.searchField).val();

      jQuery(selectors.option).each(function () {

        var className = jQuery(this).attr('class');

        //if term matches or not
        className.search(searchTerm) >= 0 ? jQuery(this).show() : jQuery(this).hide();
      });
    }, 300)
  });


}
