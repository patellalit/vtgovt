<!-- <!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
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
<meta charset="utf-8">
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
            <h1>વિભાગ 4 - પૂર્વ પ્રાથમિક ગતિવિધિઓનું પત્રક</h1>
            રેપોર્ત મહિનો/વર્ષ <?php echo date('m').'/'.date('Y') ?>
            <table style="width:100%;">
                <tr>
<td style="border:none" cellspacing="0"  cellpadding="0">
                        <table style="width:100%">
                            <tr><td height="29.5">&nbsp;</td></tr>
                            <tr><td height="29.5">A</td></tr>
                            <tr><td height="<?php echo (count($activities))*29.5 ?>">&nbsp;</td></tr>
                        </table>
                    </td>
                    <td style="border:none">
                        <table style="width:100%">
                            <tr>
                                <td>તારીખ</td>
                                <?php
                                    for($i=1;$i<=11;$i++)
                                    {
                                        echo '<td>'.$i.'</td>';
                                    }
                                ?>
                            </tr>
                            <tr>
                                <td>પૂર્વ પ્રાથમિક શિક્ષણ માટે કરાવેલ પ્રવૃત્તિ નું પત્રક</td>
                                <td colspan="11"></td>
                            </tr>
                            <?php
                                for($i=0;$i<count($activities);$i++)
                                {
                            ?>
                                    <tr>
                                        <td>
                                            <?php echo $activities[$i]['name']; ?>
                                        </td>
                                        <?php
                                            for($j=1;$j<=11;$j++)
                                            {
                                                ?>
                                        <td>
                                        <?php
                                            if(!empty($activitiesservices[$j-1]))
                                            {
                                                if(in_array($activities[$i]['id'],$activitiesservices[$j-1]['activity_id']))
                                                    echo 'હા';
                                                else
                                                    echo 'ના';
                                                
                                            }
                                            else
                                            {
                                                echo 'ના';
                                            }
                                            ?>
                                        <?php
                                            }
                                        ?>
                                        </td>
                                    </tr>
                            <?php
                                }
                            ?>
                                <tr>
                                    <td>
                                        દરેક દિવસે કરાવેલ કુલ પ્રવૃત્તિ ની સંખ્યા
                                    </td>

                                    <?php
                                        for($j=1;$j<=11;$j++)
                                        {
                                    ?>
                                            <td>
                                            <?php
                                                if(!empty($activitiesservices[$j-1]))
                                                {
                                                        echo count($activitiesservices[$j-1]['activity_id']);
                                                    
                                                }
                                                else
                                                {
                                                    echo '0';
                                                }
                                                ?>
                                            </td>

                                    <?php
                                        }
                                    ?>
                                </tr>
                            </table>
                            </td>
                            </tr>
                        </table>
                    </td>
                </tr>


            </table>
            <br><br>
            <table style="width:100%">
                <tr>
                    <td>B</td>
                    <td>કોઈપણ પૂર્વ પ્રાથમિક શિક્ષણ ની પ્રવૃત્તિ કરાઈ હોય તે દિવસ ની સંખ્યા </td>
                    <td><?php echo $totalActivityDays ?></td>
                </tr>
            </table>
            <br><br>
            <table style="width:100%">
                <tr>
                    <td>B</td>
                    <td>ચાર અથવા વધારે પૂર્વ પ્રાથમિક શિક્ષણ ની પ્રવૃત્તિ કરાઈ હોય તે દિવસ ની સંખ્યા </td>
                    <td><?php echo $moreThanFourActivityDays ?></td>
                </tr>
            </table>
            <br><br>
            D. દરરોજ ની હાજર સંખ્યા
            <br><br>
            <table style="width:100%" cellspacing="0"  cellpadding="0">
                <tr>
                    <td style="border:none">
                        <table style="width:100%">
                            <tr><td height="29.5">&nbsp;</td></tr>
                            <tr><td height="88.5">કન્યાઓ</td></tr>
                        </table>
                    </td>
                    <td style="border:none">
                    <table style="width:100%">
                        <tr>
                            <td style="width:34%">તારીખ</td>
                            <?php
                                for($i=1;$i<=11;$i++)
                                {
                                    echo '<td style="width:6%">'.$i.'</td>';
                                }
                            ?>
                        </tr>
                        <tr>
                            <td style="width:34%">3-4 વર્ષ </td>
                            <?php
                                for($j=1;$j<=11;$j++)
                                {
                                    ?>

                                    <td style="width:6%"><?php echo $memberAttandence[$j-1]['girls_3_4'] ?></td>
                                    <?php
                                }
                            ?>
                        </tr>
                        <tr>
                            <td style="width:34%">4-5 વર્ષ </td>
                            <?php
                                for($j=1;$j<=11;$j++)
                                {
                                    ?>

                                    <td style="width:6%"><?php echo $memberAttandence[$j-1]['girls_4_5'] ?></td>
                            <?php
                                }
                                ?>
                        </tr>
                        <tr>
                            <td style="width:34%">5-6 વર્ષ </td>
                            <?php
                            for($j=1;$j<=11;$j++)
                            {
                                ?>

                                <td style="width:6%"><?php echo $memberAttandence[$j-1]['girls_5_6'] ?></td>
                            <?php
                            }
                            ?>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td  style="border:none">
                    <table style="width:100%">
                        <tr><td height="88.5">કુમારો</td></tr>
                    </table>
                </td>
                <td  style="border:none">
                <table style="width:100%">
                    <tr>
                        <td style="width:34%">3-4 વર્ષ </td>
                        <?php
                            for($j=1;$j<=11;$j++)
                            {
                                ?>

                        <td style="width:6%"><?php echo $memberAttandence[$j-1]['boys_3_4'] ?></td>
                        <?php
                            }
                            ?>
                    </tr>
                    <tr>
                        <td style="width:34%">4-5 વર્ષ </td>
                        <?php
                            for($j=1;$j<=11;$j++)
                            {
                                ?>

                        <td style="width:6%"><?php echo $memberAttandence[$j-1]['boys_4_5'] ?></td>
                        <?php
                            }
                            ?>
                    </tr>
                    <tr>
                        <td style="width:34%">5-6 વર્ષ </td>
                        <?php
                            for($j=1;$j<=11;$j++)
                            {
                                ?>

                        <td style="width:6%"><?php echo $memberAttandence[$j-1]['boys_5_6'] ?></td>
                        <?php
                            }
                            ?>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td  style="border:none">
                <table style="width:100%">
                    <tr><td height="88.5">બધા બાળકો </td></tr>
                </table>
            </td>
            <td  style="border:none">
                <table style="width:100%">
                    <tr>
                        <td style="width:34%">3-4 વર્ષ </td>
                        <?php
                            for($j=1;$j<=11;$j++)
                            {
                                ?>

                        <td style="width:6%"><?php echo $memberAttandence[$j-1]['all_3_4'] ?></td>
                        <?php
                            }
                            ?>
                    </tr>
                    <tr>
                        <td style="width:34%">4-5 વર્ષ </td>
                        <?php
                            for($j=1;$j<=11;$j++)
                            {
                                ?>

                        <td style="width:6%"><?php echo $memberAttandence[$j-1]['all_4_5'] ?></td>
                        <?php
                            }
                            ?>
                    </tr>
                    <tr>
                        <td style="width:34%">5-6 વર્ષ </td>
                        <?php
                            for($j=1;$j<=11;$j++)
                            {
                                ?>

                        <td style="width:6%"><?php echo $memberAttandence[$j-1]['all_5_6'] ?></td>
                        <?php
                            }
                            ?>
                    </tr>

                </table>
            </td>
        </tr>
        </table>
        <br><br>
        <table style="width:100%">
            <tr>

                    <?php
                        for($i=12;$i<=31;$i++)
                        {
                            echo '<td>'.$i.'</td>';
                        }
                    ?>
                    <td>કુલ</td>

            </tr>
            <tr>
                <td colspan="21">&nbsp;</td>
            </tr>

            <?php
                for($i=0;$i<count($activities);$i++)
                {
            ?>
                    <tr>

                    <?php
                        for($j=12;$j<=31;$j++)
                        {
                    ?>
                            <td>
                            <?php
                                if(!empty($activitiesservices[$j-1]))
                                {
                                    if(in_array($activities[$i]['id'],$activitiesservices[$j-1]['activity_id']))
                                        echo 'હા';
                                    else
                                        echo 'ના';
        
                                }
                                else
                                {
                                    echo 'ના';
                                }
                            ?>
                            </td>

                            <?php
                        }
                        ?>
                        <td><?php echo $activities[$i]['cnt'] ?></td>
                    </tr>
                <?php
            }
        ?>
        </table>
        <br><br>
        <table style="width:100%">

            <tr>
                <td  style="border:none">
                    <table style="width:100%">
                    <tr>

                    <?php
                        for($i=12;$i<=31;$i++)
                        {
                            echo '<td >'.$i.'</td>';
                        }
                        ?>
                    <td>કુલ</td>

                    </tr>
                    <tr>

                        <?php
                            for($j=12;$j<=31;$j++)
                            {
                        ?>
                            <td ><?php if(!empty($memberAttandence[$j-1])) { echo $memberAttandence[$j-1]['girls_3_4'];} else {echo '-&nbsp;';} ?></td>
                        <?php
                            }
                        ?>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <?php
                            for($j=12;$j<=31;$j++)
                            {
                        ?>
                            <td ><?php if(!empty($memberAttandence[$j-1])) { echo $memberAttandence[$j-1]['girls_4_5'];} else {echo '-&nbsp;';} ?></td>
                        <?php
                            }
                        ?>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <?php
                            for($j=12;$j<=31;$j++)
                            {
                                ?>
                            <td ><?php if(!empty($memberAttandence[$j-1])) { echo $memberAttandence[$j-1]['girls_5_6'];} else {echo '-&nbsp;';} ?></td>
                                <?php
                            }
                        ?>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td  style="border:none">
                <table style="width:100%">
                    <tr>

                        <?php
                            for($j=12;$j<=31;$j++)
                            {
                                ?>
                                <td ><?php if(!empty($memberAttandence[$j-1])) { echo $memberAttandence[$j-1]['boys_3_4'];} else {echo '-&nbsp;';} ?></td>
                            <?php
                            }
                                
                        ?>
                            <td>&nbsp; </td>
                        </tr>
                        <tr>

                            <?php
                                for($j=12;$j<=31;$j++)
                                {
                                    ?>

                                    <td ><?php if(!empty($memberAttandence[$j-1])) { echo $memberAttandence[$j-1]['boys_4_5'];} else {echo '-&nbsp;';} ?></td>
                            <?php
                                }
                                ?>
                                <td>&nbsp;</td>
                        </tr>
                        <tr>

                            <?php
                                for($j=12;$j<=31;$j++)
                                {
                                    ?>

                            <td ><?php if(!empty($memberAttandence[$j-1])) { echo $memberAttandence[$j-1]['boys_5_6'];} else {echo '-&nbsp;';} ?></td>
                            <?php
                                }
                                ?>
                            <td>&nbsp;</td>
                        </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td  style="border:none">
                <table style="width:100%">
                    <tr>
                        <?php
                            for($j=12;$j<=31;$j++)
                            {
                                ?>

                        <td ><?php if(!empty($memberAttandence[$j-1])) { echo $memberAttandence[$j-1]['all_3_4'];} else {echo '-&nbsp;';} ?></td>
                        <?php
                            }
                            ?>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <?php
                            for($j=12;$j<=31;$j++)
                            {
                                ?>

                        <td ><?php if(!empty($memberAttandence[$j-1])) { echo $memberAttandence[$j-1]['all_4_5'];} else {echo '-&nbsp;';} ?></td>
                        <?php
                            }
                            ?>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <?php
                            for($j=12;$j<=31;$j++)
                            {
                                ?>

                        <td ><?php if(!empty($memberAttandence[$j-1])) { echo $memberAttandence[$j-1]['all_5_6'];} else {echo '-&nbsp;';} ?></td>
                        <?php
                            }
                            ?>
                        <td>&nbsp;</td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

        </div>
    </body>
</html>
