<?php
/**
 * Markup for the wksl_slidebar_button shortcode
 */
?>

<button class="wksl-slidebar-button"><?php echo strlen( $atts['text'] ) > 0 ? $atts['text'] : 'Slidebar'; ?></button>
