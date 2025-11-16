<?php 
include("header.php");

$success = '';
$error = '';
$news_item = null;

// Buscar notícia para editar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $news_id = (int)$_GET['id'];
    $result = mysql_query("SELECT * FROM gbnews WHERE Id = $news_id");
    if ($result && mysql_num_rows($result) > 0) {
        $news_item = mysql_fetch_assoc($result);
    } else {
        $error = 'Notícia não encontrada!';
    }
} else {
    $error = 'ID da notícia não fornecido!';
}

// Processar atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $news_item) {
    $news_id = (int)$_POST['id'];
    $title = mysql_real_escape_string($_POST['title'] ?? '');
    $text = mysql_real_escape_string($_POST['text'] ?? '');
    $text2 = mysql_real_escape_string($_POST['text2'] ?? '');
    
    if (empty($title) || empty($text)) {
        $error = 'Título e texto são obrigatórios!';
    } else {
        $update = mysql_query("UPDATE gbnews SET Title = '$title', Text = '$text', Text2 = '$text2' WHERE Id = $news_id");
        
        if ($update) {
            $success = "Notícia atualizada com sucesso!";
            // Recarregar dados atualizados
            $result = mysql_query("SELECT * FROM gbnews WHERE Id = $news_id");
            if ($result && mysql_num_rows($result) > 0) {
                $news_item = mysql_fetch_assoc($result);
            }
        } else {
            $error = 'Erro ao atualizar notícia: ' . mysql_error();
        }
    }
}

if (!$news_item && !$error) {
    $error = 'Notícia não encontrada!';
}
?>

<a name="maincontent"></a>

<h1>Editar Notícia</h1>
    <p>Edite os detalhes da notícia.</p>
    
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
    
    <?php if ($news_item): ?>
    <div class="admin-section" style="margin-top: 2rem;">
        <h2>Editar Notícia</h2>
        <form method="post" style="padding: 1.5rem;">
            <input type="hidden" name="id" value="<?php echo $news_item['Id']; ?>">
            
            <dl>
                <dt><label for="title">Título: *</label></dt>
                <dd>
                    <input type="text" id="title" name="title" required maxlength="135" 
                           value="<?php echo htmlspecialchars($news_item['Title']); ?>"
                           placeholder="Título da notícia"
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            
            <dl>
                <dt><label for="text">Conteúdo Principal: *</label></dt>
                <dd>
                    <textarea id="text" name="text" required rows="8" 
                              placeholder="Conteúdo da notícia"
                              style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px; font-family: inherit;"><?php echo htmlspecialchars($news_item['Text']); ?></textarea>
                </dd>
            </dl>
            
            <dl>
                <dt><label for="text2">Conteúdo Secundário (opcional):</label></dt>
                <dd>
                    <textarea id="text2" name="text2" rows="4" 
                              placeholder="Conteúdo adicional"
                              style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px; font-family: inherit;"><?php echo htmlspecialchars($news_item['Text2']); ?></textarea>
                </dd>
            </dl>
            
            <p style="margin-top: 1rem; display: flex; gap: 1rem;">
                <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                             color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                             border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-save"></i> Salvar Alterações
                </button>
                <a href="add_news.php" class="button1" style="padding: 0.75rem 1.5rem; display: inline-block;">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </p>
        </form>
    </div>
    <?php endif; ?>
    
    <p style="margin-top: 2rem;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>

