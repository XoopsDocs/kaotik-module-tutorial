<?php
// Tutorial                    										
// Created by KaotiK												
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');

if (isset($_POST['listall'])){
echo '<table width="100" border="0">
<tr>
<td bgcolor="#99cc99">'.TT_NAME.'</td>
<td bgcolor="#66cc99">'.TT_ADDRESS.'</td>
<td bgcolor="#99cc99">'.TT_TELEPHONE.'</td>
<td bgcolor="#66cc99">'.TT_EMAIL.'</td>
</tr>';
$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('tutorial_myform'));
while($myrow = $xoopsDB->fetchArray($query) )
{
$name = $myrow['name'];
$address = $myrow['address'];
$telephone = $myrow['telephone'];
$email = $myrow['email'];
echo '<tr><td bgcolor="#99cc99">'.$name.'</td><td bgcolor="#66cc99">'.$address.'</td><td bgcolor="#99cc99">'.$telephone.'</td><td bgcolor="#66cc99">'.$email.'</td></tr>';
}
echo '</table>';
}

if (isset($_POST['submit'])){
if (empty($_POST['name'])){
echo 'please fill in a name';
} else {
$name=$_POST['name'];
$address=$_POST['address'];
$tel=$_POST['tel'];
$email=$_POST['email'];
$query = "Insert into ".$xoopsDB->prefix("tutorial_myform")." (name, address, telephone, email) values ('$name', '$address', '$tel', '$email' )";
	$res=$xoopsDB->query($query);
	if(!$res) {
		echo "error: $query";
	} else {
	echo "Data was correctly inserted into DB!";
	}
}
}
?>
<form name="tutorial_form" method="post" action="index.php">
  <table width="400" border="0">
    <tr>
      <td align="right"><?php echo TT_NAME; ?></td>
      <td><input type="text" name="name"></td>
    </tr><tr>
      <td align="right"><?php echo TT_ADDRESS; ?></td>
      <td><input type="text" name="address"></td>
    </tr><tr>
      <td align="right"><?php echo TT_TELEPHONE; ?></td>
      <td><input type="text" name="tel"></td>
    </tr><tr>
      <td align="right"><?php echo TT_EMAIL; ?></td>
      <td><input type="text" name="email"></td>
    </tr><tr>
      <td><input type="submit" name="listall" value="List All"></td>
      <td><input type="submit" name="submit" value="submit"></td>
    </tr>
  </table>
</form>

<?php
require(XOOPS_ROOT_PATH.'/footer.php');
?>