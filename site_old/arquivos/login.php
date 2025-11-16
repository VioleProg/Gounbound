<?php
require_once("blockpage.php"); // Requere a página onde está a função
checapagina( basename(__FILE__) ); // Chama a função
?>
<div id="topo_perfil"><link rel="stylesheet" href="../gbound.html" type="text/css">
  <form name="id_search"  method="post"><div id="topo_perfil_conteudo">
  <div id="topo_perfil_login">
  <div id="topo_perfil_usuario">
    <input name="usuario" type="text" class="login"/>
  </div></div>
  <div id="topo_perfil_senha">
    <input name="senha" type="password"  class="login"/>
  </div>
	<div id="topo_perfil_lembrarsenha"><a href="#"><img src="images/icones/06.png" width="22" height="13" /> Esqueceu sua senha?</a></div>
    <div id="topo_perfil_entrar">
      <input src="images/botao_join.png" name="Submit2" type="image"  />
    </div>
  </div></form>   
</div>