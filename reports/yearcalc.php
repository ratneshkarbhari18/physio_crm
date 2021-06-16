<?php
    //include '../includes/db.php';
$d=date("Y-m-d");
	$query="select * from docsal where  YEAR(date)=YEAR('".$d."')";
	$res=mysqli_query($conn,$query);
	$saly1=0;
	$saly2=0;
	$n=mysqli_num_rows($res);
	//echo $n;
	while($r=mysqli_fetch_array($res)){
		 $payd=json_decode($r['mode'],true);
		if($payd['mode']=='cash'){
			//echo $r['amount'];
		$saly1=$saly1 + $r['amount'];
	}
	else if($payd['mode']=='cheque'){
		//echo $r['amount'];
		$saly2=$saly2 + $r['amount'];
	}	
	}
	$query1="select * from staffsal where  YEAR(date)=YEAR('".$d."')";
	$res1=mysqli_query($conn,$query1);
	while($r1=mysqli_fetch_array($res1)){
			 $payd=json_decode($r1['mode'],true);
		
		if($payd['mode']=='cash'){
			
		$saly1=$saly1 + $r1['ns'];
	}
	else if($payd['mode']=='cheque'){
		$saly2=$saly2 + $r1['ns'];
	}
	}
	$dony1=0;
	$dony2=0;
	$query2="select * from donations where  YEAR(payment_time)=YEAR('".$d."')";
	$res2=mysqli_query($conn,$query2);
	while($r2=mysqli_fetch_array($res2)){
		 $payd=json_decode($r2['payment_details'],true);
		
		if($payd['mode']=='cash'){
			
		$dony1=$dony1 + $r2['amount'];
	}
	else if($payd['mode']=='cheque'){
		$dony2=$dony2 + $r2['amount'];
	}
	}

		$totaly=0;
		$totaly1=0;
		$q="select * from reports where  YEAR(pay_time)=YEAR('".$d."')";
		$r=mysqli_query($conn,$q);
		$n=mysqli_num_rows($r);
		//echo $q;
		while($rw=mysqli_fetch_array($r)){
		$payd=json_decode($rw['payment_details'],true);
		//echo $payd['mode']."<br>";
		if($payd['mode']=='cash'){
		$t = array(json_decode($rw['base_treatment'],true)['id']);
		$b = $t[0];
		$array = json_decode($rw['treatments'],true);
		foreach($array as $i){
			array_push($t,$i['id']);
		}
		foreach($t as $i){
        $query = "SELECT * FROM treatments WHERE id=$i";
        
        $r2 = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($r2);
        if($b == $i)
            $a = $row["amount"];
        else
            $a = 10;
        $first = true;    
        $totaly+=$a;
    }
    $totaly += 25;
    
			
		}
		if($payd['mode']=='cheque'){
		$t = array(json_decode($rw['base_treatment'],true)['id']);
		$b = $t[0];
		$array = json_decode($rw['treatments'],true);
		foreach($array as $i){
			array_push($t,$i['id']);
		}
		foreach($t as $i){
        $query = "SELECT * FROM treatments WHERE id=$i";
        
        $r2 = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($r2);
        if($b == $i)
            $a = $row["amount"];
        else
            $a = 10;
        $first = true;    
        $totaly1+=$a;
    }
    $totaly1 += 25;
    
			}
    }
	$query = "select DISTINCT(p_id) from reports where  YEAR(pay_time)=YEAR('".$d."')";
    $r1 = mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)>0){
        while($row = mysqli_fetch_array($r1)){
            $totaly +=10;
		}
		}
		$q10="select * from consultant where YEAR(date)=YEAR('".$d."')";
		$r10=mysqli_query($conn,$q10);
		while($rw10=mysqli_fetch_array($r10)){
			$payd=json_decode($rw10['mode'],true);
			if($payd['mode']=='cash'){
				$totaly=$totaly+$rw10['cost'];
			}
			else if($payd['mode']=='cheque'){
				$totaly1=$totaly1+$rw10['cost'];
			}
		}

		$cony1=0;
	$cony2=0;
	$query5="select * from vouchers where  YEAR(date)=YEAR('".$d."')";
	$res5=mysqli_query($conn,$query5);
	while($r5=mysqli_fetch_array($res5)){
		 $payd=json_decode($r5['mode'],true);
		
		if($payd['mode']=='cash'){
			
		$cony1=$cony1 + $r5['amount'];
	}
	else if($payd['mode']=='cheque'){
		$cony2=$cony2 + $r5['amount'];
	}
	}
	// echo $saly1.'<br>';
	// echo $saly2.'<br>';
	// echo $cony1.'<br>';
	// echo $cony2.'<br>';
	// echo $dony1.'<br>';
	// echo $dony2.'<br>';
	// echo $totaly.'<br>';
	// echo $totaly1.'<br>';
?>