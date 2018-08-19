<div class="wpfkr-success-msg" style="display: none;"></div>
<div class="wpfkr-error-msg" style="display: none;"></div>
<form method="post" id="wpfkrGenProductForm">
	<input type="hidden" name="action" value="wpfkrAjaxGenProducts" />
	<input type="hidden" name="remaining_products" class="remaining_products" value="" />
    <table class="form-table">
        <tr valign="top">
	        <th scope="row">Number of products</th>
	        <td>
	        	<input type="number" name="wpfkr-product_count" class="wpfkr-product_count"  placeholder="Number of products" value="10" max="500" min="1" />
	        </td>
        </tr>
        <tr valign="top">
	        <th scope="row">Generate Thumbnail</th>
	        <td>
	        	<input type="checkbox" name="wpfkr-thumbnail" />
	        </td>
        </tr>
    </table>
    <input class="wpfkr-btn btnFade wpfkr-btnBlueGreen wpfkrGenerateProducts" type="submit" name="wpfkrGenerateProducts" value="Generate products">
</form>
<div class="remaining_notification">
	<?php wpfkrGetWcCategories(); ?>
</div>