<?php
// Detectar caminho base automaticamente (se não foi definido no header)
if (!isset($base_path)) {
    $base_path = '';
    if (strpos(__DIR__, '/admin') !== false || strpos(__DIR__, '\\admin') !== false) {
        $base_path = '../';
    }
}
?>      
        <center>    
        <footer class="main-footer">
            <div class="container">
                <div class="footer-content">
                    <p>GunBound &copy; <?php echo date('Y'); ?></p>
                    
                </div>
            </div>
            <a href="https://discord.gg/uWz9kN7ShB" target="_blank" class="developer-logo" title="Desenvolvido por VioleProg">
                        <img src="<?php echo $base_path; ?>Assets/dev/violeprog.png" alt="VioleProg">
                    </a>
        </footer>
        </center>
    </div>
    
    <!-- Partículas de fuligem -->
    <div class="particles-container" id="particlesContainer"></div>
    
    <!-- Modal de Login -->
    <div class="auth-modal" id="loginModal">
        <div class="auth-modal-content">
            <button class="auth-modal-close" onclick="closeModal('loginModal')">
                <i class="fas fa-times"></i>
            </button>
            <div class="auth-card">
                <div class="auth-header">
                    <h1>Login</h1>
                    <p>Entre na sua conta</p>
                </div>
                
                <div id="loginAlert" class="alert" style="display: none;"></div>
                
                <form id="loginForm" class="auth-form">
                    <div class="form-group">
                        <label for="modal_username">Usuário</label>
                        <input type="text" id="modal_username" name="username" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="modal_password">Senha</label>
                        <input type="password" id="modal_password" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                </form>
                
                <div class="auth-footer">
                    <p>Não tem uma conta? <a href="#" onclick="event.preventDefault(); closeModal('loginModal'); openModal('registerModal');">Registre-se aqui</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de Registro -->
    <div class="auth-modal" id="registerModal">
        <div class="auth-modal-content">
            <button class="auth-modal-close" onclick="closeModal('registerModal')">
                <i class="fas fa-times"></i>
            </button>
            <div class="auth-card">
                <div class="auth-header">
                    <h1>Criar Conta</h1>
                    <p>Junte-se ao Gunbound hoje</p>
                </div>
                
                <div id="registerAlert" class="alert" style="display: none;"></div>
                
                <form id="registerForm" class="auth-form">
                    <div class="form-group">
                        <label for="modal_login">Login *</label>
                        <input type="text" id="modal_login" name="login" required maxlength="12" pattern="[a-zA-Z0-9]{6,12}" title="6-12 caracteres alfanuméricos">
                        <small>6-12 caracteres, apenas letras e números</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="modal_nick">Nickname *</label>
                        <input type="text" id="modal_nick" name="nick" required maxlength="12" pattern="[a-zA-Z0-9]{6,12}" title="6-12 caracteres alfanuméricos">
                        <small>6-12 caracteres, apenas letras e números</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="modal_email">Email *</label>
                        <input type="email" id="modal_email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="modal_email_confirm">Confirmar Email *</label>
                        <input type="email" id="modal_email_confirm" name="email_confirm" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="modal_password_reg">Senha *</label>
                        <input type="password" id="modal_password_reg" name="password" required minlength="6" maxlength="12">
                        <small>6-12 caracteres</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="modal_password_confirm">Confirmar Senha *</label>
                        <input type="password" id="modal_password_confirm" name="password_confirm" required minlength="6" maxlength="12">
                    </div>
                    
                    <div class="form-group">
                        <label for="modal_gender">Gênero *</label>
                        <select id="modal_gender" name="gender" required>
                            <option value="0">Masculino</option>
                            <option value="1">Feminino</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Criar Conta</button>
                </form>
                
                <div class="auth-footer">
                    <p>Já tem uma conta? <a href="#" onclick="event.preventDefault(); closeModal('registerModal'); openModal('loginModal');">Faça login aqui</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de Avatares -->
    <div class="auth-modal" id="avatarsModal">
        <div class="auth-modal-content auth-modal-large">
            <button class="auth-modal-close" onclick="closeModal('avatarsModal')">
                <i class="fas fa-times"></i>
            </button>
            <div class="auth-card">
                <div class="avatars-header">
                    <button class="btn-voltar" onclick="closeModal('avatarsModal')">
                        <i class="fas fa-arrow-left"></i> VOLTAR
                    </button>
                    <button class="btn-ordenar" onclick="sortAvatars()">
                        ORDENAR AVATARES POR ORDEM ALFABÉTICA IN-GAME
                    </button>
                </div>
                
                <div class="avatars-section">
                    <h2 class="section-title">Meus Avatares</h2>
                    <div class="avatars-table-container">
                        <table class="avatars-table">
                            <thead>
                                <tr>
                                    <th>Imagem</th>
                                    <th>Tipo</th>
                                    <th>Nome</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody id="avatarsList">
                                <tr>
                                    <td colspan="4" class="text-center">Carregando...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="closet-section">
                    <h2 class="section-title">Meu Closet</h2>
                    <p class="closet-description">
                        Os avatares que estiverem no seu closet não poderão ser acessados através do jogo. 
                        Para isso, será necessário recupera-los. Após recuperar eles voltam a aparecer no jogo e são retirados do seu closet.
                    </p>
                    <div class="avatars-table-container">
                        <table class="avatars-table">
                            <thead>
                                <tr>
                                    <th>Imagem</th>
                                    <th>Tipo</th>
                                    <th>Nome</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody id="closetList">
                                <tr>
                                    <td colspan="4" class="text-center">Carregando...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de Ranking -->
    <div class="auth-modal" id="rankingModal">
        <div class="auth-modal-content auth-modal-large">
            <button class="auth-modal-close" onclick="closeModal('rankingModal')">
                <i class="fas fa-times"></i>
            </button>
            <div class="auth-card">
                <div class="auth-header">
                    <h1>Ranking</h1>
                    <p>Top jogadores do servidor</p>
                </div>
                
                <div class="ranking-search-container">
                    <div class="ranking-search-row">
                        <div class="ranking-search-input-wrapper">
                            <i class="fas fa-search ranking-search-icon"></i>
                            <input type="text" id="rankingSearch" class="ranking-search-input" placeholder="Buscar por usuário..." onkeyup="handleRankingSearch(event)">
                        </div>
                        <select id="rankingSortBy" class="ranking-sort-select" onchange="loadRanking(1, getRankingFilters())">
                            <option value="rank">Ordenar por Rank</option>
                            <option value="points">Ordenar por Pontos</option>
                            <option value="gold">Ordenar por Gold</option>
                        </select>
                        <button class="btn btn-secondary" onclick="clearRankingSearch()">
                            <i class="fas fa-times"></i> Limpar
                        </button>
                    </div>
                </div>
                
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
                        <tbody id="rankingTableBody">
                            <tr>
                                <td colspan="5" class="text-center">Carregando...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div id="rankingPagination"></div>
            </div>
        </div>
    </div>
    
    <!-- Modal de Confirmação/Alerta -->
    <div class="confirm-modal" id="confirmModal">
        <div class="confirm-modal-content">
            <div class="confirm-modal-header">
                <h3 id="confirmModalTitle">Confirmação</h3>
            </div>
            <div class="confirm-modal-body">
                <p id="confirmModalMessage"></p>
            </div>
            <div class="confirm-modal-footer">
                <button class="btn btn-secondary" id="confirmModalCancel" onclick="closeConfirmModal(false)">Cancelar</button>
                <button class="btn btn-primary" id="confirmModalOk" onclick="closeConfirmModal(true)">OK</button>
            </div>
        </div>
    </div>
    
    <!-- Modal de Informações de Registro -->
    <div class="confirm-modal" id="registrationInfoModal">
        <div class="confirm-modal-content" style="max-width: 500px;">
            <div class="confirm-modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h3 style="color: white; margin: 0;">
                    <i class="fas fa-check-circle"></i> Conta Criada com Sucesso!
                </h3>
            </div>
            <div class="confirm-modal-body" id="registrationInfoContent">
                <!-- Conteúdo será preenchido via JavaScript -->
            </div>
            <div class="confirm-modal-footer">
                <button class="btn btn-primary" id="registrationInfoOk" onclick="closeRegistrationInfoModal()" style="width: 100%;">
                    <i class="fas fa-check"></i> Entendi
                </button>
            </div>
        </div>
    </div>
    
    <!-- Modal de Alerta (apenas mensagem) -->
    <div class="alert-modal" id="alertModal">
        <div class="alert-modal-content">
            <div class="alert-modal-header">
                <h3>Aviso</h3>
            </div>
            <div class="alert-modal-body">
                <p id="alertModalMessage"></p>
            </div>
            <div class="alert-modal-footer">
                <button class="btn btn-primary" onclick="closeAlertModal()">OK</button>
            </div>
        </div>
    </div>
    
    <script src="<?php echo $base_path; ?>Assets/js/main.js"></script>
</body>
</html>

