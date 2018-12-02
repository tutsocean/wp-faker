<div class="wpfkr-wrapper">

	<?php if ( class_exists( 'WooCommerce' ) ) { ?>

	<div class="wpfkr-top-header">
	    <h2><?php echo  WPFKR_PLUGIN_NAME ?> <span> - Generate Woocommerce products</span></h2>
	    <?php 
	    if(isset($_GET['status'])){
	    	if($_GET['status'] == 'success'){
	    		echo '<div class="wpfkr-success-msg">All products deleted successfully.</div>';
	    	}else{
	    		echo '<div class="wpfkr-error-msg">Something went wrong.</div>';
	    	}
	    }
		if( isset( $_GET[ 'tab' ] ) ) {
		    $active_tab = $_GET[ 'tab' ];
		}else{
			$active_tab = 'generate_products';
		}
		?>
	    <h2 class="nav-tab-wrapper">
		    <a href="?page=wpfkr-products&tab=generate_products" class="nav-tab <?php echo $active_tab == 'generate_products' ? 'nav-tab-active' : ''; ?>">Generate Products</a>
		    <a href="?page=wpfkr-products&tab=view_products" class="nav-tab <?php echo $active_tab == 'view_products' ? 'nav-tab-active' : ''; ?>">View Fake Products</a>
		</h2>
	</div>
	<div class="wpfkr-pagebody">
		<?php 
		if($active_tab == 'generate_products'){
			$page_slug = 'wpfkr-generateProducts-form';
		}else{
			$page_slug = 'wpfkr-listProducts';
		}
		include(WP_PLUGIN_DIR.'/'.plugin_dir_path(WPFKR_PLUGIN_BASE_URL) . 'admin/partials/products/'.$page_slug.'.php');
		?>
	</div>
	<div class="wpfkr-footer">
		
	</div> 
	<?php } else{ ?>
		<div class="wpfkr-pagebody">
			<div class="wpfkr-error-msg">This section requires woocommerce plugin to be installed and active. Please activate woocommerce plugin first.</div>
		</div>
	<?php } ?>
</div>