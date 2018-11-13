<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>String maker</title>

<script>
function myFunction() {
  /* Get the text field */
  var copyText = document.getElementById("myInput");

  /* Select the text field */
  copyText.select();

  /* Copy the text inside the text field */
  document.execCommand("copy");

}
</script>
</head>

<body>
<p>
  <?php
if ( isset($_POST["Submit"]) ) 
{
	$file = $_FILES["file"]['tmp_name']; 
	$handle = fopen($file,"r"); 
	
	while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) 
	{
		if (is_numeric($row['0']))		
		{
			$order = $row['0'];
			$p_name = $row['1'];
			$p_address = $row['2'];
			$p_city = $row['3'];
			$p_state = $row['4'];
			$p_zip = $row['5'];
			$p_contact = $row['6'];
			$p_phone = $row['7'];
			$d_name = $row['8'];
			$d_address = $row['9'];
			$d_city = $row['10'];
			$d_state = $row['11'];
			$d_zip = $row['12'];
			$d_contact = $row['13'];
			$d_phone = $row['14'];
			$vin = $row['15'];
			$year = $row['16'];
			$make = $row['17'];
			$model = $row['18'];
			$trim = $row['19'];
			$type = $row['20'];
			$charged = $row['21'];
			$payout= $row['22'];
			if ($row['23'] == "** NO **") { $op = "inoperable"; } else { $op = "operable"; }

			$type = "";
			$pay_method = "check";
			$trailer = "open";
			$info = "ACV AUCTIONS - Get Paid electronically Instantly!";
			$date1 = date("Y-m-d");
			$date2 = date('Y-m-d', strtotime('+30 days'));
			
			$import[] = "$order,$p_city,$p_state,$p_zip,$d_city,$d_state,$d_zip,$payout,0.00,$pay_method,delivery,quickpay,open,$op,$date1,$date2,$info,||||$vin";
			$del[]= "DELETE($order)";
		}
	}	
	
	if ($_POST['account'] == "A") { $str = "UID(qkvvFU48)*"; } else { str = "neC848Q4"; }
	foreach($del as $value)
	{
		$str = $str . $value . "*";
	}
	foreach($import as $val)
	{
		$str = $str . $val . "*";
	}
}
?>   
</p>
<table width="600" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td>Here's your string</td>
    <td><div align="right"><a href="#" onclick="myFunction()">copy text</a>&nbsp;&nbsp;&nbsp; </div></td>
  </tr>
  <tr>
    <td colspan="2"><textarea name="myInput" cols="200" rows="12" id="myInput"><?php echo $str; ?></textarea></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <label>
      <input type="submit" name="Submit" value="Send to CD" />
      </label>
    </div></td>
  </tr>
</table>
<p>
  <label></label>
</p>
</body>
</html>
