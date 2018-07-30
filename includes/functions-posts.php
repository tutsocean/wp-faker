<?php
function wpfkrPosts(){
    include( WP_PLUGIN_DIR.'/'.plugin_dir_path(PLUGIN_BASE_URL) . 'admin/template/wpfkr-posts.php');
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

function wpfkrGeneratePosts($posttype='post', $numOfPosts = '10'){
    die('here');
    include( WP_PLUGIN_DIR.'/'.plugin_dir_path(PLUGIN_BASE_URL) . 'vendor/autoload.php');
    // use the factory to create a Faker\Generator instance
    $wpfkrFaker = Faker\Factory::create();
    $wpfkrPostTitle = $wpfkrFaker->text($maxNbChars = 40);
    $wpfkrPostDescription = $wpfkrFaker->text($maxNbChars = 700);
    $rand_num = rand(1,10);
    $wpfkrPostThumb = WP_PLUGIN_DIR.'/'.plugin_dir_path(PLUGIN_BASE_URL) . 'images/posts/'.$rand_num.".jpg";
    // create post
    $wpfkrPostArray = array(
      'post_title'    => wp_strip_all_tags( $wpfkrPostTitle ),
      'post_content'  => $wpfkrPostDescription,
      'post_status'   => 'publish',
      'post_author'   => 1,
      //'post_type' => 'football'
    );
    // Insert the post into the database
    $wpfkrPostID = wp_insert_post( $wpfkrPostArray );
    if($wpfkrPostID){
        Generate_Featured_Image( $wpfkrPostThumb,$wpfkrPostID);
    }else{
        echo "some error occured";
    }

}
function Generate_Featured_Image( $image_url, $post_id ){
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
    $res2= set_post_thumbnail( $post_id, $attach_id );
}