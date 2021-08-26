<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" id="formImage" name="formImage" enctype="multipart/form-data">
				<div class="modal-body">
					<code align="center" style="text-align: center;" id="productImagesTextID"></code>
					<input type="hidden" name="product_id_i" id="product_id_i" value="{{ old('product_id_i', $product->id) }}">
					<input type="hidden" name="images_id" id="images_id">
					<input type="hidden" name="_method" id="modalFormMethod" value="PUT">
					<div class="row">
						<div class="col-lg-6">
							<div class="alert-message">
								<code id="product_id_iError"></code>
								<code id="images_idError"></code>
							</div>
							<div class="form-group">
								<label for="images">Gambar Kategori</label>
								<input type="file" name="images" class="form-control" id="images">
								<div class="alert-message">
									<code id="imagesError"></code>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btnSave">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>