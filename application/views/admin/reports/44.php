<!-- <!DOCTYPE html>
<html lang="en-US">
<head>
<title>District Innovation Fund </title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<style type="text/css">
    body
{
    font-family: shree-guj-0768;
src: url('http://localhost/vatsalya/assets/uploads/Shree768.ttf');
}
</style>
        <div style="font-family:shree-guj-0768;">અહેવાલો નામ</div>
</body>
</html> -->
<html>
    <head>
        <title>Activities report</title>
<style type="text/css">
td {
border: 1px solid black;
    
}
table {
    border-spacing: 0;
    border-collapse: collapse;
}
.noborder{border:none;}



</style>
    </head>
    <body>
<div id="printable" style="width:800px;margin:0 auto;">
        <h1>Vibhag 4 - Purvak prathmik gatividhionu patrak</h1>
        Report mahino/varsh <?php echo date('m').'/'.date('Y') ?>
        <table style="width:100%">
            <tr>
<td>&nbsp;</td>
<td>Date</td>
<?php
    for($i=1;$i<=11;$i++)
    {
        echo '<td>'.$i.'</td>';
    }
    ?>
            </tr>
<tr>
    <td>A</td>
<td>
    purv prathmik sikshn mate karavel pravruti nu patrak
</td>
<td colspan="11"></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>
        <table style="width:100%">
            <?php
                for($i=0;$i<count($activities);$i++)
                {
                    echo "<tr><td style='border-top:0px;border-left:0px;border-right:0px;'>".$activities[0]['name']."</td></tr>";
                }
            ?>
        </table>
    </td>
</tr>
        </table>
</div>
    </body>
</html>
