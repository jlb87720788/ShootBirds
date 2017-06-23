<?php
include_once("../ShootBirdComm/config.php");
try{
	$gameId = trim($_GET['g']);
	if(!empty($gameId)){
		$gameId = intval(base64_decode($gameId));
		$con = mysqli_connect($dbConfig['host'],$dbConfig['username'],$dbConfig['password'],$dbConfig['dbname']);
		if ($con){
			$gameId = intval($gameId);
			//判断是否存在这个gameId
			$sql6 = "select count(*) from sk_user where game_id = '".$gameId."'";
			$result6 = $con->query($sql6);
			$row6 = $result6->fetch_row();
			if($row6[0] > 0){
				$today = date("Y-m-d"); 
				$sql = "select * from sk_share where game_id = '".$gameId."' and add_date = '".$today."'";
				$result = $con->query($sql);
				$has = false;
				$addGold = true;
				while($row = $result->fetch_assoc()){
				    $goldNum = intval($row['add_gold']);
				    $ips = $row['ips'];
				    $id = $row['id'];
				    $has = true;
				    if($goldNum < 10){
				    	$myIp = $_SERVER['REMOTE_ADDR'];
				    	if(strpos($ips,$myIp) === false){
							$newIps = $ips.$myIp.",";
							$sql2 = "update sk_share set add_gold = add_gold + 1,ips = '".$newIps."' where id = '".$id."'";
							$con->query($sql2);
						}else{
							$addGold = false;
						}
				    }else{
				    	$addGold = false;
				    }
				    break;
				}

				if(!$has){
					$sigleIp = $_SERVER['REMOTE_ADDR'].",";
					$sql4 = "insert into sk_share (game_id,add_date,add_gold,ips) values ('".$gameId."','".$today."','1','".$sigleIp."')";
					$con->query($sql4);
				}

				if($addGold){
					$sql3 = "update sk_user set gold_num = gold_num + 1,share_gold_num = share_gold_num + 1 where game_id = '".$gameId."'";
					$con->query($sql3);
				}
			}
			$con->close();
		}
	}
}catch( Exception $e) {

}
?>


<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2">
	<meta charset="utf-8">
	<meta name="format-detection" content="telephone=no">
	<title>Shoot Birds</title>
<style>

	html{height: 100%;width: 100%;margin:0;padding:0;}
body{
	height: 100%;width: 100%;margin:0;padding:0;
background:url(https://github.com/jlb87720788/ShootBirds/raw/master/background.png)no-repeat;
    width:100%;
    height:100%;
    background-size:100% 100%;
    position:absolute;
    filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='bg-login.png',sizingMethod='scale'
}


</style>

	</head>
<body>

<a href="https://itunes.apple.com/cn/app/id1242665576">
<img src="https://github.com/jlb87720788/ShootBirds/raw/master/iosicon.png"  style="width:30%;top:40%;left:15%;position:absolute;">
</a>


<a href="https://github.com/jlb87720788/ShootBirds/raw/master/Android_shootbird.apk">
<img src="https://github.com/jlb87720788/ShootBirds/raw/master/androidicon.png"  style="width:30%;top:40%;right:15%;position:absolute;">
</a>


</body>
</html>
 


