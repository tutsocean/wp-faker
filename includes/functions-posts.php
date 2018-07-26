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