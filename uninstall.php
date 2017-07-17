<?php
// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}

delete_option( 'wksl_slidebars_settings' );

// For site options in Multisite
delete_site_option( 'wksl_slidebars_settings' );

?>
