<?php
function wpfkrPosts(){
    include( WP_PLUGIN_DIR.'/'.plugin_dir_path(WPFKR_PLUGIN_BASE_URL) . 'admin/template/wpfkr-posts.php');
}
function wpfkrGetPostTypes(){
    $args=array(
        'public'                => true,
        'exclude_from_search'   => false,
        '_builtin'              => false
    ); 
    $output = 'names'; // names or objects, note names is the default
    $operator = 'and'; // 'and' or 'or'
    $regPostTypes = get_post_types($args,$output,$operator);
    $posttypes_array = array();
    $posttypes_array['post'] = 'Posts';
    foreach ($regPostTypes  as $post_type ) {
        $wpfkr_pt = get_post_type_object( $post_type );
        $wpfkr_pt_name = $wpfkr_pt->labels->name;
        $posttypes_array[$post_type] = $wpfkr_pt_name;
    }
    unset($posttypes_array['product']); //exclude 'product' post type as we are providing separate section for products 
    return $posttypes_array;
}

function wpfkrGeneratePosts($posttype='post',$wpfkrIsThumbnail='off'){
    include( WP_PLUGIN_DIR.'/'.plugin_dir_path(WPFKR_PLUGIN_BASE_URL) . 'vendor/autoload.php');
    // use the factory to create a Faker\Generator instance
    $wpfkrFaker = Faker\Factory::create();
    $wpfkrPostTitle = $wpfkrFaker->text($maxNbChars = 40);
    $wpfkrPostDescription = $wpfkrFaker->text($maxNbChars = 700);
    $rand_num = rand(1,15);
    $wpfkrPostThumb = WP_PLUGIN_DIR.'/'.plugin_dir_path(WPFKR_PLUGIN_BASE_URL) . 'images/posts/'.$rand_num.".jpg";
    // create post
    $wpfkrPostArray = array(
      'post_title'    => wp_strip_all_tags( $wpfkrPostTitle ),
      'post_content'  => $wpfkrPostDescription,
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type' => $posttype
    );
    // Insert the post into the database
    $wpfkrPostID = wp_insert_post( $wpfkrPostArray );
    if($wpfkrPostID){
        update_post_meta($wpfkrPostID,'wpfkr_post','true');
        if($wpfkrIsThumbnail=='on')
        wpfkr_Generate_Featured_Image( $wpfkrPostThumb,$wpfkrPostID);
        return 'success';
    }else{
        return 'error';
    }

}
function wpfkr_Generate_Featured_Image( $image_url, $post_id ){
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $filename = "wpfkr_".$post_id;
    if(wp_mkdir_p($upload_dir['path'])){
        $file = $upload_dir['path'] . '/' . $filename;
    }
    else{
        $file = $upload_dir['basedir'] . '/' . $filename;
    }
    file_put_contents($file, $image_data);
    $wp_filetype = wp_check_filetype($filename, null ); 
    $attachment = array(
        'post_mime_type' => 'image/jpg',
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
    update_post_meta($attach_id, 'wpfkr_attachment','true');
    $res2= set_post_thumbnail( $post_id, $attach_id );
}


function wpfkrAjaxGenPosts () {
    $wpfkrIsThumbnail = 'off';
    $post_type = $_POST['wpfkr-posttype'];
    $remaining_posts = $_POST['remaining_posts'];
    $post_count = $_POST['wpfkr-post_count'];

    if($remaining_posts>=2){
        $loopLimit = 2;
    }else{
        $loopLimit = $remaining_posts;
    }


    $wpfkrIsThumbnail = $_POST['wpfkr-thumbnail'];
    $counter = 0;
    for ($i=0; $i < $loopLimit ; $i++) { 
        $generationStatus = wpfkrGeneratePosts($post_type,$wpfkrIsThumbnail);
        if($generationStatus == 'success'){
            $counter++;
        }
    }
    if($remaining_posts>=2){
        $remaining_posts = $remaining_posts - 2;
    }else{
        $remaining_posts = 0;
    }
    echo json_encode(array('status' => 'success', 'message' => 'Posts generated successfully.','remaining_posts' => $remaining_posts) );
    die();
}
add_action("wp_ajax_wpfkrAjaxGenPosts", "wpfkrAjaxGenPosts");
add_action("wp_ajax_nopriv_wpfkrAjaxGenPosts", "wpfkrAjaxGenPosts");

function wpfkrGetFakePostsList(){
    $postsArr = wpfkrGetPostTypes();
    $allPostTypes = array();
    foreach ($postsArr as $key => $value) {
        array_push($allPostTypes, $key);
    }
    $args = array(
        'posts_per_page' => -1,
        'post_type' => $allPostTypes,
        'order' => 'DESC',
        'meta_query' => array(
            array(
                'key' => 'wpfkr_post',
                'value' => 'true',
                'compare' => '='
            ),
        )
    );
    $wpfkrQueryData = new WP_Query( $args );
    return $wpfkrQueryData;
}

function wpfkrDeleteFakePosts(){
    $wpfkrQueryData = wpfkrGetFakePostsList();
    if ($wpfkrQueryData->have_posts()) {
        while ( $wpfkrQueryData->have_posts() ) :
            $wpfkrQueryData->the_post();
            wp_delete_post(get_the_ID());
        endwhile;
    }
    wp_reset_postdata();
}

function wpfkrDeletePosts () {
    wpfkrDeleteFakePosts();
    echo json_encode(array('status' => 'success', 'message' => 'Data deleted successfully.') );
    die();
}
add_action("wp_ajax_wpfkrDeletePosts", "wpfkrDeletePosts");
add_action("wp_ajax_nopriv_wpfkrDeletePosts", "wpfkrDeletePosts");