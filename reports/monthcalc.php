<?php
    //include '../includes/db.php';
$d=date("Y-m-d");
	$query="select * from docsal where MONTH(date)=MONTH('".$d."') and YEAR(date)=YEAR('".$d."')";
	$res=mysqli_query($conn,$query);
	$salm1=0;
	$salm2=0;
	$n=mysqli_num_rows($res);
	//echo $n;
	while($r=mysqli_fetch_array($res)){
		 $payd=json_decode($r['mode'],true);
		if($payd['mode']=='cash'){
			//echo $r['amount'];
		$salm1=$salm1 + $r['amount'];
	}
	else if($payd['mode']=='cheque'){
		//echo $r['amount'];
		$salm2=$salm2 + $r['amount'];
	}	
	}
	$query1="select * from staffsal where MONTH(date)=MONTH('".$d."') and YEAR(date)=YEAR('".$d."')";
	$res1=mysqli_query($conn,$query1);
	while($r1=mysqli_fetch_array($res1)){
			 $payd=json_decode($r1['mode'],true);
		
		if($payd['mode']=='cash'){
			
		$salm1=$salm1 + $r1['ns'];
	}
	else if($payd['mode']=='cheque'){
		$salm2=$salm2 + $r1['ns'];
	}
	}
	$donm1=0;
	$donm2=0;
	$query2="select * from donations where MONTH(payment_time)=MONTH('".$d."') and YEAR(payment_time)=YEAR('".$d."')";
	$res2=mysqli_query($conn,$query2);
	while($r2=mysqli_fetch_array($res2)){
		 $payd=json_decode($r2['payment_details'],true);
		
		if($payd['mode']=='cash'){
			
		$donm1=$donm1 + $r2['amount'];
	}
	else if($payd['mode']=='cheque'){
		$donm2=$donm2 + $r2['amount'];
	}
	}

		$totalm=0;
		$totalm1=0;
		$q="select * from reports where MONTH(pay_time)=MONTH('".$d."') and YEAR(pay_time)=YEAR('".$d."')";
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
        $totalm+=$a;
    }
    $totalm += 25;
    
			
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
        $totalm1+=$a;
    }
    $totalm1 += 25;
    
			}
    }
	$query = "select DISTINCT(p_id) from reports where MONTH(pay_time)=MONTH('".$d."') and YEAR(date)=YEAR('".$d."')";
    $r1 = mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)>0){
        while($row = mysqli_fetch_array($r1)){
            $totalm +=10;
		}
		}
		$q10="select * from consultant where DATE(date)='".$d."'";
		$r10=mysqli_query($conn,$q10);
		while($rw10=mysqli_fetch_array($r10)){
			$payd=json_decode($rw10['mode'],true);
			if($payd['mode']=='cash'){
				$totalm=$totalm+$rw10['cost'];
			}
			else if($payd['mode']=='cheque'){
				$totalm1=$totalm1+$rw10['cost'];
			}
		}

		$conm1=0;
	$conm2=0;
	$query5="select * from vouchers where MONTH(date)=MONTH('".$d."') and YEAR(date)=YEAR('".$d."')";
	$res5=mysqli_query($conn,$query5);
	while($r5=mysqli_fetch_array($res5)){
		 $payd=json_decode($r5['mode'],true);
		
		if($payd['mode']=='cash'){
			
		$conm1=$conm1 + $r5['amount'];
	}
	else if($payd['mode']=='cheque'){
		$conm2=$conm2 + $r5['amount'];
	}
	}
	// echo $salm1.'<br>';
	// echo $salm2.'<br>';
	// echo $conm1.'<br>';
	// echo $conm2.'<br>';
	// echo $donm1.'<br>';
	// echo $donm2.'<br>';
	// echo $totalm.'<br>';
	// echo $totalm1.'<br>';
?>