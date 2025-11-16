<?php
require_once 'config.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user_info = getUserInfo($_SESSION['user_id']);
$user_id = $_SESSION['user_id'];

// Buscar informações completas do usuário
global $conn;

// Buscar imagem de perfil (já vem no getUserInfo)
$profile_image = $user_info['imagem_perfil'] ?? '';

// Buscar login
$stmt = $conn->prepare("SELECT user FROM gunwcuser WHERE Id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$login_result = $stmt->get_result();
$login_data = $login_result->fetch_assoc();
$login = $login_data['user'] ?? $user_id;

$page_title = 'Meu Perfil';
include 'includes/header.php';
?>

<main class="main-content">
    <div class="container">
        <h1 class="page-title">Meu Perfil</h1>
        
        <div class="profile-layout">
            <!-- Informações do Perfil -->
            <div class="profile-info-card">
                <div class="profile-avatar-section">
                    <div class="profile-avatar-wrapper">
                        <?php if ($profile_image): ?>
                            <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Avatar" class="profile-avatar" onerror="this.src='<?php echo $base_path; ?>Assets/images/default-avatar.png'">
                        <?php else: ?>
                            <div class="profile-avatar-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h2 class="profile-name"><?php echo htmlspecialchars($user_info['Nickname'] ?? $user_info['NickName'] ?? 'N/A'); ?></h2>
                    <p class="profile-id">ID: <?php echo htmlspecialchars($user_id); ?></p>
                </div>
                
                <div class="profile-stats-grid">
                    <div class="profile-stat-item">
                        <div class="stat-icon"><i class="fas fa-star"></i></div>
                        <div class="stat-content">
                            <div class="stat-label">Pontos Totais</div>
                            <div class="stat-value"><?php echo number_format($user_info['TotalScore'] ?? 0); ?></div>
                        </div>
                    </div>
                    <div class="profile-stat-item">
                        <div class="stat-icon"><i class="fas fa-coins"></i></div>
                        <div class="stat-content">
                            <div class="stat-label">Gold</div>
                            <div class="stat-value"><?php echo number_format($user_info['Money'] ?? 0); ?></div>
                        </div>
                    </div>
                    <div class="profile-stat-item">
                        <div class="stat-icon"><i class="fas fa-trophy"></i></div>
                        <div class="stat-content">
                            <div class="stat-label">Ranking</div>
                            <div class="stat-value">#<?php echo $user_info['TotalRank'] ?? 0; ?></div>
                        </div>
                    </div>
                    <div class="profile-stat-item">
                        <div class="stat-icon"><i class="fas fa-envelope"></i></div>
                        <div class="stat-content">
                            <div class="stat-label">Email</div>
                            <div class="stat-value"><?php echo htmlspecialchars($user_info['E_Mail'] ?? 'N/A'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Formulários de Edição -->
            <div class="profile-edit-section">
                <div class="edit-tabs">
                    <button class="edit-tab active" onclick="showEditTab('nickname')">
                        <i class="fas fa-user-edit"></i> Nickname
                    </button>
                    <button class="edit-tab" onclick="showEditTab('password')">
                        <i class="fas fa-lock"></i> Senha
                    </button>
                    <button class="edit-tab" onclick="showEditTab('email')">
                        <i class="fas fa-envelope"></i> Email
                    </button>
                    <button class="edit-tab" onclick="showEditTab('avatar')">
                        <i class="fas fa-image"></i> Foto de Perfil
                    </button>
                </div>
                
                <!-- Tab: Nickname -->
                <div class="edit-tab-content active" id="tab-nickname">
                    <div class="edit-form-card">
                        <h3 class="edit-form-title">
                            <i class="fas fa-user-edit"></i> Alterar Nickname
                        </h3>
                        <p class="edit-form-description">
                            Seu nickname atual: <strong><?php echo htmlspecialchars($user_info['Nickname'] ?? $user_info['NickName'] ?? 'N/A'); ?></strong>
                        </p>
                        <form id="editNicknameForm" class="edit-form">
                            <div class="form-group">
                                <label for="new_nickname">Novo Nickname</label>
                                <input type="text" id="new_nickname" name="nickname" required 
                                       maxlength="12" minlength="6" 
                                       pattern="[a-zA-Z0-9]{6,12}" 
                                       placeholder="6-12 caracteres alfanuméricos"
                                       value="<?php echo htmlspecialchars($user_info['Nickname'] ?? $user_info['NickName'] ?? ''); ?>">
                                <small>6-12 caracteres, apenas letras e números</small>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Salvar Alterações
                            </button>
                        </form>
                        <div id="nicknameAlert" class="alert" style="display: none;"></div>
                    </div>
                </div>
                
                <!-- Tab: Senha -->
                <div class="edit-tab-content" id="tab-password">
                    <div class="edit-form-card">
                        <h3 class="edit-form-title">
                            <i class="fas fa-lock"></i> Alterar Senha
                        </h3>
                        <p class="edit-form-description">
                            Para sua segurança, você precisará informar sua senha atual.
                        </p>
                        <form id="editPasswordForm" class="edit-form">
                            <div class="form-group">
                                <label for="current_password">Senha Atual</label>
                                <input type="password" id="current_password" name="current_password" required 
                                       placeholder="Digite sua senha atual">
                            </div>
                            <div class="form-group">
                                <label for="new_password">Nova Senha</label>
                                <input type="password" id="new_password" name="new_password" required 
                                       minlength="6" maxlength="12" 
                                       placeholder="6-12 caracteres">
                                <small>6-12 caracteres</small>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirmar Nova Senha</label>
                                <input type="password" id="confirm_password" name="confirm_password" required 
                                       minlength="6" maxlength="12" 
                                       placeholder="Digite a nova senha novamente">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Alterar Senha
                            </button>
                        </form>
                        <div id="passwordAlert" class="alert" style="display: none;"></div>
                    </div>
                </div>
                
                <!-- Tab: Email -->
                <div class="edit-tab-content" id="tab-email">
                    <div class="edit-form-card">
                        <h3 class="edit-form-title">
                            <i class="fas fa-envelope"></i> Alterar Email
                        </h3>
                        <p class="edit-form-description">
                            Seu email atual: <strong><?php echo htmlspecialchars($user_info['E_Mail'] ?? 'N/A'); ?></strong>
                        </p>
                        <form id="editEmailForm" class="edit-form">
                            <div class="form-group">
                                <label for="new_email">Novo Email</label>
                                <input type="email" id="new_email" name="email" required 
                                       placeholder="seu@email.com"
                                       value="<?php echo htmlspecialchars($user_info['E_Mail'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="confirm_email">Confirmar Email</label>
                                <input type="email" id="confirm_email" name="confirm_email" required 
                                       placeholder="Digite o email novamente">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Alterar Email
                            </button>
                        </form>
                        <div id="emailAlert" class="alert" style="display: none;"></div>
                    </div>
                </div>
                
                <!-- Tab: Foto de Perfil -->
                <div class="edit-tab-content" id="tab-avatar">
                    <div class="edit-form-card">
                        <h3 class="edit-form-title">
                            <i class="fas fa-image"></i> Alterar Foto de Perfil
                        </h3>
                        <p class="edit-form-description">
                            Insira a URL de uma imagem para usar como foto de perfil.
                        </p>
                        <div class="avatar-preview-section">
                            <div class="avatar-preview-wrapper">
                                <?php if ($profile_image): ?>
                                    <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Preview" id="avatarPreview" class="avatar-preview" onerror="this.src='<?php echo $base_path; ?>Assets/images/default-avatar.png'">
                                <?php else: ?>
                                    <div class="avatar-preview-placeholder" id="avatarPreview">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <form id="editAvatarForm" class="edit-form">
                            <div class="form-group">
                                <label for="avatar_url">URL da Imagem</label>
                                <input type="url" id="avatar_url" name="avatar_url" 
                                       placeholder="https://exemplo.com/imagem.jpg"
                                       value="<?php echo htmlspecialchars($profile_image); ?>"
                                       oninput="updateAvatarPreview(this.value)">
                                <small>Cole o link completo da imagem (deve começar com http:// ou https://)</small>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary" onclick="clearAvatar()">
                                    <i class="fas fa-times"></i> Remover Foto
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Salvar Foto
                                </button>
                            </div>
                        </form>
                        <div id="avatarAlert" class="alert" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.profile-layout {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 2rem;
    margin-top: 2rem;
}

.profile-info-card {
    background: var(--bg-white);
    border-radius: 12px;
    padding: 2rem;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    height: fit-content;
}

.profile-avatar-section {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--border-color);
}

.profile-avatar-wrapper {
    margin-bottom: 1rem;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--primary-color);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.profile-avatar-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 3rem;
    border: 4px solid var(--primary-color);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-dark);
    margin: 0.5rem 0;
}

.profile-id {
    color: var(--text-muted);
    font-size: 0.9rem;
    margin: 0;
}

.profile-stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.profile-stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-light);
    border-radius: 8px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.profile-stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.stat-content {
    flex: 1;
}

.stat-label {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin-bottom: 0.25rem;
}

.stat-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-dark);
}

.profile-edit-section {
    background: var(--bg-white);
    border-radius: 12px;
    padding: 2rem;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
}

.edit-tabs {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 2rem;
    border-bottom: 2px solid var(--border-color);
    flex-wrap: wrap;
}

.edit-tab {
    padding: 0.75rem 1.5rem;
    background: transparent;
    border: none;
    border-bottom: 3px solid transparent;
    cursor: pointer;
    font-size: 0.95rem;
    color: var(--text-muted);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.edit-tab:hover {
    color: var(--primary-color);
    background: var(--bg-light);
}

.edit-tab.active {
    color: var(--primary-color);
    border-bottom-color: var(--primary-color);
    font-weight: 600;
}

.edit-tab-content {
    display: none;
}

.edit-tab-content.active {
    display: block;
    animation: fadeIn 0.3s ease;
}

.edit-form-card {
    max-width: 600px;
}

.edit-form-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.edit-form-description {
    color: var(--text-muted);
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
}

.edit-form {
    margin-top: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--text-dark);
}

.form-group input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-group input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
}

.form-group small {
    display: block;
    margin-top: 0.5rem;
    color: var(--text-muted);
    font-size: 0.85rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
}

.btn-secondary {
    background: var(--bg-light);
    color: var(--text-dark);
    border: 1px solid var(--border-color);
}

.btn-secondary:hover {
    background: var(--border-color);
}

.avatar-preview-section {
    margin-bottom: 2rem;
    text-align: center;
}

.avatar-preview-wrapper {
    display: inline-block;
}

.avatar-preview {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--primary-color);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.avatar-preview-placeholder {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 4rem;
    border: 4px solid var(--primary-color);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.alert {
    padding: 1rem;
    border-radius: 6px;
    margin-top: 1rem;
}

.alert.success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert.error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 968px) {
    .profile-layout {
        grid-template-columns: 1fr;
    }
    
    .profile-stats-grid {
        grid-template-columns: 1fr;
    }
    
    .edit-tabs {
        overflow-x: auto;
        flex-wrap: nowrap;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
function showEditTab(tabName) {
    // Esconder todas as tabs
    document.querySelectorAll('.edit-tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    document.querySelectorAll('.edit-tab').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Mostrar tab selecionada
    document.getElementById('tab-' + tabName).classList.add('active');
    event.target.closest('.edit-tab').classList.add('active');
}

function updateAvatarPreview(url) {
    const preview = document.getElementById('avatarPreview');
    if (url && url.trim() !== '') {
        if (preview.tagName === 'IMG') {
            preview.src = url;
        } else {
            const img = document.createElement('img');
            img.src = url;
            img.alt = 'Preview';
            img.className = 'avatar-preview';
            img.onerror = function() {
                this.src = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'Assets/images/default-avatar.png';
            };
            preview.parentNode.replaceChild(img, preview);
        }
    }
}

function clearAvatar() {
    document.getElementById('avatar_url').value = '';
    const preview = document.getElementById('avatarPreview');
    if (preview.tagName === 'IMG') {
        const placeholder = document.createElement('div');
        placeholder.className = 'avatar-preview-placeholder';
        placeholder.id = 'avatarPreview';
        placeholder.innerHTML = '<i class="fas fa-user"></i>';
        preview.parentNode.replaceChild(placeholder, preview);
    }
}

// Form: Nickname
document.getElementById('editNicknameForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('action', 'update_nickname');
    
    const alertDiv = document.getElementById('nicknameAlert');
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Salvando...';
    alertDiv.style.display = 'none';
    
    // Função para restaurar botão
    const restoreButton = () => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    };
    
    // Timeout de segurança: restaurar botão após 10 segundos
    const safetyTimeout = setTimeout(() => {
        console.warn('Timeout de segurança: restaurando botão de nickname');
        restoreButton();
    }, 10000);
    
    fetch((typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/profile_update.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        clearTimeout(safetyTimeout);
        if (!response.ok) {
            throw new Error('Erro HTTP: ' + response.status);
        }
        return response.text();
    })
    .then(text => {
        try {
            const data = JSON.parse(text);
            if (data.success) {
                alertDiv.className = 'alert success';
                alertDiv.textContent = data.message || 'Nickname alterado com sucesso!';
                alertDiv.style.display = 'block';
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                alertDiv.className = 'alert error';
                alertDiv.textContent = data.message || 'Erro ao alterar nickname';
                alertDiv.style.display = 'block';
                restoreButton();
            }
        } catch (e) {
            console.error('Erro ao parsear resposta:', e, text);
            alertDiv.className = 'alert error';
            alertDiv.textContent = 'Erro ao processar resposta do servidor';
            alertDiv.style.display = 'block';
            restoreButton();
        }
    })
    .catch(error => {
        clearTimeout(safetyTimeout);
        console.error('Erro ao enviar requisição:', error);
        alertDiv.className = 'alert error';
        alertDiv.textContent = 'Erro ao processar requisição: ' + error.message;
        alertDiv.style.display = 'block';
        restoreButton();
    });
});

// Form: Password
document.getElementById('editPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (newPassword !== confirmPassword) {
        const alertDiv = document.getElementById('passwordAlert');
        alertDiv.className = 'alert error';
        alertDiv.textContent = 'As senhas não coincidem!';
        alertDiv.style.display = 'block';
        return;
    }
    
    const formData = new FormData(this);
    formData.append('action', 'update_password');
    
    const alertDiv = document.getElementById('passwordAlert');
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Alterando...';
    alertDiv.style.display = 'none';
    
    // Função para restaurar botão
    const restoreButton = () => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    };
    
    // Timeout de segurança: restaurar botão após 10 segundos
    const safetyTimeout = setTimeout(() => {
        console.warn('Timeout de segurança: restaurando botão de senha');
        restoreButton();
    }, 10000);
    
    fetch((typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/profile_update.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        clearTimeout(safetyTimeout);
        if (!response.ok) {
            throw new Error('Erro HTTP: ' + response.status);
        }
        return response.text();
    })
    .then(text => {
        try {
            const data = JSON.parse(text);
            if (data.success) {
                alertDiv.className = 'alert success';
                alertDiv.textContent = data.message || 'Senha alterada com sucesso!';
                alertDiv.style.display = 'block';
                this.reset();
                restoreButton();
            } else {
                alertDiv.className = 'alert error';
                alertDiv.textContent = data.message || 'Erro ao alterar senha';
                alertDiv.style.display = 'block';
                restoreButton();
            }
        } catch (e) {
            console.error('Erro ao parsear resposta:', e, text);
            alertDiv.className = 'alert error';
            alertDiv.textContent = 'Erro ao processar resposta do servidor';
            alertDiv.style.display = 'block';
            restoreButton();
        }
    })
    .catch(error => {
        clearTimeout(safetyTimeout);
        console.error('Erro ao enviar requisição:', error);
        alertDiv.className = 'alert error';
        alertDiv.textContent = 'Erro ao processar requisição: ' + error.message;
        alertDiv.style.display = 'block';
        restoreButton();
    });
});

// Form: Email
document.getElementById('editEmailForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const newEmail = document.getElementById('new_email').value;
    const confirmEmail = document.getElementById('confirm_email').value;
    
    if (newEmail !== confirmEmail) {
        const alertDiv = document.getElementById('emailAlert');
        alertDiv.className = 'alert error';
        alertDiv.textContent = 'Os emails não coincidem!';
        alertDiv.style.display = 'block';
        return;
    }
    
    const formData = new FormData(this);
    formData.append('action', 'update_email');
    
    const alertDiv = document.getElementById('emailAlert');
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Alterando...';
    alertDiv.style.display = 'none';
    
    // Função para restaurar botão
    const restoreButton = () => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    };
    
    // Timeout de segurança: restaurar botão após 10 segundos
    const safetyTimeout = setTimeout(() => {
        console.warn('Timeout de segurança: restaurando botão de email');
        restoreButton();
    }, 10000);
    
    fetch((typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/profile_update.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        clearTimeout(safetyTimeout);
        if (!response.ok) {
            throw new Error('Erro HTTP: ' + response.status);
        }
        return response.text();
    })
    .then(text => {
        try {
            const data = JSON.parse(text);
            if (data.success) {
                alertDiv.className = 'alert success';
                alertDiv.textContent = data.message || 'Email alterado com sucesso!';
                alertDiv.style.display = 'block';
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                alertDiv.className = 'alert error';
                alertDiv.textContent = data.message || 'Erro ao alterar email';
                alertDiv.style.display = 'block';
                restoreButton();
            }
        } catch (e) {
            console.error('Erro ao parsear resposta:', e, text);
            alertDiv.className = 'alert error';
            alertDiv.textContent = 'Erro ao processar resposta do servidor';
            alertDiv.style.display = 'block';
            restoreButton();
        }
    })
    .catch(error => {
        clearTimeout(safetyTimeout);
        console.error('Erro ao enviar requisição:', error);
        alertDiv.className = 'alert error';
        alertDiv.textContent = 'Erro ao processar requisição: ' + error.message;
        alertDiv.style.display = 'block';
        restoreButton();
    });
});

// Form: Avatar
document.getElementById('editAvatarForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    formData.append('action', 'update_avatar');
    
    const alertDiv = document.getElementById('avatarAlert');
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Salvando...';
    alertDiv.style.display = 'none';
    
    // Função para restaurar botão
    const restoreButton = () => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    };
    
    // Timeout de segurança: restaurar botão após 10 segundos
    const safetyTimeout = setTimeout(() => {
        console.warn('Timeout de segurança: restaurando botão de avatar');
        restoreButton();
    }, 10000);
    
    fetch((typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/profile_update.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        clearTimeout(safetyTimeout);
        if (!response.ok) {
            throw new Error('Erro HTTP: ' + response.status);
        }
        return response.text();
    })
    .then(text => {
        try {
            const data = JSON.parse(text);
            if (data.success) {
                alertDiv.className = 'alert success';
                alertDiv.textContent = data.message || 'Foto de perfil alterada com sucesso!';
                alertDiv.style.display = 'block';
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                alertDiv.className = 'alert error';
                alertDiv.textContent = data.message || 'Erro ao alterar foto de perfil';
                alertDiv.style.display = 'block';
                restoreButton();
            }
        } catch (e) {
            console.error('Erro ao parsear resposta:', e, text);
            alertDiv.className = 'alert error';
            alertDiv.textContent = 'Erro ao processar resposta do servidor';
            alertDiv.style.display = 'block';
            restoreButton();
        }
    })
    .catch(error => {
        clearTimeout(safetyTimeout);
        console.error('Erro ao enviar requisição:', error);
        alertDiv.className = 'alert error';
        alertDiv.textContent = 'Erro ao processar requisição: ' + error.message;
        alertDiv.style.display = 'block';
        restoreButton();
    });
});
</script>

<?php include 'includes/footer.php'; ?>
