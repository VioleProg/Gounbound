<?php


Function checapagina($pagina_original){
    $pagina_erro='index.php'; // Nome da página para onde será direcionada a página que for bloqueiada
    $redirecionar=$pagina_erro; // Redireciona e manda uma variável 'p' com o nome da página que estava sendo acessada
    $pagina_browser=end(explode("/", $_SERVER['SCRIPT_NAME'])); // Captura a página que está sendo acessada no browser
        if($pagina_original==$pagina_browser){
            exit(header("Location: $redirecionar")); // Para a execução e redireciona
        }
}
?>
