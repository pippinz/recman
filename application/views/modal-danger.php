<div id="modal-del" class="modal modal-danger fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Delete Data</h4>
			</div>
			<div class="modal-body">
				<p><?php echo isset($sModalInfo) ? $sModalInfo : ''; ?></p>
				<p>Are you sure to continue?</p>
			</div>
			<input type="hidden" id="hiddenval" name="hiddenval" value="">
			<div class="modal-footer">
				<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancel</button>
				<button id="btnDel" type="button" class="btn btn-outline" data-id>Delete</button>
			</div>
		</div>
	</div>
</div>