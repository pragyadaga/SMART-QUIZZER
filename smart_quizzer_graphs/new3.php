
<html>
<head>
<title> My Result</title>
    <?php
    //GRAPH:PER STUDENT AVERAGE IN ALL SUBJECTS
    $host="localhost"; 
    $username="root"; 
    $password=""; 
    $db_name="smart_quizzer1";
    $con=mysqli_connect("$host", "$username", "$password","$db_name")or die("cannot connect"); 
  //  mysql_select_db("$db_name")or die("cannot select DB");
    $usn='1PI12CS102'; //**************send variable here*************************
$sql ="select r.USN ,t.course_id,AVG(r.score)as score from test t,result r,student s where
 s.USN='".$usn."'and s.USN=r.USN and t.test_id=r.test_id group by t.course_id";
$result = mysqli_query($con,$sql);

$json_courseid= array();
$json_avgscore=array();

if($result === FALSE)
{
    echo 'failed';
}

while($row=mysqli_fetch_array($result))
{
$row_1['label']= $row['course_id'];
$row_2['value']=$row['score'];

array_push($json_courseid,$row_1);
array_push($json_avgscore,$row_2);

}

//mysql_close($db_name);
//echo json_encode($json_courseid); 
//echo json_encode($json_avgscore);

    
    ?>
<script type="text/javascript" src="fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" >



i=<?php echo json_encode($json_avgscore); ?>;//score from result table
usn_js=<?php echo json_encode($usn); ?>;//usn from result table
j=<?php echo json_encode($json_courseid); ?>;//courseid from result table
function myfun(){
//alert(i);

    caption="Student Result Analysis of all subjects for USN:"+usn_js;
    
    FusionCharts.ready(function () {
        var courseWiseavg = new FusionCharts({
            type: "mscombi3d",
            renderAt: 'chart-container',
            width: '1320',
            height: '580',
            dataFormat: 'json',
            dataSource: {
    		
                "chart": {
                    "caption": caption,
                    "subCaption": "",
                    "xAxisname": "Course ID ",
                    "yAxisName": "Marks Secured",
                    "numberPrefix": "",
                    "showBorder": "0",
                    "showValues": "1",
                    "paletteColors": "#04B431",
                    "bgColor": "#FFFF00",
                    "showCanvasBorder": "1",
                    "canvasBgColor": "#FFBF00",
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
                        "category": j
                    }
                ]
,
                "dataset":
                [
                    {
                        "seriesName": "Average marks",
                        "showValues": "1",
                        "data": i
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