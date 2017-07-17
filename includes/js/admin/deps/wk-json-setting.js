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
