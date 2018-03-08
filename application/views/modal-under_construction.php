<div id="modal-uc" class="modal modal-warning">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Under Construction</h4>
	  </div>
	  <div class="modal-body">
		<p>Please have a cup of coffee and be here again another time :)</p>
	  </div>
	  <div class="modal-footer">
		<!--button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button-->
		<button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
	  </div>
	</div>
	<!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
$(function(){
	$('.uc').click(function(){
		$("#modal-uc").modal(function(){
			$(this).show();
		});
	});
});
</script>