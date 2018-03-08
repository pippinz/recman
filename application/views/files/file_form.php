<?php $this->load->view('modal-danger'); ?>
<div class="row">
	<form role="form" id="myform" method="post" action="<?php echo current_url(); ?>">
	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-black-topborder">
				<div class="box-body">
					<?php 
					echo '<input type="hidden" id="id" name="id" value="' . $id . '">';
					echo $this->app_html->form_group(array('type'=>'text','line'=>'fi_name', 'id'=>'name','name'=>'name','val'=>$name,'class'=>'form-control','max'=>128,'errmsg'=>true)); 
					echo $this->app_html->form_group(array('type'=>'date','line'=>'fi_date','id'=>'date','name'=>'date','val'=>$date,'ph'=>'yyyy-mm-dd','errmsg'=>true));
					echo $this->app_html->form_group(array('type'=>'select','line'=>'fi_year','id'=>'year','name'=>'year','val'=>$year,'lkp'=>$aYear,'ph'=>'Select a value from the list','errmsg'=>true));
					echo $this->app_html->form_group(array('type'=>'select','line'=>'fi_location','id'=>'location','name'=>'location','val'=>$location,'lkp'=>$aLocation,'ph'=>'Select or enter new value','errmsg'=>true));
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
					echo $this->app_html->form_group(array('type'=>'select','line'=>'fi_category','id'=>'category','name'=>'category','val'=>$category,'lkp'=>$aCategory,'ph'=>'Select or enter new value','errmsg'=>true));
					echo $this->app_html->form_group(array('type'=>'select','line'=>'fi_volume','id'=>'volume','name'=>'volume','val'=>$volume,'lkp'=>$aVolume,'ph'=>'Select or enter new value','errmsg'=>true));
					echo $this->app_html->form_group(array('type'=>'area','line'=>'fi_desc','id'=>'desc','name'=>'desc','val'=>$desc,'row'=>3,'errmsg'=>true));
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
			<h3 class="box-title">File Attachments</h3>
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

<div class="row">
<div class="col-xs-12">
	<div class="box box-black-topborder">
		<div class="box-header">
			<h3 class="box-title">File Documents</h3>
			<span id="divdocadd" style="float:right;<?php echo ($mode == 'insert') ? 'display:none;' : '';?>">
				<button id="btnadd" name="btnadd" type="button" class="btn btn-primary btn-primary-small" onclick="<?php echo 'location.href=\'' . $this->config->item('uri_files_doc_form') . $id . '/\'';?>">Add New Document</button>
			<span>
		</div>
		<?php if ($record_count >0): ?>
		<div id="doc-content" class="box-body">
		  <table id="example1" class="table table-bordered table-striped">
			<thead>
			<?php
			echo '<tr>' .
				'<th>'. $this->lang->line('fd_id') . '</th>' .
				'<th>'. $this->lang->line('fd_name') . '</th>' .
				'<th>'. $this->lang->line('fd_doc_date') . '</th>' .
				'<th>'. $this->lang->line('fd_process_date') . '</th>' .
				'<th>'. $this->lang->line('fd_pic') . '</th>' .
				'<th>'. '#' . '</th>' .
				'</tr>';
			?>
			</thead>
			<tbody>
			<?php
			foreach ($record as $r) { 
				echo '<tr id="tr_'. $r['id'] .'">' .
					'<td>'. $r['id'] .'</td>' .
					'<td>'. $r['name'] .'</td>' .
					'<td>'. $r['doc_date'] .'</td>' .
					'<td>'. $r['process_date'] .'</td>' .
					'<td>'. $r['pic'] .'</td>' .
					'<td>'. 
						'<a href="'. $this->config->item('uri_files_doc_form') . $r['fileid'] .'/' . $r['id'] . '/">' . $this->config->item('ico_edit') .'</a>' . 
						'<a name="del_'. $r['id'] .'" class="hand" data-target="#modal-del" data-id="'. $r['fileid'] .'::'. $r['id'] .'">' . $this->config->item('ico_del') .'</a>' .
						'</td>' .
					'</tr>' ;
			}
			?>
			</tbody>
			<tfoot>
			<?php
			echo '<tr>' .
				'<th>'. $this->lang->line('fd_id') . '</th>' .
				'<th>'. $this->lang->line('fd_name') . '</th>' .
				'<th>'. $this->lang->line('fd_doc_date') . '</th>' .
				'<th>'. $this->lang->line('fd_process_date') . '</th>' .
				'<th>'. $this->lang->line('fd_pic') . '</th>' .
				'<th>'. '#' . '</th>' .
				'</tr>' ;
			?>
			</tfoot>
		  </table>
		</div> <!-- /.box-body -->
		<?php endif; ?>
	</div>
</div>
</div>

<script type="text/javascript">
$(function () {
	$('#date').datepicker({format: 'yyyy-mm-dd', autoclose: true});
    $(".select2").select2();
	$("#year").select2({allowClear: true});
	$("#location").select2({tags: true,	selectOnBlur: true, allowClear: true});
	$("#category").select2({tags: true,	selectOnBlur: true, allowClear: true});
	$("#volume").select2({tags: true,	selectOnBlur: true, allowClear: true});

	$("a[name*='del_']").click(function(){
		//uId = JSON.stringify($(this).data('id'));
		uId = $(this).data('id');
		$("#btnDel").attr('data-id', uId);
		$("#modal-del").modal(function(){
			$(this).show();
		});
	});
	$("#btnDel").click(function(){
		aId = uId.split("::");
		sType = aId[0]; nId = aId[1];
		$("#modal-del").modal('hide');
		$.ajax({
			url: "<?php echo $this->config->item('uri_files_del'); ?>", 
			type: "POST", 
			dataType: "html", 
			data: "id=" + uId + "",
			success: function(uReturn){
				//$('#tr\\@' + $("#hiduser").val()).remove();
				var oRet = jQuery.parseJSON(uReturn);
				if(oRet.state === 1){
					$('#tr_' + nId).css("background-color","#FF9999");
					$('#tr_' + nId).css("color","#FFF");
					$('#tr_' + nId).fadeOut(1500);
				}
			}
		});

	});

});
</script>
