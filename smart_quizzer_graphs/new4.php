
<html>
<head>
<title> My Result</title>
    <?php
    //GRAPH:PER INSTRUCTOR AVERAGE OF VARIOUS CLASSES FOR TESTS IN HIS COURSE
    $host="localhost"; 
    $username="root"; 
    $password=""; 
    $db_name="smart_quizzer1";
     $con=mysqli_connect("$host", "$username", "$password","$db_name")or die("cannot connect"); 
 
    $ssn='CSEAAA'; //**************send variable here*************************
    $course='12CS351';
    $class='12CSEB';
$sql ="select t.class_id,t.course_id,t.test_id as test_id,AVG(r.score) as score,i.i_id from result r,instructor i,test t where i.i_id='".$ssn."'
and i.i_id=t.i_id and t.course_id='".$course."' and t.class_id='".$class."' and t.test_id=r.test_id  group by r.test_id";
$result = mysqli_query($con,$sql);

$json_testid= array();
$json_avgscore=array();

if($result === FALSE)
{
    echo 'failed';
}

while($row=mysqli_fetch_array($result))
{
$row_1['label']= $row['test_id'];
$row_2['value']=$row['score'];

array_push($json_testid,$row_1);
array_push($json_avgscore,$row_2);

}

?>
<script type="text/javascript" src="fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" >



i=<?php echo json_encode($json_avgscore); ?>;
usn_js=<?php echo json_encode($ssn); ?>;
class_js=<?php echo json_encode($class); ?>;
course_js=<?php echo json_encode($course); ?>;
ssn_js=<?php echo json_encode($ssn); ?>;
j=<?php echo json_encode($json_testid); ?>;

function myfun(){
//alert(i);

    caption="Result analysis for course  "+course_js+"  by Instructor "+ssn_js;
    
    FusionCharts.ready(function () {
        var chart = new FusionCharts({
            type: "mscombi3d",
            renderAt: 'chart-container',
            width: '1320',
            height: '580',
            dataFormat: 'json',
            dataSource: {
    		
                "chart": {
                    "caption": caption,
                    "subCaption": "",
                    "xAxisname": "Test ID ",
                    "yAxisName": "Class Average Marks ",
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
                        "seriesName":  "Class Average for class:"+class_js,
                        "showValues": "1",
                        "data": i
                    }/*{
                        "seriesName":  "Class Average for class:"+class_js,
                        "showValues": "1",
                        "data": k
                    }*/
                ]
            } 
        }).render();
    });

}
</script>
</head>
<body>
    <div id="chart-container">Results will load here!!! Please wait...</div>
    <input type="button" id="see" value="see result" onclick="myfun()" width="30px"/>
</body>
</html>