<html>
    <head>
        <meta charset="utf-8">
        <title>Vatslya Kutumb Report</title>
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
        <script >
            window.onload=callprint;
            function callprint()
            {
                //alert("hihello");
                window.print();
            }
        </script>
    </head>
    <body id="non-printable">
        <?php
            //print_r($castArray);
            $laghu = array('-','હા','ના');
            $rehvasi = array('ના','હા');
        ?>
        <div id="printable" style="width:800px;margin:0 auto;">
        <table style="width:100%;">
            <tr>
                <td class="noborder"><h1>કુટુંબ વિગત</h1></td>
                <td class="noborder">&nbsp;</td>
            </tr>
            <tr>
                <td class="noborder"><h2>કુટુંબનો ક્રમ નંબર : <?php echo $kutumbDetail[0]['family_rank'] ?></h2></td>
                <td class="noborder"><h2>જાતિ :<?php echo $castArray[$kutumbDetail[0]['jati_id']-1]['name_guj']; ?></h2></td>
            </tr>
            <tr>
                <td class="noborder"><h2>સ્થળ : <?php echo $placeArray[$kutumbDetail[0]['sthal_id']-1]['name_guj'] ?></h2></td>
                <td class="noborder"><h2>ધર્મ :<?php echo $religionArray[$kutumbDetail[0]['dharm_id']-1]['name_guj'] ?></h2></td>
            </tr>
        </table>
        <table style="width:100%;">
            <tr>
                <td style="width:10%"><h3>કુટુંબમાં વ્યક્તિનો ક્રમ નંબર</h3></td>
                <td style="width:20%"><h3>યુ.આઈ.ડી. / આધાર નંબર</h3></td>
                <td style="width:30%"><h3>કુટુંબના સભ્યોના નામ</h3></td>
                <td style="width:10%"><h3>કુટુંબના વડા સાથેનો સબંધ</h3></td>
                <td style="width:10%"><h3>જાતિ (પુરૂષ/સ્ત્રી)</h3></td>
                <td style="width:10%"><h3>હાલનો વૈવાહિક દરજ્જો</h3></td>
                <td style="width:10%">
                    <table>
                        <tr><td class="noborder" colspan="3"><h3>જન્મ તારીખ</h3></td></tr>
                        <tr><td>દિવસ</td><td>મહિનો</td><td>વર્ષ</td></tr>
                    </table>
                </td>
            </tr>
            <?php
                for($i=0;$i<count($kutumbDetail[0]['persondata']);$i++)
                {
                    ?>
                    <tr>
                        <td style="width:10%"><?php echo $kutumbDetail[0]['persondata'][$i]['person_rank'] ?></td>
                        <td style="width:20%"><?php echo $kutumbDetail[0]['persondata'][$i]['uid_aadharnumber'] ?></td>
                        <td style="width:30%"><?php echo $kutumbDetail[0]['persondata'][$i]['first_name'].' '.$kutumbDetail[0]['persondata'][$i]['middle_name'].' '.$kutumbDetail[0]['persondata'][$i]['last_name'] ?></td>
                        <td style="width:10%"><?php echo $relationArray[$kutumbDetail[0]['persondata'][$i]['relation_with_main_person']-1]['name_guj'] ?></td>
                        <td style="width:10%"><?php echo $genderArray[$kutumbDetail[0]['persondata'][$i]['gender']-1]['name_guj'] ?></td>
                        <td style="width:10%"><?php echo $maritalStatusArray[$kutumbDetail[0]['persondata'][$i]['merridial_status']-1]['name_guj'] ?></td>
                        <td style="width:10%">
                            <table style="width:100%">
                                <tr>
                                    <td class="noborder"><?php echo date('d',strtotime($kutumbDetail[0]['persondata'][$i]['birth_date'])); ?>/</td>
                                    <td class="noborder"><?php echo date('m',strtotime($kutumbDetail[0]['persondata'][$i]['birth_date'])); ?>/</td>
                                    <td class="noborder"><?php echo date('Y',strtotime($kutumbDetail[0]['persondata'][$i]['birth_date'])); ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </table>
        <div style="padding:50px;width:100%;">&nbsp;</div>
        <table style="width:100%;">
            <tr>
                <?php if($kutumbDetail[0]['laghumati']==1) { ?>
                    <td class="noborder"><h2>રાજ્યમાં લઘુમતી છે : <img width="25" height="25" src="<?php echo site_url() ?>assets/img/admin/chk.png"> હા &nbsp;<img width="25" height="25" src="<?php echo site_url() ?>assets/img/admin/unchk.png" /> ના</h2></td>
                <?php } else { ?>
                    <td class="noborder"><h2>રાજ્યમાં લઘુમતી છે : <img width="25" height="25"  src="<?php echo site_url() ?>assets/img/admin/unchk.png"> હા &nbsp;<img width="25" height="25" src="<?php echo site_url() ?>assets/img/admin/chk.png" /> ના</h2></td>
                <?php } ?>
            </tr>
        </table>
        <table style="width:100%;">
            <tr>
                <td style="width:10%">
                    <table>
                        <tr><td class="noborder" colspan="2"><h3>એપ્રિલમાં થતી ઉમર</h3></td></tr>
                        <tr><td class="noborder"><table style="width:100%;"><tr><td class="noborder"  style="width:50%">વર્ષ</td><td class="noborder" >મહિના</td></tr></table></tr>
                    </table>
                </td>
                <td style="width:20%"><h3>માતાનું નામ (0-6 વર્ષના બાળકો માટે)</h3></td>
                <td style="width:10%"><h3>લક્ષ્યાંક કોડ</h3></td>
                <td style="width:10%"><h3>ખોડખાંપણ નો પ્રકાર જો હોય તો</h3></td>
                <td style="width:10%"><h3>આંગણવાડી કેન્દ્ર વિસ્તારના રહેવાસી છે?</h3></td>
                <td style="width:10%"><h3>ગામમાં સ્થળાંતર કરીને આવેલ તારીખ</h3></td>
                <td style="width:10%"><h3>ગામમાંથી બહાર સ્થળાંતર કરેલ તારીખ</h3></td>
                <td style="width:10%"><h3>મરણ તારીખ</h3></td>
                <td style="width:10%">
                    <table>
                        <tr><td class="noborder" colspan="2"><h3>આંગણવાડીની નીચેની સેવાઓ પ્રાપ્ત કરવાની ઈચ્છા ધરાવે છે?</h3></td></tr>
                        <tr><td class="noborder">પૂરક આહાર</td><td class="noborder">પૂર્વ પ્રાથમિક શિક્ષણ</td></tr>
                    </table>
                </td>
            </tr>
            <?php
                for($i=0;$i<count($kutumbDetail[0]['persondata']);$i++)
                {
                    if($kutumbDetail[0]['persondata'][$i]['gam_shift_date'] == '0000-00-00 00:00:00' || $kutumbDetail[0]['persondata'][$i]['gam_shift_date'] == '')
                        $kutumbDetail[0]['persondata'][$i]['gam_shift_date']='-';
                    else
                        $kutumbDetail[0]['persondata'][$i]['gam_shift_date'] = date('d-m-Y',strtotime($kutumbDetail[0]['persondata'][$i]['gam_shift_date']));
                    
                    if($kutumbDetail[0]['persondata'][$i]['gam_out_shift_date'] == '0000-00-00 00:00:00' || $kutumbDetail[0]['persondata'][$i]['gam_out_shift_date'] == '')
                        $kutumbDetail[0]['persondata'][$i]['gam_out_shift_date']='-';
                    else
                        $kutumbDetail[0]['persondata'][$i]['gam_out_shift_date'] = date('d-m-Y',strtotime($kutumbDetail[0]['persondata'][$i]['gam_out_shift_date']));
                    
                    if($kutumbDetail[0]['persondata'][$i]['die_date'] == '0000-00-00 00:00:00' || $kutumbDetail[0]['persondata'][$i]['die_date'] == '')
                        $kutumbDetail[0]['persondata'][$i]['die_date']='-';
                    else
                        $kutumbDetail[0]['persondata'][$i]['die_date'] = date('d-m-Y',strtotime($kutumbDetail[0]['persondata'][$i]['die_date']));
                    ?>
                    <tr>
                        <td style="width:10%">
                            <table style="width:100%;">
                                <tr>
                                    <td class="noborder"  style="width:50%"><?php echo $kutumbDetail[0]['persondata'][$i]['ageIn_year'] ?>&nbsp;</td>
                                    <td class="noborder" ><?php echo $kutumbDetail[0]['persondata'][$i]['ageIn_month'] ?>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:20%"><?php echo $kutumbDetail[0]['persondata'][$i]['mother_name'] ?>&nbsp;</td>
                        <td style="width:10%"><?php echo $targetCodeArray[$kutumbDetail[0]['persondata'][$i]['lakshyank_code']-1]['name_guj'] ?>&nbsp;</td>
                        <td style="width:10%"><?php echo $malformationTypeArray[$kutumbDetail[0]['persondata'][$i]['khodkhapan_type']-1]['name_guj'] ?>&nbsp;</td>
                        <td style="width:10%"><?php echo $rehvasi[$kutumbDetail[0]['persondata'][$i]['anganwadi_kendra_vistar_rehvasi']] ?>&nbsp;</td>
                        <td style="width:10%"><?php echo $kutumbDetail[0]['persondata'][$i]['gam_shift_date'] ?>&nbsp;</td>
                        <td style="width:10%"><?php echo $kutumbDetail[0]['persondata'][$i]['gam_out_shift_date'] ?>&nbsp;</td>
                        <td style="width:10%"><?php echo $kutumbDetail[0]['persondata'][$i]['die_date'] ?>&nbsp;</td>
                        <td style="width:10%">
                            <table style="width:100%;">
                                <tr>
                                    <td class="noborder"><?php echo $rehvasi[$kutumbDetail[0]['persondata'][$i]['purak_aahar']]; ?></td>
                                    <td class="noborder"><?php echo $rehvasi[$kutumbDetail[0]['persondata'][$i]['purv_prathmik_shikshan']]; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </table>
    </body>
</html>
<?php //echo "<pre>"; print_r($kutumbDetail); echo "<pre>"; ?>