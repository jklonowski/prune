<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>The Batchery - CSV Download</title>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 24px;
}
.style2 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; }
.style11 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #000000; }
.style12 {font-size: 12px}
.style13 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; color: #FFFFFF; }
.style14 {font-family: Arial, Helvetica, sans-serif}
.style15 {font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
.style16 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; }
.style20 {font-size: 12px; font-style: italic; }
.style8 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; color: #FFFFFF; }
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
	
	//Write the file
	$filename = "ACV_Jobs_" . date('MdY') . ".csv";
	unlink($filename);

	$fp = fopen($filename, 'w');
	$header = "Order #,Pickup Name,Pickup Address,Pickup City,Pickup State,Pickup Zip,Pickup Contact,Pickup Phone,Delivery Name,Del Address,Del City,Del State,Del Zip,Del Contact,Del Phone,VIN,Year,Make,Model,Trim,Class,Charged,Payout,Operable";
	$header = explode(",",$header);
	fputcsv($fp, $header);
	
	$x = 0;
	foreach ($info as $val)
	{
		$auction = $val['auction_id'];
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
		
		if ($pay[$auction] <> "")
		{
			if (isset($inop[$auction])) { $job['23'] = "** NO **"; } else { $job['23'] = "Yes"; }
			fputcsv($fp, $job);
			$x++;
		} else {
			$nobatch[] = $job;
		}
	}
	
	fclose($fp);	
	
}


?>	
<p align="center" class="style1">Uh oh! You've been Shuecklered! </p>
<p align="center" class="style1">&nbsp;</p>
<p align="center" class="style2"><?php printf($x); ?> Pruned Jobs | <?php printf(count($nobatch)); ?> Leftover Jobs </p>
<p align="center" class="style2"><a href="#">Post to Partners</a> | <a href="#">Post to Preferred</a> </p>
<p align="center" class="style2">Download CSV File: <a href="<?php echo "$filename"; ?>"><?php echo "$filename"; ?></a></p>
<p align="center" class="style2">&nbsp;</p>
<table width="1400" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td colspan="13"><div align="center"><span class="style16">Leftover Jobs <br />
    </span></div></td>
  </tr>
  <tr>
    <td colspan="4"><div align="center" class="style11"> </div></td>
    <td colspan="7"><div align="center" class="style16"></div></td>
    <td colspan="2"><div align="right" class="style14">
      <div align="center">
        <?php if (isset($nobatch)) { printf(count($nobatch)); } else { echo "0"; } ?>
        Leftover Job(s) </div>
    </div></td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#000000" class="style8"><div align="center">Auction Info </div></td>
    <td colspan="5" bgcolor="#000000" class="style8"><div align="center">Pickup Info </div></td>
    <td colspan="5" bgcolor="#000000" class="style8"><div align="center">Delivery Info </div></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#330000"><div align="center" class="style8 style12 style14">Auction ID </div></td>
    <td bgcolor="#330000"><div align="center" class="style8 style12 style14">Vehicle</div></td>
    <td bgcolor="#000033"><div align="center" class="style13">Name</div></td>
    <td bgcolor="#000033"><div align="center" class="style13">Address</div></td>
    <td bgcolor="#000033"><div align="center" class="style13">City</div></td>
    <td bgcolor="#000033"><div align="center" class="style13">State</div></td>
    <td bgcolor="#000033"><div align="center" class="style13">Zip</div></td>
    <td bgcolor="330033"><div align="center" class="style13">Name</div></td>
    <td bgcolor="330033"><div align="center" class="style13">Address</div></td>
    <td bgcolor="330033"><div align="center" class="style13">City</div></td>
    <td bgcolor="330033"><div align="center" class="style13">State</div></td>
    <td bgcolor="330033"><div align="center" class="style13">Zip</div></td>
  </tr>
  <?php if(isset($nobatch))
  { 
  
  	$bcolor  = "#F1EEEE";  //starting row background color
  	foreach($nobatch as $ljob) {
		
		$thisid = $ljob['0'];
		
			$vehicle = $ljob['17'] . " " . $ljob['18'] . " " . $ljob['19'] . " " . $ljob['20'];
			
			if ($bcolor == "#FFFFFF")   //alternate row background colors
			{ 
				$bcolor = "#F1EEEE"; 
			} else { 
				$bcolor = "#FFFFFF"; 
			}
	 ?>
  <tr bgcolor="<?php echo $bcolor; ?>" onmouseover="this.bgColor = '#C2F3C6'" onmouseout ="this.bgColor = '<?php echo $bcolor ?>'">
    <td colspan="2"><span class="style15"><?php printf($ljob['0']); ?></span></td>
    <td><span class="style15"><?php echo $vehicle; ?></span></td>
    <td><span class="style15"><?php printf($ljob['1']); ?></span></td>
    <td><span class="style15"><?php printf($ljob['2']); ?></span></td>
    <td><span class="style15"><?php printf($ljob['3']); ?></span></td>
    <td><span class="style15"><?php printf($ljob['4']); ?></span></td>
    <td><span class="style15"><?php printf($ljob['5']); ?></span></td>
    <td><span class="style15"><?php printf($ljob['8']); ?></span></td>
    <td><span class="style15"><?php printf($ljob['9']); ?></span></td>
    <td><span class="style15"><?php printf($ljob['10']); ?></span></td>
    <td><span class="style15"><?php printf($ljob['11']); ?></span></td>
    <td><span class="style15"><?php printf($ljob['12']); ?></span></td>
  </tr>
  <?php } 
  } else { ?>
  <tr>
    <td colspan="13"><p>&nbsp;</p>
        <p align="center" class="style14">No leftover jobs</p>
      <p>&nbsp;</p></td>
  </tr>
  <?php } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="style15">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p align="center" class="style2">&nbsp;</p>
</body>
</html>
