<?php





Function checapagina($pagina_original){

    $pagina_erro='index.php'; // Nome da pсgina para onde serс direcionada a pсgina que for bloqueiada

    $redirecionar=$pagina_erro; // Redireciona e manda uma variсvel 'p' com o nome da pсgina que estava sendo acessada

    $pagina_browser=end(explode("/", $_SERVER['SCRIPT_NAME'])); // Captura a pсgina que estс sendo acessada no browser

        if($pagina_original==$pagina_browser){

            exit(header("Location: $redirecionar")); // Para a execuчуo e redireciona

        }

}

?>