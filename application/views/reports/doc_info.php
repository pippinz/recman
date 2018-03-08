<?php
if ($isrecord):
?>
<!-- .row -->
<div class="row">
	<!-- left column -->
	<div class="col-md-6">
		<div class="box-body">
			<?php
			echo $this->app_html->tblrec('rd_name', $docname);
			echo $this->app_html->tblrec('rd_date', $docdate);
			echo $this->app_html->tblrec('rd_process_date', $docprocessdate);
			?>
		</div>
	</div>
	<!--/.col (left) -->

	<!-- right column -->
	<div class="col-md-6">
		<div class="box-body">
			<?php
			echo $this->app_html->tblrec('rd_pic_short', array_key_exists($docpic, $aPic) ? $aPic[$docpic] : $docpic);
			echo $this->app_html->tblrec('rd_desc', nl2br($docdesc));
			?>
		</div>
	</div>
	<!--/.col (right) -->
</div>
<!-- /.row -->

<?php
else:
echo $this->lang->line('data_not_found');
endif;
?>
<style type="text/css">
.form-group{float:left;width:100%;}
.form-group label{font-weight:normal;background-color:#eee;border:1px dotted #666;}
</style>