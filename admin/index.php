<?php
require_once '../config.php';
require_once '../includes/functions.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: ../login.php');
    exit;
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 20;
$offset = ($page - 1) * $per_page;

$users = getAllUsers($per_page, $offset);
$total_users = countUsers();
$total_pages = ceil($total_users / $per_page);

$page_title = 'Painel Admin';
include '../includes/header.php';
?>

<main class="main-content admin-page">
    <div class="container">
        <div class="admin-header">
            <h1 class="page-title">Painel Administrativo</h1>
            <p>Gerenciamento de Contas</p>
        </div>
        
        <div class="admin-stats">
            <div class="admin-stat-card">
                <div class="stat-value"><?php echo number_format($total_users); ?></div>
                <div class="stat-label">Total de Usuários</div>
            </div>
        </div>
        
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nickname</th>
                        <th>Email</th>
                        <th>Pontos</th>
                        <th>Gold</th>
                        <th>Status</th>
                        <th>Autoridade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="8" class="text-center">Nenhum usuário encontrado</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['Id']); ?></td>
                                <td><strong><?php echo htmlspecialchars($user['Nickname'] ?? $user['NickName'] ?? 'N/A'); ?></strong></td>
                                <td><?php echo htmlspecialchars($user['E_Mail'] ?? 'N/A'); ?></td>
                                <td><?php echo number_format($user['TotalScore']); ?></td>
                                <td><?php echo number_format($user['Money']); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $user['Status'] == '1' ? 'active' : 'inactive'; ?>">
                                        <?php echo $user['Status'] == '1' ? 'Ativo' : 'Inativo'; ?>
                                    </span>
                                </td>
                                <td><?php echo $user['Authority']; ?></td>
                                <td class="actions">
                                    <a href="edit.php?id=<?php echo urlencode($user['Id']); ?>" class="btn btn-sm btn-primary">Editar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>" class="btn btn-secondary">Anterior</a>
                <?php endif; ?>
                
                <span>Página <?php echo $page; ?> de <?php echo $total_pages; ?></span>
                
                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?>" class="btn btn-secondary">Próxima</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>

