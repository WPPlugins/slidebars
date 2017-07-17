/**
 * WK Slidebars
 * JavaScript for the settings page
 * Depends on functions defined in /deps
 */
 

jQuery(document).ready(function() {

  WordpressSettingsTooltips.create( 'wksl_slidebars_settings[preview_mode]', wksl_settings_content.preview_mode_tooltip );
  WordpressSettingsTooltips.create( 'wksl_slidebars_settings[hide_on]', wksl_settings_content.hide_on_tooltip );
  WordpressSettingsTooltips.create( 'wksl_slidebars_settings[push_content]', wksl_settings_content.push_content_tooltip );
  WordpressSettingsTooltips.create( 'wksl_slidebars_settings[use_content_overlay]', wksl_settings_content.use_content_overlay_tooltip );

  wp_color_picker( '.wksl-slidebars-color-field' );

  wk_select_setting({
    container: '.wk-select-setting',
    option: '.wk-select-value-option',
    valueContainer: '.wk-select-value-container',
    optionsContainer: '.wk-select-options-container',
    searchField: '.wk-select-value-search'
  });

  wk_json_setting({
    container: '.wk-json-setting',
    valueAdder: '.wk-json-value-adder',
    valueRemover: '.wk-json-value-remover',
    valueContainer: '.wk-json-value-container',
    valueDisplay: '.wk-json-value-display'
  });

});

/**
 * WebKinder WordPress JSON Setting
 * Converts a regular text setting into a JSON setting that stores a dynamic array of values
 * that can be edited without a page reload
 *
 * @param selectors, Object of valid jQuery selectors containing
 *          .container
 *          .valueAdder
 *          .valueRemover
 *          .valueContainer,
 *          .valueDisplay
 *
 */

function wk_json_setting( selectors ) {

  //json settings field display current values
  displayValues();

  //json settings field adding
  jQuery(selectors.container).children(selectors.valueAdder).click(function() {
    var $valueContainer = jQuery(this).siblings( selectors.valueContainer );
    var newValue = parseInt( jQuery(this).siblings('select').val() );

    var currentValue = JSON.parse( $valueContainer.val() );
    if( currentValue.indexOf( newValue ) === -1 ) {
      currentValue.push( newValue );
      $valueContainer.val(JSON.stringify( currentValue ));
      displayValues();
    }
  });

  //json settings field displaying
  function displayValues() {

    //clear old values
    var $valueDisplay = jQuery( selectors.container ).children( selectors.valueDisplay );
    $valueDisplay.html('');

    //display new ones
    JSON.parse( jQuery(selectors.container).children(selectors.valueContainer).val() ).map(function(page_id) {
      $valueDisplay.append( makeItem( page_id ) ).children('#page_id-'+page_id).children( selectors.valueRemover ).click(function() {
        removeItem( parseInt( jQuery(this).parent('.wk-json-value-item').attr('data-page_id') ) );
      });
    });
  }

  //make a new display item
  function makeItem( page_id ) {
    var pageName = jQuery(selectors.container).children('select').children('option[value="'+page_id+'"]').text();
    return '<li class="wk-json-value-item" data-page_id="'+page_id+'" id="page_id-'+page_id+'">'+pageName+'<span class="'+selectors.valueRemover.substr(1)+'">-</span></li>';
  }

  //remove an item
  function removeItem( page_id ) {
    var $valueContainer = jQuery( selectors.container ).children( selectors.valueContainer );
    var values = JSON.parse( $valueContainer.val() );

    if( values.indexOf( page_id ) != -1 ) {
      values.splice( values.indexOf( page_id ), 1 );
      $valueContainer.val( JSON.stringify( values ) );
      displayValues();
    }

  }

}

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

/**
 * Minified version of https://github.com/maurobringolf/wordpress-settings-tooltips
 */
var WordpressSettingsTooltips=function(t){function e(e){t(e).each(function(){n(this)&&i(this.settingName)&&t('input[name="'+this.settingName+'"]').parents("tr").children('th[scope="row"]').append('<span class="wordpress-settings-tooltip-container">?</span>').children(".wordpress-settings-tooltip-container").mouseover(s).mouseleave(r).css(p().icon).append(o(this.text)).children(".wordpress-settings-tooltip-text").css(p().tooltip)})}function n(t){return"text"in t&&"string"==typeof t.text&&"settingName"in t&&"string"==typeof t.settingName}function i(e){return t(' input[name="'+e+'"]').length>0}function o(t){return'<span class="wordpress-settings-tooltip-text">'+t+"</span>"}function s(){jQuery(this).children(".wordpress-settings-tooltip-text").css("opacity","1")}function r(){jQuery(this).children(".wordpress-settings-tooltip-text").css("opacity","0")}function p(){var t={"font-size":"13px","background-color":"#a0a5aa",height:"18px",width:"18px",color:"white","text-align":"center","line-height":"18px",display:"inline-block","border-radius":"100%","margin-left":"10px",position:"relative",cursor:"pointer"},e={"font-size":"13px","background-color":"white",color:"black",position:"absolute",left:"25px",top:"0",width:"200px","z-index":"10000","pointer-events":"none","box-shadow":"0px 0px 5px rgba(0,0,0,0.3)",opacity:"0",transition:"opacity 0.15s ease",padding:"4px"};return{icon:t,tooltip:e}}if(void 0===t)throw new Error("jQuery is not defined.");return e.create=function(t,n){e([{settingName:t,text:n}])},e}(jQuery);

/**
 * Converts a field into a WordPress color picker field
 *
 * @param selector, valid jQuery selector
 */
function wp_color_picker( selector ) {
  jQuery( selector ).wpColorPicker();
}
