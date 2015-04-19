<?php
$host="localhost"; 
$username="root"; 
$password=""; 
$db_name="smart_quizzer1";
    $con=mysqli_connect("$host", "$username", "$password","$db_name")or die("cannot connect"); 
  //  mysql_select_db("$db_name")or die("cannot select DB");
    $ssn='CSEAAA'; //**************send variable here*************************
    $course='12CS351';
    $class='12CSEB';
$sql ="select t.class_id,t.course_id,t.test_id as test_id,AVG(r.score) as score,i.i_id from result r,instructor i,test t where i.i_id='".$ssn."'
and i.i_id=t.i_id and t.course_id='".$course."' and t.class_id='".$class."' and t.test_id=r.test_id  group by r.test_id";
$result = mysqli_query($con,$sql);

$json_courseid= array();
$json_avgscore=array();

if($result === FALSE)
{
    echo 'failed';
}

while($row=mysqli_fetch_array($result))
{
$row_1['label']= $row['test_id'];
$row_2['value']=$row['score'];

array_push($json_courseid,$row_1);
array_push($json_avgscore,$row_2);

}

//mysql_close($db_name);
echo json_encode($json_courseid); 
echo json_encode($json_avgscore);

?>
