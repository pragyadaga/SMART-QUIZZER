
<html>
<head>
<title> My Result</title>
    <?php
    //grph:coursewise marks in various tests for one student
    $host="localhost"; 
    $username="root"; 
    $password=""; 
    $db_name="smart_quizzer1";
    $con=mysqli_connect("$host", "$username", "$password","$db_name")or die("cannot connect"); 
   // mysql_select_db("$db_name")or die("cannot select DB");

$usn='1PI12CS102'; //**************send variable here*************************
$course='12CS351';//**************send variable here*************************
$sql = "select t.test_id, r.score from result r,test t,takes tk,course c,student s where s.USN= '".$usn.
 "'and r.test_id=t.test_id and t.course_id='".$course."'and r.USN=tk.USN and tk.course_id=t.course_id group by r.test_id"; 
$result = mysqli_query($con,$sql);

$json_testid = array();
$json_score=array();

while($row=mysqli_fetch_array($result))
{
$row_1['label']= $row['test_id'];
$row_2['value']=$row['score'];

array_push($json_testid,$row_1);
array_push($json_score,$row_2);

}

?>

<script type="text/javascript" src="fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" >

i=<?php echo json_encode($json_score); ?>;//score from result table
usn_js=<?php echo json_encode($usn); ?>;//usn from result table
testid=<?php echo json_encode($json_testid); ?>;//testid from result table
course_js=<?php echo json_encode($course); ?>;//course name or id from table
function myfun(){
//alert(i);

    caption="Result Analysis for USN: "+usn_js+" in the course "+course_js;
    
    FusionCharts.ready(function () {
        var analysis = new FusionCharts({
            type: "mscombi3d",
            renderAt: 'chart-container',
            width: '1320',
            height: '580',
            dataFormat: 'json',
            dataSource: {
            
                "chart": {
                    "caption": caption,
                    "subCaption": "Software Engineering",
                    "xAxisname": "Test ID",
                    "yAxisName": "Marks Secured",
                    "numberPrefix": "",
                    "showBorder": "0",
                    "showValues": "1",
                    "paletteColors": "#FF0000,#1aaf5d,#f2c500",
                    "bgColor": "#FFBF00",
                    "showCanvasBorder": "1",
                    "canvasBgColor": "#FFFF00",
                    "captionFontSize": "14",
                    "subcaptionFontSize": "14",
                    "xAxisnameFontSize": "14",
                    "subcaptionFontBold": "1",
                    "divlineColor": "#999999",
                    "divLineIsDashed": "1",
                    "divLineDashLen": "1",
                    "divLineGapLen": "1",
                    "showAlternateHGridColor": "1",
                    "usePlotGradientColor": "1",
                    "toolTipColor": "#ffffff",
                    "toolTipBorderThickness": "10",
                    "toolTipBgColor": "#000000",
                    "toolTipBgAlpha": "80",
                    "toolTipBorderRadius": "2",
                    "toolTipPadding": "5",
                    "legendBgColor": "#ffffff",
                    "legendBorderAlpha": '1',
                    "legendShadow": '1',
                    "legendItemFontSize": '25',
                    "legendItemFontColor": '#666666'
                },
                "categories":
                [
                    {  
                        "category": testid
                    }
                ]
,
                "dataset":
                [
                    {
                        "seriesName": "My marks in Course:",
                        "showValues": "1",
                        "data": i//json of value:score
                    }
                ]
            } 
        }).render();
    });

}
</script>
</head>
<body>
    <div id="chart-container">Results will load here!!! Please wait...</div>
    <input type="button" id="see" value="see result" onclick="myfun()" width="20px"/>
</body>
</html>