<?php
add_action('admin_menu', 'wpfkrDashboard');
function wpfkrDashboard(){
    add_menu_page( 'wpfkr dashboard', 'wp faker', 'manage_options', 'wpfkr-dashboard', 'wpfkrMainDashboard',plugin_dir_url( __DIR__ ).'admin/images/logo-plugin.png',58);
    add_submenu_page ( 'wpfkr-dashboard', 'Users', 'Users', 'read', 'Users', 'wpfkrUsers');
    add_submenu_page ( 'wpfkr-dashboard', 'Posts', 'Posts', 'read', 'Posts', 'wpfkrPosts');
}
function wpfkrMainDashboard(){
    include( WP_PLUGIN_DIR.'/'.plugin_dir_path(PLUGIN_BASE_URL) . 'admin/template/wpfkr-dashboard.php');
}
function dcs_print($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}