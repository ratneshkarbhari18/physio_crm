<?php
   //include 'includes/session.php';
    include '../includes/db.php';
    //redirect();
    //$title = "Doctor Reports";
   /* 
function calculate($base, $other){
    $total = 0;
    global $conn;
    $t = array(json_decode($base,true)['id']);
    $b = $t[0];
    $array = json_decode($other,true);
    foreach($array as $i){
        array_push($t,$i['id']);
    }
    $first = false;
    foreach($t as $i){
        $query = "SELECT * FROM treatments WHERE id=$i";
        
        $r = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($r);
        if($b == $i)
            $a = $row["amount"];
        else
            $a = 10;
        $first = true;    
        $total+=$a;
    }
    $total += 25;
    /*$query = "SELECT MIN(id) FROM reports WHERE p_id=$pid";
    $r = mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)>0){
        $row = mysqli_fetch_array($r);
        if($id==$row[0]){
            $total +=10;
        }
    }
    return $total;
  } */
?>
<?php
$date=date("Y/m/d");
$q="SELECT * FROM reports WHERE pay_time='$date' AND paid=1";
$r=mysqli_query($conn,$q);
$gt=0;
while($row=mysqli_fetch_array($r)){
$treatments = array(json_decode($row['base_treatment'],true)['id']);
$total=25;
$q1="select * from treatments where id=".$treatments[0];
$r1=mysqli_query($conn,$q1);
$row1=mysqli_fetch_array($r1);
$total=$total+(int)$row1['amount'];
$array = json_decode($row['treatments'],true);
$treat=array();
foreach($array as $i){
    array_push($treat,$i['id']);
	$total=$total+10;
}
$p_id = $row['p_id'];
$query = "SELECT COUNT(id) FROM reports WHERE p_id=$p_id";
$res = mysqli_query($conn,$query);
$row2 = mysqli_fetch_array($res);
//var_dump();
if($row2['COUNT(id)']==1){
	$total = $total +10;
}
//var_dump($treat);
$gt=$gt+$total;
}
echo $gt;
?>