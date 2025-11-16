<?php 
include("header.php"); 
include("../mesh.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $user_id = mysql_real_escape_string($_POST['user_id'] ?? '');
    
    if ($action === 'unban' && !empty($user_id)) {
        $update = mysql_query("UPDATE gunwcuser SET Status = '1', Authority = '1' WHERE Id = '$user_id' AND (Status = '0' OR Authority = '-100')");
        
        if ($update && mysql_affected_rows() > 0) {
            $success = "Usuário desbanido com sucesso!";
        } else {
            $error = 'Usuário não encontrado ou já está desbanido!';
        }
    }
}

// Buscar usuários banidos
$banned_users = [];
$result = mysql_query("SELECT Id, NickName, user, IP, Status, Authority FROM gunwcuser WHERE Status = '0' OR Authority = '-100' ORDER BY Id");
while ($row = mysql_fetch_assoc($result)) {
    $banned_users[] = $row;
}
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Desbanear Usuários</h1>
    
    <?php if ($success): ?>
        <div style="background: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 5px;">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 5px;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <p>Total de usuários banidos: <strong><?php echo count($banned_users); ?></strong></p>
    
    <table width='100%' cellspacing="1">
        <caption>Usuários Banidos</caption>
        <thead>
            <tr>
                <th>ID do Usuário</th>
                <th>Nickname</th>
                <th>Username</th>
                <th>IP</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($banned_users) > 0) {
                foreach ($banned_users as $user) {
                    $status_text = ($user['Authority'] == '-100') ? 'Banido Permanentemente' : 'Banido';
                    echo '<tr class="row2">';
                    echo '<td>' . htmlspecialchars($user['Id']) . '</td>';
                    echo '<td>' . htmlspecialchars($user['NickName'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($user['user'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($user['IP'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($status_text) . '</td>';
                    echo '<td>';
                    echo '<form method="post" style="display: inline;" onsubmit="return confirm(\'Tem certeza que deseja desbanir este usuário?\');">';
                    echo '<input type="hidden" name="action" value="unban">';
                    echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($user['Id']) . '">';
                    echo '<input type="submit" value="Desbanear" class="button1" style="background: #28a745; color: white;">';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6" style="text-align: center;">Nenhum usuário banido encontrado.</td></tr>';
            }
            ?>
        </tbody>
    </table>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>
</div>

<?php include("footer.php"); ?>

