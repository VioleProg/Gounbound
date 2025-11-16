<?php
include("verify.php"); // verify.php já inclui mesh.php
include("../includes/rank_functions.php");

$user_id = $_SESSION['user_id'] ?? $_SESSION['user'] ?? '';

// Buscar dados em game (para rank/grade)
$sql_game = mysql_query("SELECT TotalGrade, Nickname FROM game WHERE Id='".mysql_real_escape_string($user_id)."'");
$sqlly_game = mysql_fetch_assoc($sql_game);

// Buscar nickname e Authority em gunwcuser (tabela principal)
$sql_gunwc = mysql_query("SELECT NickName, Authority FROM gunwcuser WHERE Id='".mysql_real_escape_string($user_id)."'");
$sqlly_gunwc = mysql_fetch_assoc($sql_gunwc);

$grade = $sqlly_game['TotalGrade'] ?? '-4';
$username = $sqlly_game['Nickname'] ?? $sqlly_gunwc['NickName'] ?? $user_id;
$current_authority = (int)($sqlly_gunwc['Authority'] ?? 0);
$is_gm = ($current_authority == 99);

// Usar a função getRankImageName para obter o nome correto da imagem
$rank_image_name = getRankImageName($grade);
$rank_image = "../Assets/rank/".$rank_image_name;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - GunBound</title>
    <link rel="stylesheet" href="../Assets/css/style.css">
    <link rel="stylesheet" href="style/admin_modern.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="ltr">
<div id="wrap">
    <div id="page-header">
        <h1><i class="fas fa-shield-alt"></i> Painel Administrativo</h1>
        <p>
            <a href="admin_panel.php"><i class="fas fa-home"></i> Painel</a>
            <a href="../"><i class="fas fa-globe"></i> Site</a>
            <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
        </p>
    </div>
    
    <div id="page-body">
        <div id="tabs">
            <ul>
                <li id="activetab"><a href="admin_panel.php"><span>Painel Administrativo</span></a></li>
            </ul>
        </div>

        <div id="acp">
            <div class="panel">
                <div id="content">
                    <div id="toggle">
                        <a id="toggle-handle" accesskey="m" title="Ocultar ou exibir o menu lateral" onclick="switch_menu(); return false;" href="#"></a>
                    </div>
                    
                    <div id="menu">
                        <p>
                            <strong>
                                <img src="<?php echo htmlspecialchars($rank_image); ?>" alt="Rank" style="width: 24px; height: 24px; vertical-align: middle; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);" />
                                <?php echo htmlspecialchars($username); ?>
                            </strong>
                            <a href="../logout.php">Sair</a>
                        </p>

                        <ul>
                            <li class="header">Menu Principal</li>
                            <li><a href="admin_panel.php"><span><i class="fas fa-home"></i> Painel Administrativo</span></a></li>
                        </ul>
                    </div>
                    
                    <div id="main">
