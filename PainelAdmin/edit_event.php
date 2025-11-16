<?php 
include("header.php");

$success = '';
$error = '';
$event_item = null;

// Buscar evento para editar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $event_id = (int)$_GET['id'];
    $result = mysql_query("SELECT * FROM gbevents WHERE Id = $event_id");
    if ($result && mysql_num_rows($result) > 0) {
        $event_item = mysql_fetch_assoc($result);
    } else {
        $error = 'Evento não encontrado!';
    }
} else {
    $error = 'ID do evento não fornecido!';
}

// Processar atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $event_item) {
    $event_id = (int)$_POST['id'];
    $title = mysql_real_escape_string($_POST['title'] ?? '');
    $text = mysql_real_escape_string($_POST['text'] ?? '');
    $text2 = mysql_real_escape_string($_POST['text2'] ?? '');
    $date = mysql_real_escape_string($_POST['date'] ?? date('Y-m-d'));
    
    if (empty($title) || empty($text)) {
        $error = 'Título e descrição são obrigatórios!';
    } else {
        $update = mysql_query("UPDATE gbevents SET Title = '$title', Text = '$text', Text2 = '$text2', Date = '$date' WHERE Id = $event_id");
        
        if ($update) {
            $success = "Evento atualizado com sucesso!";
            // Recarregar dados atualizados
            $result = mysql_query("SELECT * FROM gbevents WHERE Id = $event_id");
            if ($result && mysql_num_rows($result) > 0) {
                $event_item = mysql_fetch_assoc($result);
            }
        } else {
            $error = 'Erro ao atualizar evento: ' . mysql_error();
        }
    }
}

if (!$event_item && !$error) {
    $error = 'Evento não encontrado!';
}
?>

<a name="maincontent"></a>

<h1>Editar Evento</h1>
    <p>Edite os detalhes do evento.</p>
    
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
    
    <?php if ($event_item): ?>
    <div class="admin-section" style="margin-top: 2rem;">
        <h2>Editar Evento</h2>
        <form method="post" style="padding: 1.5rem;">
            <input type="hidden" name="id" value="<?php echo $event_item['Id']; ?>">
            
            <dl>
                <dt><label for="title">Título: *</label></dt>
                <dd>
                    <input type="text" id="title" name="title" required maxlength="135" 
                           value="<?php echo htmlspecialchars($event_item['Title']); ?>"
                           placeholder="Título do evento"
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            
            <dl>
                <dt><label for="date">Data do Evento:</label></dt>
                <dd>
                    <input type="date" id="date" name="date" 
                           value="<?php echo date('Y-m-d', strtotime($event_item['Date'])); ?>"
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            
            <dl>
                <dt><label for="text">Descrição Principal: *</label></dt>
                <dd>
                    <textarea id="text" name="text" required rows="8" 
                              placeholder="Descrição do evento"
                              style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px; font-family: inherit;"><?php echo htmlspecialchars($event_item['Text']); ?></textarea>
                </dd>
            </dl>
            
            <dl>
                <dt><label for="text2">Descrição Secundária (opcional):</label></dt>
                <dd>
                    <textarea id="text2" name="text2" rows="4" 
                              placeholder="Informações adicionais"
                              style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px; font-family: inherit;"><?php echo htmlspecialchars($event_item['Text2']); ?></textarea>
                </dd>
            </dl>
            
            <p style="margin-top: 1rem; display: flex; gap: 1rem;">
                <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                             color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                             border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-save"></i> Salvar Alterações
                </button>
                <a href="add_event.php" class="button1" style="padding: 0.75rem 1.5rem; display: inline-block;">
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

