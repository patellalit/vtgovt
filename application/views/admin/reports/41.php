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
            <h1>વિભાગ ૧-અ: પૂર્વ પ્રાથમિક શિક્ષણ ની વિગત 3 થી 4 વર્ષ ની બધી કન્યાઓ માટે </h1>
            રેપોર્ત મહિનો/વર્ષ <?php echo date('m').'/'.date('Y') ?>
            <table style="width:100%;border:none">
                <tr>
                    <?php
                        for($i=1;$i<=9;$i++)
                        {
                            echo '<td>'.$i.'</td>';
                        }
                    ?>
                </tr>
                <tr>
                    <td style="width:5%">ક્રમ નંબર </td>
                    <td style="width:5%">કુટુંબનો ક્રમ નંબર </td>
                    <td style="width:10%">કુટુંબમાં વ્યક્તિનો ક્રમ નંબર </td>

                    <td style="width:25%">નામ </td>
                    <td style="width:10%">ઉમર </td>
                    <td style="width:10%">જાતી</td>

                    <td style="width:10%">રાજ્યમાં લઘુમતી છે <br>( હા / ના )</td>
                    <td style="width:10%">વિકલાંગ <br>( હા / ના )</td>
                    <td style="width:15%">સમગ્ર માસ દરમ્યાન પૂર્વ પ્રાથમિક શિક્ષણમાં હાજર કુલ દિવસ ની સંખ્યા </td>
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
            <table style="width:100%">
                <tr>
                    <td>
                        <table style="width:100%">
                            <tr><td height="29.5">&nbsp;</td></tr>
                            <tr><td height="88.5">કન્યાઓ</td></tr>
                        </table>
                    </td>
                    <td>
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
                <td>
                    <table style="width:100%">
                        <tr><td height="88.5">કુમારો</td></tr>
                    </table>
                </td>
                <td>
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
            <td>
                <table style="width:100%">
                    <tr><td height="88.5">બધા બાળકો </td></tr>
                </table>
            </td>
            <td>
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
                <td>
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
            <td>
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
            <td>
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
