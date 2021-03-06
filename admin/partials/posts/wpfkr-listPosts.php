<?php
global $wpdb;
if(isset($_GET['action']) && $_GET['action'] == 'wpfkr_deleteposts'){
	wpfkrDeleteFakePosts();
	wp_redirect("admin.php?page=wpfkr-posts&tab=view_posts&status=success");
}
$wpfkrQueryData = wpfkrGetFakePostsList();
$wpfkrPostData = $wpfkrQueryData->posts;
$wpfkrActual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
 ?>
 <h2>Bellow are all the posts generated by this plugin 
 	<?php if ( !empty($wpfkrPostData) ) { ?>
	 	<span class="deleteSpan">
	 		<a onclick="return confirm('Are you sure you want to delete all fake posts?')" class="wpfkr-btn wpfkr-btnRed" href="<?=$wpfkrActual_link?>&action=wpfkr_deleteposts">Delete all posts</a>
	 	</span>
 	<?php } ?>
 </h2>
<table id="wpfkrListPostsTbl" class="stripe" style="width:100%">
	<thead>
		<tr>
			<th>#</th>
			<th>Post title</th>
			<th>Post type</th>
			<th>Post Status</th>
			<th>Created date</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ( !empty($wpfkrPostData) ) {
			$counter = 1;
			foreach ($wpfkrPostData as $key => $postDatavalue){ ?>
				<tr>
					<td><?=$counter?></td>
					<td><?=$postDatavalue->post_title?></td>
					<td><?=$postDatavalue->post_type?></td>

					<td><?=$postDatavalue->post_status?></td>
					<td><?=date("F jS, Y", strtotime($postDatavalue->post_date));?></td>
				</tr>
				<?php
				$counter++;
			}
			wp_reset_postdata();
		} ?>
	</tbody>
</table>