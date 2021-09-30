<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title-delete"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form type="POST" id="form_product_delete">
      <div class="modal-body">
          <input type="hidden" name="product_id" id="product_id">
          <input type="hidden" name="_method" id="formMethodD" value="DELETE">
        <p align="center">
          Anda akan menghapus product: <span id="modalProductName"></span>
          <br>
          <code>Note: Gambar akan terhapus secara permanen.</code>
        </p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger" id="btnDelete"><i class="fa fa-trash"></i> &nbsp Delete</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detail" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="detail-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover">
								<tr>
									<td>Product Name</td>
									<td width="10">:</td>
									<td>
										<span id="product_name_text"></span>
									</td>
									<td>Part Code</td>
									<td width="10">:</td>
									<td>
										<span id="product_code_text"></span>
									</td>
								</tr>
								<tr>
									<td>Product Price</td>
									<td width="10">:</td>
									<td>
										<span id="product_price_text"></span>
									</td>
									<td>Stock</td>
									<td width="10">:</td>
									<td>
										<span id="product_stock_text"></span>
									</td>
								</tr>
								<tr>
									<td>Terjual</td>
									<td width="10">:</td>
									<td colspan="4">
										<span id="product_terjual_text"></span>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
