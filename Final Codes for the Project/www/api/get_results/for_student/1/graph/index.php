<html>
<head>
<title> My Result</title>
<?php
//Graph:marks vs class average


include_once $_SERVER['DOCUMENT_ROOT']."/consql3.php";

$usn=$st_id; //**************send variable here*************************
$sql = "select t.date from result r, test t where r.USN= '".$usn. " ' and t.test_id=r.test_id"; 
$result = mysqli_query($conn,$sql);

$json_response = array();


while($row=mysqli_fetch_array($result))
{
    $row_array['label']= $row['date'];

    array_push($json_response,$row_array);
}

$sql2 = "select score from result where USN= '".$usn. " '";
$result2 = mysqli_query($conn,$sql2);
$json=array();

while($rowi=mysqli_fetch_array($result2))
{
    $row_array2['value']= $rowi['score'];

    array_push($json,$row_array2);
}

$sql3="select t.class_id, t.date, t.test_id,AVG(r.score) as class_average from test t,class c,result r where c.class_id=t.class_id and t.test_id=r.test_id group by t.test_id";
$result3 = mysqli_query($conn,$sql3);
$json1=array();

while($rowi=mysqli_fetch_array($result3))
{
    $row_array2['value']= $rowi['class_average'];

    array_push($json1,$row_array2);
}    

//mysql_close($db_name);
// $value_json=json_encode($json); 
//echo $value_json;
?>
<script type="text/javascript" src="/fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" >



i=<?php echo json_encode($json); ?>;//score from result table
usn_js=<?php echo json_encode($usn); ?>;//usn from result table
testid=<?php echo json_encode($json_response); ?>;//testid from result table
j=<?php echo json_encode($json1); ?>;//class average from result table


    caption="Result Analysis for USN:"+usn_js;
    
    FusionCharts.ready(function () {
        var AnlysisChart = new FusionCharts({
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
                    "paletteColors": "#3A01DF,#FF0000,#f2c500",
                    "bgColor": "",
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
                        "seriesName": "My marks",
                        "showValues": "1",
                        "renderAs":"column",
                        "data": i
                    },
                    {
                        "seriesName": "Class average ",
                        "renderAs": "column",
                        "data": j 
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