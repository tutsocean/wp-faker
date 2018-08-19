<?php
function wpfkrProducts(){
    include( WP_PLUGIN_DIR.'/'.plugin_dir_path(WPFKR_PLUGIN_BASE_URL) . 'admin/template/wpfkr-products.php');
}

function wpfkrGenerateProducts($posttype='product',$wpfkrIsThumbnail='off'){
    include( WP_PLUGIN_DIR.'/'.plugin_dir_path(WPFKR_PLUGIN_BASE_URL) . 'vendor/autoload.php');
    // use the factory to create a Faker\Generator instance
    $wpfkrFaker = Faker\Factory::create();
    $wpfkrPostTitle = $wpfkrFaker->text($maxNbChars = 10);
    $wpfkrPostDescription = $wpfkrFaker->text($maxNbChars = 700);
    $rand_num = rand(1,10);
    $wpfkrPostThumb = WP_PLUGIN_DIR.'/'.plugin_dir_path(WPFKR_PLUGIN_BASE_URL) . 'images/products/'.$rand_num.".jpg";
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

        // update visibility, price etc
        // visibility
		update_post_meta( $wpfkrPostID, '_visibility', 'visible' );

		// price
		$price = wc_format_decimal( floatval( rand( 1, 10000 ) ) / 100.0 );
		update_post_meta( $wpfkrPostID, '_price', $price );
		update_post_meta( $wpfkrPostID, '_regular_price', $price );
		update_post_meta( $wpfkrPostID, '_sale_price', $price-1 );

		// add categories
		$wpfkrTerms = array();
		$wpfkr_cats = wpfkrGetWcCategories();
		$wpfkrCategoryNumber = count( $wpfkr_cats );
		$wpfkrMax = rand( 1, 3 );
		for ( $i = 0; $i < $wpfkrMax ; $i++ ) {
			$wpfkrTerms[] = $wpfkr_cats[rand( 0, $wpfkrCategoryNumber - 1 )]->term_id;
		}
		wp_set_object_terms( $wpfkrPostID, $wpfkrTerms, 'product_cat', true );


        if($wpfkrIsThumbnail=='on')
        wpfkr_Generate_Featured_Image( $wpfkrPostThumb,$wpfkrPostID);
        return 'success';
    }else{
        return 'error';
    }

}
function wpfkrGetWcCategories(){
	// since wordpress 4.5.0
	$args = array(
	    'taxonomy'   => "product_cat",
	    'hide_empty' =>  false,
	);
	$wpfkrProductCategories = get_terms($args);
	return $wpfkrProductCategories;
}
function wpfkrAjaxGenProducts () {
    $wpfkrIsThumbnail = 'off';
    $post_type = 'product';
    $remaining_products = $_POST['remaining_products'];
    $product_count = $_POST['wpfkr-product_count'];

    if($remaining_products>=10){
        $loopLimit = 10;
    }else{
        $loopLimit = $remaining_products;
    }


    $wpfkrIsThumbnail = $_POST['wpfkr-thumbnail'];
    $counter = 0;
    for ($i=0; $i < $loopLimit ; $i++) { 
        $generationStatus = wpfkrGenerateProducts($post_type,$wpfkrIsThumbnail);
        if($generationStatus == 'success'){
            $counter++;
        }
    }
    if($remaining_products>=10){
        $remaining_products = $remaining_products - 10;
    }else{
        $remaining_products = 0;
    }
    echo json_encode(array('status' => 'success', 'message' => 'Products generated successfully.','remaining_products' => $remaining_products) );
    die();
}
add_action("wp_ajax_wpfkrAjaxGenProducts", "wpfkrAjaxGenProducts");
add_action("wp_ajax_nopriv_wpfkrAjaxGenProducts", "wpfkrAjaxGenProducts");

function wpfkrGetFakeProductsList(){
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'product',
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

function wpfkrDeleteFakeProducts(){
    $wpfkrQueryData = wpfkrGetFakeProductsList();
    if ($wpfkrQueryData->have_posts()) {
        while ( $wpfkrQueryData->have_posts() ) :
            $wpfkrQueryData->the_post();
            wp_delete_post(get_the_ID());
        endwhile;
    }
    wp_reset_postdata();
}