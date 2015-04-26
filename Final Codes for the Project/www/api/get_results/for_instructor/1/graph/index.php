<?php

include_once $_SERVER['DOCUMENT_ROOT']."/consql3.php";

//GRAPH:PER INSTRUCTOR AVERAGE OF VARIOUS CLASSES FOR TESTS IN HIS COURSE

$ssn=$in_id;
$course=$_GET['course'];
$class=$_GET['class'];
$sql ="select t.class_id,t.course_id, date,c_name, t.test_id as test_id,AVG(r.score) as score,i.i_id from result r,instructor i, course, test t where i.i_id='".$ssn."'
and i.i_id=t.i_id and t.course_id='".$course."' and t.class_id='".$class."' and t.test_id=r.test_id  group by r.test_id";
$result = mysqli_query($conn,$sql);

$json_testid= array();
$json_avgscore=array();

if($result === FALSE){
    echo 'failed';
}

while($row=mysqli_fetch_array($result)){
$row_1['label']= $row['date'];
$row_2['value']=$row['score'];
$course_name=$row['c_name'];
array_push($json_testid,$row_1);
array_push($json_avgscore,$row_2);
}
?>
<html>
<head>
<script type="text/javascript" src="/fusioncharts/js/fusioncharts.js"></script>
<script src="/script/jquery-1.11.2.min.js"></script>
<script type="text/javascript" >

    i=<?php echo json_encode($json_avgscore); ?>;
    usn_js=<?php echo json_encode($ssn); ?>;
    class_js=<?php echo json_encode($class); ?>;
    course_js=<?php echo json_encode($course_name); ?>;
    ssn_js=<?php echo json_encode($ssn); ?>;
    j=<?php echo json_encode($json_testid); ?>;

    caption="Result analysis for  "+course_js;
    
    FusionCharts.ready(function () {
        var chart = new FusionCharts({
            type: "mscombi3d",
            renderAt: 'chart-container',
            width: '550',
            height: '350',
            dataFormat: 'json',
            dataSource: {
    		
                "chart": {
                    "caption": caption,
                    "subCaption": "",
                    "xAxisname": "Test Date ",
                    "yAxisName": "Class Average Marks ",
                    "numberPrefix": "",
                    "showBorder": "0",
                    "showValues": "1",
                    "paletteColors": "#04B431",
                    "bgColor": "#FFFFFF",
                    "showCanvasBorder": "1",
                    "canvasBgColor": "#FFFFFF",
                    "captionFontSize": "14",
                    "subcaptionFontSize": "10",
                    "xAxisnameFontSize": "14",
                    "subcaptionFontBold": "1",
                    "divlineColor": "#FFFFFF",
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
                    "legendItemFontSize": '15',
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
                    }
                ]
            } 
        }).render();
    });

</script>
</head>
<body>
    <div id="chart-container"></div>
</body>
</html>