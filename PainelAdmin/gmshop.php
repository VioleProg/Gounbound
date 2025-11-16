<?php 
// verify.php já é incluído em header.php
include("header.php"); 
?>
					<div id="main">




	<h1>Loja de Avatares GM</h1>

	<p><b>LEMBRE-SE:</b> Certos avatares são apenas para GM. Eles têm <font color='red'>(GM)</font> ao lado deles.</p>

	<form id="select_user" action='' method='post'>

	<fieldset>
		<legend>Enviar Avatar(s)</legend>

   <b><font color='blue'>Gênero Masculino:</font></b><br /> <br />
   
   <b>Cabeça Masculina: </b>

   <b>Corpo Masculino: </b>
  
   <b>Cabeça com Óculos Masculina: </b>
   <br /><br />
   
   
   <b><font color='blue'>Gênero Feminino:</font> </b><br /><br />
   <b>Cabeça Feminina: </b>
   <b>Corpo Feminino: </b>
   <b>Cabeça com Óculos Feminina: </b> <br /><br />
   
   <b><font color='blue'>Unissex:</font> </b><br /><br />
   <b>Bandeiras: </b>
   
   <b>Planos de Fundo</b><br /><br />
   
   ID de Login: <input type='text' name='loginid' />
   <p class="quick">
       <input type="submit" value="Enviar Avatar" class="button1">
       <a href="admin_panel.php" class="button1">Voltar</a>
   </p>
  </fieldset>
			<span class="corners-bottom"><span></span></span>
			<div class="clear"></div>
</div>
<?PHP include "footer.php"; ?>