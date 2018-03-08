<?php
if ($isrecord):
?>
<!-- .row -->
<div class="row">
	<!-- left column -->
	<div class="col-md-6">
		<div class="box-body">
			<?php
			echo $this->app_html->tblrec('rf_name', $name);
			echo $this->app_html->tblrec('rf_date', $date);
			echo $this->app_html->tblrec('rf_year', $year);
			echo $this->app_html->tblrec('rf_location', $location);
			?>
		</div>
	</div>
	<!--/.col (left) -->

	<!-- right column -->
	<div class="col-md-6">
		<div class="box-body">
			<?php
			echo $this->app_html->tblrec('rf_category', array_key_exists($category, $aCategory) ? $aCategory[$category] : $category);
			echo $this->app_html->tblrec('rf_volume',  array_key_exists($volume, $aVolume) ? $aVolume[$volume] : $volume);
			echo $this->app_html->tblrec('rf_desc', nl2br($desc));
			?>
		</div>
	</div>
	<!--/.col (right) -->
</div>
<!-- /.row -->

<!-- documents -->
<div class="row">
<div class="col-xs-12">
	<div class="box box-black-topborder">
		<div class="box-header">
			<h3 class="box-title">File Documents</h3>
		</div>
		<?php if ($doc['record_count'] > 0): ?>
		<div id="doc-content" class="box-body">
		  <table id="example1" class="table table-bordered table-striped">
			<thead>
			<?php
			echo '<tr>' .
				'<th>'. $this->lang->line('rd_id') . '</th>' .
				'<th>'. $this->lang->line('rd_name') . '</th>' .
				'<th>'. $this->lang->line('rd_date') . '</th>' .
				'<th>'. $this->lang->line('rd_process_date') . '</th>' .
				'<th>'. $this->lang->line('rd_pic') . '</th>' .
				'<th>'. '#' . '</th>' .
				'</tr>';
			?>
			</thead>
			<tbody>
			<?php
			foreach ($doc['record'] as $r) { 
				echo '<tr id="tr_'. $r['id'] .'">' .
					'<td>'. $r['id'] .'</td>' .
					'<td>'. $r['name'] .'</td>' .
					'<td>'. $r['doc_date'] .'</td>' .
					'<td>'. $r['process_date'] .'</td>' .
					'<td>'. $r['pic'] .'</td>' .
					'<td>'. 
						'<a href="'. $this->config->item('uri_reports_docs') . $r['fileid'] .'/' . $r['id'] . '/">' . $this->config->item('ico_info') .'</a>' . 
						'</td>' .
					'</tr>' ;
			}
			?>
			</tbody>
		  </table>
		</div> <!-- /.box-body -->
		<?php endif; ?>
	</div>
</div>
</div>


<?php
else:
echo $this->lang->line('data_not_found');
endif;
?>
<style type="text/css">
.form-group{float:left;width:100%;}
.form-group label{font-weight:normal;background-color:#eee;border:1px dotted #666;}
</style>