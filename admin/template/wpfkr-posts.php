<div class="wpfkr-wrapper">
	<div class="wpfkr-top-header">
	    <h2><?php echo  PLUGIN_NAME ?> <span> - Generate Posts</span></h2>
	    <?php 
	    if(isset($_GET['status'])){
	    	if($_GET['status'] == 'success'){
	    		echo '<div class="wpfkr-success-msg">All posts deleted successfully.</div>';
	    	}else{
	    		echo '<div class="wpfkr-error-msg">Something went wrong.</div>';
	    	}
	    }
		if( isset( $_GET[ 'tab' ] ) ) {
		    $active_tab = $_GET[ 'tab' ];
		}else{
			$active_tab = 'generate_posts';
		}
		?>
	    <h2 class="nav-tab-wrapper">
		    <a href="?page=Posts&tab=generate_posts" class="nav-tab <?php echo $active_tab == 'generate_posts' ? 'nav-tab-active' : ''; ?>">Generate Posts</a>
		    <a href="?page=Posts&tab=view_posts" class="nav-tab <?php echo $active_tab == 'view_posts' ? 'nav-tab-active' : ''; ?>">View Fake Posts</a>
		</h2>
	</div>
	<div class="wpfkr-pagebody">
		<?php 
		if($active_tab == 'generate_posts'){
			$page_slug = 'wpfkr-generatePosts-form';
		}else{
			$page_slug = 'wpfkr-listPosts';
		}
		include(WP_PLUGIN_DIR.'/'.plugin_dir_path(PLUGIN_BASE_URL) . 'admin/partials/posts/'.$page_slug.'.php');
		?>
	</div>
	<div class="wpfkr-footer">
		
	</div>
</div>