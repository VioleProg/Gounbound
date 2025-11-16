<?php 
include("header.php"); 
include("../mesh.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $ip_address = mysql_real_escape_string($_POST['ip_address'] ?? '');
    
    if ($action === 'unban' && !empty($ip_address)) {
        $update = mysql_query("UPDATE gunwcuser SET Status = '1', Authority = '1' WHERE IP = '$ip_address' AND (Status = '0' OR Authority = '-100')");
        
        if ($update && mysql_affected_rows() > 0) {
            $affected = mysql_affected_rows();
            $success = "IP desbanido com sucesso! ($affected usuário(s) afetado(s))";
        } else {
            $error = 'IP não encontrado ou já está desbanido!';
        }
    }
}

// Buscar IPs banidos
$banned_ips = [];
$result = mysql_query("SELECT IP, COUNT(*) as count FROM gunwcuser WHERE (Status = '0' OR Authority = '-100') AND IP IS NOT NULL AND IP != '' GROUP BY IP ORDER BY count DESC");
while ($row = mysql_fetch_assoc($result)) {
    $banned_ips[] = $row;
}
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Desbanear (Reset) IP's</h1>
    
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
    
    <p>Total de IPs banidos: <strong><?php echo count($banned_ips); ?></strong></p>
    
    <table width='100%' cellspacing="1">
        <caption>IPs Banidos</caption>
        <thead>
            <tr>
                <th>Endereço IP</th>
                <th>Usuários Afetados</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($banned_ips) > 0) {
                foreach ($banned_ips as $ip_data) {
                    echo '<tr class="row2">';
                    echo '<td>' . htmlspecialchars($ip_data['IP']) . '</td>';
                    echo '<td>' . htmlspecialchars($ip_data['count']) . '</td>';
                    echo '<td>';
                    echo '<form method="post" style="display: inline;" onsubmit="return confirm(\'Tem certeza que deseja desbanir este IP?\');">';
                    echo '<input type="hidden" name="action" value="unban">';
                    echo '<input type="hidden" name="ip_address" value="' . htmlspecialchars($ip_data['IP']) . '">';
                    echo '<input type="submit" value="Desbanear IP" class="button1" style="background: #28a745; color: white;">';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="3" style="text-align: center;">Nenhum IP banido encontrado.</td></tr>';
            }
            ?>
        </tbody>
    </table>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>
</div>

<?php include("footer.php"); ?>

