<?php 
include("header.php"); 
include("../mesh.php");

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 50;
$offset = ($page - 1) * $per_page;

// Buscar histórico de registros ordenado por data
$result = mysql_query("SELECT Id, NickName, user, E_Mail, datareg, Country 
                       FROM gunwcuser 
                       ORDER BY datareg DESC 
                       LIMIT $offset, $per_page");

$count_result = mysql_query("SELECT COUNT(*) as total FROM gunwcuser");
$count_row = mysql_fetch_assoc($count_result);
$total = $count_row['total'] ?? 0;
$total_pages = ceil($total / $per_page);
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Histórico de Registro</h1>
    <p>Total de registros: <strong><?php echo $total; ?></strong></p>
    
    <table width='100%' cellspacing="1">
        <caption>Histórico de Registros (Página <?php echo $page; ?> de <?php echo $total_pages; ?>)</caption>
        <thead>
            <tr>
                <th>ID do Usuário</th>
                <th>Username</th>
                <th>Nickname</th>
                <th>Email</th>
                <th>País</th>
                <th>Data de Registro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && mysql_num_rows($result) > 0) {
                while ($row = mysql_fetch_assoc($result)) {
                    echo '<tr class="row2">';
                    echo '<td><a href="account.php?search=' . htmlspecialchars($row['Id']) . '">' . htmlspecialchars($row['Id']) . '</a></td>';
                    echo '<td>' . htmlspecialchars($row['user'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($row['NickName'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($row['E_Mail'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($row['Country'] ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($row['datareg'] ?? 'N/A') . '</td>';
                    echo '<td><a href="account.php?search=' . htmlspecialchars($row['Id']) . '" class="button1">Ver Detalhes</a></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="7" style="text-align: center;">Nenhum registro encontrado.</td></tr>';
            }
            ?>
        </tbody>
    </table>
    
    <?php if ($total_pages > 1): ?>
        <div style="text-align: center; margin: 20px 0;">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo ($page - 1); ?>" class="button1">« Anterior</a>
            <?php endif; ?>
            
            <?php
            $start = max(1, $page - 2);
            $end = min($total_pages, $page + 2);
            for ($i = $start; $i <= $end; $i++):
            ?>
                <a href="?page=<?php echo $i; ?>" class="button1" style="<?php echo $i == $page ? 'background: #007bff; color: white;' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo ($page + 1); ?>" class="button1">Próxima »</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>
</div>

<?php include("footer.php"); ?>

