	<?php $this->load->view('modal-danger'); ?>
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
				<h3 class="box-title"><?php echo isset($sLookupTitle) ? $sLookupTitle : '';?></h3>
				<a href="<?php echo $this->config->item('uri_lookup_form') . $aLkp['lkp'];?>">
				<button id="btnsubmit" name="btnsubmit" type="submit" class="btn btn-sm btn-primary btn-warning" style="float:right !important;"><?php echo $this->lang->line('add_new')?></button>
				</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
				<?php
				echo '<tr>' .
					'<th width="1%">'. $this->lang->line('li_id') . '</th>' .
					'<th width="30%">'. $this->lang->line('li_val') . '</th>' .
					'<th width="68%">'. $this->lang->line('li_name') . '</th>' .
					'<th width="1%">'. '#' . '</th>' .
					'</tr>';
				?>
                </thead>
                <tbody>
				<?php
				foreach ($record as $r) { 
					$nRid = $r['id'];
					$uVal = $r['str'];
					echo '<tr id="tr_'. $nRid .'">' .
						'<td>'. $r['id'] .'</td>' .
						'<td>'. $uVal .'</td>' .
						'<td>'. $r['name'] .'</td>' .
						'<td nowrap="nowrap">'. 
							'<a href="'. $this->config->item('uri_lookup_form') . $sLookupCode . '/' . $r['id'] .'/">' . $this->config->item('ico_edit') .'</a>' . 
							'<a name="del_'. $r['id'] .'" class="hand" data-target="#modal-del" data-id="'. $r['id'] .'">' . $this->config->item('ico_del') .'</a>' .
							'</td>' .
						'</tr>' ;
				}
				?>
                </tbody>
                <tfoot>
				<?php
				echo '<tr>' .
					'<th>'. $this->lang->line('li_id') . '</th>' .
					'<th>'. $this->lang->line('li_val') . '</th>' .
					'<th>'. $this->lang->line('li_name') . '</th>' .
					'<th>'. '#' . '</th>' .
					'</tr>';
				?>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
<?php 
echo $htmltailattr; 
?>
<script type="text/javascript">
$(function () {
    $("#example1").DataTable({
      "ordering": false,
	});
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });

	$("a[name*='del_']").click(function(){
		//uId = JSON.stringify($(this).data('id'));
		nId = $(this).data('id');
		$("#btnDel").attr('data-id', nId);
		$("#modal-del").modal(function(){
			$(this).show();
		});
	});
	$("#btnDel").click(function(){
		$("#modal-del").modal('hide');
		$.ajax({
			url: "<?php echo $this->config->item('uri_lookup_del'); ?>", 
			type: "POST", 
			dataType: "html", 
			data: "lkp=<?php echo $sLookupCode;?>&id=" + nId + "",
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