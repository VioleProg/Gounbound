<?PHP session_start(); 
include("verify.php");
?>

<?PHP

include ("header.php"); 
$search = mysql_real_escape_string($_GET['search']);
$submit = mysql_real_escape_string($_GET['submit']);
echo "<script language=javascript>function fnlocation(argu) {window.open(argu, 'View', 'scrollbars=no, width=400 height=s00, top=0, left=0');} </script>
      <script language=javascript>function fnnlocation(argu) {window.open(argu, 'View', 'scrollbars=yes, width=400 height=s00, top=0, left=0');} </script>";
$sqle = mysql_query("SELECT Id FROM game WHERE Id='$search'");
$sqllye = mysql_num_rows($sqle);
if($sqllye == 0)
{
  die("<script>alert('Username does not exist'); history.back('');</script>");
}
$sqllog = mysql_query("SELECT * FROM game WHERE Id='$search'");
$sqllylog = mysql_fetch_assoc($sqllog);
$user_name = $sqllylog['Id'];
$nickname = $sqllylog['NickName'];
$gp = $sqllylog['TotalScore'];
$grade = $sqllylog['TotalGrade'];
$guild = $sqllylog['Guild'];
$guildrank = $sqllylog['GuildRank'];
$membercount = $sqllylog['MemberCount'];
$rank = $sqllylog['TotalRank'];
$laston = $sqllylog['LastUpdateTime'];
$countrygrade = $sqllylog['CountryGrade'];
$accounttype = $sqllylog['AccountType'];
$gold = $sqllylog['Money'];


$sqlu = mysql_query("SELECT * FROM user WHERE Id='$search'");
$sqllu = mysql_fetch_assoc($sqlu);
$sex = $sqllu['Gender'];
$password = $sqllu['Password'];
$email = $sqllu['E_Mail'];
$email_verify = $sqllu['E_Mail_Verify'];
$country = $sqllu['Country'];
$birthday = $sqllu['Birthdate'];
$firstname = $sqllu['Firstname'];
$lastname = $sqllu['Lastname'];
$ipaddress = $sqllu['IP'];

$sqla = mysql_query("SELECT * FROM user WHERE Id='".$_SESSION['user']."'");
$sqllya = mysql_fetch_assoc($sqla);
$authority = $sqllya['Authority'];

$sqlc = mysql_query("SELECT * FROM cash WHERE ID='$search'");
$sqllyc = mysql_fetch_assoc($sqlc);
$cash = $sqllyc['Cash'];

if(isset($_POST['updateacc']))
{
$ud_nick = mysql_real_escape_string($_POST['ud_nick']);
$ud_grade = mysql_real_escape_string($_POST['ud_grade']);
$ud_gold = mysql_real_escape_string($_POST['ud_gold']);
$ud_cash = mysql_real_escape_string($_POST['ud_cash']);
$ud_gp = mysql_real_escape_string($_POST['ud_gp']);
$ud_country = mysql_real_escape_string($_POST['ud_country']);
$ud_sex = mysql_real_escape_string($_POST['sex']);
$ud_verify = mysql_real_escape_string($_POST['email_verified']);
$ud_guild = mysql_real_escape_string($_POST['guild']);

$updategame = mysql_query("UPDATE game SET NickName='$ud_nick', TotalGrade='$ud_grade', Guild='$ud_guild', Country='$ud_country', CountryGrade='$ud_grade', SeasonGrade='$ud_grade', TotalScore='$ud_gp', Money='$ud_gold' WHERE Id='$search'") or die(mysql_error());
$updategunwc = mysql_query("UPDATE gunwcuser SET NickName='$ud_nick', Gender='$ud_sex', Country='$ud_country', E_Mail_Verify='$ud_verify' WHERE Id='$search'") or die(mysql_error());
$updateuser = mysql_query("UPDATE user SET Gender='$ud_sex', NickName='$ud_nick', Country='$ud_country', E_Mail_Verify='$ud_verify' WHERE Id='$search'") or die(mysql_error());
$updatecash = mysql_query("UPDATE cash SET Cash='$ud_cash' WHERE Id='$search'") or die(mysql_error());
echo '<meta http-equiv="REFRESH" content="0;url=account.php?search='.$search.'"> <font color="green">Record(s) Updated</font>';
}


?>
<a name="maincontent"></a>



	<a href="./index.php?i=users&amp;sid=5f9cd8072dd81f0c33716888697f7a23&amp;icat=13&amp;mode=overview" style="float: right;">&laquo; Back</a>

	<h1>User administration :: You searched for - <strong><u><?PHP echo $search; ?></u></strong></h1>
<?PHP
echo "<form method='post' action=''>
<fieldset>
	<legend>Account Overview</legend>

<dl>
	<dt><label for='user'>Login ID:</label><br /><span>Length must be between 3 and 20 characters.</span></dt>

	<dd><strong>$user_name</dd>

</dl>";
if($authority >= 100)
{
echo "<dl>
	<dt><label for='user'>Password:</label><br /><span>Highlight to view password</span></dt>

	<dd><strong><font color='white'>$password </font></dd>

</dl>";
}

echo "
<dl>
	<dt><label for='nick'>Game ID:</label><br /><span>Length must be between 3 and 20 characters.</span></dt>

	<dd><input type='text' id='user' name='ud_nick' value='$nickname' /></dd>

	
</dl>
<dl>
	<dt><label for='nick'>IP Address: </label><br /><span></span></dt>

	<dd>$ipaddress</dd>

	
</dl>
<dl>
	<dt><label>E-mail:</label><br /><span>Use for security</span></dt>
	<dd><strong>$email</strong></dd>

</dl>
<dl>
	<dt><label>E-mail Activation: </label></dt>";
	echo "<dd>";
  if($email_verify != 1)
                {
                 echo "<input type='radio' name='email_verified' value='0' checked /> Unverified ";
                 echo "<input type='radio' name='email_verified' value='1' /> Verified";
                }
                if($email_verify !=0)
                {
                 echo "<input type='radio' name='email_verified' value='0' /> Unverified ";
                 echo "<input type='radio' name='email_verified' value='1' checked /> Verified";
                }
  echo "</dd>";

echo "</dl>
<dl>
<dt><label>Gender:</label></dt>
<dd>";
if($sex != 1)
                {
                 echo "<input type='radio' name='sex' value='0' checked /> Male ";
                 echo "<input type='radio' name='sex' value='1' /> Female ";
                }
                if($sex !=0)
                {
                 echo "<input type='radio' name='sex' value='0' /> Male ";
                 echo "<input type='radio' name='sex' value='1' checked /> Female ";
                }
echo "</dd>
</dl>";
echo "
<dl>
	<dt><label for='nick'>Account Status:</label><br /><span></span></dt>

	<dd><strong>Functioning</strong></dd>
</dl>

<dl>
	<dt><label for='nick'>Birthday:</label><br /><span>Use for security</span></dt>

	<dd><strong>$birthday</strong></dd>
</dl>
<dl>
	<dt><label>Last Online:</label></dt>
	<dd><strong>$laston</strong></dd>

</dl>
<dl>
	<dt><label>Total GP</label></dt>

	<dd><strong><input type='text' name='ud_gp' value='$gp' /></strong></dd>
</dl>
<dl>
	<dt><label>Country</label></dt>

	<dd><strong><input type='text' name='ud_country' value='$country' /></strong>
  <br /><u>All Countries:</u><a href="."javascript:fnnlocation('all_countries')"." /> here</a><br /></dd>
</dl>
<dl>
	<dt><label>Total Rank:</label></dt>
	<dd><strong>$rank</strong></dd>
</dl>
<dl>
	<dt><label>Level:</label></dt>
	<dd><strong><img src='../images/v2/arcade/gunbound/levels/".$grade.".gif' alt='' border='0' /></strong> <input type=text size='2' maxlength='2' name='ud_grade' value='$grade' />
  <br /><u>All Grades:</u><a href="."javascript:fnlocation('all_grades')"." /> here</a><br /></dd>
</dl>
<dl>
	<dt><label>Guild:</label><br /><span>Change via Guild Management</span></dt>
	<dd><input name='guild' type='text' value='$guild' /> [$guildrank / $membercount ]</dd>
</dl>

<dl>
	<dt><label>Gold:</label></dt>
	<dd><input type='text' id='gold' name='ud_gold' value='$gold' /></dd>
</dl>

<dl>
	<dt><label>Cash:</label></dt>
	<dd><input type='text' id='gold' name='ud_cash' value='$cash' /></dd>
</dl>
<p class='quick'>
	<input class='button1' type='submit' name='updateacc' value='Update Account' />
</p>

</fieldset>
</form>




	</form>

</div>";
include "footer.php" ?>


