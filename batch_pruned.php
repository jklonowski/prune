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

if ( isset($_POST["filename"]) ) 
{
	$pay = $_POST['pay'];
	//Take address swap CSV and throw it into an array
	if (($csvfile = fopen("add_swap.csv", "r")) !== FALSE) 
	{
    	while (($data = fgetcsv($csvfile, 1000, ",")) !== FALSE) 
		{
			$tempid = $data['0'];
			$add_csv[$tempid] = $data;
    	}
    	fclose($csvfile);
	}
	
	//handle upload and setup batch file into an array
	$file = $_POST['filename']; 
	$handle = fopen($file,"r"); 
	
	while (($row = fgetcsv($handle, 1200, ",")) !== FALSE) 
	{
		if (is_numeric($row['0']))		
		{
			$auctionid = $row['0'];
			if (isset($pay[$auctionid]))
			{
				$p_id = $row['1'];
				$d_id = $row['10'];
				$row['19'] = $pay[$auctionid];
				
				if ($row['3'] == "") { $row['3'] = $row['2']; }
				if ($row['12'] == "") { $row['12'] = $row['11']; }
				
				if (isset($add_csv[$p_id]) && $add_csv[$p_id]['6'])
				{  // Swap out the pickup info
					$row['4'] = $add_csv[$p_id]['2'];
					$row['5'] = $add_csv[$p_id]['3'];
					$row['6'] = $add_csv[$p_id]['4'];
					$row['7'] = $add_csv[$p_id]['5'];
				} 
				if (isset($add_csv[$d_id]) && $add_csv[$d_id]['7'])
				{  //Swap out the delivery info
					$row['13'] = $add_csv[$d_id]['2'];
					$row['14'] = $add_csv[$d_id]['3'];
					$row['15'] = $add_csv[$d_id]['4'];
					$row['16'] = $add_csv[$d_id]['5'];
				}
			}
		}
	}	
	unlink('ACV_pruned.csv');
	$fp = fopen('ACV_pruned.csv', 'w');
	foreach ($row as $value)
	{
		fputcsv($fp, $value);
	}
	fclose($fp);	
}


?>	
<p align="center" class="style1">Uh oh! You've been Shuecklered! </p>
<p align="center" class="style1">&nbsp;</p>
<p align="center" class="style2"><a href="acv_pruned.csv">Your File </a></p>
<p align="center" class="style2">&nbsp;</p>
<p align="center" class="style2"><strong>Dont mess it up!</strong><br />
  <em>Psssst. This means you Matt.</em> </p>
</body>
</html>
