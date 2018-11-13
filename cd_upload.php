<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Transport - Central Dispatch Batch Poster </title>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 24px;
}
.style2 {
	font-size: 14px;
	font-family: Arial, Helvetica, sans-serif;
}
.style3 {font-family: Arial, Helvetica, sans-serif}
-->
</style>
</head>

<body>


<div align="center">
  <p>&nbsp;</p>
  <p class="style1">Central Dispatch Batch Poster </p>
  <p>&nbsp;</p>
  <form id="form1" name="form1" enctype="multipart/form-data" method="post" action="cd_batch.php">
    <label><span class="style2">CD Account</span>
    <select name="account" id="account">
      <option value="A">A Account</option>
      <option value="B">B Account</option>
    </select>
    <span class="style2"><br />
    <br />
    CSV File</span>
      <input type="file" name="file" />
    </label>
    <p>&nbsp;</p>
    <p>
      <label>
      <input type="submit" name="Submit" value="Upload" />
      </label>
    </p>
  </form>
  <p>&nbsp; </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
</body>
</html>
