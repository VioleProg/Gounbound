<?php
/**
 * Sistema de Ranks baseado em GP Standards
 * Baseado na tabela de níveis do Gunbound
 */

// Array de ranks com GP Standards (da imagem fornecida)
// Mapeamento para Image 1.bmp até Image 47.bmp da pasta Assets/rank
function getRankStandards() {
    return [
        // Níveis especiais
        ['grade' => -5, 'name' => 'Administrator', 'gp' => 0, 'image' => 'Image 43.bmp', 'special' => true],
        ['grade' => -4, 'name' => 'Emo', 'gp' => 0, 'image' => 'Image 44.bmp', 'special' => true],
        ['grade' => -3, 'name' => 'Gold Trophy', 'gp' => 0, 'image' => 'Image 46.bmp', 'special' => true],
        ['grade' => -2, 'name' => 'Silver Trophy', 'gp' => 0, 'image' => 'Image 47.bmp', 'special' => true],
        ['grade' => -1, 'name' => 'Bronze Trophy', 'gp' => 0, 'image' => 'Image 45.bmp', 'special' => true],
        ['grade' => 21, 'name' => 'VIP', 'gp' => 0, 'image' => 'Image 43.bmp', 'special' => true],
        
        // Dragons (Image 28-32) - Baseado na tabela fornecida
        ['grade' => 24, 'name' => 'Dragão de Prata', 'gp' => 200870, 'image' => 'Image 32.bmp'],
        ['grade' => 23, 'name' => 'Dragão Vermelho', 'gp' => 110179, 'image' => 'Image 31.bmp'],
        ['grade' => 22, 'name' => 'Dragão Azul', 'gp' => 64006, 'image' => 'Image 30.bmp'],
        
        // Scepters/Holes (Image 24-27) - Baseado na tabela
        ['grade' => 21, 'name' => 'Cetro de Diamante', 'gp' => 39592, 'image' => 'Image 27.bmp'],
        ['grade' => 47, 'name' => 'Cetro de Ruby', 'gp' => 25775, 'image' => 'Image 26.bmp'],
        ['grade' => 19, 'name' => 'Cetro de Safira', 'gp' => 15451, 'image' => 'Image 25.bmp'],
        ['grade' => 18, 'name' => 'Cetro de Violeta', 'gp' => 10304, 'image' => 'Image 24.bmp'],
        
        // Double Axes (Image 13-18) - Baseado na tabela
        ['grade' => 12, 'name' => 'Machado de Ouro com Duas Lâminas +', 'gp' => 9450, 'image' => 'Image 18.bmp'],
        ['grade' => 11, 'name' => 'Machado de Ouro com Duas Lâminas', 'gp' => 8550, 'image' => 'Image 17.bmp'],
        ['grade' => 10, 'name' => 'Machado de Prata com Duas Lâminas +', 'gp' => 7700, 'image' => 'Image 16.bmp'],
        ['grade' => 9, 'name' => 'Machado de Prata com Duas Lâminas', 'gp' => 6900, 'image' => 'Image 15.bmp'],
        ['grade' => 8, 'name' => 'Machado de Metal com Duas Lâminas +', 'gp' => 6150, 'image' => 'Image 14.bmp'],
        ['grade' => 7, 'name' => 'Machado de Metal com Duas Lâminas', 'gp' => 5450, 'image' => 'Image 13.bmp'],
        
        // Single Axes (Image 9-12) - Baseado na tabela
        ['grade' => 6, 'name' => 'Machado de Ouro Duplo', 'gp' => 4800, 'image' => 'Image 12.bmp'],
        ['grade' => 5, 'name' => 'Machado de Ouro', 'gp' => 4200, 'image' => 'Image 11.bmp'],
        ['grade' => 4, 'name' => 'Machado de Prata Duplo', 'gp' => 3650, 'image' => 'Image 10.bmp'],
        ['grade' => 3, 'name' => 'Machado de Prata', 'gp' => 3150, 'image' => 'Image 9.bmp'],
        
        // Metal/Stone Axes (Image 5-8) - Baseado na tabela
        ['grade' => 2, 'name' => 'Machado de Metal Duplo', 'gp' => 2700, 'image' => 'Image 8.bmp'],
        ['grade' => 1, 'name' => 'Machado de Metal', 'gp' => 2300, 'image' => 'Image 7.bmp'],
        ['grade' => 0, 'name' => 'Martelo de Pedra Duplo', 'gp' => 1950, 'image' => 'Image 6.bmp'],
        ['grade' => -1, 'name' => 'Martelo de Pedra', 'gp' => 1650, 'image' => 'Image 5.bmp'],
        
        // Wood Hammers (Image 3-4) - Baseado na tabela
        ['grade' => -2, 'name' => 'Martelo de Madeira Duplo', 'gp' => 1400, 'image' => 'Image 4.bmp'],
        ['grade' => -3, 'name' => 'Martelo de Madeira', 'gp' => 1200, 'image' => 'Image 3.bmp'],
        
        // A Little Chick (Image 2) - rank mais baixo
        ['grade' => -4, 'name' => 'Pintinho', 'gp' => 1000, 'image' => 'Image 2.bmp'],
    ];
}

/**
 * Obter rank atual do jogador baseado no GP
 */
function getCurrentRank($gp) {
    $ranks = getRankStandards();
    
    // Filtrar apenas ranks com GP >= 1000 (incluindo Pintinho) e ordenar por GP decrescente
    $ranks_with_gp = array_filter($ranks, function($r) {
        return $r['gp'] >= 1000 && !isset($r['special']);
    });
    
    usort($ranks_with_gp, function($a, $b) {
        return $b['gp'] - $a['gp'];
    });
    
    // Se GP menor que 1000, retorna Pintinho
    if ($gp < 1000) {
        foreach ($ranks as $rank) {
            if ($rank['grade'] == -4) {
                return $rank;
            }
        }
        return ['grade' => -4, 'name' => 'Pintinho', 'gp' => 1000, 'image' => 'Image 2.bmp'];
    }
    
    // Encontrar o rank baseado no GP (maior rank que o jogador alcançou)
    foreach ($ranks_with_gp as $rank) {
        if ($gp >= $rank['gp']) {
            return $rank;
        }
    }
    
    // Se não encontrou, retorna Pintinho (rank mais baixo)
    foreach ($ranks as $rank) {
        if ($rank['grade'] == -4) {
            return $rank;
        }
    }
    
    return ['grade' => -4, 'name' => 'Pintinho', 'gp' => 1000, 'image' => 'Image 2.bmp'];
}

/**
 * Obter próximo rank
 */
function getNextRank($current_gp) {
    $ranks = getRankStandards();
    
    // Filtrar apenas ranks com GP >= 1000 e ordenar por GP CRESCENTE (do menor para o maior)
    $ranks_with_gp = array_filter($ranks, function($r) {
        return !isset($r['special']) && $r['gp'] >= 1000;
    });
    
    usort($ranks_with_gp, function($a, $b) {
        return $a['gp'] - $b['gp']; // Ordenar CRESCENTE
    });
    
    $ranks_with_gp = array_values($ranks_with_gp); // Reindexar
    
    $current_rank = getCurrentRank($current_gp);
    
    // Se já está no máximo (Dragão de Prata), retorna null
    if ($current_rank['grade'] == 24) {
        return null;
    }
    
    // Encontrar o próximo rank imediato (primeiro rank com GP maior que o GP do rank atual)
    foreach ($ranks_with_gp as $rank) {
        if ($rank['gp'] > $current_rank['gp']) {
            return $rank; // Retorna o primeiro rank encontrado (próximo imediato)
        }
    }
    
    return null; // Já está no rank máximo
}

/**
 * Calcular progresso para próximo rank
 */
function getRankProgress($current_gp) {
    $current_rank = getCurrentRank($current_gp);
    $next_rank = getNextRank($current_gp);
    
    if (!$next_rank || $next_rank['gp'] == 0) {
        return [
            'current' => $current_rank,
            'next' => null,
            'progress' => 100,
            'gp_needed' => 0,
            'gp_current' => $current_gp,
            'gp_total' => 0
        ];
    }
    
    // GP atual dentro do range do rank atual
    $gp_current = $current_gp - $current_rank['gp'];
    // GP total necessário para o próximo rank
    $gp_total = $next_rank['gp'] - $current_rank['gp'];
    // GP que falta para o próximo rank
    $gp_needed = $next_rank['gp'] - $current_gp;
    
    // Calcular porcentagem
    $progress = ($gp_total > 0) ? ($gp_current / $gp_total) * 100 : 0;
    
    return [
        'current' => $current_rank,
        'next' => $next_rank,
        'progress' => min(100, max(0, $progress)),
        'gp_needed' => max(0, $gp_needed),
        'gp_current' => max(0, $gp_current),
        'gp_total' => $gp_total
    ];
}

/**
 * Obter imagem do rank
 */
function getRankImage($grade, $size = 'small') {
    $ranks = getRankStandards();
    foreach ($ranks as $rank) {
        if ($rank['grade'] == $grade) {
            if ($size == 'large') {
                $width = 56;
                $height = 56;
            } elseif ($size == 'medium') {
                $width = 40;
                $height = 40;
            } else {
                $width = 28;
                $height = 28;
            }
            $image = $rank['image'] ?? 'Image 2.bmp';
            return '<img src="Assets/rank/' . $image . '" width="' . $width . '" height="' . $height . '" alt="' . $rank['name'] . '" style="vertical-align: middle;" />';
        }
    }
    return '';
}

/**
 * Obter nome da imagem do rank
 */
function getRankImageName($grade) {
    $ranks = getRankStandards();
    foreach ($ranks as $rank) {
        if ($rank['grade'] == $grade) {
            return $rank['image'] ?? 'Image 2.bmp';
        }
    }
    return 'Image 2.bmp';
}

