<?php
require_once 'config.php';
require_once 'includes/functions.php';
require_once 'includes/rank_functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_info = getUserInfo($user_id);

global $conn;

// Buscar avatares do chest
$stmt = $conn->prepare("SELECT c.*, a.Name, a.Type, a.Gender FROM chest c LEFT JOIN avatar_table a ON c.Item = a.cod_num WHERE c.Owner = ? ORDER BY a.Name ASC");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$avatars = [];
while ($row = $result->fetch_assoc()) {
    $avatars[] = $row;
}

// Buscar avatares do closet
$stmt = $conn->prepare("SELECT c.*, a.Name, a.Type, a.Gender FROM closet c LEFT JOIN avatar_table a ON c.Item = a.cod_num WHERE c.Owner = ? ORDER BY a.Name ASC");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$closet_avatars = [];
while ($row = $result->fetch_assoc()) {
    $closet_avatars[] = $row;
}

$page_title = 'Meus Avatares';
include 'includes/header.php';
?>

<main class="main-content">
    <div class="container">
        <div class="avatars-header">
            <button class="btn-voltar" onclick="window.location.href='dashboard.php'">
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
                        <?php if (empty($avatars)): ?>
                            <tr>
                                <td colspan="4" class="text-center">Nenhum avatar encontrado</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($avatars as $avatar): 
                                $item_code = $avatar['Item'];
                                $avatar_name = $avatar['Name'] ?? 'Desconhecido';
                                $avatar_type = $avatar['Type'] ?? 'Unknown';
                                $type_icon = getTypeIcon($avatar_type);
                            ?>
                            <tr data-item="<?php echo htmlspecialchars($item_code); ?>">
                                <td>
                                    <div class="avatar-image">
                                        <img src="get_avatar_image.php?item=<?php echo $item_code; ?>" alt="<?php echo htmlspecialchars($avatar_name); ?>" onerror="this.src='Assets/images/no_avatar.png'">
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-type-icon"><?php echo $type_icon; ?></div>
                                </td>
                                <td>
                                    <div class="avatar-name"><?php echo htmlspecialchars($avatar_name); ?></div>
                                </td>
                                <td>
                                    <div class="avatar-actions">
                                        <button class="btn-delete" onclick="deleteAvatar('<?php echo $item_code; ?>', false)">
                                            DELETE
                                        </button>
                                        <button class="btn-closet" onclick="moveToCloset('<?php echo $item_code; ?>')">
                                            CLOSET
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
                        <?php if (empty($closet_avatars)): ?>
                            <tr>
                                <td colspan="4" class="text-center">Nenhum avatar no closet</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($closet_avatars as $avatar): 
                                $item_code = $avatar['Item'];
                                $avatar_name = $avatar['Name'] ?? 'Desconhecido';
                                $avatar_type = $avatar['Type'] ?? 'Unknown';
                                $type_icon = getTypeIcon($avatar_type);
                            ?>
                            <tr data-item="<?php echo htmlspecialchars($item_code); ?>">
                                <td>
                                    <div class="avatar-image">
                                        <img src="get_avatar_image.php?item=<?php echo $item_code; ?>" alt="<?php echo htmlspecialchars($avatar_name); ?>" onerror="this.src='Assets/images/no_avatar.png'">
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-type-icon"><?php echo $type_icon; ?></div>
                                </td>
                                <td>
                                    <div class="avatar-name"><?php echo htmlspecialchars($avatar_name); ?></div>
                                </td>
                                <td>
                                    <div class="avatar-actions">
                                        <button class="btn-delete" onclick="deleteAvatar('<?php echo $item_code; ?>', true)">
                                            DELETE
                                        </button>
                                        <button class="btn-recover" onclick="recoverFromCloset('<?php echo $item_code; ?>')">
                                            RECUPERAR
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php
function getTypeIcon($type) {
    $icons = [
        'Helm' => '<i class="fas fa-hard-hat"></i>',
        'Body' => '<i class="fas fa-tshirt"></i>',
        'Accessory' => '<i class="fas fa-gem"></i>',
        'Weapon' => '<i class="fas fa-sword"></i>',
    ];
    return $icons[$type] ?? '<i class="fas fa-question"></i>';
}
?>

<style>
.avatars-header {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    align-items: center;
}

.btn-voltar, .btn-ordenar {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.btn-voltar {
    background: #6b7280;
    color: white;
}

.btn-voltar:hover {
    background: #4b5563;
}

.btn-ordenar {
    background: #f97316;
    color: white;
}

.btn-ordenar:hover {
    background: #ea580c;
}

.avatars-section, .closet-section {
    background: var(--bg-white);
    padding: 2rem;
    border-radius: 12px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin: 0 0 1.5rem 0;
}

.closet-description {
    color: var(--text-light);
    margin-bottom: 1.5rem;
    line-height: 1.6;
    padding: 1rem;
    background: var(--bg-gray);
    border-radius: 8px;
}

.avatars-table-container {
    overflow-x: auto;
}

.avatars-table {
    width: 100%;
    border-collapse: collapse;
}

.avatars-table thead {
    background: var(--bg-gray);
}

.avatars-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: var(--text-dark);
    border-bottom: 2px solid var(--border-color);
}

.avatars-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.avatar-image {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.avatar-type-icon {
    font-size: 1.5rem;
    color: var(--primary-color);
}

.avatar-name {
    font-weight: 600;
    color: var(--text-dark);
}

.avatar-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-delete, .btn-closet, .btn-recover {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-delete {
    background: #6b7280;
    color: white;
}

.btn-delete:hover {
    background: #4b5563;
}

.btn-closet, .btn-recover {
    background: #fbbf24;
    color: #000;
}

.btn-closet:hover, .btn-recover:hover {
    background: #f59e0b;
}

.text-center {
    text-align: center;
    color: var(--text-light);
    padding: 2rem;
}
</style>

<script>
function moveToCloset(item) {
    if (!confirm('Deseja mover este avatar para o closet?')) return;
    
    const formData = new FormData();
    formData.append('action', 'move_to_closet');
    formData.append('item', item);
    
    fetch('api/avatar_closet.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('Erro ao mover avatar');
    });
}

function recoverFromCloset(item) {
    if (!confirm('Deseja recuperar este avatar do closet?')) return;
    
    const formData = new FormData();
    formData.append('action', 'recover_from_closet');
    formData.append('item', item);
    
    fetch('api/avatar_closet.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('Erro ao recuperar avatar');
    });
}

function deleteAvatar(item, fromCloset) {
    if (!confirm('Tem certeza que deseja deletar este avatar? Esta ação não pode ser desfeita!')) return;
    
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('item', item);
    formData.append('from_closet', fromCloset ? '1' : '0');
    
    fetch('api/avatar_closet.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('Erro ao deletar avatar');
    });
}

function sortAvatars() {
    const tbody = document.getElementById('avatarsList');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        const nameA = a.querySelector('.avatar-name').textContent.trim();
        const nameB = b.querySelector('.avatar-name').textContent.trim();
        return nameA.localeCompare(nameB);
    });
    
    rows.forEach(row => tbody.appendChild(row));
}
</script>

<?php include 'includes/footer.php'; ?>

