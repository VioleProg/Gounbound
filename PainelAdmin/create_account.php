<?php 
include("header.php"); // mesh.php já está incluído em header.php
include("../includes/functions.php");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = mysql_real_escape_string($_POST['login'] ?? '');
    $nick = mysql_real_escape_string($_POST['nick'] ?? '');
    $password = mysql_real_escape_string($_POST['password'] ?? '');
    $email = mysql_real_escape_string($_POST['email'] ?? '');
    $gender = (int)($_POST['gender'] ?? 0);
    $country = mysql_real_escape_string($_POST['country'] ?? '28');
    $gold = (int)($_POST['gold'] ?? 300000);
    $cash = (int)($_POST['cash'] ?? 50000);
    $gp = (int)($_POST['gp'] ?? 1000);
    $grade = (int)($_POST['grade'] ?? -3);
    
    if (empty($login) || empty($nick) || empty($password) || empty($email)) {
        $error = 'Preencha todos os campos obrigatórios!';
    } else {
        // Verificar se login já existe
        $check = mysql_query("SELECT Id FROM gunwcuser WHERE Id='$login' OR user='$login'");
        if (mysql_num_rows($check) > 0) {
            $error = 'Este login já está em uso!';
        } else {
            // Usar função de registro (ordem: login, nick, email, password, gender, country)
            $result = register($login, $nick, $email, $password, $gender, $country);
            
            if ($result['success']) {
                // Atualizar gold, cash e GP (valores padrão já são inseridos pela função register)
                // A função register já insere: Money=300000, Cash=50000, item inicial
                // Se valores diferentes forem especificados, atualizar
                if ($gold != 300000) {
                    mysql_query("UPDATE game SET Money = $gold WHERE Id = '$login'");
                }
                if ($cash != 50000) {
                    mysql_query("UPDATE cash SET Cash = $cash WHERE ID = '$login'");
                }
                if ($gp != 1000) {
                    mysql_query("UPDATE game SET TotalScore = $gp WHERE Id = '$login'");
                }
                if ($grade != -3) {
                    mysql_query("UPDATE game SET TotalGrade = $grade, SeasonGrade = $grade, CountryGrade = $grade WHERE Id = '$login'");
                }
                
                $success = "Conta criada com sucesso! Login: <strong>$login</strong> | Número de registro: <strong>#{$result['user_number']}</strong>";
            } else {
                $error = $result['message'] ?? 'Erro ao criar conta!';
            }
        }
    }
}
?>

<a name="maincontent"></a>

<h1>Criar Nova Conta</h1>
    <p>Crie uma nova conta de usuário no sistema.</p>
    
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
    
    <div class="admin-section" style="max-width: 600px;">
        <h2>Informações da Conta</h2>
        <form method="post" style="padding: 1.5rem;">
            <dl>
                <dt><label for="login">Login (ID): *</label></dt>
                <dd>
                    <input type="text" id="login" name="login" required maxlength="16" 
                           placeholder="6-16 caracteres alfanuméricos"
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            
            <dl>
                <dt><label for="nick">Nickname: *</label></dt>
                <dd>
                    <input type="text" id="nick" name="nick" required maxlength="16" 
                           placeholder="Apelido do jogador"
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            
            <dl>
                <dt><label for="password">Senha: *</label></dt>
                <dd>
                    <input type="password" id="password" name="password" required maxlength="16" 
                           placeholder="6-16 caracteres"
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            
            <dl>
                <dt><label for="email">Email: *</label></dt>
                <dd>
                    <input type="email" id="email" name="email" required 
                           placeholder="email@exemplo.com"
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            
            <dl>
                <dt><label for="gender">Gênero:</label></dt>
                <dd>
                    <select id="gender" name="gender" style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                        <option value="0">Masculino</option>
                        <option value="1">Feminino</option>
                    </select>
                </dd>
            </dl>
            
            <dl>
                <dt><label for="country">País:</label></dt>
                <dd>
                    <input type="text" id="country" name="country" value="28" maxlength="3" 
                           placeholder="Código do país (ex: 28)"
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                </dd>
            </dl>
            
            <fieldset style="margin-top: 1.5rem;">
                <legend>Valores Iniciais (Opcional)</legend>
                
                <dl>
                    <dt><label for="gold">Gold Inicial:</label></dt>
                    <dd>
                        <input type="number" id="gold" name="gold" value="300000" min="0" 
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                        <small>Padrão: 300000</small>
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="cash">Cash Inicial:</label></dt>
                    <dd>
                        <input type="number" id="cash" name="cash" value="50000" min="0" 
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                        <small>Padrão: 50000</small>
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="gp">GP Inicial:</label></dt>
                    <dd>
                        <input type="number" id="gp" name="gp" value="1000" min="0" 
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
                
                <dl>
                    <dt><label for="grade">Grade Inicial:</label></dt>
                    <dd>
                        <input type="number" id="grade" name="grade" value="-3" min="-4" max="20" 
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;">
                    </dd>
                </dl>
            </fieldset>
            
            <p style="margin-top: 1.5rem;">
                <button type="submit" style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                                             color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                                             border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-user-plus"></i> Criar Conta
                </button>
            </p>
        </form>
    </div>
    
    <p style="margin-top: 2rem;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>

