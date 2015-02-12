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
                            echo '--------- <tr>';
                        }
                    
                        echo '<td><a href="'.$reportarray[$i]['key'].'">'.$reportarray[$i]['val'].'</a></td>';
                        
                        if($i%2==0)
                        {
                            echo '</tr>';
                        }
                    }
                ?>



            </tbody>
          </table>
      </div>
    </div>