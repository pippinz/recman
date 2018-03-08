      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Documents</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="filestable" class="table table-bordered table-striped">
                <thead>
				<?php
				echo '<tr>' .
					'<th>'. $this->lang->line('rd_filename') . '</th>' .
					'<th>'. $this->lang->line('rd_name') . '</th>' .
					'<th>'. $this->lang->line('rd_doc_date') . '</th>' .
					'<th>'. $this->lang->line('rd_doc_processdate') . '</th>' .
					'<th>'. $this->lang->line('rd_pic') . '</th>' .
					'<th>'. '#' . '</th>' .
					'</tr>';
				?>
                </thead>
                <tbody>
				<?php
				foreach ($record as $r) { 
					echo '<tr id="tr_'. $r['docid'] .'">' .
						'<td>'. $r['filename'] .'</td>' .
						'<td>'. $r['docname'] .'</td>' .
						'<td>'. $r['docdate'] .'</td>' .
						'<td>'. $r['docprocessdate'] .'</td>' .
						'<td>'. (array_key_exists($r['docpic'], $aPic) ? $aPic[$r['docpic']] : $r['docpic']) .'</td>' .
						'<td nowrap="nowrap">'. 
							'<a href="'. $this->config->item('uri_reports_docs') . $r['fileid'] . '/' . $r['docid'] .'/">' . $this->config->item('ico_info') .'</a>' . 
							'</td>' .
						'</tr>' ;
				}
				?>
                </tbody>
                <tfoot>
				<?php
				echo '<tr>' .
					'<th>'. $this->lang->line('rd_filename') . '</th>' .
					'<th>'. $this->lang->line('rd_name') . '</th>' .
					'<th>'. $this->lang->line('rd_doc_date') . '</th>' .
					'<th>'. $this->lang->line('rd_doc_processdate') . '</th>' .
					'<th>'. $this->lang->line('rd_pic') . '</th>' .
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