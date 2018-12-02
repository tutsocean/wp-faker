<?php
function wpfkrUsers(){
    include( WP_PLUGIN_DIR.'/'.plugin_dir_path(WPFKR_PLUGIN_BASE_URL) . 'admin/template/wpfkr-users.php');
}

function wpfkrGenerateUsers($userRole='subscriber',$wpfkrIsBio='off'){
	include( WP_PLUGIN_DIR.'/'.plugin_dir_path(WPFKR_PLUGIN_BASE_URL) . 'vendor/autoload.php');
    // use the factory to create a Faker\Generator instance
    $wpfkrFaker = Faker\Factory::create();
    $wpfkrFirstName = $wpfkrFaker->firstName;
    $wpfkrLastName = $wpfkrFaker->lastName;
    $wpfkrUserName = $wpfkrFaker->userName;
    $wpfkrUserEmail = $wpfkrFaker->freeEmail;
    $wpfkrPassword = 'wpfkr';
    $user_id = wp_create_user( $wpfkrUserName, $wpfkrPassword, $wpfkrUserEmail );
    update_user_meta($user_id,'wpfkr_user','true');
    update_user_meta($user_id,'first_name',$wpfkrFirstName);
    update_user_meta($user_id,'last_name',$wpfkrLastName);
    if($wpfkrIsBio == 'on'){
	    $wpfkrUserBio = $wpfkrFaker->text;
	    update_user_meta($user_id,'description',$wpfkrUserBio);
    }
    if($userRole != 'subscriber'){
    	$wpfkrUserObj = new WP_User( $user_id );
		$wpfkrUserObj->remove_role( 'subscriber' );
		$wpfkrUserObj->add_role( $userRole );
    }
    if( !is_wp_error( $user_id ) ){
    	return "success";
    }else{
    	return "error";
    }
}

function wpfkrAjaxGenUsers () {
    $wpfkrIsBio = 'off';
    $userRole = $_POST['wpfkr-userRole'];
    $remaining_users = $_POST['remaining_users'];
    $user_count = $_POST['wpfkr-user_count'];
    $wpfkrIsBio = $_POST['wpfkr-bio'];
    if($remaining_users>=2){
        $loopLimit = 2;
    }else{
        $loopLimit = $remaining_users;
    }
    $counter = 0;
    for ($i=0; $i < $loopLimit ; $i++) { 
        $generationStatus = wpfkrGenerateUsers($userRole,$wpfkrIsBio);
        if($generationStatus == 'success'){
            $counter++;
        }
    }
    if($remaining_users>=2){
        $remaining_users = $remaining_users - 2;
    }else{
        $remaining_users = 0;
    }
    echo json_encode(array('status' => 'success', 'message' => 'Users generated successfully.','remaining_users' => $remaining_users) );
    die();
}
add_action("wp_ajax_wpfkrAjaxGenUsers", "wpfkrAjaxGenUsers");
add_action("wp_ajax_nopriv_wpfkrAjaxGenUsers", "wpfkrAjaxGenUsers");

function wpfkrGetFakeUsers(){
    $users = get_users(array(
        'meta_key'     => 'wpfkr_user',
        'meta_value'   => 'true',
        'meta_compare' => '=',
    ));
    return $users;
}

function wpfkrDeleteFakeUsers(){
    $users = wpfkrGetFakeUsers();
    foreach ($users as $key => $userDatavalue){
        wp_delete_user($userDatavalue->ID);
    }
}

function wpfkrDeleteUsers () {
    wpfkrDeleteFakeUsers();
    echo json_encode(array('status' => 'success', 'message' => 'Data deleted successfully.') );
    die();
}
add_action("wp_ajax_wpfkrDeleteUsers", "wpfkrDeleteUsers");
add_action("wp_ajax_nopriv_wpfkrDeleteUsers", "wpfkrDeleteUsers");