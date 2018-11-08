<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Transport - Batch Fixer</title>
<style type="text/css">
<!--
.style2 {font-size: 24px}
-->
</style>
</head>

<body>
<p>
  <span class="style2">The Batch file has been pruned! </span><br />
  <br />
  <?php
if ( isset($_POST["Submit"]) ) 
{
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
	$file = $_FILES["file"]['tmp_name']; 
	$handle = fopen($file,"r"); 
	
	while (($row = fgetcsv($handle, 1200, ",")) !== FALSE) 
	{
		if (is_numeric($row['0']))		
		{
			$auctionid = $row['0'];
			$p_id = $row['1'];
			$p_name = $row['2'];
			$p_dba = $row['3'];
			$p_address = $row['4'];
			$p_city = $row['5'];
			$p_state = $row['6'];
			$p_zip = $row['7'];
			$p_contact = $row['8'];
			$p_phone = $row['9'];
			$d_name = $row['10'];
			$d_id = $row['11'];
			$d_dba = $row['12'];
			$d_address = $row['13'];
			$d_city = $row['14'];
			$d_state = $row['15'];
			$d_zip = $row['16'];
			$d_contact = $row['17'];
			$d_phone = $row['18'];

			
			if (isset($add_csv[$p_id]) && $add_csv[$p_id]['6'])
			{
				$row['4'] = $add_csv[$p_id]['2'];
				$row['5'] = $add_csv[$p_id]['3'];
				$row['6'] = $add_csv[$p_id]['4'];
				$row['7'] = $add_csv[$p_id]['5'];
				echo "Swapped out Auction: $auctionid: $p_id - $p_name - $p_dba </br>";
			} 
			if (isset($add_csv[$d_id]) && $add_csv[$d_id]['7'])
			{
				$row['13'] = $add_csv[$d_id]['2'];
				$row['14'] = $add_csv[$d_id]['3'];
				$row['15'] = $add_csv[$d_id]['4'];
				$row['16'] = $add_csv[$d_id]['5'];
				echo "Swapped out $d_id - $d_name - $d_dba </br>";
			}
		}
		$new_csv[] = $row;
	}	
	unlink('ACV_pruned.csv');
	$fp = fopen('ACV_pruned.csv', 'w');
	foreach ($new_csv as $value)
	{
		fputcsv($fp, $value);
	}
fclose($fp);
//print_r($new_csv);
}
?>   
</p>
<p>&nbsp;</p>
<p><a href="ACV_pruned.csv">Pruned List </a></p>
</body>
</html>
