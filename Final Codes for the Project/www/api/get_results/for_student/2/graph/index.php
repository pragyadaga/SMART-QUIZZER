
<html>
<head>
<title> My Result</title>
<?php
    //grph:coursewise marks in various tests for one student

include_once $_SERVER['DOCUMENT_ROOT']."/consql3.php";

$usn=$st_id; //**************send variable here*************************
$course=$_GET['course'];//**************send variable here*************************
$sql = "select t.date, t.test_id, r.score from result r,test t,takes tk,course c,student s where r.USN= '".$usn.
 "'and r.test_id=t.test_id and t.course_id='".$course."'and r.USN=tk.USN and tk.course_id=t.course_id group by r.test_id"; 
$result = mysqli_query($conn,$sql);

$json_testid = array();
$json_score=array();

while($row=mysqli_fetch_array($result))
{
$row_1['label']= $row['date'];
$row_2['value']=$row['score'];

array_push($json_testid,$row_1);
array_push($json_score,$row_2);
}
?>

<script type="text/javascript" src="/fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" >

i=<?php echo json_encode($json_score); ?>;//score from result table
usn_js=<?php echo json_encode($usn); ?>;//usn from result table
testid=<?php echo json_encode($json_testid); ?>;//testid from result table
course_js=<?php echo json_encode($course); ?>;//course name or id from table

    caption="Result Analysis for USN: "+usn_js+" in the course "+course_js;
    
    FusionCharts.ready(function () {
        var analysis = new FusionCharts({
            type: "mscombi3d",
            renderAt: 'chart-container',
            width: '500',
            height: '400',
            dataFormat: 'json',
            dataSource: {
            
                "chart": {
                    "caption": caption,
                    "xAxisname": "Date",
                    "yAxisName": "Marks Secured",
                    "numberPrefix": "",
                    "showBorder": "0",
                    "showValues": "1",
                    "paletteColors": "#FF0000,#1aaf5d,#f2c500",
                    "bgColor": "#FFFFFF",
                    "showCanvasBorder": "1",
                    "canvasBgColor": "#FFFFFF",
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
</script>
</head>
<body>
    <div id="chart-container"></div>
</body>
</html>