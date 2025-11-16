<?php
require_once '../config.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

global $conn;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 20;
$offset = ($page - 1) * $per_page;

// Parâmetros de busca e filtro
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'rank'; // rank, points, gold

// Construir query com busca e ordenação
$where_clause = '';
$params = [];
$types = '';

if (!empty($search)) {
    $where_clause = " WHERE g.Nickname LIKE ?";
    $search_param = '%' . $search . '%';
    $params[] = $search_param;
    $types .= 's';
}

// Ordenação
$order_clause = '';
switch ($sort_by) {
    case 'points':
        $order_clause = ' ORDER BY g.TotalScore DESC';
        break;
    case 'gold':
        $order_clause = ' ORDER BY g.Money DESC';
        break;
    case 'rank':
    default:
        $order_clause = ' ORDER BY g.TotalRank ASC';
        break;
}

// Query para contar total
$count_query = "SELECT COUNT(*) as total FROM game g" . $where_clause;
$count_stmt = $conn->prepare($count_query);
if (!empty($params) && !empty($types)) {
    $count_stmt->bind_param($types, ...$params);
}
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_row = $count_result->fetch_assoc();
$total_users = $total_row ? (int)$total_row['total'] : 0;
$total_pages = $total_users > 0 ? ceil($total_users / $per_page) : 1;

// Query para buscar usuários
$query = "SELECT g.Id, g.Nickname, g.TotalScore, g.Money, g.TotalRank, gw.E_Mail, gw.Authority, gw.Status 
          FROM game g 
          LEFT JOIN gunwcuser gw ON g.Id = gw.Id" . 
          $where_clause . 
          $order_clause . 
          " LIMIT ? OFFSET ?";

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $params[] = $per_page;
    $params[] = $offset;
    $types .= 'ii';
    $stmt->bind_param($types, ...$params);
} else {
    $stmt->bind_param("ii", $per_page, $offset);
}
$stmt->execute();
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

$html = '';

if (empty($users)) {
    $html = '<tr><td colspan="5" class="text-center">Nenhum jogador encontrado</td></tr>';
} else {
    foreach ($users as $index => $user) {
        $html .= '<tr>';
        $html .= '<td>' . ($offset + $index + 1) . '</td>';
        $html .= '<td><strong>' . htmlspecialchars($user['Nickname'] ?? $user['NickName'] ?? 'N/A') . '</strong></td>';
        $html .= '<td>' . number_format($user['TotalScore']) . '</td>';
        $html .= '<td>' . number_format($user['Money']) . '</td>';
        $html .= '<td>#' . $user['TotalRank'] . '</td>';
        $html .= '</tr>';
    }
}

$pagination = '';
if ($total_pages > 1) {
    $pagination .= '<div class="pagination">';
    if ($page > 1) {
        $pagination .= '<button class="btn btn-secondary" onclick="loadRankingPage(' . ($page - 1) . ', getRankingFilters())">Anterior</button>';
    }
    $pagination .= '<span>Página ' . $page . ' de ' . $total_pages . '</span>';
    if ($page < $total_pages) {
        $pagination .= '<button class="btn btn-secondary" onclick="loadRankingPage(' . ($page + 1) . ', getRankingFilters())">Próxima</button>';
    }
    $pagination .= '</div>';
}

echo json_encode([
    'success' => true,
    'html' => $html,
    'pagination' => $pagination,
    'page' => $page,
    'total_pages' => $total_pages,
    'total_users' => $total_users
]);

