<?php 
// Processar POST antes de incluir header (para evitar erro ao usar header())
if(isset($_POST['updateacc']))
{
    // Iniciar sessão e verificar autoridade
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include("../mesh.php");
    include("../includes/rank_functions.php");
    
    // Verificar autoridade
    $user_id = $_SESSION['user_id'] ?? $_SESSION['user'] ?? null;
    if (!$user_id) {
        header("Location: ../index.php");
        exit;
    }
    
    $sqla = mysql_query("SELECT Authority FROM gunwcuser WHERE Id='".mysql_real_escape_string($user_id)."'");
    $sqllya = mysql_fetch_assoc($sqla);
    $authority = $sqllya['Authority'] ?? 0;
    
    if($authority < 98) {
        header("Location: ../index.php");
        exit;
    }
    
    $search = mysql_real_escape_string($_POST['search'] ?? $_GET['search'] ?? '');
    
    if (empty($search)) {
        header("Location: account.php?error=" . urlencode("ID do usuário não fornecido"));
        exit;
    }
    
    $ud_nick = mysql_real_escape_string($_POST['ud_nick'] ?? '');
    $ud_grade = mysql_real_escape_string($_POST['ud_grade'] ?? '-4');
    $ud_gold = mysql_real_escape_string($_POST['ud_gold'] ?? '0');
    $ud_cash = mysql_real_escape_string($_POST['ud_cash'] ?? '0');
    $ud_gp = mysql_real_escape_string($_POST['ud_gp'] ?? '0');
    $ud_country = mysql_real_escape_string($_POST['ud_country'] ?? '28');
    $ud_sex = mysql_real_escape_string($_POST['sex'] ?? '0');
    $ud_verify = mysql_real_escape_string($_POST['email_verified'] ?? '0');
    $ud_guild = mysql_real_escape_string($_POST['guild'] ?? '');

    // Verificar se o usuário existe antes de atualizar
    $check_user = mysql_query("SELECT Id FROM game WHERE Id='$search'");
    if (mysql_num_rows($check_user) == 0) {
        header("Location: account.php?search=" . urlencode($search) . "&error=" . urlencode("Usuário não encontrado"));
        exit;
    }

    $updategame = mysql_query("UPDATE game SET Nickname='$ud_nick', TotalGrade='$ud_grade', Guild='$ud_guild', Country='$ud_country', CountryGrade='$ud_grade', SeasonGrade='$ud_grade', TotalScore='$ud_gp', Money='$ud_gold' WHERE Id='$search'");
    if (!$updategame) {
        // Se houver erro, redirecionar com mensagem de erro
        $error_msg = mysql_error();
        header("Location: account.php?search=" . urlencode($search) . "&error=" . urlencode("Erro ao atualizar game: " . $error_msg));
        exit;
    }

    // Verificar se existe em gunwcuser antes de atualizar
    $check_gunwc = mysql_query("SELECT Id FROM gunwcuser WHERE Id='$search'");
    if (mysql_num_rows($check_gunwc) > 0) {
        $updategunwc = mysql_query("UPDATE gunwcuser SET NickName='$ud_nick', Gender='$ud_sex', Country='$ud_country', E_Mail_Verify='$ud_verify' WHERE Id='$search'");
        if (!$updategunwc) {
            $error_msg = mysql_error();
            header("Location: account.php?search=" . urlencode($search) . "&error=" . urlencode("Erro ao atualizar gunwcuser: " . $error_msg));
            exit;
        }
    }

    // Tentar atualizar user também (se existir)
    @mysql_query("UPDATE user SET Gender='$ud_sex', NickName='$ud_nick', Country='$ud_country', E_Mail_Verify='$ud_verify' WHERE Id='$search'");

    // Verificar se existe em cash antes de atualizar
    $check_cash = mysql_query("SELECT ID FROM cash WHERE ID='$search'");
    if (mysql_num_rows($check_cash) > 0) {
        $updatecash = mysql_query("UPDATE cash SET Cash='$ud_cash' WHERE ID='$search'");
        if (!$updatecash) {
            $error_msg = mysql_error();
            header("Location: account.php?search=" . urlencode($search) . "&error=" . urlencode("Erro ao atualizar cash: " . $error_msg));
            exit;
        }
    } else {
        // Se não existir, criar registro
        $insert_cash = mysql_query("INSERT INTO cash (ID, Cash) VALUES ('$search', '$ud_cash')");
        if (!$insert_cash) {
            $error_msg = mysql_error();
            header("Location: account.php?search=" . urlencode($search) . "&error=" . urlencode("Erro ao criar registro de cash: " . $error_msg));
            exit;
        }
    }

    // Redirecionar após atualização bem-sucedida
    header("Location: account.php?search=" . urlencode($search) . "&success=1");
    exit;
}

// verify.php já é incluído em header.php
// rank_functions.php também já é incluído em header.php
include("header.php"); 

// Verificar se search foi fornecido antes de usar mysql_real_escape_string
$search_raw = $_GET['search'] ?? '';
$search = !empty($search_raw) ? mysql_real_escape_string($search_raw) : '';
$submit_raw = $_GET['submit'] ?? '';
$submit = !empty($submit_raw) ? mysql_real_escape_string($submit_raw) : '';

if (empty($search)) {
    ?>
    <a name="maincontent"></a>
    <div class="error-message" style="background: #f8d7da; color: #721c24; padding: 1rem; margin: 1rem 0; border: 1px solid #f5c6cb; border-radius: 8px; border-left: 4px solid #dc3545;">
        <i class="fas fa-exclamation-circle"></i> Por favor, digite um nome de usuário.
    </div>
    <p style="margin-top: 20px;"><a href="user.php" class="button1">Voltar</a></p>
    <?php
    include("footer.php");
    exit;
}

// Scripts serão incluídos no final da página
$show_scripts = true;

// Verificar se usuário existe em game
$sqle = @mysql_query("SELECT Id FROM game WHERE Id='$search'");
if (!$sqle) {
    ?>
    <a name="maincontent"></a>
    <div class="error-message" style="background: #f8d7da; color: #721c24; padding: 1rem; margin: 1rem 0; border: 1px solid #f5c6cb; border-radius: 8px; border-left: 4px solid #dc3545;">
        <i class="fas fa-exclamation-circle"></i> Erro ao consultar banco de dados: <?php echo htmlspecialchars(mysql_error()); ?>
    </div>
    <p style="margin-top: 20px;"><a href="user.php" class="button1">Voltar</a></p>
    <?php
    include("footer.php");
    exit;
}
$sqllye = mysql_num_rows($sqle);
if($sqllye == 0)
{
  ?>
  <a name="maincontent"></a>
  <div class="error-message" style="background: #f8d7da; color: #721c24; padding: 1rem; margin: 1rem 0; border: 1px solid #f5c6cb; border-radius: 8px; border-left: 4px solid #dc3545;">
      <i class="fas fa-exclamation-circle"></i> Usuário não encontrado. Verifique o ID e tente novamente.
  </div>
  <p style="margin-top: 20px;"><a href="user.php" class="button1">Voltar</a></p>
  <?php
  include("footer.php");
  exit;
}

// Buscar dados do jogo
$sqllog = mysql_query("SELECT * FROM game WHERE Id='$search'");
$sqllylog = mysql_fetch_assoc($sqllog);
$user_name = $sqllylog['Id'] ?? '';
$nickname = $sqllylog['Nickname'] ?? $sqllylog['NickName'] ?? '';
$gp = $sqllylog['TotalScore'] ?? 0;
$grade = $sqllylog['TotalGrade'] ?? -4;
$guild = $sqllylog['Guild'] ?? '';
$guildrank = $sqllylog['GuildRank'] ?? 0;
$membercount = $sqllylog['MemberCount'] ?? 0;
$rank = $sqllylog['TotalRank'] ?? 0;
$laston = $sqllylog['LastUpdateTime'] ?? 'N/A';
$countrygrade = $sqllylog['CountryGrade'] ?? -4;
$accounttype = $sqllylog['AccountType'] ?? '';
$gold = $sqllylog['Money'] ?? 0;

// Buscar dados da conta em gunwcuser (tabela principal)
$sqlu = mysql_query("SELECT * FROM gunwcuser WHERE Id='$search'");
$sqllu = mysql_fetch_assoc($sqlu);
if (!$sqllu) {
    // Tentar em user como fallback
    $sqlu = mysql_query("SELECT * FROM user WHERE Id='$search'");
    $sqllu = mysql_fetch_assoc($sqlu);
}

$sex = $sqllu['Gender'] ?? 0;
$password = $sqllu['Password'] ?? '';
$email = $sqllu['E_Mail'] ?? '';
$email_verify = $sqllu['E_Mail_Verify'] ?? 0;
$country = $sqllu['Country'] ?? '28';
$birthday = $sqllu['birthdate'] ?? $sqllu['Birthdate'] ?? '';
$firstname = $sqllu['Firstname'] ?? '';
$lastname = $sqllu['Lastname'] ?? '';
$ipaddress = $sqllu['IP'] ?? 'N/A';

// Buscar authority do admin atual em gunwcuser
$user_id = $_SESSION['user_id'] ?? $_SESSION['user'] ?? '';
$sqla = mysql_query("SELECT Authority FROM gunwcuser WHERE Id='".mysql_real_escape_string($user_id)."'");
$sqllya = mysql_fetch_assoc($sqla);
$authority = $sqllya['Authority'] ?? 0;

$sqlc = mysql_query("SELECT * FROM cash WHERE ID='$search'");
$sqllyc = mysql_fetch_assoc($sqlc);
$cash = $sqllyc['Cash'] ?? 0;


// Exibir mensagem de sucesso ou erro se houver
$success_msg = '';
$error_msg = '';
if (isset($_GET['success']) && $_GET['success'] == '1') {
    $success_msg = 'Registro(s) Atualizado(s) com sucesso!';
}
if (isset($_GET['error'])) {
    $error_msg = htmlspecialchars($_GET['error']);
}
?>
<a name="maincontent"></a>

	<a href="admin_panel.php" style="float: right; margin-bottom: 1rem; display: inline-block; padding: 0.5rem 1rem; background: var(--admin-primary); color: white; text-decoration: none; border-radius: 8px;">&laquo; Voltar</a>

	<h1>Administração de Usuário :: Você pesquisou por - <strong><u><?php echo htmlspecialchars($search); ?></u></strong></h1>
	
	<?php if ($success_msg): ?>
		<div class="success-message" style="background: #d4edda; color: #155724; padding: 1rem; margin: 1rem 0; border: 1px solid #c3e6cb; border-radius: 8px;">
			<i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_msg); ?>
		</div>
	<?php endif; ?>
	
	<?php if ($error_msg): ?>
		<div class="error-message" style="background: #f8d7da; color: #721c24; padding: 1rem; margin: 1rem 0; border: 1px solid #f5c6cb; border-radius: 8px; border-left: 4px solid #dc3545;">
			<i class="fas fa-exclamation-circle"></i> <?php echo $error_msg; ?>
		</div>
	<?php endif; ?>
	
<?php
echo "<form method='post' action=''>
<input type='hidden' name='search' value='" . htmlspecialchars($search) . "' />
<fieldset>
	<legend>Visão Geral da Conta</legend>

<dl>
	<dt><label for='user'>ID de Login:</label><br /><span>O comprimento deve estar entre 3 e 20 caracteres.</span></dt>

	<dd><strong>" . htmlspecialchars($user_name) . "</strong></dd>

</dl>";
if($authority >= 100)
{
echo "<dl>
	<dt><label for='user'>Senha:</label><br /><span>Destaque para ver a senha</span></dt>

	<dd><strong><font color='white'>" . htmlspecialchars($password) . "</font></strong></dd>

</dl>";
}

echo "
<dl>
	<dt><label for='nick'>ID do Jogo:</label><br /><span>O comprimento deve estar entre 3 e 20 caracteres.</span></dt>

	<dd><input type='text' id='user' name='ud_nick' value='" . htmlspecialchars($nickname) . "' /></dd>

	
</dl>
<dl>
	<dt><label for='nick'>Endereço IP: </label><br /><span></span></dt>

	<dd>" . htmlspecialchars($ipaddress) . "</dd>

	
</dl>
<dl>
	<dt><label>E-mail:</label><br /><span>Usado para segurança</span></dt>
	<dd><strong>" . htmlspecialchars($email) . "</strong></dd>

</dl>
<dl>
	<dt><label>Ativação de E-mail: </label></dt>";
	echo "<dd>";
  if($email_verify != 1)
                {
                 echo "<input type='radio' name='email_verified' value='0' checked /> Não Verificado ";
                 echo "<input type='radio' name='email_verified' value='1' /> Verificado";
                }
                if($email_verify !=0)
                {
                 echo "<input type='radio' name='email_verified' value='0' /> Não Verificado ";
                 echo "<input type='radio' name='email_verified' value='1' checked /> Verificado";
                }
  echo "</dd>";

echo "</dl>
<dl>
<dt><label>Gênero:</label></dt>
<dd>";
if($sex != 1)
                {
                 echo "<input type='radio' name='sex' value='0' checked /> Masculino ";
                 echo "<input type='radio' name='sex' value='1' /> Feminino ";
                }
                if($sex !=0)
                {
                 echo "<input type='radio' name='sex' value='0' /> Masculino ";
                 echo "<input type='radio' name='sex' value='1' checked /> Feminino ";
                }
echo "</dd>
</dl>";
echo "
<dl>
	<dt><label for='nick'>Status da Conta:</label><br /><span></span></dt>

	<dd><strong>Funcionando</strong></dd>
</dl>

<dl>
	<dt><label for='nick'>Data de Nascimento:</label><br /><span>Usado para segurança</span></dt>

	<dd><strong>" . htmlspecialchars($birthday) . "</strong></dd>
</dl>
<dl>
	<dt><label>Último Online:</label></dt>
	<dd><strong>" . htmlspecialchars($laston) . "</strong></dd>

</dl>
<dl>
	<dt><label>GP Total</label></dt>

	<dd><strong><input type='text' name='ud_gp' value='" . htmlspecialchars($gp) . "' /></strong></dd>
</dl>
<dl>
	<dt><label>País</label></dt>

	<dd><strong><input type='text' name='ud_country' value='" . htmlspecialchars($country) . "' /></strong>
  <br /><u>Todos os Países:</u><a href=\"javascript:fnnlocation('all_countries')\"> aqui</a><br /></dd>
</dl>
<dl>
	<dt><label>Rank Total:</label></dt>
	<dd><strong>" . htmlspecialchars($rank) . "</strong></dd>
</dl>
<dl>
	<dt><label>Nível:</label></dt>
	<dd><strong><img src='../Assets/rank/" . htmlspecialchars(getRankImageName($grade)) . "' alt='' border='0' style='width: 30px; height: 30px;' /></strong> <input type=text size='2' maxlength='2' name='ud_grade' value='" . htmlspecialchars($grade) . "' />
  <br /><u>Todos os Níveis:</u><a href=\"javascript:fnlocation('all_grades')\"> aqui</a><br /></dd>
</dl>
<dl>
	<dt><label>Guilda:</label><br /><span>Alterar via Gerenciamento de Guildas</span></dt>
	<dd><input name='guild' type='text' value='" . htmlspecialchars($guild) . "' /> [" . htmlspecialchars($guildrank) . " / " . htmlspecialchars($membercount) . " ]</dd>
</dl>

<dl>
	<dt><label>Gold:</label></dt>
	<dd><input type='text' id='gold' name='ud_gold' value='" . htmlspecialchars($gold) . "' /></dd>
</dl>

<dl>
	<dt><label>Cash:</label></dt>
	<dd><input type='text' id='gold' name='ud_cash' value='" . htmlspecialchars($cash) . "' /></dd>
</dl>
<p class='quick'>
	<input class='button1' type='submit' name='updateacc' value='Atualizar Conta' />
</p>

</fieldset>
</form>

<script language="javascript">
function fnlocation(argu) {
    window.open(argu, 'View', 'scrollbars=no, width=400, height=500, top=0, left=0');
}
function fnnlocation(argu) {
    window.open(argu, 'View', 'scrollbars=yes, width=400, height=500, top=0, left=0');
}
</script>

<?php include("footer.php"); ?>
