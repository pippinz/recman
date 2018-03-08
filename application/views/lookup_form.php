<div class="row">
	<form role="form" id="myform" method="post" action="<?php echo current_url(); ?>">
	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-black-topborder">
				<div class="box-header">
					<h3 class="box-title"><?php echo isset($sLookupTitle) ? $sLookupTitle : '';?></h3>
					<a href="<?php echo $this->config->item('uri_lookup') . $aLkp['lkp'] . '/form/';?>">
					<button id="btnsubmit" name="btnsubmit" type="button" class="btn btn-sm btn-primary btn-warning" style="float:right !important;"><?php echo $this->lang->line('add_new')?></button>
					</a>
				</div>
				<div class="box-body">
					<?php 
					echo '<input type="hidden" id="id" name="id" value="' . $id . '">';
					echo $this->app_html->form_group(array('type'=>'text','line'=>'li_code', 'id'=>'code','name'=>'code','val'=>$code,'class'=>'form-control','max'=>64,'errmsg'=>true)); 
					echo $this->app_html->form_group(array('type'=>'text','line'=>'li_name', 'id'=>'name','name'=>'name','val'=>$name,'class'=>'form-control','max'=>64,'errmsg'=>true)); 
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
	<!--/.col (left) -->
	
	</form>
</div>
<!-- /.row -->

<?php 
echo $htmltailattr; 
$this->load->view("postjs");
?>
<script type="text/javascript">
$(function(){});
</script>
