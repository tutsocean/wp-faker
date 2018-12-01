<div class="wpfkr-wrapper">
	<div class="wpfkr-top-header">
	    <h2><?php echo  PLUGIN_NAME ?> <span> - Generate Users</span></h2>
	    <?php
	    if(isset($_GET['status'])){
	    	if($_GET['status'] == 'success'){
	    		echo '<div class="wpfkr-success-msg">All users deleted successfully.</div>';
	    	}else{
	    		echo '<div class="wpfkr-error-msg">Something went wrong.</div>';
	    	}
	    }
		if( isset( $_GET[ 'tab' ] ) ) {
		    $active_tab = $_GET[ 'tab' ];
		}else{
			$active_tab = 'generate_users';
		}
		?>
	    <h2 class="nav-tab-wrapper">
		    <a href="?page=Users&tab=generate_users" class="nav-tab <?php echo $active_tab == 'generate_users' ? 'nav-tab-active' : ''; ?>">Generate Users</a>
		    <a href="?page=Users&tab=view_users" class="nav-tab <?php echo $active_tab == 'view_users' ? 'nav-tab-active' : ''; ?>">View Fake Users</a>
		</h2>
	</div>
	<div class="wpfkr-pagebody">
		<?php 
		if($active_tab == 'generate_users'){
			$page_slug = 'wpfkr-generateUsers-form';
		}else{
			$page_slug = 'wpfkr-listUsers';
		}
		include(WP_PLUGIN_DIR.'/'.plugin_dir_path(PLUGIN_BASE_URL) . 'admin/partials/users/'.$page_slug.'.php');
		?>
	</div>
	<div class="wpfkr-footer">
		
	</div>
</div>

