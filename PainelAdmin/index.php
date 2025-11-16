<?php 
// Redirecionar para o novo painel administrativo
header("Location: admin_panel.php");
exit;
?>
         <br />

         <p>Welcome to the administration backend. You can find tools for managing the game, server,
            website, and all the configurations. Depending on your given priviledges, you will only
            be able to access certain controls within the Administration Control Panel.</p>

	
		<div class="errorbox notice">
		Hello, Ban&Suspension now works. Make sure you your ban is at least 21 hours long. - Aaron 	
		</div>
	

	<table width='100%' cellspacing="1">

		<caption>Server Statistics</caption>
		<col class="col1" /><col class="col2" /><col class="col1" /><col class="col2" />
	<thead>
	<tr>
		<th>Statistic</th>
		<th>Value</th>

		<th>Statistic</th>

		<th>Value</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td>Registered users: </td>

		<td><strong><?php 
		$result = mysql_query("SELECT COUNT(*) as total FROM `game`");
		$row = mysql_fetch_assoc($result);
		echo $row['total'] ?? 0;
		?></strong></td>

		<td>Server version: </td>
		<td><strong>556</strong></td>
	</tr>
	<tr>
		<td>Inactive users: </td>
		<td><strong><?php 
		$result = mysql_query("SELECT COUNT(*) as total FROM `game` WHERE LastUpdateTime='0000-00-00 00:00:00' OR LastUpdateTime IS NULL");
		$row = mysql_fetch_assoc($result);
		echo $row['total'] ?? 0;
		?></strong></td>

		<td>Website version: </td>
		<td><strong>1.1</strong></td>
	</tr>
	<tr>
		<td>Users online: </td>
		<td><strong><?php 
		// Verificar se a tabela currentuser existe
		$result = @mysql_query("SELECT COUNT(*) as total FROM `currentuser`");
		if ($result) {
			$row = mysql_fetch_assoc($result);
			echo $row['total'] ?? 0;
		} else {
			echo "0";
		}
		?></strong></td>
		<td>Database Version: </td>

		<td><strong>1.0.2100</strong></td>
	</tr>
	<tr>
		<td>Staff members: </td>
		<td><strong><?php 
		// Authority está apenas em gunwcuser (tabela principal)
		$result = mysql_query("SELECT COUNT(*) as total FROM `gunwcuser` WHERE Authority >= 98");
		$row = mysql_fetch_assoc($result);
		echo $row['total'] ?? 0;
		?></strong></td>
		<td>Client Version: </td>

		<td><strong>5.85</strong></td>

	</tr>


	<tr>
		<td>Server Status: </td>
		<td><strong></strong></td>
		<td>Database version: </td>

		<td><strong>MySQL 5.1.36-community-log</strong></td>

	</tr>
	<tr>
		<td>Total Servers: </td>
		<td><strong>12</strong></td>
		<td>Database size: </td>

		<td><strong>1.1 MiB</strong></td>
	</tr>
        </tbody>
	</table>
<?php 
if(isset($_POST['submitnote'])){
    $note = isset($_POST['add_note']) ? mysql_real_escape_string($_POST['add_note']) : '';
    if($note){
        if((strlen($note)>20) || (strlen($note)<2)){
            die("<script>alert('Note char limit: 2~20'); history.back();</script>");
        } 
        // Aqui você pode salvar a nota no banco de dados se necessário
        echo "<script>alert('Note has been posted!'); history.back();</script>";
    } else { 
        echo "<script>alert('Insert a note'); history.back();</script>"; 
    }
}
?>
	
                <h2>Staff Notes</h2>
<p>Notes and general chatting between staff can be done with this.</p>

<table width='100%' cellspacing="1">
    <thead>
        <tr>

            <th>Username</th>
            <th>Date</th>
            <th>Message</th>
        </tr>
    </thead>
        <form method="post">
        <td colspan='5' style='text-align: center;'>

            <input id="note" name="add_note" size="50"/>
            <input class="button1" type="submit" id="submit" name="submitnote" value="Post Note" />
        </td>
    </form>
</tr>
</tbody>
</table>

<?php 
$user_id = $_SESSION['user_id'] ?? $_SESSION['user'] ?? '';
// Authority está em gunwcuser (tabela principal)
$sqlauth = mysql_query("SELECT Authority FROM gunwcuser WHERE Id='".mysql_real_escape_string($user_id)."'");
$sqllyauth = mysql_fetch_assoc($sqlauth);

$adminauth = $sqllyauth['Authority'] ?? 0;
if($adminauth > 100) { 

  echo "<h2>Logged GM Actions</h2>

		<p>This gives an overview of the last five actions carried out by game masters. A full copy of the log can be viewed from the appropriate menu item or following the link below.</p>

		<div style='text-align: right;'><a href='#'>&raquo; View ALL Logs</a></div>

		<table width='100%' cellspacing='1'>
		<thead>
		<tr>
			<th>GM Login</th>

			<th>IP Address</th>
			<th>Time</th>
			<th>Action</th>
			
		</tr>
		</thead>
		<tbody>";
    // Verificar se a tabela gmlog existe
    $sqlgbl = @mysql_query("SELECT * FROM gmlog ORDER BY Time DESC LIMIT 5");
    if ($sqlgbl && mysql_num_rows($sqlgbl) > 0) {
        while($sqllybl = mysql_fetch_assoc($sqlgbl))
        {
            echo '<tr class="row2">
                <td><a style="color: #AA0000;" class="username-coloured">'.htmlspecialchars($sqllybl["Username"] ?? 'N/A').'</a></td>
                <td style="text-align: center;">'.htmlspecialchars($sqllybl["IP"] ?? 'N/A').'</td>
                <td style="text-align: center;">'.htmlspecialchars($sqllybl["Time"] ?? 'N/A').'</td>
                <td><strong>'.htmlspecialchars($sqllybl["Action"] ?? 'N/A').'</strong></td>
            </tr>';
        }
    } else {
        echo '<tr class="row2"><td colspan="4" style="text-align: center;">No GM logs available.</td></tr>';
    }
		echo '</tbody>

		</table>

		<br />';
} ?>
	</div>
				</div>
			<span class="corners-bottom"><span></span></span>
			<div class="clear"></div>
		</div>

		</div>
	</div>
<?php include("footer.php");