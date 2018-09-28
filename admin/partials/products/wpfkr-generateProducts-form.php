<div class="wpfkr-success-msg" style="display: none;"></div>
<div class="wpfkr-error-msg" style="display: none;"></div>
<form method="post" id="wpfkrGenProductForm" class="wpfkrCol-9">
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
			<th scope="row">Products have Sales price</th>
			<td>
				<input type="checkbox" name="wpfkr-haveSalesPrice" checked />
			</td>

		</tr>
		<tr valign="top">
			<th scope="row">All products have same price</th>
			<td>
				<input type="checkbox" name="wpfkr-haveSamePrice" />
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
<div class="wrapper dcsLoader wpfkrCol-3" style="display: none;">
	<div class="wpfkrLoaderWrpper c100 p0 blue">
		<span class="wpfkrLoaderPer">0%</span>
		<div class="slice">
			<div class="bar"></div>
			<div class="fill"></div>
		</div>
	</div>
</div>