<?php
require_once __DIR__ . '/../config.php';

/**
 * Verifica se o usuário está logado
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Verifica se o usuário é administrador
 * Usa gunwcuser como tabela principal
 */
function isAdmin() {
    if (!isLoggedIn()) {
        return false;
    }
    
    global $conn;
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("SELECT Authority FROM gunwcuser WHERE Id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        return $row['Authority'] >= 98;
    }
    
    return false;
}

/**
 * Realiza login do usuário
 * Usa gunwcuser como tabela principal de contas
 */
function login($username, $password) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT Id, Password, Authority, Status FROM gunwcuser WHERE user = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        // Verificar se conta está ativa
        if ($row['Status'] != '1') {
            return false;
        }
        
        // Verificar senha (sem hash no banco antigo, então comparação direta)
        if ($row['Password'] === $password) {
            $_SESSION['user_id'] = $row['Id'];
            $_SESSION['username'] = $username;
            $_SESSION['authority'] = $row['Authority'];
            return true;
        }
    }
    
    return false;
}

/**
 * Registra novo usuário
 */
function register($login, $nick, $email, $password, $gender, $country = '28') {
    global $conn;
    
    // Verificar se login já existe (usando gunwcuser como principal)
    $stmt = $conn->prepare("SELECT Id FROM gunwcuser WHERE user = ? OR Id = ?");
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        return ['success' => false, 'message' => 'Login já está em uso'];
    }
    
    // Verificar se nick já existe
    $stmt = $conn->prepare("SELECT Id FROM game WHERE Nickname = ?");
    $stmt->bind_param("s", $nick);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        return ['success' => false, 'message' => 'Nick já está em uso'];
    }
    
    // Verificar se email já existe (usando gunwcuser)
    $stmt = $conn->prepare("SELECT Id FROM gunwcuser WHERE E_Mail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        return ['success' => false, 'message' => 'Email já está cadastrado'];
    }
    
    // Obter próximo rank
    $rank_result = $conn->query("SELECT TotalRank FROM game ORDER BY TotalRank DESC LIMIT 1");
    $rank = 1;
    if ($rank_row = $rank_result->fetch_assoc()) {
        $rank = $rank_row['TotalRank'] + 1;
    }
    
    // Iniciar transação
    $conn->begin_transaction();
    
    try {
        // 1. Inserir na tabela gunwcuser (PRINCIPAL - responsável pelas contas)
        // Campos obrigatórios: Id, user, Gender, NickName, Password, Status, Authority, E_Mail, Country, AuthorityBackup
        // Campos com DEFAULT serão preenchidos automaticamente: User_Level, Authority2, MuteTime, RestrictTime, datareg
        $stmt = $conn->prepare("INSERT INTO gunwcuser (Id, user, Gender, NickName, Password, Status, Authority, E_Mail, Country, AuthorityBackup) VALUES (?, ?, ?, ?, ?, '1', 1, ?, ?, 0)");
        // bind_param: s (Id), s (user), i (Gender), s (NickName), s (Password), s (E_Mail), s (Country)
        $stmt->bind_param("ssissss", $login, $login, $gender, $nick, $password, $email, $country);
        
        if (!$stmt->execute()) {
            $error_msg = "Erro ao inserir em gunwcuser: " . $stmt->error;
            if ($conn->errno) {
                $error_msg .= " | MySQL Error: " . $conn->errno . " - " . $conn->error;
            }
            throw new Exception($error_msg);
        }
        
        // 2. Inserir na tabela game (dados do jogo)
        // Parâmetros: Id (s), Nickname (s), Country (i), TotalRank (i), SeasonRank (i), CountryRank (i)
        $stmt = $conn->prepare("INSERT INTO game (Id, Nickname, Money, TotalScore, SeasonScore, TotalGrade, SeasonGrade, Country, CountryGrade, TotalRank, SeasonRank, CountryRank) VALUES (?, ?, 500000, 1000, 0, -3, -3, ?, -3, ?, ?, ?)");
        $country_int = (int)$country;
        $stmt->bind_param("ssiiii", $login, $nick, $country_int, $rank, $rank, $rank);
        
        if (!$stmt->execute()) {
            throw new Exception("Erro ao inserir em game: " . $stmt->error);
        }
        
        // 3. Inserir na tabela user (tabela auxiliar)
        $stmt = $conn->prepare("INSERT INTO user (Id, user, Gender, NickName, Password, Status, MuteTime, RestrictTime, Authority, E_Mail, Country, User_Level, Authority2, datareg) VALUES (?, ?, ?, ?, ?, '1', NULL, NULL, 1, ?, ?, 1, 1, NOW())");
        $stmt->bind_param("ssissss", $login, $login, $gender, $nick, $password, $email, $country);
        
        if (!$stmt->execute()) {
            throw new Exception("Erro ao inserir em user: " . $stmt->error);
        }
        
        // 4. Inserir na tabela cash (moeda virtual)
        $stmt = $conn->prepare("INSERT INTO cash (ID, Cash) VALUES (?, 50000)");
        $stmt->bind_param("s", $login);
        
        if (!$stmt->execute()) {
            throw new Exception("Erro ao inserir em cash: " . $stmt->error);
        }
        
        // 5. Inserir item inicial na tabela CHEST (item 205043 com expiração 2030)
        $item_id = 205043;
        $item_quantity = 1;
        $expire_date = '2030-12-31 23:59:59'; // Expiração até 2030
        
        $stmt = $conn->prepare("INSERT INTO chest (Item, Volume, Expire, Owner, Acquisition, Wearing, ExpireType) VALUES (?, ?, ?, ?, 'G', '0', 'W')");
        $stmt->bind_param("iiss", $item_id, $item_quantity, $expire_date, $login);
        
        if (!$stmt->execute()) {
            throw new Exception("Erro ao inserir item no chest: " . $stmt->error);
        }
        
        // Commit da transação
        $conn->commit();
    } catch (Exception $e) {
        // Rollback em caso de erro
        $conn->rollback();
        return ['success' => false, 'message' => 'Erro ao criar conta: ' . $e->getMessage()];
    }
    
    return ['success' => true, 'message' => 'Conta criada com sucesso!'];
}

/**
 * Obter informações do usuário
 * Usa gunwcuser como tabela principal
 */
function getUserInfo($user_id) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT g.*, gw.E_Mail, gw.Authority, gw.Status FROM game g LEFT JOIN gunwcuser gw ON g.Id = gw.Id WHERE g.Id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
}

/**
 * Logout
 */
function logout() {
    session_unset();
    session_destroy();
}

/**
 * Validar email
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validar login/nick (6-12 caracteres, alfanumérico)
 */
function validateUsername($username) {
    return preg_match('/^[a-zA-Z0-9]{6,12}$/', $username);
}

/**
 * Obter todos os usuários (para admin)
 * Usa gunwcuser como tabela principal
 */
function getAllUsers($limit = 50, $offset = 0) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT g.Id, g.Nickname, g.TotalScore, g.Money, g.TotalRank, gw.E_Mail, gw.Authority, gw.Status FROM game g LEFT JOIN gunwcuser gw ON g.Id = gw.Id ORDER BY g.TotalRank ASC LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    
    return $users;
}

/**
 * Contar total de usuários
 */
function countUsers() {
    global $conn;
    $result = $conn->query("SELECT COUNT(*) as total FROM game");
    $row = $result->fetch_assoc();
    return $row['total'];
}

/**
 * Atualizar status do usuário (ban/unban)
 * Usa gunwcuser como tabela principal
 */
function updateUserStatus($user_id, $status) {
    global $conn;
    
    $stmt = $conn->prepare("UPDATE gunwcuser SET Status = ? WHERE Id = ?");
    $stmt->bind_param("ss", $status, $user_id);
    return $stmt->execute();
}

/**
 * Atualizar autoridade do usuário
 * Usa gunwcuser como tabela principal
 */
function updateUserAuthority($user_id, $authority) {
    global $conn;
    
    $stmt = $conn->prepare("UPDATE gunwcuser SET Authority = ? WHERE Id = ?");
    $stmt->bind_param("is", $authority, $user_id);
    return $stmt->execute();
}
?>

