<?php 
// verify.php e mesh.php já são incluídos em header.php
include("header.php"); 

// Buscar informações do administrador atual
$user_id = $_SESSION['user_id'] ?? $_SESSION['user'] ?? '';
$admin_info = mysql_fetch_assoc(mysql_query("SELECT * FROM gunwcuser WHERE Id='".mysql_real_escape_string($user_id)."'"));
$admin_nickname = $admin_info['NickName'] ?? $user_id;
$admin_ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$current_authority = (int)($admin_info['Authority'] ?? 0);
$is_gm = ($current_authority == 99);

// Estatísticas rápidas
$total_accounts = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) as total FROM game"))['total'] ?? 0;
$users_online = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) as total FROM currentuser"))['total'] ?? 0;
// Buscar banidos: Authority = -100 (permanente) ou que estão na tabela banlog
$ban_result = mysql_query("SELECT COUNT(DISTINCT Id) as total FROM banlog");
$ban_row = mysql_fetch_assoc($ban_result);
$total_banned = $ban_row['total'] ?? 0;
?>

<a name="maincontent"></a>

<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.75rem; font-weight: 700; color: var(--admin-primary); margin-bottom: 0.5rem;">
        Painel Administrativo
    </h1>
    <p style="color: var(--admin-text-light); font-size: 0.95rem;">Bem-vindo, <strong><?php echo htmlspecialchars($admin_nickname); ?></strong></p>
</div>
    
<!-- Estatísticas -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div class="admin-section" style="text-align: center; padding: 1rem;">
        <div style="font-size: 1.75rem; font-weight: 700; color: var(--admin-primary); margin-bottom: 0.25rem;">
            <?php echo number_format($total_accounts); ?>
        </div>
        <div style="color: var(--admin-text-light); font-weight: 500; font-size: 0.85rem;">Total de Contas</div>
    </div>
    <div class="admin-section" style="text-align: center; padding: 1rem;">
        <div style="font-size: 1.75rem; font-weight: 700; color: #10b981; margin-bottom: 0.25rem;">
            <?php echo number_format($users_online); ?>
        </div>
        <div style="color: var(--admin-text-light); font-weight: 500; font-size: 0.85rem;">Usuários Online</div>
    </div>
    <div class="admin-section" style="text-align: center; padding: 1rem;">
        <div style="font-size: 1.75rem; font-weight: 700; color: #ef4444; margin-bottom: 0.25rem;">
            <?php echo number_format($total_banned); ?>
        </div>
        <div style="color: var(--admin-text-light); font-weight: 500; font-size: 0.85rem;">Contas Banidas</div>
    </div>
</div>
    
<!-- Funcionalidades Principais -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
    <?php if ($is_gm): ?>
        <!-- Menu para GM (Authority = 99) -->
        <div class="admin-section">
            <h2><i class="fas fa-users"></i> Gerenciamento de Contas</h2>
            <div style="padding: 1rem;">
                <a href="create_account.php" class="action-button">
                    <i class="fas fa-user-plus"></i> Criar Conta
                </a>
                <a href="ban.php" class="action-button">
                    <i class="fas fa-ban"></i> Banir Contas
                </a>
            </div>
        </div>
        
        <div class="admin-section">
            <h2><i class="fas fa-coins"></i> Minha Conta</h2>
            <div style="padding: 1rem;">
                <a href="send_avatar.php" class="action-button">
                    <i class="fas fa-user-astronaut"></i> Adicionar Avatar (Minha Conta)
                </a>
                <a href="send_cash.php" class="action-button">
                    <i class="fas fa-dollar-sign"></i> Adicionar Cash (Minha Conta)
                </a>
                <a href="add_gold_cash.php" class="action-button">
                    <i class="fas fa-money-bill-wave"></i> Adicionar Gold/Cash (Minha Conta)
                </a>
            </div>
        </div>
        
        <div class="admin-section">
            <h2><i class="fas fa-newspaper"></i> Conteúdo</h2>
            <div style="padding: 1rem;">
                <a href="add_news.php" class="action-button">
                    <i class="fas fa-file-alt"></i> Adicionar Notícia
                </a>
                <a href="add_event.php" class="action-button">
                    <i class="fas fa-calendar-alt"></i> Adicionar Evento
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Menu completo para Admin (Authority >= 100) -->
        <div class="admin-section">
            <h2><i class="fas fa-users"></i> Gerenciamento de Contas</h2>
            <div style="padding: 1rem;">
                <a href="create_account.php" class="action-button">
                    <i class="fas fa-user-plus"></i> Criar Conta
                </a>
                <a href="user.php" class="action-button">
                    <i class="fas fa-search"></i> Pesquisar Conta
                </a>
                <a href="account.php" class="action-button">
                    <i class="fas fa-edit"></i> Editar Conta
                </a>
                <a href="ban.php" class="action-button">
                    <i class="fas fa-ban"></i> Banir Contas
                </a>
                <a href="add_gm_admin.php" class="action-button">
                    <i class="fas fa-user-shield"></i> Adicionar GM/Admin
                </a>
            </div>
        </div>
        
        <div class="admin-section">
            <h2><i class="fas fa-coins"></i> Recursos e Moedas</h2>
            <div style="padding: 1rem;">
                <a href="send_avatar.php" class="action-button">
                    <i class="fas fa-user-astronaut"></i> Adicionar Avatar
                </a>
                <a href="send_cash.php" class="action-button">
                    <i class="fas fa-dollar-sign"></i> Adicionar Cash
                </a>
                <a href="add_gold_cash.php" class="action-button">
                    <i class="fas fa-money-bill-wave"></i> Adicionar Gold/Cash
                </a>
                <a href="add_gold_cash_all.php" class="action-button">
                    <i class="fas fa-users-cog"></i> Adicionar Gold/Cash (Todos)
                </a>
                <a href="create_token.php" class="action-button">
                    <i class="fas fa-key"></i> Criar Token de Resgate
                </a>
            </div>
        </div>
        
        <div class="admin-section">
            <h2><i class="fas fa-newspaper"></i> Conteúdo</h2>
            <div style="padding: 1rem;">
                <a href="add_news.php" class="action-button">
                    <i class="fas fa-file-alt"></i> Adicionar Notícia
                </a>
                <a href="add_event.php" class="action-button">
                    <i class="fas fa-calendar-alt"></i> Adicionar Evento
                </a>
            </div>
        </div>
        
        <div class="admin-section">
            <h2><i class="fas fa-box"></i> Inventário e Itens</h2>
            <div style="padding: 1rem;">
                <a href="edit_inventory.php" class="action-button">
                    <i class="fas fa-warehouse"></i> Editar Inventário
                </a>
                <a href="edit_account_items.php" class="action-button">
                    <i class="fas fa-cog"></i> Editar Itens da Conta
                </a>
            </div>
        </div>
        
        <div class="admin-section">
            <h2><i class="fas fa-store"></i> Loja e Eventos</h2>
            <div style="padding: 1rem;">
                <a href="manage_store.php" class="action-button">
                    <i class="fas fa-shopping-cart"></i> Gerenciar Loja
                </a>
                <a href="manage_event_store.php" class="action-button">
                    <i class="fas fa-gift"></i> Loja de Eventos
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include("footer.php"); ?>
