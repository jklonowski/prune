<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 24px;
}
.style2 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; }
-->
</style>
</head>

<body>
<?php 
//*** Connect to the DB ***
$user = "xdggshzwajnsri";
$pass = "5322b774ceb298ccabda93325e8d1d0396cd228349e2798f1f12c8f787701449";
$dbconn = pg_connect("host=ec2-107-21-98-165.compute-1.amazonaws.com port=5432 dbname=deisda4pd1ikeg user=$user password=$pass");
if (!$dbconn) { echo "An error occurred.\n"; exit;}

//If we have payout #s from previous page
if ( isset($_POST['pay']) ) 
{
	$pay = $_POST['pay'];
	$inop = $_POST['inop'];
	
	//Setup pruned requests
	$table = 'public."transport"';
	$mysql = "SELECT * FROM $table WHERE pruned = FALSE";
	$result = pg_query($dbconn, $mysql);
	if (!$result) 
	{ 
		echo "An error occurred with Transportation table.\n"; exit; 
	} else { 
		$info = pg_fetch_all($result); 
	}
	
	
	//Update DB with pay and inop
	
	//Write the file
	$filename = "ACV_Jobs_" . date('MdY') . ".csv";
	unlink($filename);

	$fp = fopen($filename, 'w');
	$header = "Order #,Pickup Name,Pickup Address,Pickup City,Pickup State,Pickup Zip,Pickup Contact,Pickup Phone,Delivery Name,Del Address,Del City,Del State,Del Zip,Del Contact,Del Phone,VIN,Year,Make,Model,Trim,Class,Charged,Payout,Operable";
	$header = explode(",",$header);
	fputcsv($fp, $header);
	foreach ($info as $val)
	{
		$auction = $val['auction_id'];
		if ($pay[$auction] <> "")
		{
			$job['0'] = $auction;
			$job['1'] = $val['p_name'];
			$job['2'] = $val['p_address'];
			$job['3'] = $val['p_city'];
			$job['4'] = $val['p_state'];
			$job['5'] = $val['p_zip'];
			$job['6'] = $val['p_contact'];
			$job['7'] = $val['p_phone'];
			$job['8'] = $val['d_name'];
			$job['9'] = $val['d_address'];
			$job['10'] = $val['d_city'];
			$job['11'] = $val['d_state'];
			$job['12'] = $val['d_zip'];
			$job['13'] = $val['d_contact'];
			$job['14'] = $val['d_phone'];
			$job['15'] = $val['vin'];
			$job['16'] = $val['v_year'];
			$job['17'] = $val['v_make'];
			$job['18'] = $val['v_model'];
			$job['19'] = $val['v_trim'];
			$job['20'] = $val['v_class'];
			$job['21'] = $val['charged'];
			$job['22'] = $pay[$auction];

			if (isset($inop[$auction])) { $job['23'] = "** NO **"; $my_arr['inop'] = TRUE; } else { $job['23'] = "Yes"; $my_arr['inop'] = FALSE; }
			fputcsv($fp, $job);
			
			$my_arr['payout'] = $pay[$auction];
			$condition['auction_id'] = $auction;
			$res = pg_update($dbconn, 'transport', $my_arr, $condition);	
		}
	}
	fclose($fp);
}

?>	
<p align="center" class="style1">Uh oh! You've been Shuecklered! </p>
<p align="center" class="style1">&nbsp;</p>
<p align="center" class="style2">Your File: <a href="<?php echo "$filename"; ?>"><?php echo "$filename"; ?></a></p>
<p align="center" class="style2">&nbsp;</p>
<p align="center" class="style2"><strong>Dont mess it up!</strong><br />
  <em>Psssst. This means you Matt.</em> </p>
</body>
</html>
