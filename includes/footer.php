<?php
// Detectar caminho base automaticamente (se não foi definido no header)
if (!isset($base_path)) {
    $base_path = '';
    if (strpos(__DIR__, '/admin') !== false || strpos(__DIR__, '\\admin') !== false) {
        $base_path = '../';
    }
}
?>
        <footer class="main-footer">
            <div class="container">
                <div class="footer-content">
                    <p>&copy; <?php echo date('Y'); ?> Gunbol. Todos os direitos reservados.</p>
                </div>
            </div>
        </footer>
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
                    <p>Junte-se ao Gunbol hoje</p>
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
    
    <script src="<?php echo $base_path; ?>Assets/js/main.js"></script>
</body>
</html>

