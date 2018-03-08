      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Files</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="filestable" class="table table-bordered table-striped">
                <thead>
				<?php
				echo '<tr>' .
					'<th>'. $this->lang->line('rf_id') . '</th>' .
					'<th>'. $this->lang->line('rf_name') . '</th>' .
					'<th>'. $this->lang->line('rf_date') . '</th>' .
					'<th>'. $this->lang->line('rf_year') . '</th>' .
					'<th>'. $this->lang->line('rf_location') . '</th>' .
					'<th>'. $this->lang->line('rf_category') . '</th>' .
					'<th>'. $this->lang->line('rf_volume') . '</th>' .
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
							'<a href="'. $this->config->item('uri_reports_files') . $r['id'] .'/">' . $this->config->item('ico_info') .'</a>' . 
							'</td>' .
						'</tr>' ;
				}
				?>
                </tbody>
                <tfoot>
				<?php
				echo '<tr>'
					. '<th>'. $this->lang->line('rf_id') . '</th>'
					. '<th>'. $this->lang->line('rf_name') . '</th>'
					. '<th>'. $this->lang->line('rf_date') . '</th>'
					. '<th>'. $this->lang->line('rf_year') . '</th>'
					. '<th>'. $this->lang->line('rf_location') . '</th>'
					. '<th>'. $this->lang->line('rf_category') . '</th>'
					. '<th>'. $this->lang->line('rf_volume') . '</th>'
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
    $("#filestable").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
});
</script>