<?php 
include("header.php");

$search = isset($_GET['search']) ? mysql_real_escape_string($_GET['search']) : '';
$success = '';
$error = '';
?>

<a name="maincontent"></a>
    
    <h1>Administração de Usuário</h1>
    
    <p><b>LEMBRE-SE:</b> Pesquise o usuário pelo ID de Login</p>
    
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
    
    <div class="admin-section" style="max-width: 600px;">
        <h2>Pesquisar Conta</h2>
        <form id="select_user" action='user.php' method='get' style="padding: 1.5rem;">
            <dl>
                <dt><label for="username">Encontrar um membro:</label></dt>
                <dd>
                    <input class="text medium" type="text" id="username" name="search" 
                           value="<?php echo htmlspecialchars($search); ?>"
                           placeholder="Digite o ID do usuário" 
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;" required>
                </dd>
            </dl>
            
            <p class="quick" style="margin-top: 1rem;">
                <button type="submit" name="submit" 
                        style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                               color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                               border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-search"></i> Pesquisar
                </button>
            </p>
        </form>
    </div>
    
    <?php if (!empty($search)): ?>
        <?php
        // Verificar se usuário existe
        $sqle = @mysql_query("SELECT Id FROM game WHERE Id='$search'");
        if (!$sqle || mysql_num_rows($sqle) == 0) {
            echo '<div class="error-message" style="margin-top: 2rem;">
                    <i class="fas fa-exclamation-circle"></i> Usuário não encontrado. Verifique o ID e tente novamente.
                  </div>';
        } else {
            // Buscar dados do jogo
            $sqllog = mysql_query("SELECT * FROM game WHERE Id='$search'");
            $sqllylog = mysql_fetch_assoc($sqllog);
            
            // Buscar dados da conta
            $sqlu = mysql_query("SELECT * FROM gunwcuser WHERE Id='$search'");
            $sqllu = mysql_fetch_assoc($sqlu);
            if (!$sqllu) {
                $sqlu = mysql_query("SELECT * FROM user WHERE Id='$search'");
                $sqllu = mysql_fetch_assoc($sqlu);
            }
            
            // Buscar cash
            $sqlc = mysql_query("SELECT * FROM cash WHERE ID='$search'");
            $sqllyc = mysql_fetch_assoc($sqlc);
            
            // Buscar authority do admin
            $user_id = $_SESSION['user_id'] ?? $_SESSION['user'] ?? '';
            $sqla = mysql_query("SELECT Authority FROM gunwcuser WHERE Id='".mysql_real_escape_string($user_id)."'");
            $sqllya = mysql_fetch_assoc($sqla);
            $authority = $sqllya['Authority'] ?? 0;
            
            // Extrair dados
            $user_name = $sqllylog['Id'] ?? '';
            $nickname = $sqllylog['Nickname'] ?? $sqllylog['NickName'] ?? '';
            $gp = $sqllylog['TotalScore'] ?? 0;
            $grade = $sqllylog['TotalGrade'] ?? -4;
            $guild = $sqllylog['Guild'] ?? '';
            $rank = $sqllylog['TotalRank'] ?? 0;
            $gold = $sqllylog['Money'] ?? 0;
            $cash = $sqllyc['Cash'] ?? 0;
            $email = $sqllu['E_Mail'] ?? '';
            $gender = $sqllu['Gender'] ?? 0;
            $country = $sqllu['Country'] ?? '28';
            $authority_user = $sqllu['Authority'] ?? 0;
            $authority2 = $sqllu['Authority2'] ?? 0;
            $status = $sqllu['Status'] ?? '1';
            $ip = $sqllu['IP'] ?? 'N/A';
            $laston = $sqllylog['LastUpdateTime'] ?? 'N/A';
            
            // Buscar avatares
            $avatars_count = 0;
            $avatars_query = mysql_query("SELECT COUNT(*) as total FROM chest WHERE Owner='$search'");
            if ($avatars_query) {
                $avatars_row = mysql_fetch_assoc($avatars_query);
                $avatars_count = $avatars_row['total'] ?? 0;
            }
            
            // Buscar amigos
            $friends_count = 0;
            $friends_query = mysql_query("SELECT COUNT(*) as total FROM buddylist WHERE Id='$search'");
            if ($friends_query) {
                $friends_row = mysql_fetch_assoc($friends_query);
                $friends_count = $friends_row['total'] ?? 0;
            }
        ?>
        
        <div class="admin-section" style="margin-top: 2rem;">
            <h2 style="margin-bottom: 1.5rem;">Informações da Conta: <?php echo htmlspecialchars($user_name); ?></h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                <!-- Informações Básicas -->
                <div style="padding: 1.5rem; background: var(--admin-bg); border-radius: 8px; border-left: 4px solid var(--admin-primary);">
                    <h3 style="margin: 0 0 1rem 0; color: var(--admin-primary);">
                        <i class="fas fa-user"></i> Informações Básicas
                    </h3>
                    <dl style="margin: 0;">
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">ID de Login:</dt>
                        <dd style="margin: 0 0 0.75rem 0;"><?php echo htmlspecialchars($user_name); ?></dd>
                        
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">Nickname:</dt>
                        <dd style="margin: 0 0 0.75rem 0;"><?php echo htmlspecialchars($nickname); ?></dd>
                        
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">E-mail:</dt>
                        <dd style="margin: 0 0 0.75rem 0;"><?php echo htmlspecialchars($email ?: 'N/A'); ?></dd>
                        
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">Gênero:</dt>
                        <dd style="margin: 0 0 0.75rem 0;"><?php echo $gender == 1 ? 'Masculino' : 'Feminino'; ?></dd>
                        
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">Status:</dt>
                        <dd style="margin: 0 0 0.75rem 0;">
                            <?php if ($status == '1'): ?>
                                <span style="color: #28a745;"><i class="fas fa-check-circle"></i> Ativo</span>
                            <?php else: ?>
                                <span style="color: #dc3545;"><i class="fas fa-times-circle"></i> Inativo/Banido</span>
                            <?php endif; ?>
                        </dd>
                        
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">IP:</dt>
                        <dd style="margin: 0;"><?php echo htmlspecialchars($ip); ?></dd>
                    </dl>
                </div>
                
                <!-- Informações do Jogo -->
                <div style="padding: 1.5rem; background: var(--admin-bg); border-radius: 8px; border-left: 4px solid var(--admin-secondary);">
                    <h3 style="margin: 0 0 1rem 0; color: var(--admin-secondary);">
                        <i class="fas fa-gamepad"></i> Informações do Jogo
                    </h3>
                    <dl style="margin: 0;">
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">GP (Total Score):</dt>
                        <dd style="margin: 0 0 0.75rem 0;"><?php echo number_format($gp); ?></dd>
                        
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">Rank:</dt>
                        <dd style="margin: 0 0 0.75rem 0;">#<?php echo number_format($rank); ?></dd>
                        
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">Grade:</dt>
                        <dd style="margin: 0 0 0.75rem 0;"><?php echo $grade; ?></dd>
                        
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">Guild:</dt>
                        <dd style="margin: 0 0 0.75rem 0;"><?php echo htmlspecialchars($guild ?: 'Nenhuma'); ?></dd>
                        
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">Último Acesso:</dt>
                        <dd style="margin: 0;"><?php echo htmlspecialchars($laston); ?></dd>
                    </dl>
                </div>
                
                <!-- Recursos -->
                <div style="padding: 1.5rem; background: var(--admin-bg); border-radius: 8px; border-left: 4px solid #28a745;">
                    <h3 style="margin: 0 0 1rem 0; color: #28a745;">
                        <i class="fas fa-coins"></i> Recursos
                    </h3>
                    <dl style="margin: 0;">
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">Gold:</dt>
                        <dd style="margin: 0 0 0.75rem 0;"><?php echo number_format($gold); ?></dd>
                        
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">Cash:</dt>
                        <dd style="margin: 0 0 0.75rem 0;"><?php echo number_format($cash); ?></dd>
                        
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">Avatares:</dt>
                        <dd style="margin: 0 0 0.75rem 0;"><?php echo number_format($avatars_count); ?></dd>
                        
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">Amigos:</dt>
                        <dd style="margin: 0;"><?php echo number_format($friends_count); ?></dd>
                    </dl>
                </div>
                
                <!-- Permissões -->
                <div style="padding: 1.5rem; background: var(--admin-bg); border-radius: 8px; border-left: 4px solid #ffc107;">
                    <h3 style="margin: 0 0 1rem 0; color: #ffc107;">
                        <i class="fas fa-shield-alt"></i> Permissões
                    </h3>
                    <dl style="margin: 0;">
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">Authority:</dt>
                        <dd style="margin: 0 0 0.75rem 0;">
                            <?php 
                            if ($authority_user >= 100) {
                                echo '<span style="color: #dc3545;"><i class="fas fa-crown"></i> Admin</span>';
                            } elseif ($authority_user == 99) {
                                echo '<span style="color: #ffc107;"><i class="fas fa-star"></i> GM</span>';
                            } else {
                                echo '<span style="color: #6c757d;"><i class="fas fa-user"></i> Jogador</span>';
                            }
                            ?>
                            (<?php echo $authority_user; ?>)
                        </dd>
                        
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">Authority2:</dt>
                        <dd style="margin: 0 0 0.75rem 0;"><?php echo $authority2; ?></dd>
                        
                        <dt style="font-weight: 600; margin-bottom: 0.25rem;">País:</dt>
                        <dd style="margin: 0;"><?php echo htmlspecialchars($country); ?></dd>
                    </dl>
                </div>
            </div>
        </div>
        <?php } ?>
    <?php endif; ?>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>
