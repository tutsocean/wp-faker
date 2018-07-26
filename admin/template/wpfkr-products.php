<div class="wpfkr-wrapper">
	<div class="wpfkr-top-header">
	    <h2>
	    	<?php echo  PLUGIN_NAME ?> <span> - Generate Products</span>
	    </h2>
	</div>
	<div class="wpfkr-pagebody">
		<form method="post" action="options.php">
		    <table class="form-table">
		        <tr valign="top">
			        <th scope="row">Type of product</th>
			        <td>
			        	<input type="radio" name="wpfkr-product_type">Random
			        	<input type="radio" name="wpfkr-product_type">Simple only
			        	<input type="radio" name="wpfkr-product_type">Variation only
			        	<input type="radio" name="wpfkr-product_type">Simple and variation
			        </td>
		        </tr>
		        <tr valign="top">
			        <th scope="row">Number of products</th>
			        <td>
			        	<input type="number" name="wpfkr-product_count" placeholder="Ex: 10" />
			        </td>
		        </tr>

		        <tr valign="top">
			        <th scope="row">Generate Thumbnail</th>
			        <td>
			        	<input type="checkbox" name="wpfkr-thumbnail" />
			        </td>
		        </tr>

		    </table>
		    <input class="wpfkr-btn btnFade wpfkr-btnBlueGreen wpfkrGenerateProducts" type="submit" name="wpfkrGenerateProducts" value="Generate Products">
		</form>

	</div>

	<div class="wpfkr-footer">
		
	</div>
</div>