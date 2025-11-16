<?PHP include "header.php"; 
include("verify.php");
?>
					<div id="main">

<div id="main">

<a name="maincontent"></a>
<?PHP
$judge = $_SESSION['user'];
$duration = mysql_real_escape_string($_POST['banduration']);
$reason = mysql_real_escape_string($_POST['banreason']);
$banuser = mysql_real_escape_string($_POST['banuserid']);
$time = strtotime('+'.$duration.' hours');
$bantime = date("Y-m-d H:i:s",$time);
$nowtime = date("Y-m-d H:i:s");
 
if(isset($_POST['banuser'])){
if(isset($_POST['permaban']) &&
	$_POST['permaban'] == '-1')
	{
	    
  $banlog = mysql_query("INSERT INTO banlog (Id, StartTime, Reason, Judge) VALUES
  ('$banuser','$nowtime','$reason','$judge')");
  $updategunwc = mysql_query("UPDATE gunwcuser SET Authority='-100' WHERE Id='$banuser'");
  $updateuser = mysql_query("UPDATE user SET Authority='-100' WHERE Id='$banuser'");
  $updategame = mysql_query("UPDATE game SET NoRankUpdate='1' WHERE Id='$banuser'");
  echo "This user has been permanently banned for: <b>$reason</b>";
	}
  else
  {
  $updatebanlog = mysql_query("INSERT INTO banlog (Id, StartTime, Reason, Judge)
VALUES ('$banuser','$nowtime','$reason','$judge')");

  $updategunwc = mysql_query("UPDATE gunwcuser SET RestrictTime='$bantime' WHERE Id='$banuser'");
  echo "This user has been successfully banned until $bantime for: <b>$reason</b>"; 
  }
  
  }
 
	


?>


	<h1>Ban / User Suspension</h1>
  <p><b><font color='red'>BANNING DURATION <u>MUST</u> be at least 21 HOURS</font></b></p>
	<form id="select_user" action='' method='post'>

	<fieldset>
		<legend>Select a user</legend>

	<dl>
		<dt><label for="username">Ban/Suspension</label></dt>
		<dd>Login ID: <input class="text medium" type="text" id="username" name="banuserid"><br /><br />
    Duration: <input class="text medium" type="text" id="username" name="banduration"> (HOURS)<br />
    <br />&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
    <FONT size='1' color='orange'><b>Permanent Ban:</b></font> 
    <input type='checkbox' name='permaban' value='-1' /><br />
    <br />Reason: &nbsp; <input class="text medium" type="text" maxlength="15" id="username" name="banreason"></dd>

	</dl>

	<p class="quick">
		<input type="submit" name="banuser" value="Ban" class="button1">
	</p>
	</fieldset>

	</form> 
 
		<h2>Ban Log</h2>

		<p>This gives an overview of all the accounts that have been banned.</p>

	

		<table width='110% cellspacing="1">
		<thead>
		<tr>
			<th>Username</th>

			<th>User IP</th>
			<th>Duration</th>
			<th>Reason</th>
			<th>Judge</th>
		</tr>
		</thead>
		<tbody>
		<?PHP
    $sqlgbl = mysql_query("SELECT * FROM banlog");
    while($sqllybl = mysql_fetch_assoc($sqlgbl))
    {
    $sqllip = mysql_query("SELECT * FROM user WHERE Id='".$sqllybl['Id']."'");
    $sqllyip = mysql_fetch_assoc($sqllip);
    $ip = $sqllyip['IP'];
    
    $sqlres = mysql_query("SELECT * FROM gunwcuser WHERE Id='".$sqllybl['Id']."'");
    $sqllyres = mysql_fetch_assoc($sqlres);
    $restrict = $sqllyres['RestrictTime'];
    
    $sqlat = mysql_query("SELECT * FROM gunwcuser WHERE Id='".$sqllybl['Id']."'");
    $sqllyat = mysql_fetch_assoc($sqlat);
    $authority = $sqllyat['Authority'];
    echo '<tr class="row2">

				<td><a style="color: #AA0000;" class="username-coloured">'.$sqllybl['Id'].'</a></td>
				<td style="text-align: center;">'.$ip.'</td>';
			  if($authority == -100) { echo '<td style="text-align: center;"><font color="red">Permanent Ban </font></td>'; } else { echo '<td style="text-align: center;">'.$restrict.'</td>'; }
				echo '<td><strong>'.$sqllybl['Reason'].'</strong></td>
				<td><strong>'.$sqllybl['Judge'].'</strong></td>
			</tr>'; } ?>
		
		</tbody>

		</table>
</div> 
				</div>
       

			<span class="corners-bottom"><span></span></span>
			<div class="clear"></div>
		</div>
		</div>
	</div>
<?PHP include "footer.php"; ?>