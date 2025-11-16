<?php
require_once 'config.php';
require_once 'includes/functions.php';

$page_title = 'Início';
include 'includes/header.php';
?>

<main class="main-content">
    <section class="hero-section">
        <div class="hero-slider">
            <div class="slide active">
                <img src="Assets/banner1.jpg" alt="Banner 1">
            </div>
            <div class="slide">
                <img src="Assets/webeventohallo1.png" alt="Evento Halloween 1">
            </div>
            <div class="slide">
                <img src="Assets/webeventohallo2.png" alt="Evento Halloween 2">
            </div>
        </div>
        <div class="hero-content">
            <div class="hero-logo">
                <img src="Assets/logo.png" alt="Gunbol Logo">
            </div>
            <?php if (!isLoggedIn()): ?>
                <div class="hero-buttons">
                    <a href="register.php" class="btn btn-primary btn-large">Começar Agora</a>
                    <a href="login.php" class="btn btn-secondary btn-large">Fazer Login</a>
                </div>
            <?php else: ?>
                <div class="hero-buttons">
                    <a href="dashboard.php" class="btn btn-primary btn-large">Dashboard</a>
                    <a href="ranking.php" class="btn btn-secondary btn-large">Ver Ranking</a>
                </div>
            <?php endif; ?>
        </div>
        <div class="slider-controls">
            <button class="slider-btn prev" onclick="changeSlide(-1)"><i class="fas fa-chevron-left"></i></button>
            <button class="slider-btn next" onclick="changeSlide(1)"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="slider-dots">
            <span class="dot active" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </section>

    <section class="news-section">
        <div class="news-container">
            <div class="news-content-wrapper">
                <div class="news-list-container">
                    <?php
                    global $conn;
                    $allNews = [];
                    
                    // Buscar eventos
                    try {
                        $result = $conn->query("SELECT *, 'Evento' as Type FROM gbevents ORDER BY Date DESC LIMIT 10");
                        if ($result) {
                            while ($row = $result->fetch_assoc()) {
                                $allNews[] = $row;
                            }
                        }
                    } catch (Exception $e) {
                        // Se a tabela não existir, usar dados de exemplo
                    }
                    
                    // Buscar notícias de manutenção
                    try {
                        $result = $conn->query("SELECT *, 'Manutenção' as Type FROM gbnews WHERE Title LIKE '%manutenção%' OR Title LIKE '%maintenance%' ORDER BY Date DESC LIMIT 10");
                        if ($result) {
                            while ($row = $result->fetch_assoc()) {
                                $allNews[] = $row;
                            }
                        }
                    } catch (Exception $e) {
                        // Se não existir, usar exemplos
                    }
                    
                    // Buscar patch notes
                    try {
                        $result = $conn->query("SELECT *, 'Atualização' as Type FROM gbnews WHERE Title LIKE '%patch%' OR Title LIKE '%atualização%' ORDER BY Date DESC LIMIT 10");
                        if ($result) {
                            while ($row = $result->fetch_assoc()) {
                                $allNews[] = $row;
                            }
                        }
                    } catch (Exception $e) {
                        // Se não existir, usar exemplos
                    }
                    
                    // Se não houver notícias no banco, usar exemplos
                    if (empty($allNews)) {
                        $allNews = [
                            ['Title' => 'Bem-vindo ao Gunbound Mundial', 'Text' => 'Bem-vindo ao melhor servidor de Gunbound!', 'Date' => date('Y-m-d H:i:s'), 'Type' => 'Manutenção'],
                            ['Title' => 'Evento de Halloween', 'Text' => 'Participe do evento especial de Halloween!', 'Date' => date('Y-m-d H:i:s', strtotime('-2 days')), 'Type' => 'Evento'],
                            ['Title' => 'Atualização de Gunbound', 'Text' => 'Nova atualização disponível com melhorias e correções.', 'Date' => date('Y-m-d H:i:s', strtotime('-3 days')), 'Type' => 'Atualização'],
                            ['Title' => 'Novo sistema anti-hack', 'Text' => 'Sistema de segurança aprimorado para garantir fair play.', 'Date' => date('Y-m-d H:i:s', strtotime('-5 days')), 'Type' => 'Manutenção']
                        ];
                    }
                    
                    // Ordenar por data (mais recente primeiro)
                    usort($allNews, function($a, $b) {
                        return strtotime($b['Date']) - strtotime($a['Date']);
                    });
                    
                    // Primeira notícia (destaque)
                    $featuredNews = !empty($allNews) ? $allNews[0] : null;
                    $otherNews = array_slice($allNews, 1, 3);
                    ?>
                    
                    <?php if ($featuredNews): 
                        $typeLabel = '';
                        if ($featuredNews['Type'] == 'Evento') {
                            $typeLabel = 'Event';
                        } elseif ($featuredNews['Type'] == 'Manutenção') {
                            $typeLabel = 'Notice';
                        } else {
                            $typeLabel = 'Update';
                        }
                    ?>
                    <div class="news-featured">
                        <button class="news-type-btn news-type-<?php echo strtolower($featuredNews['Type']); ?>">
                            <?php echo $typeLabel; ?>
                        </button>
                        <h3 class="news-featured-title"><?php echo htmlspecialchars($featuredNews['Title']); ?></h3>
                        <div class="news-featured-date">
                            <?php echo date('Y.m.d', strtotime($featuredNews['Date'])); ?> <span><?php echo date('H', strtotime($featuredNews['Date'])); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="news-other-list">
                        <?php foreach ($otherNews as $news): 
                            $typeLabel = '';
                            if ($news['Type'] == 'Evento') {
                                $typeLabel = 'Event';
                            } elseif ($news['Type'] == 'Manutenção') {
                                $typeLabel = 'Notice';
                            } else {
                                $typeLabel = 'Update';
                            }
                        ?>
                        <div class="news-other-item">
                            <button class="news-type-btn news-type-<?php echo strtolower($news['Type']); ?>">
                                <?php echo $typeLabel; ?>
                            </button>
                            <h4 class="news-other-title"><?php echo htmlspecialchars($news['Title']); ?></h4>
                            <div class="news-other-date">
                                <?php echo date('Y.m.d', strtotime($news['Date'])); ?> <span><?php echo date('H', strtotime($news['Date'])); ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="news-navigation">
                        <button class="news-nav-btn" onclick="scrollNews(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="news-nav-btn" onclick="scrollNews(1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                
                <div class="news-logo-container">
                    <img src="Assets/logo.png" alt="Gunbol Logo" class="news-logo">
                </div>
            </div>
        </div>
    </section>

    <!-- Seção de Sets/Personagens -->
    <section class="sets-section">
        <div class="sets-background"></div>
        <div class="container">
            <h2 class="section-title">Sets Disponíveis</h2>
            <div class="sets-carousel-wrapper">
                <button class="carousel-btn prev-btn" onclick="scrollSetsCarousel(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="sets-carousel" id="setsCarousel">
                    <?php
                    $sets = [
                        ['name' => 'Fallen Angel', 'file' => 'Set_Fallen-Angel.gif', 'type' => 'Set'],
                        ['name' => 'Demon NF', 'file' => 'Set_Demon_NF_M.gif', 'type' => 'Set'],
                        ['name' => 'Santa Observador', 'file' => 'Santa_Observador_Set_H.gif', 'type' => 'Set'],
                        ['name' => 'Bizarrerie Santa', 'file' => 'Bizarrerie_Santa_Set_H.gif', 'type' => 'Set'],
                        ['name' => 'Angel U', 'file' => 'Angel_U_Set_H.gif', 'type' => 'Set'],
                        ['name' => 'Thunder Trooper', 'file' => 'Set_Thunder_trooper_M.gif', 'type' => 'Set'],
                        ['name' => 'Snowwoman', 'file' => 'Snowwoman_Set_M.gif', 'type' => 'Set'],
                        ['name' => 'Xmas Dragon', 'file' => 'Xmas_Dragon_Set_H.gif', 'type' => 'Set']
                    ];
                    
                    foreach ($sets as $set):
                    ?>
                    <div class="set-item">
                        <div class="set-image-wrapper">
                            <img src="Assets/gif/<?php echo htmlspecialchars($set['file']); ?>" alt="<?php echo htmlspecialchars($set['name']); ?>" class="set-image">
                        </div>
                        <div class="set-info">
                            <div class="set-name"><?php echo htmlspecialchars($set['name']); ?></div>
                            <div class="set-type">Tipo: <?php echo htmlspecialchars($set['type']); ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-btn next-btn" onclick="scrollSetsCarousel(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Seção de Screenshots -->
    <section class="screenshots-section">
        <div class="container">
            <h2 class="section-title">Screenshots</h2>
            <div class="screenshots-grid">
                <?php
                $screenshots = [
                    ['file' => 'screen 1.JPG', 'label' => 'Server List'],
                    ['file' => 'screen01.jpg', 'label' => 'Game List'],
                    ['file' => 'screen2.jpg', 'label' => 'Game Room'],
                    ['file' => 'scren3.jpg', 'label' => 'Game Room'],
                    ['file' => 'secren4.jpg', 'label' => 'Game Room'],
                    ['file' => 'screen6.jpg', 'label' => 'Server List']
                ];
                
                foreach ($screenshots as $screenshot):
                ?>
                <div class="screenshot-item" onclick="openScreenshotModal('Assets/shot/<?php echo htmlspecialchars($screenshot['file']); ?>')">
                    <div class="screenshot-image-wrapper">
                        <img src="Assets/shot/<?php echo htmlspecialchars($screenshot['file']); ?>" alt="<?php echo htmlspecialchars($screenshot['label']); ?>" class="screenshot-thumb">
                        <div class="screenshot-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                    <div class="screenshot-label"><?php echo htmlspecialchars($screenshot['label']); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Modal de Screenshot -->
    <div class="screenshot-modal" id="screenshotModal" onclick="if(event.target === this) closeScreenshotModal()">
        <div class="screenshot-modal-content">
            <button class="screenshot-modal-close" onclick="closeScreenshotModal()">
                <i class="fas fa-times"></i>
            </button>
            <img src="" alt="Screenshot" id="screenshotModalImage" onclick="event.stopPropagation()">
        </div>
    </div>

    <?php if (isLoggedIn()): 
        $user_info = getUserInfo($_SESSION['user_id']);
    ?>
    <section class="user-stats-section">
        <div class="stats-background"></div>
        <div class="container">
            <h2 class="section-title">Suas Estatísticas</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value"><?php echo number_format($user_info['TotalScore'] ?? 0); ?></div>
                    <div class="stat-label">Pontos Totais</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo number_format($user_info['Money'] ?? 0); ?></div>
                    <div class="stat-label">Gold</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">#<?php echo $user_info['TotalRank'] ?? 0; ?></div>
                    <div class="stat-label">Ranking</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo htmlspecialchars($user_info['Nickname'] ?? $user_info['NickName'] ?? 'N/A'); ?></div>
                    <div class="stat-label">Nickname</div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>

