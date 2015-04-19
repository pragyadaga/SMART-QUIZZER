
<html>
<head>
<title> My Result</title>
    <?php
    //Graph:marks vs class average
    $host="localhost"; 
    $username="root"; 
    $password=""; 
    $db_name="smart_quizzer1";
    $con=mysqli_connect("$host", "$username", "$password","$db_name")or die("cannot connect"); 
   // mysql_select_db("$db_name")or die("cannot select DB");

    $usn='1PI12CS102'; //**************send variable here*************************
    $sql = "select test_id from result where USN= '".$usn. " '"; 
    $result = mysqli_query($con,$sql);

    $json_response = array();


    while($row=mysqli_fetch_array($result))
    {
        $row_array['label']= $row['test_id'];

        array_push($json_response,$row_array);
    }


   
    $sql2 = "select score from result where USN= '".$usn. " '";
    $result2 = mysqli_query($con,$sql2);
    $json=array();

    while($rowi=mysqli_fetch_array($result2))
    {
        $row_array2['value']= $rowi['score'];

        array_push($json,$row_array2);
    }

    $sql3="select t.class_id,t.test_id,AVG(r.score) as class_average from test t,class c,result r where c.class_id=t.class_id and t.test_id=r.test_id group by t.test_id";
    $result3 = mysqli_query($con,$sql3);
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
<script type="text/javascript" src="fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" >



i=<?php echo json_encode($json); ?>;//score from result table
usn_js=<?php echo json_encode($usn); ?>;//usn from result table
testid=<?php echo json_encode($json_response); ?>;//testid from result table
j=<?php echo json_encode($json1); ?>;//class average from result table
function myfun(){
//alert(i);

    caption="Per Student Result Analysis for USN:"+usn_js;
    
    FusionCharts.ready(function () {
        var AnlysisChart = new FusionCharts({
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
                    "paletteColors": "#3A01DF,#FF0000,#f2c500",
                    "bgColor": "",
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

}
</script>
</head>
<body>
    <div id="chart-container">Results will load here!!! Please wait...</div>
    <input type="button" id="see" value="see result" onclick="myfun()" width="20px"/>
</body>
</html>