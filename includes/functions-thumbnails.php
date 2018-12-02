<?php
function wpfkrThumbnails(){
    include( WP_PLUGIN_DIR.'/'.plugin_dir_path(WPFKR_PLUGIN_BASE_URL) . 'admin/template/wpfkr-thumbnails.php');
}
function wpfkrGetFakeThumbnailsList(){
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'attachment',
        'order' => 'DESC',
        'post_status' => 'inherit',
        'meta_query' => array(
            array(
                'key' => 'wpfkr_attachment',
                'value' => 'true',
                'compare' => '='
            ),
        )
    );
    $wpfkrQueryData = new WP_Query( $args );
    return $wpfkrQueryData;
}
// wpfkrDeleteFakeThumbnails
function wpfkrDeleteFakeThumbnails(){
    $wpfkrQueryData = wpfkrGetFakeThumbnailsList();
    if ($wpfkrQueryData->have_posts()) {
        while ( $wpfkrQueryData->have_posts() ) :
            $wpfkrQueryData->the_post();
            wp_delete_post(get_the_ID());
        endwhile;
    }
    wp_reset_postdata();
}

function wpfkrDeleteThumbnails () {
    wpfkrDeleteFakeThumbnails();
    echo json_encode(array('status' => 'success', 'message' => 'Data deleted successfully.') );
    die();
}
add_action("wp_ajax_wpfkrDeleteThumbnails", "wpfkrDeleteThumbnails");
add_action("wp_ajax_nopriv_wpfkrDeleteThumbnails", "wpfkrDeleteThumbnails");