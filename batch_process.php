<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Transport - Batch Fixer</title>
<style type="text/css">
<!--
.style8 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; color: #FFFFFF; }
.style11 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #000000; }
.style12 {font-size: 12px}
.style13 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; color: #FFFFFF; }
.style14 {font-family: Arial, Helvetica, sans-serif}
.style15 {font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
.style16 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; }
-->
</style>
</head>

<body>
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
			if ($row['3'] == "") { $row['3'] = $row['2']; }
			if ($row['12'] == "") { $row['12'] = $row['11']; }

			/*
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
			*/
		

			if ($row['28'] == "1" && $row['3'] <> "ACV"){
			//If there is a pickup Slip available
				if ($row['29'] == "1" || $row['29'] == "1" || $row['30'] == "1" || $row['31'] == "1" || $row['32'] == "1" || $row['33'] == "1") {
				//If there are any in-op flags in the condition report fields
					$inop[] = $row;
				} else {
				//If no inop fields flagged
					$ready[] = $row;
				}
			}
		}
	}	
			print_r($row);
	/*
	unlink('ACV_pruned.csv');
	$fp = fopen('ACV_pruned.csv', 'w');
	foreach ($new_csv as $value)
	{
		fputcsv($fp, $value);
	}
fclose($fp);
*/
		
}

?>
<br />
<br />
<form id="form1" name="form1" method="post" action="batch_pruned.php">
  <table width="1400" border="0" align="center" cellpadding="3" cellspacing="1">
    <tr>
      <td colspan="13"><div align="center"><span class="style16">Ready to Rock </span></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center" class="style11">
        </div></td>
      <td colspan="7"><div align="center" class="style16"></div></td>
      <td colspan="4"><div align="right" class="style14">
        <div align="center"><?php printf(count($ready)); ?> Ready Jobs </div>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#000000" class="style8"><div align="center"></div></td>
      <td colspan="5" bgcolor="#000000" class="style8"><div align="center">Pickup Info </div></td>
      <td colspan="5" bgcolor="#000000" class="style8"><div align="center">Delivery Info </div></td>
      <td colspan="2" bgcolor="#000000" class="style8"><div align="center">Monitary</div></td>
    </tr>
    <tr>
      <td bgcolor="#330000"><div align="center" class="style8 style12 style14">Auction ID </div></td>
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
      <td bgcolor="#003300"><div align="center" class="style13">Charged</div></td>
      <td width="80" bgcolor="#003300"><div align="center" class="style13">Payout</div></td>
    </tr>
    <?php if(isset($ready))
  { 
  	$bcolor  = "#F1EEEE";  //starting row background color
  	foreach($ready as $job) {
	
	if ($bcolor == "#FFFFFF")   //alternate row background colors
  	{ 
		$bcolor = "#F1EEEE"; 
  	} else { 
		$bcolor = "#FFFFFF"; 
  	}
	 ?>
    <tr bgcolor="<?php echo $bcolor; ?>" onMouseOver="this.bgColor = '#C2F3C6'" onMouseOut ="this.bgColor = '<?php echo $bcolor ?>'">
      <td><span class="style15"><?php printf($job['0']); ?></span></td>
      <td><span class="style15"><?php printf($job['3']); ?></span></td>
      <td><span class="style15"><?php printf($job['4']); ?></span></td>
      <td><span class="style15"><?php printf($job['5']); ?></span></td>
      <td><span class="style15"><?php printf($job['6']); ?></span></td>
      <td><span class="style15"><?php printf($job['7']); ?></span></td>
      <td><span class="style15"><?php printf($job['12']); ?></span></td>
      <td><span class="style15"><?php printf($job['13']); ?></span></td>
      <td><span class="style15"><?php printf($job['14']); ?></span></td>
      <td><span class="style15"><?php printf($job['15']); ?></span></td>
      <td><span class="style15"><?php printf($job['16']); ?></span></td>
      <td><div align="center"><span class="style15">$<?php printf(number_format($job['19'],0)); ?></span></div></td>
      <td width="80"><span class="style15">
        <label> $
          <input name="textfield" type="text" class="style15" size="5" maxlength="5" />
        </label>
      </span></td>
    </tr>
    <?php } 
  }?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="80">&nbsp;</td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
