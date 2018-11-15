<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style11 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #000000; }
.style13 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; color: #FFFFFF; }
.style14 {font-family: Arial, Helvetica, sans-serif}
.style15 {font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
.style16 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; }
.style8 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; color: #FFFFFF; }
-->
</style>
</head>

<body>
<?php
$user = "xdggshzwajnsri";
$pass = "5322b774ceb298ccabda93325e8d1d0396cd228349e2798f1f12c8f787701449";
$dbconn = pg_connect("host=ec2-107-21-98-165.compute-1.amazonaws.com port=5432 dbname=deisda4pd1ikeg user=$user password=$pass");
if (!$dbconn) { echo "An error occurred.\n"; exit;}

$table = 'public."transport"';
$mysql = "SELECT * FROM $table";
$result = pg_query($dbconn, $mysql);
if (!$result) 
{ 
	echo "An error occurred with removing unpruned data \n"; exit; 
}
	$info = pg_fetch_all($result); 
?>
<table width="900" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>Filters</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="1400" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td colspan="21"><div align="center"><span class="style16">ACV Transportation Jobs </span><br />
    </div></td>
  </tr>
  <tr>
    <td colspan="5"><div align="center" class="style11">
      <div align="left"><?php printf(count($info)); ?> Ready Jobs </div>
    </div></td>
    <td colspan="7"><div align="center" class="style16"></div></td>
    <td colspan="9"><div align="right" class="style14">
      <div align="center"></div>
    </div></td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#000000" class="style8"><div align="center">Auction Info </div></td>
    <td colspan="5" bgcolor="#000000" class="style8"><div align="center">Pickup Info </div></td>
    <td colspan="5" bgcolor="#000000" class="style8"><div align="center">Delivery Info </div></td>
    <td colspan="2" bgcolor="#000000" class="style8"><div align="center">Monitary</div></td>
    <td bgcolor="#000000" class="style8">&nbsp;</td>
    <td bgcolor="#000000" class="style8">&nbsp;</td>
    <td bgcolor="#000000" class="style8">&nbsp;</td>
    <td bgcolor="#000000" class="style8">&nbsp;</td>
    <td bgcolor="#000000" class="style8">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#330000">&nbsp;</td>
    <td bgcolor="#330000"><div align="center" class="style13">Auction ID </div></td>
	    <td bgcolor="#330000"><div align="center" class="style13">Vehicle</div></td>
    <td bgcolor="#330000"><div align="center" class="style13">Inop? </div></td>
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
    <td bgcolor="#333333" class="style13"><div align="center">Rdy</div></td>
    <td bgcolor="#333333" class="style13"><div align="center">Ptr</div></td>
    <td bgcolor="#333333" class="style13"><div align="center">Prf</div></td>
    <td bgcolor="#333333" class="style13"><div align="center">CD</div></td>
    <td bgcolor="#333333" class="style13"><div align="center">Dsp</div></td>a
  </tr>
  <?php if(isset($info))
  { 
  	$bcolor  = "#F1EEEE";  //starting row background color
  	foreach($info as $job) {
	
		$vehicle = $job['v_year'] . " " . $job['v_make'] . " " . $job['v_model'] . " " . $job['v_trim'];
	
		$thisid = $job['auction_id'];
		if ($bcolor == "#FFFFFF")   //alternate row background colors
		{ 
			$bcolor = "#F1EEEE"; 
		} else { 
			$bcolor = "#FFFFFF"; 
		}
	 ?>
  <tr bgcolor="<?php echo $bcolor; ?>" onmouseover="this.bgColor = '#C2F3C6'" onmouseout ="this.bgColor = '<?php echo $bcolor ?>'">
    <td bgcolor="<?php echo $bcolor; ?>"><a href="#">edit</a></td>
    <td><span class="style15"><?php printf($job['auction_id']); ?></span></td>
	<td><span class="style15"><?php echo $vehicle; ?></span></td>
    <td><div align="center">
      <input name="inop[<?php printf($job['auction_id']); ?>]" type="checkbox" value="checkbox" <?php if($job['inop'] == "t") { ?> checked="checked" <?php } ?> />
    </div></td>
    
    <td><span class="style15"><?php printf($job['p_name']); ?></span></td>
    <td><span class="style15"><?php printf($job['p_address']); ?></span></td>
    <td><span class="style15""><?php printf($job['p_city']); ?></span></td>
    <td><span class="style15"><?php printf($job['p_state']); ?></span></td>
    <td><span class="style15"><?php printf($job['p_zip']); ?></span></td>
    <td><span class="style15"><?php printf($job['d_name']); ?></span></td>
    <td><span class="style15"><?php printf($job['d_address']); ?></span></td>
    <td><span class="style15"><?php printf($job['d_city']); ?></span></td>
    <td><span class="style15"><?php printf($job['d_state']); ?></span></td>
    <td><span class="style15"><?php printf($job['d_zip']); ?></span></td>
    <td><div align="center"><span class="style15">$
              <?php  if ($job['charged'] > 0 && $job['charged'] <> "") { printf(number_format($job['charged'],0)); } else { echo "0";  $job['charged'] = "0"; } ?>
    </span></div></td>
    <td width="80" bgcolor="<?php echo $bcolor; ?>"><span class="style15">$</span><?php printf($job['payout']); ?>   </td>
    <td bgcolor="<?php echo $bcolor; ?>">
      <div align="center">
        <input type="checkbox" name="checkbox" value="checkbox" />    
      </div></td>
    <td bgcolor="<?php echo $bcolor; ?>"><div align="center">
      <input type="checkbox" name="checkbox2" value="checkbox" />
    </div></td>
    <td bgcolor="<?php echo $bcolor; ?>"><div align="center">
      <input type="checkbox" name="checkbox3" value="checkbox" />
    </div></td>
    <td bgcolor="<?php echo $bcolor; ?>"><div align="center">
      <input type="checkbox" name="checkbox4" value="checkbox" />
    </div></td>
    <td bgcolor="<?php echo $bcolor; ?>"><div align="center">
      <input type="checkbox" name="checkbox5" value="checkbox" />
    </div></td>
  </tr>
  <?php } 
  }?>
  <tr>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
    <td width="80">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
