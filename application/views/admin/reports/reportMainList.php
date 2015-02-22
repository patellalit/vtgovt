    <div class="container top">
      <ul class="breadcrumb">
        <li class="active">
          અહેવાલો
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          અહેવાલો
        </h2>
      </div>
<?php
    $options_aanganvadi = array(0 => "select");
    foreach ($aanganvadi as $row)
    {
        $options_aanganvadi[$row['id']] = $row['aanganvadi_name'];
    }
    
    echo form_dropdown('aanganvadi_id', $options_aanganvadi, $aanganwadiid_selected, 'class="span2"  id="aanganvadi_id"');
    ?>
      <div class="row">
        <div class="span12 columns">
          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th colspan="3" class="yellow header headerSortDown">અહેવાલો નામ</th>

              </tr>
            </thead>
            <tbody>
                <?php
                    for($i=0;$i<count($reportarray);$i++)
                    {
                        
                        if($i%2==0)
                        {
                            if($i!=0)
                                echo '</tr>';
                            echo '<tr>';
                        }
                    
                        echo '<td><a onclick="if(document.getElementById(\'aanganvadi_id\').value==0){alert(\'Please select aanganwadi\');}else{document.location.href=\''.$reportarray[$i]['key'].'&aanganvadi_id=\'+document.getElementById(\'aanganvadi_id\').value;}" href="javascript:void(0)">'.$reportarray[$i]['val'].'</a></td>';
                    }
                ?>



            </tbody>
          </table>
      </div>
    </div>