	<?php $this->load->view('modal-danger'); ?>
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Files</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
				<?php
				echo '<tr>' .
					'<th>'. $this->lang->line('fi_id') . '</th>' .
					'<th>'. $this->lang->line('fi_name') . '</th>' .
					'<th>'. $this->lang->line('fi_date') . '</th>' .
					'<th>'. $this->lang->line('fi_year') . '</th>' .
					'<th>'. $this->lang->line('fi_location') . '</th>' .
					'<th>'. $this->lang->line('fi_category') . '</th>' .
					'<th>'. $this->lang->line('fi_volume') . '</th>' .
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
						'<td>'. $r['date'] .'</td>' .
						'<td>'. $r['year'] .'</td>' .
						'<td>'. (array_key_exists($r['location'], $aLocation) ? $aLocation[$r['location']] : $r['location']) .'</td>' .
						'<td>'. (array_key_exists($r['category'], $aCategory) ? $aCategory[$r['category']] : $r['category']) .'</td>' .
						'<td>'. (array_key_exists($r['volume'], $aVolume) ? $aVolume[$r['volume']] : $r['volume']) .'</td>' .
						'<td nowrap="nowrap">'. 
							'<a href="'. $this->config->item('uri_files_form') . $r['id'] .'/">' . $this->config->item('ico_edit') .'</a>' . 
							'<a name="del_'. $r['id'] .'" class="hand" data-target="#modal-del" data-id="'. $r['id'] .'">' . $this->config->item('ico_del') .'</a>' .
							'</td>' .
						'</tr>' ;
				}
				?>
                </tbody>
                <tfoot>
				<?php
				echo '<tr>'
					. '<th>'. $this->lang->line('fi_id') . '</th>'
					. '<th>'. $this->lang->line('fi_name') . '</th>'
					. '<th>'. $this->lang->line('fi_date') . '</th>'
					. '<th>'. $this->lang->line('fi_year') . '</th>'
					. '<th>'. $this->lang->line('fi_location') . '</th>'
					. '<th>'. $this->lang->line('fi_category') . '</th>'
					. '<th>'. $this->lang->line('fi_volume') . '</th>'
					. '<th>'. '#' . '</th>'
					. '</tr>';
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
    $("#example1").DataTable();
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
			url: "<?php echo $this->config->item('uri_files_del'); ?>", 
			type: "POST", 
			dataType: "html", 
			data: "id=" + nId + "",
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