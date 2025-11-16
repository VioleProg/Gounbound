<?php
require_once '../config.php';
header('Content-Type: application/json');

$countries_dir = '../Assets/pais/';
$countries = [];

// Primeiro, criar um mapeamento de nomes de arquivos para nomes da tabela
$flag_to_country_map = [
    'Brasil.png' => 'Brazil',
    'United Kingdom(Great Britain).png' => 'United Kingdom',
    'USA.png' => 'United States',
    'Myanmar(Burma).png' => 'Myanmar',
    'Congo-Brazzaville.png' => 'Congo',
    'Congo-Kinshasa(Zaire).png' => 'Zaire',
    'Timor-Leste.png' => 'East Timor',
    'Cambodja.png' => 'Cambodia',
    'South Afriica.png' => 'South Africa',
    'Tahiti(French Polinesia).png' => 'Tahiti',
    'Vanutau.png' => 'Vanuatu'
];

// Buscar países da tabela country_reference
try {
    $result = $conn->query("SELECT Country_Number, Country_Name FROM country_reference ORDER BY Country_Name ASC");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $country_name = $row['Country_Name'];
            $country_number = $row['Country_Number'];
            
            // Tentar encontrar o arquivo de bandeira correspondente
            // Primeiro tenta o nome exato
            $flag_file = $country_name . '.png';
            $flag_path = $countries_dir . $flag_file;
            
            // Se não encontrar, verificar no mapeamento
            if (!file_exists($flag_path)) {
                $found = false;
                foreach ($flag_to_country_map as $flag_file_map => $country_name_map) {
                    if ($country_name_map === $country_name) {
                        $flag_file = $flag_file_map;
                        $flag_path = $countries_dir . $flag_file;
                        if (file_exists($flag_path)) {
                            $found = true;
                            break;
                        }
                    }
                }
                
                // Se ainda não encontrou, tentar buscar por similaridade
                if (!$found && is_dir($countries_dir)) {
                    $files = scandir($countries_dir);
                    foreach ($files as $file) {
                        if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'png') {
                            $file_name = pathinfo($file, PATHINFO_FILENAME);
                            // Comparação simples (pode ser melhorada)
                            if (stripos($file_name, $country_name) !== false || stripos($country_name, $file_name) !== false) {
                                $flag_file = $file;
                                $flag_path = $countries_dir . $file;
                                break;
                            }
                        }
                    }
                }
            }
            
            // Adicionar à lista (mesmo sem arquivo, para que o país possa ser selecionado)
            $countries[] = [
                'name' => $country_name,
                'number' => $country_number,
                'flag' => file_exists($flag_path) ? 'Assets/pais/' . $flag_file : 'Assets/pais/default.png'
            ];
        }
    }
} catch (Exception $e) {
    // Log do erro para debug
    error_log("Erro ao buscar países: " . $e->getMessage());
    // Fallback: buscar arquivos da pasta e tentar mapear
    if (is_dir($countries_dir)) {
        $files = scandir($countries_dir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'png' && $file !== 'Thumbs.db') {
                $country_name = pathinfo($file, PATHINFO_FILENAME);
                
                // Tentar encontrar na tabela country_reference
                $country_number = 28; // Default
                if (isset($flag_to_country_map[$file])) {
                    $mapped_name = $flag_to_country_map[$file];
                    $stmt = $conn->prepare("SELECT Country_Number FROM country_reference WHERE Country_Name = ? LIMIT 1");
                    if ($stmt) {
                        $stmt->bind_param("s", $mapped_name);
                        $stmt->execute();
                        $result_map = $stmt->get_result();
                        if ($row_map = $result_map->fetch_assoc()) {
                            $country_number = $row_map['Country_Number'];
                            $country_name = $mapped_name;
                        }
                        $stmt->close();
                    }
                } else {
                    // Tentar buscar pelo nome do arquivo
                    $stmt = $conn->prepare("SELECT Country_Number, Country_Name FROM country_reference WHERE Country_Name = ? LIMIT 1");
                    if ($stmt) {
                        $stmt->bind_param("s", $country_name);
                        $stmt->execute();
                        $result_map = $stmt->get_result();
                        if ($row_map = $result_map->fetch_assoc()) {
                            $country_number = $row_map['Country_Number'];
                            $country_name = $row_map['Country_Name'];
                        }
                        $stmt->close();
                    }
                }
                
                $countries[] = [
                    'name' => $country_name,
                    'number' => $country_number,
                    'flag' => 'Assets/pais/' . $file
                ];
            }
        }
    }
}

// Se não encontrou países, retornar erro
if (empty($countries)) {
    echo json_encode([
        'success' => false, 
        'message' => 'Nenhum país encontrado',
        'countries' => []
    ]);
} else {
    echo json_encode(['success' => true, 'countries' => $countries]);
}

