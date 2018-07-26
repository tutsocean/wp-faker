<div class="wpfkr-wrapper">
	<div class="wpfkr-top-header">
	    <h2>
	    	<?php echo  PLUGIN_NAME ?> <span> - Generate Posts</span>
	    </h2>
	</div>
	<div class="wpfkr-pagebody">
		<?php 
		$wpfkrPosTypes = wpfkrGetPostTypes();
		?>

		<form method="post" action="options.php">
		    <table class="form-table">
		        <tr valign="top">
			        <th scope="row">Choose Post type</th>
			        <td>
			        	<select name="wpfkr-posttype">
			        		<?php foreach ($wpfkrPosTypes as $key => $value): ?>
			        			<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
			        		<?php endforeach; ?>
			        	</select>
			        </td>
		        </tr>
		        <tr valign="top">
			        <th scope="row">Number of posts</th>
			        <td>
			        	<input type="number" name="wpfkr-post_count" placeholder="Number of posts" />
			        </td>
		        </tr>

		        <tr valign="top">
			        <th scope="row">Generate Thumbnail</th>
			        <td>
			        	<input type="checkbox" name="wpfkr-thumbnail" />
			        </td>
		        </tr>

		    </table>
		    <input class="wpfkr-btn btnFade wpfkr-btnBlueGreen wpfkrGeneratePosts" type="submit" name="wpfkrGeneratePosts" value="Generate posts">
		</form>

	</div>

	<div class="wpfkr-footer">
		
	</div>
</div>

