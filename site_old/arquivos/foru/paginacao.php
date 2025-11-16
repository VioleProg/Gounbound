<?php
require_once("blockpage.php"); // Requere a página onde está a função
checapagina( basename(__FILE__) ); // Chama a função
?>

<?php
$quant_pg = ceil($quantreg/$numreg);
$quant_pg++;

// Verifica se esta na primeira página, se nao estiver ele libera o link para anterior
if ( $pg > 0) {
	echo "<a href=".$PHP_SELF."?mdv=foru&id=". $item ."&pg=".($pg-1) ."class=pg><b>&laquo; anterior</b></a>";
} else {
	echo "<font color=#CCCCCC>&laquo; anterior</font>";
}

// Aqui começa a alteração
// faz o controle da quantidade de paginas irá mostrar em números na paginação

    if (($pg - 3) < 1 ){

    $ant = 1;

    } else {

    $ant = $pg - 3;

    }

    if (($pg + 6) > $quant_pg ) {

    $pos = $quant_pg;

    } else {

    $pos = $pg + 13;

    }

    

    // Faz aparecer os numeros das página entre o ANTERIOR e PROXIMO

    for($i_pg=$ant;$i_pg < $pos;$i_pg++) {

    // Aqui termina a alteração

        // Verifica se a página que o navegante esta e retira o link do número para identificar visualmente

        if ($pg == ($i_pg-1)) {

            echo "&nbsp;<span class=pgoff>[$i_pg]</span>&nbsp;";

        } else {

            $i_pg2 = $i_pg-1;

            echo "&nbsp;<a href=".$PHP_SELF."?mdv=foru&id=". $item ."&pg=$i_pg2 class=pg><b>$i_pg</b></a>&nbsp;";

        }

    }

    

    // Verifica se esta na ultima página, se nao estiver ele libera o link para próxima

    if (($pg+2) < $quant_pg) {

        echo "<a href=".$PHP_SELF."?mdv=foru&id=". $item ."&pg=".($pg+1)." class=pg><b>próximo &raquo;</b></a>";

    } else {

        echo "<font color=#CCCCCC>próximo &raquo;</font>";

    }

?>