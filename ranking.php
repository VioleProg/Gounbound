<?php
require_once 'config.php';
require_once 'includes/functions.php';

$page_title = 'Ranking';
include 'includes/header.php';

// Paginação
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 20;
$offset = ($page - 1) * $per_page;

$users = getAllUsers($per_page, $offset);
$total_users = countUsers();
$total_pages = ceil($total_users / $per_page);
?>

<main class="main-content">
    <div class="container">
        <h1 class="page-title">Ranking</h1>
        
        <div class="ranking-table-container">
            <table class="ranking-table">
                <thead>
                    <tr>
                        <th>Posição</th>
                        <th>Nickname</th>
                        <th>Pontos</th>
                        <th>Gold</th>
                        <th>Rank</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhum jogador encontrado</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $index => $user): ?>
                            <tr>
                                <td><?php echo $offset + $index + 1; ?></td>
                                <td><strong><?php echo htmlspecialchars($user['Nickname'] ?? $user['NickName'] ?? 'N/A'); ?></strong></td>
                                <td><?php echo number_format($user['TotalScore']); ?></td>
                                <td><?php echo number_format($user['Money']); ?></td>
                                <td>#<?php echo $user['TotalRank']; ?></td>
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

<?php include 'includes/footer.php'; ?>

