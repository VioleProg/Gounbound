<?php
require_once("blockpage.php"); // Requere a página onde está a função
checapagina( basename(__FILE__) ); // Chama a função
?>

<div id="topo_perfil"><link rel="stylesheet" href="../gbound.html" type="text/css">
<div id="logado_cash"><a href="index.php?page=cash"><img src="images/botoes/cash.png" border="0" height="45" width="54"></a></div>
<div id="logado_bg"><div id="logado_bg_nivel"><?=getImgLevel($_SESSION["s_usuario"]);?></div><div id="logado_bg_nickname">
  <div align="left"><?=$_SESSION["s_usuario"]?></div>
</div><div id="logado_bg_rank">RANK</div><div id="logado_bg_rank_total">
  <div align="right"><?=getRank($_SESSION["s_usuario"]);?></div>
</div>
  <div id="logado_bg_rank_gps">
		<div align="right"><?=getGP($_SESSION["s_usuario"]);?> GP</div>
  </div>
  <div id="logado_bg_linha"></div> 
  <div id="logado_bg_gold">GOLD</div> 
  <div id="logado_bg_gold_info"> 
  <div align="right"><?=getGold($_SESSION["s_usuario"]);?></div> 
  </div>
  <div id="logado_bg_cash">CASH</div> 
  <div id="logado_bg_cash_info"> 
  <div align="right"><?=getCash($_SESSION["s_usuario"]);?></div> 
  </div>
</div>
<div id="logado_status"><a href="index.php?page=perfil&amp;p=status"><img src="images/botoes/logado_status.png" border="0" height="22" width="99"></a></div>
<div id="logado_editar"><a href="index.php?page=perfil&amp;p=editar"><img src="images/botoes/logado_editar.png" border="0" height="22" width="99"></a></div>
<div id="logado_sair"><a href="?logout=1"><img src="images/botoes/logado_sair.png" border="0" height="22" width="99"></a></div>
  
</div>

