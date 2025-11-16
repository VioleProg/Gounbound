<?php 
// verify.php já é incluído em header.php
include("header.php"); 
include("../mesh.php");

// Paginação
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 50;
$offset = ($page - 1) * $per_page;

// Buscar logs
$search = mysql_real_escape_string($_GET['search'] ?? '');
$where = "1=1";
if ($search) {
    $where .= " AND (Id LIKE '%$search%')";
}

$sql = "SELECT * FROM loginlog 
        WHERE $where 
        ORDER BY Time DESC 
        LIMIT $offset, $per_page";

$result = mysql_query($sql);

// Contar total
$count_sql = "SELECT COUNT(*) as total FROM loginlog WHERE $where";
$count_result = mysql_query($count_sql);
$count_row = mysql_fetch_assoc($count_result);
$total = $count_row['total'] ?? 0;
$total_pages = ceil($total / $per_page);

// Função para converter IP
function intToIP($int) {
    return long2ip($int);
}
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Logs de Login</h1>
    <p>Visualize os logs de login dos usuários.</p>
    
    <!-- Busca -->
    <form method="get" action="" style="margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Buscar por ID de usuário..." 
               value="<?php echo htmlspecialchars($search); ?>" style="width: 400px; padding: 5px;">
        <input type="submit" value="Buscar" class="button1">
        <?php if ($search): ?>
            <a href="login_logs.php" class="button1">Limpar</a>
        <?php endif; ?>
    </form>
    
    <!-- Estatísticas -->
    <div style="margin-bottom: 20px; padding: 10px; background: #f0f0f0; border: 1px solid #ddd;">
        <strong>Total de logs:</strong> <?php echo $total; ?>
    </div>
    
    <!-- Lista de Logs -->
    <table width='100%' cellspacing="1" class="admin-table">
        <caption>Logs de Login (Página <?php echo $page; ?> de <?php echo $total_pages; ?>)</caption>
        <thead>
            <tr>
                <th>ID do Usuário</th>
                <th>IP</th>
                <th>Porta</th>
                <th>IP do Servidor</th>
                <th>Porta do Servidor</th>
                <th>País</th>
                <th>Data/Hora</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && mysql_num_rows($result) > 0) {
                while ($log = mysql_fetch_assoc($result)) {
                    $ip = intToIP($log['Ip'] ?? 0);
                    $server_ip = intToIP($log['ServerIP'] ?? 0);
                    
                    echo '<tr class="row2">';
                    echo '<td><a href="account.php?search=' . htmlspecialchars($log['Id']) . '">' . htmlspecialchars($log['Id']) . '</a></td>';
                    echo '<td>' . htmlspecialchars($ip) . '</td>';
                    echo '<td>' . htmlspecialchars($log['Port'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($server_ip) . '</td>';
                    echo '<td>' . htmlspecialchars($log['ServerPort'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($log['Country'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($log['Time'] ?? 'N/A') . '</td>';
                    echo '<td>';
                    echo '<a href="account.php?search=' . htmlspecialchars($log['Id']) . '" class="button1" style="background: #007bff; color: white; padding: 3px 10px; text-decoration: none; border-radius: 4px;">Ver Conta</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="8" style="text-align: center;">Nenhum log encontrado.</td></tr>';
            }
            ?>
        </tbody>
    </table>
    
    <!-- Paginação -->
    <?php if ($total_pages > 1): ?>
        <div style="text-align: center; margin: 20px 0;">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo ($page - 1); ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="button1">« Anterior</a>
            <?php endif; ?>
            
            <?php
            $start = max(1, $page - 2);
            $end = min($total_pages, $page + 2);
            for ($i = $start; $i <= $end; $i++):
            ?>
                <a href="?page=<?php echo $i; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" 
                   class="button1" style="<?php echo $i == $page ? 'background: #007bff; color: white;' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo ($page + 1); ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="button1">Próxima »</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>
</div>

<?php include("footer.php"); ?>

