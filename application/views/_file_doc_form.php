<div class="row">
	<form role="form" id="myform" method="post" action="<?php echo current_url(); ?>">
	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-black-topborder">
				<div class="box-body">
					<?php 
					echo '<input type="hidden" id="id" name="id" value="' . $id . '">';
					echo '<input type="hidden" id="fileid" name="fileid" value="' . $fileid . '">';
					echo $this->app_html->form_group(array('type'=>'text','line'=>'fd_name', 'id'=>'name','name'=>'name','val'=>$name,'class'=>'form-control','max'=>128,'errmsg'=>true)); 
					echo $this->app_html->form_group(array('type'=>'date','line'=>'fd_doc_date','id'=>'doc_date','name'=>'doc_date','val'=>$doc_date,'ph'=>'yyyy-mm-dd','errmsg'=>true));
					echo $this->app_html->form_group(array('type'=>'date','line'=>'fd_process_date','id'=>'process_date','name'=>'process_date','val'=>$process_date,'ph'=>'yyyy-mm-dd','errmsg'=>true));
					?>
				</div>
		</div>
		<!-- /.box -->

		<!-- Form Element sizes -->
		<!-- /.box -->

		<!-- Input addon -->
		<!-- /.box -->

	</div>
	<!--/.col (left) -->
	
	<!-- right column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-black-topborder">
				<div class="box-body">
					<?php 
					echo $this->app_html->form_group(array('type'=>'select','line'=>'fd_pic','id'=>'pic','name'=>'pic','val'=>$pic,'lkp'=>$aPic,'ph'=>'Select PIC from the list','errmsg'=>true));
					echo $this->app_html->form_group(array('type'=>'area','line'=>'fd_desc','id'=>'desc','name'=>'desc','val'=>$desc,'row'=>3,'errmsg'=>true));
					?>
				</div>

				<div class="box-footer">
					<button id="btnsubmit" name="btnsubmit" type="submit" class="btn btn-primary" style="float:left;">Submit</button>
					<div id="btnbusy" class="btnbusy"></div><div id="btninfo" class="btninfo">Processing...</div>
				</div>
		</div>
		<!-- /.box -->

		<!-- Form Element sizes -->
		<!-- /.box -->

		<!-- Input addon -->
		<!-- /.box -->

	</div>

	<!--/.col (right) -->
	</form>
</div>
<!-- /.row -->

<div class="row">
<div class="col-xs-12">
	<div class="box box-black-topborder">
		<div class="box-header">
			<h3 class="box-title">Document Attachments</h3>
		</div>
		<div id="divjfuview"></div>
	</div>
</div>
</div>
<?php 
echo $htmltailattr; 
$this->load->view("postjs");
if ($mode == 'update')
{
	$this->load->view('jfu_view');
}
?>

<script type="text/javascript">
$(function () {
	$('#doc_date').datepicker({format: 'yyyy-mm-dd', autoclose: true});
	$('#process_date').datepicker({format: 'yyyy-mm-dd', autoclose: true});
	$("#pic").select2({allowClear: true});
});
</script>