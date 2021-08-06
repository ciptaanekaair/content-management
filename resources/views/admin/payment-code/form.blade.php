<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title-delete"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form type="POST" id="delete-form" name="delete-form">
			<div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" name="peyment_method_id_d" id="peyment_method_id_d">
					<input type="hidden" name="_method" id="formMethodD" value="DELETE">
				<p align="center">
					Anda akan menghapus data:<br>
					<code id="payment_method_name_d"></code>.
					<br>
					<b>Apakah anda yakin? Anda tidak akan dapat mengembalikan data ini.</b>
				</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-danger" id="btnDelete"><i class="fa fa-trash"></i> &nbsp Delete</button>
			</form>
			</div>
		</div>
	</div>
</div>