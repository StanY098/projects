<!DOCTYPE html>
<html>
    <head>
        <title>Sample of Google Spreadsheet Transfer</title>
        <link rel="stylesheet" href="main.css" />
    </head>
    <body>
        <header><h1>Sample of Google Spreadsheet Data Transfer</h1></header>
        <?php
            class GData {
            # method to get spreadsheet data
               public static function getSpreadsheetData($url, $rowFormatArr) {
                  $content = file_get_contents($url);
                  $contentArr = json_decode($content, true);
                  $rows = array();
                  $rowItems = array();
                  $index = 0;
                  foreach($contentArr['feed']['entry'] as $row) {
                     if ($row['title']['$t'] == '-') {
                        continue;
                     }
                     $string = "";
                     foreach($rowFormatArr as $item) {
                        //$rowItems[$item] = self::getRowValue($row['content']['$t'], $rowFormatArr, $item);
                        $count = 0;
                        foreach($row['content'] as $element){
                            $count++;
                            if($count == 2){
                                    //split strings into array by ,, _ and space
                                    $string = preg_split("/[\s,]+/", $element);
                                    if (!$string){
                                            echo "false";
                                    }
                                    else {
                                            $strings = array();
                                            $ii = 0;
                                            foreach($string as $s){
                                                    if(!preg_match("/^_/",$s)){
                                                            $strings[$ii] = $s;
                                                            $ii++;
                                                    }
                                            }
                                            $rowItems[$index] = $strings;
                                            $index++;
                                    }
                            }
                        }
                     }
                  }
                  return $rowItems;
               }
               #get row values
               static function getRowValue($row, $rowFormatArr, $column_name) {
                  if (empty($column_name)) {
                     throw new Exception('column_name must not empty');
                  }
                  $begin = strpos($row, $column_name);
            
                  if ($begin == -1) {
                     return '';
                  }
                  $begin = $begin + strlen($column_name) + 1;
            
                  $end = -1;
                  $found_begin = false;
            	        foreach($rowFormatArr as $entity) {
                     if ($found_begin && strpos($row, $entity) != -1) {
                        $end = strpos($row, $entity) - 2;
                        break;
                     }
                     if ($entity == $column_name) {
                        $found_begin = true;
                     }
                     #check if last element
                     if (substr($row, strlen($row) - 1) == $column_name) {
                        $end = strlen($row);
                     } else {
                        if ($end == -1) {
                           $end = strlen($row);
                        } else {
                           $end = $end + 2;
                        }
                     }
                  }
                  $value = substr($row, $begin, $end - $begin);
                  $value = trim($value);
                  return $value;
               }
            }
            #JSON Representation
            $url = 'https://spreadsheets.google.com/feeds/list/1Jxcv21pqfbgKzncj8ziGWW2WxSuL-pXmZqANON-DA10/od6/public/values?alt=json';
            $formatArr = array('row');
            #use $rows array to get spreadsheet data
            $rows = GData::getSpreadsheetData($url, $formatArr);
            //print_r($rows);
            $count = 0;
            $count_array = 0;
            foreach ($rows as $r){
                if($count < 2 || $count >= sizeof($rows)-3){
                    $count++;
                    continue;
                }
                $count_element = 0;
                for($i=0;$i<sizeof($r);$i++){
                    if($r[$i] == "winter2018studentworkhoursrememberdevotionalontuesday:"){
                        continue;
                    }
                    if ($r[$i] == "N/A") {
                        $array_table[$count_array][$count_element++] = " ";
                    }
                    else if($r[$i] == "Tech" || preg_match("/Jan|Feb|Mar|Apr|Jun|Jul|Aug|Sep|Oct|Nov|Dec/",$r[$i]) || preg_match('/AM|PM/',$r[$i+1])){
                        $array_table[$count_array][$count_element++] = $r[$i]." ".$r[$i+1];
                        $i++; //increment 1 here to increment 2 in total
                    }
                    else {
                        $array_table[$count_array][$count_element++] = $r[$i];
                    }
                }
                $count_array++;
                $count++;
            }
            #draw table, first part is all titles (including tile, days of week, positions, names, grad date and start and end time
        ?>
        <div id="wrapper">
            <table>
                <caption>
                    It is just a sample of data.
                </caption>
                <tbody>
                <tr>
                    <td id="title" colspan="12"><span style="font-size: small;">Spring&nbsp;2017 Student Work Hours (Remember Devotional On Tuesday)</td>
                </tr>
                <tr>
                    <td id="second_sub_title">Position</td>
                    <td id="second_sub_title">Name</td>
                    <td id="second_sub_title" colspan="2">Monday</td>
                    <td id="second_sub_title" colspan="2">Tuesday</td>
                    <td id="second_sub_title" colspan="2">Wednesday</td>
                    <td id="second_sub_title" colspan="2">Thursday</td>
                    <td id="second_sub_title2" colspan="2">Friday</td>
                </tr>
                <tr>
                    <td id="third_sub_title2">&nbsp;</td>
                    <td id="third_sub_title2">Grad Date</td>
                    <td id="third_sub_title">Start</td>
                    <td id="third_sub_title2">End</td>
                    <td id="third_sub_title">Start</td>
                    <td id="third_sub_title2">End</td>
                    <td id="third_sub_title">Start</td>
                    <td id="third_sub_title2">End</td>
                    <td id="third_sub_title">Start</td>
                    <td id="third_sub_title2">End</td>
                    <td id="third_sub_title">Start</td>
                    <td id="third_sub_title">End</td>
                </tr>
            
                <?php
                    #set position color to green
                    $position = "#608c43";
                    #set devotional color to red
                    $devotional = "#cc4949";
                    #set border right
                    $border_right = "border-right: 1px solid black;";
                    #loop through the Big Array
                    for($arrayCount=0;$arrayCount<sizeof($array_table);$arrayCount++){
                        $array = $array_table[$arrayCount];
                ?>
                        <tr>
                <?php
                        for($elementCount=0;$elementCount<sizeof($array);$elementCount++){
                            if($elementCount == 0 && $arrayCount%2 == 0){
                                $background_color = "green_background";
                            }
                            else if(($arrayCount%2 == 0 && ($elementCount == 4 || $elementCount == 5)) || ($arrayCount%2 == 1 && ($elementCount == 3 || $elementCount == 4))){
                                $background_color = "red_background";
                            }
                            else if($arrayCount%4 == 0 || $arrayCount%4 == 1){
                                $background_color = "white_background";
                            }
                            else {
                                $background_color = "grey_background";
                            }
                            if($elementCount == 0 && $arrayCount%2 == 0){
                ?>
                                <td id="center" class="<?php echo $background_color ?>" rowspan="2"><?php echo $array[$elementCount] ?></td>
                <?php
                            }
                            else {
                ?>
                                <td id="center" class="<?php echo $background_color ?>"><?php echo $array[$elementCount] ?></td>
                <?php
                            }
                        }
                ?>
                        </tr>
                <?php
                    }
                    #close the whole table
                ?>
                    <tr>
                        <?php
                            $lastArray = $array_table[sizeof($array_table)-1];
                            for($lastCount = 0;$lastCount<12;$lastCount++){
                                if($lastCount == 4){
                        ?>
                                    <td id="center" class="red_background" colspan="2">DEVOTIONAL</td>
                        <?php
                                    $lastCount++;
                                }
                                else {
                        ?>
                                    <td id="center" class="white_background"></td>
                        <?php
                                }
                            }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
