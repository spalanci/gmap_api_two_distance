<?php

	error_reporting ( E_ALL ); 
	ini_set('display_errors','On');
	$i = 0;
	if(!empty($_GET["query"])){

			$query = $_GET["query"];
			$filename  = "insert.txt";
			$countfile = fopen($filename,a) or die("$filename -> dosya açýlamadý");
			fwrite($countfile,$query."\n");
			fclose($countfile);
			$i = $_GET["i"]+1;
			//if($i==3500) exit;
			/*
			INSERT INTO two_point_distance 
			(lineCode, routeCode, origin,destination, 
			distance, duration, status, created_at) VALUES
			('230D','230D_G_D0', '1174','1175',259.88238525390625,44.19403648376465,
			1,'2019-09-11 10:50:33');

			*/
	}
		//config
		include("my.init.php");
	
	$hat = "110";
	
	echo $sql = "select concat(d1.enlem,'#',d1.boylam) x,concat(d2.enlem,'#',d2.boylam) y,t.d1 sdurakkodu1,t.d2 sdurakkodu2,t.hatkodu,t.s1,t.s2 from 
	(SELECT a.hatkodu,a.sirano s1,b.sirano s2,a.durak_id d1,b.durak_id d2 FROM 
	hatduraklari a, hatduraklari b where a.hatkodu=b.hatkodu and a.sirano+1=b.sirano) t 
	left join duraklar d1 on t.d1=d1.id left join duraklar d2 on t.d2=d2.id order by t.s1 limit $i,1";
	$mconnection = getMDBConnection();
	$result = mysqli_query($mconnection, $sql); 
	while ($list = mysqli_fetch_array($result)) {
          include("google.php"); 
	}    
		
?>