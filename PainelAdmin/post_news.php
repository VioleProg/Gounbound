<?php 
include("header.php"); 
include("../mesh.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysql_real_escape_string($_POST['title'] ?? '');
    $content = mysql_real_escape_string($_POST['content'] ?? '');
    $type = mysql_real_escape_string($_POST['type'] ?? 'news');
    
    if (empty($title) || empty($content)) {
        $error = 'Preencha todos os campos!';
    } else {
        $user_id = $_SESSION['user_id'] ?? $_SESSION['user'] ?? '';
        $admin_nick = mysql_fetch_assoc(mysql_query("SELECT NickName FROM gunwcuser WHERE Id='".mysql_real_escape_string($user_id)."'"))['NickName'] ?? 'Admin';
        
        // Verificar se a tabela gbnews existe, caso contrário usar outra
        $table = 'gbnews';
        $insert = @mysql_query("INSERT INTO $table (Title, Text, Date, Author) VALUES ('$title', '$content', NOW(), '$admin_nick')");
        
        if ($insert) {
            $success = "Notícia postada com sucesso!";
        } else {
            $error = 'Erro ao postar notícia! Verifique se a tabela existe.';
        }
    }
}
?>

<div id="main">
    <a name="maincontent"></a>
    
    <h1>Postar Notícia</h1>
    
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
    
    <form method="post" style="max-width: 800px;">
        <fieldset>
            <legend>Postar Notícia</legend>
            
            <dl>
                <dt><label for="type">Tipo:</label></dt>
                <dd>
                    <select id="type" name="type" style="width: 100%; padding: 5px;">
                        <option value="news">Notícia</option>
                        <option value="event">Evento</option>
                        <option value="maintenance">Manutenção</option>
                    </select>
                </dd>
            </dl>
            
            <dl>
                <dt><label for="title">Título:</label></dt>
                <dd><input type="text" id="title" name="title" required style="width: 100%; padding: 5px;"></dd>
            </dl>
            
            <dl>
                <dt><label for="content">Conteúdo:</label></dt>
                <dd><textarea id="content" name="content" required style="width: 100%; padding: 5px; height: 300px;"></textarea></dd>
            </dl>
            
            <p class="quick">
                <input type="submit" value="Postar Notícia" class="button1">
                <a href="admin_panel.php" class="button1">Voltar</a>
            </p>
        </fieldset>
    </form>
</div>

<?php include("footer.php"); ?>

