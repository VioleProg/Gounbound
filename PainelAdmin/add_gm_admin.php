<?php 
include("header.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = mysql_real_escape_string($_POST['user_id'] ?? '');
    $authority = (int)($_POST['authority'] ?? 98);
    
    if (empty($user_id)) {
        $error = 'ID do usuário é obrigatório!';
    } else {
        // Verificar se usuário existe
        $check = mysql_query("SELECT Id FROM gunwcuser WHERE Id='$user_id'");
        if (mysql_num_rows($check) == 0) {
            $error = 'Usuário não encontrado!';
        } else {
            // Atualizar authority
            $update = mysql_query("UPDATE gunwcuser SET Authority = $authority, Authority2 = $authority WHERE Id = '$user_id'");
            
            if ($update) {
                $authority_name = $authority >= 100 ? 'Administrador' : ($authority >= 98 ? 'Game Master' : 'Usuário');
                $success = "Usuário <strong>$user_id</strong> agora é <strong>$authority_name</strong> (Authority: $authority)";
            } else {
                $error = 'Erro ao atualizar authority: ' . mysql_error();
            }
        }
    }
}

// Buscar usuários com authority
$admins = [];
$result = @mysql_query("SELECT g.Id, g.Nickname, gw.Authority FROM game g 
                        JOIN gunwcuser gw ON g.Id = gw.Id 
                        WHERE gw.Authority >= 98 
                        ORDER BY gw.Authority DESC, g.Nickname ASC 
                        LIMIT 50");
if ($result) {
    while ($row = mysql_fetch_assoc($result)) {
        $admins[] = $row;
    }
}
?>

<a name="maincontent"></a>

<h1>Adicionar GM ou Admin</h1>
    <p>Defina o nível de autoridade de um usuário (GM = 98, Admin = 100).</p>
    
    <?php if ($success): ?>
        <div class="success-message">
            <i class="fas fa-check-circle"></i> <?php echo $success; ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="error-message">
            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2rem;">
        <!-- Formulário -->
        <div class="admin-section">
            <h2>Definir Authority</h2>
            <form method="post" style="padding: 1.5rem;">
                <dl>
                    <dt><label for="user_id">ID do Usuário:</label></dt>
                    <dd>
                        <input type="text" id="user_id" name="user_id" required 
                               placeholder="Digite o ID do usuário"
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="authority">Nível de Authority:</label></dt>
                    <dd>
                        <select id="authority" name="authority" style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                            <option value="1">Usuário Normal (1)</option>
                            <option value="98" selected>Game Master (98)</option>
                            <option value="100">Administrador (100)</option>
                        </select>
                        <small style="color: var(--admin-text-light); display: block; margin-top: 0.5rem;">
                            <strong>98</strong> = Game Master (acesso ao painel admin)<br>
                            <strong>100</strong> = Administrador (acesso total)
                        </small>
                    </dd>
                </dl>
                
                <p style="margin-top: 1rem;">
                    <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                                 color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                                 border-radius: 8px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-user-shield"></i> Definir Authority
                    </button>
                </p>
            </form>
        </div>
        
        <!-- Lista de Admins/GMs -->
        <div class="admin-section">
            <h2>Usuários com Authority</h2>
            <div style="padding: 1.5rem; max-height: 500px; overflow-y: auto;">
                <?php if (count($admins) > 0): ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nickname</th>
                                <th>Authority</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($admins as $admin): 
                                $type = $admin['Authority'] >= 100 ? 'Admin' : 'GM';
                                $type_color = $admin['Authority'] >= 100 ? '#ef4444' : '#f59e0b';
                            ?>
                                <tr>
                                    <td><a href="account.php?search=<?php echo urlencode($admin['Id']); ?>"><?php echo htmlspecialchars($admin['Id']); ?></a></td>
                                    <td><?php echo htmlspecialchars($admin['Nickname']); ?></td>
                                    <td><?php echo $admin['Authority']; ?></td>
                                    <td>
                                        <span style="padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; font-weight: 600;
                                                    background: <?php echo $type == 'Admin' ? '#fee2e2' : '#fef3c7'; ?>; 
                                                    color: <?php echo $type_color; ?>;">
                                            <?php echo $type; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center; color: var(--admin-text-light); padding: 2rem;">
                        <i class="fas fa-info-circle"></i> Nenhum GM/Admin encontrado.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <p style="margin-top: 2rem;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>

