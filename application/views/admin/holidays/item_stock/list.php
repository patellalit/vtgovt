    <div class="container top">
      <ul class="breadcrumb">
        <li class="active">
          જથ્થો નોંધણી
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          જથ્થો
		  <?php
		  	if($this->session->userdata('is_admin')==true)
			{
		  ?>
          		<a  href="<?php echo site_url("").$this->uri->segment(1); ?>/add" class="btn btn-success">નવી જથ્થો ઉમેરો</a>
			<?php
			}
			?>
        </h2>
      </div>
      
      <div class="row">
        <div class="span12 columns">
          <div class="well">
           
            <?php
           
            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform','method'=>'GET');
            echo form_open('item_stock', $attributes);
              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'શોધ કરવી');
                
                $montharray = array('0'=>'પસંદ કરો','1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'Septmber','10'=>'October','11'=>'November','12'=>'December');
                echo form_dropdown('month',$montharray,$month,'','class="span2" id="month"');
                ?>
&nbsp;&nbsp;
<?php
                $yeararray = array('0'=>'પસંદ કરો');
                for($i=0;$i<=10;$i++)
                {
                    $yeararray[date('Y')-$i] = date('Y')-$i;
                }
                echo form_dropdown('year',$yeararray,$year,'class="span2" id="year"');
		  ?>
			  &nbsp;&nbsp;<input type="text" id="search" name="search" value="<?php echo $search ?>" />
				<input type="hidden" id="perpage" name="perpage" value="<?php echo $perpage ?>" />
			  <input type="hidden" id="currentpage" name="currentpage" value="<?php echo $currentpage ?>" />
			  <?php
              echo form_submit($data_submit);
            echo form_close();
            ?>

          </div>

          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">ક્રમ નંબર</th>
				<th class="yellow header headerSortDown">આંગણવાડી નામ</th>
                <th class="yellow header headerSortDown">વસ્તુ નામ</th>
				<th class="yellow header headerSortDown">જથ્થો (IN) ( KG )</th>
				<th class="yellow header headerSortDown">જથ્થો (OUT) ( KG )</th>
				<th class="yellow header headerSortDown">કુલ જથ્થો ( KG )</th>
               <!--  <th class="red header">&nbsp;</th> -->
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($item as $row)
              {
				$total_in=($row['total_in'] > 0) ? ($row['total_in']/1000) : 0;
				$total_out=($row['total_out'] > 0) ? ($row['total_out']/1000) : 0;
				//$total=($row['total_stock'] > 0) ? ($row['total_stock']/1000) : 0;
                  $total = $total_in-$total_out;
                echo '<tr>';
                echo '<td>'.$row['autoid'].'</td>';
				echo '<td>'.$row['aanganvadi_name'].'</td>';
                echo '<td>'.$row['item_name'].'</td>';
				echo '<td>'.$total_in.'</td>';
				echo '<td>'.$total_out.'</td>';				
				echo '<td>'.$total.'</td>';
                echo '</tr>';
              }
              ?>      
            </tbody>
          </table>
			
          <?php echo '<div class="pagination"><div class="pagingLeft"><select style="width:100px" id="rowsperpage" name="rowsperpage" onchange="changePaging()"><option value="20">20</option><option value="50">50</option><option value="75">75</option><option value="100">100</option></select></div><div class="pagingCenter"><input type"text" id="gotopage" name="gotopage" value="'.$currentpage.'" style="width:100px" onKeyPress="return changePage(event,this);" /></div><div class="pagingRight">'.$this->pagination->create_links().'</div><div style="clear:both"></div></div>'; ?>

      </div>
    </div>
	<script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript">
		var $ = jQuery.noConflict();
		$(document).ready(function(){

			$('#rowsperpage').val('<?php echo $perpage ?>');
		}
		);
		function changePage(e,textbox)
		{
			var code = (e.keyCode ? e.keyCode : e.which);
			if(code == 13 && document.getElementById('gotopage').value!='') { //Enter keycode
			 	//document.location.href='<?php echo base_url('jilla/page') ?>/'+document.getElementById('gotopage').value+'/'+document.getElementById('rowsperpage').value;
				$('#perpage').val($('#rowsperpage').val());
				$('#currentpage').val($('#gotopage').val());
				$("#myform").attr("action", '<?php echo base_url('item/page') ?>/'+document.getElementById('gotopage').value);
				$('#myform').submit();
			}
			else
			{
			
				if (code > 31 && (code < 48 || code > 57)) {
				
                    return false;
                }
                return true;
			}
		}
		function changePaging()
		{
			//document.location.href='<?php echo base_url('jilla/page/'.$currentpage) ?>/'+document.getElementById('rowsperpage').value;			
			$('#perpage').val($('#rowsperpage').val());
					$('#currentpage').val($('#gotopage').val());
					$("#myform").attr("action", '<?php echo base_url('item/page') ?>/'+document.getElementById('gotopage').value);
					$('#myform').submit();
		}
		
	</script>
