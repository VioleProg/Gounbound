<?php 
// verify.php já é incluído em header.php
include("header.php"); 
?>
					<div id="main">

<div id="main">

<a name="maincontent"></a>
<?php
$judge = $_SESSION['user_id'] ?? $_SESSION['user'] ?? '';
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
	    
  $banuser_escaped = mysql_real_escape_string($banuser);
  $reason_escaped = mysql_real_escape_string($reason);
  $judge_escaped = mysql_real_escape_string($judge);
  
  $banlog = mysql_query("INSERT INTO banlog (Id, StartTime, Reason, Judge) VALUES
  ('$banuser_escaped','$nowtime','$reason_escaped','$judge_escaped')");
  $updategunwc = mysql_query("UPDATE gunwcuser SET Authority='-100' WHERE Id='$banuser_escaped'");
  // Tentar atualizar user também (se existir)
  @mysql_query("UPDATE user SET Authority='-100' WHERE Id='$banuser_escaped'");
  $updategame = @mysql_query("UPDATE game SET NoRankUpdate='1' WHERE Id='$banuser_escaped'");
  echo "Este usuário foi banido permanentemente por: <b>" . htmlspecialchars($reason) . "</b>";
	}
  else
  {
  $banuser_escaped = mysql_real_escape_string($banuser);
  $reason_escaped = mysql_real_escape_string($reason);
  $judge_escaped = mysql_real_escape_string($judge);
  
  $updatebanlog = mysql_query("INSERT INTO banlog (Id, StartTime, Reason, Judge)
VALUES ('$banuser_escaped','$nowtime','$reason_escaped','$judge_escaped')");

  $updategunwc = mysql_query("UPDATE gunwcuser SET RestrictTime='$bantime' WHERE Id='$banuser_escaped'");
  echo "Este usuário foi banido com sucesso até $bantime por: <b>" . htmlspecialchars($reason) . "</b>"; 
  }
  
  }
 
	


?>


	<h1>Banir / Suspender Usuário</h1>
  <p><b><font color='red'>A DURAÇÃO DO BANIMENTO <u>DEVE</u> ser de pelo menos 21 HORAS</font></b></p>
	<form id="select_user" action='' method='post'>

	<fieldset>
		<legend>Selecionar um usuário</legend>

	<dl>
		<dt><label for="username">Banir/Suspender</label></dt>
		<dd>ID de Login: <input class="text medium" type="text" id="username" name="banuserid"><br /><br />
    Duração: <input class="text medium" type="text" id="username" name="banduration"> (HORAS)<br />
    <br />&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
    <FONT size='1' color='orange'><b>Banimento Permanente:</b></font> 
    <input type='checkbox' name='permaban' value='-1' /><br />
    <br />Motivo: &nbsp; <input class="text medium" type="text" maxlength="15" id="username" name="banreason"></dd>

	</dl>

	<p class="quick">
		<input type="submit" name="banuser" value="Banir" class="button1">
	</p>
	</fieldset>

	</form> 
 
		<h2>Log de Banimentos</h2>

		<p>Isso mostra uma visão geral de todas as contas que foram banidas.</p>

	

		<table width='100%' cellspacing="1">
		<thead>
		<tr>
			<th>Usuário</th>

			<th>IP do Usuário</th>
			<th>Duração</th>
			<th>Motivo</th>
			<th>Administrador</th>
		</tr>
		</thead>
		<tbody>
		<?php
    $sqlgbl = @mysql_query("SELECT * FROM banlog ORDER BY StartTime DESC");
    if ($sqlgbl && mysql_num_rows($sqlgbl) > 0) {
        while($sqllybl = mysql_fetch_assoc($sqlgbl))
        {
            $user_id_escaped = mysql_real_escape_string($sqllybl['Id']);
            // Tentar buscar IP em gunwcuser primeiro, depois user
            $sqllip = @mysql_query("SELECT IP FROM gunwcuser WHERE Id='$user_id_escaped'");
            $sqllyip = mysql_fetch_assoc($sqllip);
            if (!$sqllyip) {
                $sqllip = @mysql_query("SELECT IP FROM user WHERE Id='$user_id_escaped'");
                $sqllyip = mysql_fetch_assoc($sqllip);
            }
            $ip = $sqllyip['IP'] ?? 'N/A';
            
            $sqlres = mysql_query("SELECT RestrictTime, Authority FROM gunwcuser WHERE Id='$user_id_escaped'");
            $sqllyres = mysql_fetch_assoc($sqlres);
            $restrict = $sqllyres['RestrictTime'] ?? 'N/A';
            $authority = $sqllyres['Authority'] ?? 0;
            
            echo '<tr class="row2">
                <td><a style="color: #AA0000;" class="username-coloured">'.htmlspecialchars($sqllybl['Id']).'</a></td>
                <td style="text-align: center;">'.htmlspecialchars($ip).'</td>';
            if($authority == -100) { 
                echo '<td style="text-align: center;"><font color="red">Banimento Permanente</font></td>'; 
            } else { 
                echo '<td style="text-align: center;">'.htmlspecialchars($restrict).'</td>'; 
            }
            echo '<td><strong>'.htmlspecialchars($sqllybl['Reason'] ?? 'N/A').'</strong></td>
                <td><strong>'.htmlspecialchars($sqllybl['Judge'] ?? 'N/A').'</strong></td>
            </tr>'; 
        }
    } else {
        echo '<tr class="row2"><td colspan="5" style="text-align: center;">Nenhum log de banimento disponível.</td></tr>';
    }
    ?>
		
		</tbody>

		</table>
</div> 
				</div>
       

			<span class="corners-bottom"><span></span></span>
			<div class="clear"></div>
		</div>
		</div>
	</div>
<?php include("footer.php"); ?>