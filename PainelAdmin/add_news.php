<?php 
include("header.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysql_real_escape_string($_POST['title'] ?? '');
    $text = mysql_real_escape_string($_POST['text'] ?? '');
    $text2 = mysql_real_escape_string($_POST['text2'] ?? '');
    $author = $_SESSION['user_id'] ?? $_SESSION['user'] ?? 'Admin';
    
    if (empty($title) || empty($text)) {
        $error = 'Título e texto são obrigatórios!';
    } else {
        $insert = mysql_query("INSERT INTO gbnews (Title, Text, Text2, Date, Author, Comments) 
                               VALUES ('$title', '$text', '$text2', NOW(), '$author', 0)");
        
        if ($insert) {
            $success = "Notícia criada com sucesso!";
        } else {
            $error = 'Erro ao criar notícia: ' . mysql_error();
        }
    }
}

// Processar ações de deletar
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    $delete = mysql_query("DELETE FROM gbnews WHERE Id = $delete_id");
    if ($delete) {
        $success = "Notícia deletada com sucesso!";
    } else {
        $error = 'Erro ao deletar notícia: ' . mysql_error();
    }
}

// Listar notícias
$news = [];
$result = @mysql_query("SELECT * FROM gbnews ORDER BY Date DESC LIMIT 20");
if ($result) {
    while ($row = mysql_fetch_assoc($result)) {
        $news[] = $row;
    }
}
?>

<a name="maincontent"></a>

<h1>Adicionar Notícia</h1>
    <p>Crie e gerencie notícias do site.</p>
    
    <?php if ($success): ?>
        <div class="success-message">
            <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
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
            <h2>Criar Nova Notícia</h2>
            <form method="post" style="padding: 1.5rem;">
                <dl>
                    <dt><label for="title">Título: *</label></dt>
                    <dd>
                        <input type="text" id="title" name="title" required maxlength="135" 
                               placeholder="Título da notícia"
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="text">Conteúdo Principal: *</label></dt>
                    <dd>
                        <textarea id="text" name="text" required rows="8" 
                                  placeholder="Conteúdo da notícia"
                                  style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px; font-family: inherit;"></textarea>
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="text2">Conteúdo Secundário (opcional):</label></dt>
                    <dd>
                        <textarea id="text2" name="text2" rows="4" 
                                  placeholder="Conteúdo adicional"
                                  style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px; font-family: inherit;"></textarea>
                    </dd>
                </dl>
                
                <p style="margin-top: 1rem;">
                    <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                                 color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                                 border-radius: 8px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-file-alt"></i> Criar Notícia
                    </button>
                </p>
            </form>
        </div>
        
        <!-- Lista de Notícias -->
        <div class="admin-section">
            <h2>Notícias Recentes</h2>
            <div style="padding: 1.5rem; max-height: 600px; overflow-y: auto;">
                <?php if (count($news) > 0): ?>
                    <?php foreach ($news as $item): ?>
                        <div style="padding: 1rem; margin-bottom: 1rem; background: var(--admin-bg); border-radius: 8px; border-left: 4px solid var(--admin-primary);">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                <h3 style="margin: 0; font-size: 1rem; color: var(--admin-primary); flex: 1;">
                                    <?php echo htmlspecialchars($item['Title']); ?>
                                </h3>
                                <div style="display: flex; gap: 0.5rem; margin-left: 1rem;">
                                    <a href="edit_news.php?id=<?php echo $item['Id']; ?>" 
                                       style="padding: 0.4rem 0.8rem; background: var(--admin-primary); color: #fff; 
                                              border-radius: 6px; text-decoration: none; font-size: 0.85rem;
                                              display: inline-flex; align-items: center; gap: 0.3rem;"
                                       title="Editar">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <a href="?delete=<?php echo $item['Id']; ?>" 
                                       onclick="return confirm('Tem certeza que deseja deletar esta notícia?');"
                                       style="padding: 0.4rem 0.8rem; background: #dc3545; color: #fff; 
                                              border-radius: 6px; text-decoration: none; font-size: 0.85rem;
                                              display: inline-flex; align-items: center; gap: 0.3rem;"
                                       title="Deletar">
                                        <i class="fas fa-trash"></i> Deletar
                                    </a>
                                </div>
                            </div>
                            <p style="margin: 0; font-size: 0.85rem; color: var(--admin-text-light);">
                                <i class="fas fa-calendar"></i> <?php echo date('d/m/Y H:i', strtotime($item['Date'])); ?> | 
                                <i class="fas fa-user"></i> <?php echo htmlspecialchars($item['Author']); ?>
                            </p>
                            <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: var(--admin-text);">
                                <?php echo htmlspecialchars(substr($item['Text'], 0, 100)) . '...'; ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: var(--admin-text-light); padding: 2rem;">
                        <i class="fas fa-info-circle"></i> Nenhuma notícia criada ainda.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <p style="margin-top: 2rem;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>

