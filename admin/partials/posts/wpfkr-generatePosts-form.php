<?php $wpfkrPosTypes = wpfkrGetPostTypes(); ?>
<div class="wpfkr-success-msg" style="display: none;"></div>
<div class="wpfkr-error-msg" style="display: none;"></div>
<form method="post" id="wpfkrGenPostForm" class="wpfkrCol-9">
	<input type="hidden" name="action" value="wpfkrAjaxGenPosts" />
	<input type="hidden" name="remaining_posts" class="remaining_posts" value="" />
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
	        	<input type="number" name="wpfkr-post_count" class="wpfkr-post_count"  placeholder="Number of posts" value="10" max="500" min="1" />
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
<div class="wrapper dcsLoader wpfkrCol-3" style="display: none;">
	<div class="wpfkrLoaderWrpper c100 p0 blue">
		<span class="wpfkrLoaderPer">0%</span>
		<div class="slice">
			<div class="bar"></div>
			<div class="fill"></div>
		</div>
	</div>
</div>