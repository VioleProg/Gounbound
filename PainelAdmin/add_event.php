<?php 
include("header.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysql_real_escape_string($_POST['title'] ?? '');
    $text = mysql_real_escape_string($_POST['text'] ?? '');
    $text2 = mysql_real_escape_string($_POST['text2'] ?? '');
    $date = mysql_real_escape_string($_POST['date'] ?? date('Y-m-d'));
    $author = $_SESSION['user_id'] ?? $_SESSION['user'] ?? 'Admin';
    
    if (empty($title) || empty($text)) {
        $error = 'Título e texto são obrigatórios!';
    } else {
        $insert = mysql_query("INSERT INTO gbevents (Title, Text, Text2, Date, Author, Comments) 
                               VALUES ('$title', '$text', '$text2', '$date', '$author', 0)");
        
        if ($insert) {
            $success = "Evento criado com sucesso!";
        } else {
            $error = 'Erro ao criar evento: ' . mysql_error();
        }
    }
}

// Listar eventos
$events = [];
$result = @mysql_query("SELECT * FROM gbevents ORDER BY Date DESC LIMIT 20");
if ($result) {
    while ($row = mysql_fetch_assoc($result)) {
        $events[] = $row;
    }
}
?>

<a name="maincontent"></a>

<h1>Adicionar Evento</h1>
    <p>Crie e gerencie eventos do jogo.</p>
    
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
            <h2>Criar Novo Evento</h2>
            <form method="post" style="padding: 1.5rem;">
                <dl>
                    <dt><label for="title">Título: *</label></dt>
                    <dd>
                        <input type="text" id="title" name="title" required maxlength="135" 
                               placeholder="Título do evento"
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="date">Data do Evento:</label></dt>
                    <dd>
                        <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" 
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="text">Descrição Principal: *</label></dt>
                    <dd>
                        <textarea id="text" name="text" required rows="8" 
                                  placeholder="Descrição do evento"
                                  style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px; font-family: inherit;"></textarea>
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="text2">Descrição Secundária (opcional):</label></dt>
                    <dd>
                        <textarea id="text2" name="text2" rows="4" 
                                  placeholder="Informações adicionais"
                                  style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px; font-family: inherit;"></textarea>
                    </dd>
                </dl>
                
                <p style="margin-top: 1rem;">
                    <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                                 color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                                 border-radius: 8px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-calendar-alt"></i> Criar Evento
                    </button>
                </p>
            </form>
        </div>
        
        <!-- Lista de Eventos -->
        <div class="admin-section">
            <h2>Eventos Recentes</h2>
            <div style="padding: 1.5rem; max-height: 600px; overflow-y: auto;">
                <?php if (count($events) > 0): ?>
                    <?php foreach ($events as $item): ?>
                        <div style="padding: 1rem; margin-bottom: 1rem; background: var(--admin-bg); border-radius: 8px; border-left: 4px solid var(--admin-secondary);">
                            <h3 style="margin: 0 0 0.5rem 0; font-size: 1rem; color: var(--admin-secondary);">
                                <?php echo htmlspecialchars($item['Title']); ?>
                            </h3>
                            <p style="margin: 0; font-size: 0.85rem; color: var(--admin-text-light);">
                                <i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($item['Date'])); ?> | 
                                <i class="fas fa-user"></i> <?php echo htmlspecialchars($item['Author']); ?>
                            </p>
                            <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: var(--admin-text);">
                                <?php echo htmlspecialchars(substr($item['Text'], 0, 100)) . '...'; ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: var(--admin-text-light); padding: 2rem;">
                        <i class="fas fa-info-circle"></i> Nenhum evento criado ainda.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <p style="margin-top: 2rem;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>

