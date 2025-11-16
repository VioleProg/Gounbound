<style>
					table.ranking_full {border: 1px solid #e4dd3a; border-bottom: 0px; width: 100%;}
					table.ranking_full th {padding: 5px; text-align: center;}
					table.ranking_full td {padding: 1px; text-align: center;}
					table.ranking_full th {border-bottom: 1px solid #e4dd3a; background-color: #f7fccf; color: #666;}
						th.rank_placing, td.rank_placing {width: 10%;}
						th.rank_icon, td.rank_icon {width: 10%}
						th.player_nick, td.player_nick {width: 30%;}
						th.player_exp, td.player_exp {width: 20%;}
						table.ranking_full td {border-bottom: 1px solid #e2ded3;}

</style>
<div id="info_page">
  <div id="info_page_texto" align="center">F&oacute;rum</div></div><div id="center_bg_topo"><div id="centro_logotipo"></div> <div id="centro_titulo"></div>
</div> <div id="center_conteudo_meio">
  <div id="centro_meio_conteudo">
    <div align="center"></div><br />
    <div id="bg_news_texto"><?php

	
	// pega a id do tópico
	if (!is_numeric($_GET["id"])){
		$_GET["id"] = 0;
	} else {
		$item=$_GET["id"];
	}
	// verifica se esta chamando paginação, caso contrário vai da primeira e única pagina
	 if (!isset($_GET["pg"])) {
        $pg = 0;
    } else{
		$pg = $_GET["pg"];
	}
	
/* xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx VERIFICA SE POSTOU SUBMSG PARA O TOPICO PARA ENTRAR NA DB
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx 
ENTRANDO RESPOSTAS NA DB
 */
if (isset($_POST["submsg"])){
$errors = array(); // set the errors array to empty, by default
$fields = array(); // stores the field values

$rules[] = "length<1000,submsg,Mensagem muito grande.";
$rules[] = "capt,cv,Código de segurança inválido.";
$errors = validateFields($_POST, $rules);

  if (!empty($errors))
	  {  
		$fields = $_POST;
	  }
	 else 
	  {
	$message = "Mensagem postada com sucesso!";
}

 if (!empty($errors))
    {
      echo "<div class='error' style='width:95%;'>Por favor, corrija os erros abaixo:\n<ul>";
      foreach ($errors as $error)
        echo "<li>$error</li>\n";
    
      echo "</ul></div><br />"; 
    }
	
	   if (!empty($message))
    {
      echo "<div class='notify'>$message</div><br />";
	
	$autor = $_SESSION["s_usuario"];
	$sNickName = getNick($_SESSION["s_usuario"]);
	$sLevel= getLevel($_SESSION["s_usuario"]);
	$titulo = $_POST["titulo"];
	$msg = $_POST["submsg"];
	$data =  date ("Y-m-d H:i:s");
	$insersub = "INSERT INTO forumlivre2 (NickName, CountryGrade, signforum, Msg_Id, IP, Author, Title, Comment, Date) VALUES ('$sNickName', '$sLevel', '    ', $item,'', '$autor', 'title', '$msg', '$data');";
	mysql_query($insersub);
}
} //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx ENTRANDO NA SUBDB FIMMMM	
	
	
// xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx ENTRANDO TÓPICO PARA DB
if (isset($_POST["msg"])){
$errors = array(); // set the errors array to empty, by default
$fields = array(); // stores the field values

$rules[] = "required,titulo,Título do tópico requerido.";
$rules[] = "required,msg,Texto requerido.";
$rules[] = "length=3-40,titulo, Títudo deve conter mais de 3 caracteres.";
$rules[] = "length<1000,msg,Mensagem muito grande.";
$rules[] = "capt,cv,Código de segurança inválido.";
$errors = validateFields($_POST, $rules);

  if (!empty($errors))
	  {  
		$fields = $_POST;
	  }
	 else 
	  {
	$message = "Tópico criado com sucesso";
}

 if (!empty($errors))
    {
      echo "<div class='error' style='width:95%;'>Por favor, corrija os erros abaixo:\n<ul>";
      foreach ($errors as $error)
        echo "<li>$error</li>\n";
    
      echo "</ul></div><br />"; 
    }
	
	   if (!empty($message))
    {
      echo "<div class='notify'>$message</div><br />";
	
	$autor = $_SESSION["s_usuario"];
	$sNickName = getNick($_SESSION["s_usuario"]);
	$sLevel= getLevel($_SESSION["s_usuario"]);
	$titulo = $_POST["titulo"];
	$msg = $_POST["msg"];
	$data =  date ("Y-m-d H:i:s");
	$inser = "INSERT INTO forumlivre (NickName, CountryGrade, signforum, Title, Text, Text2, Date, Author, Comments, class, lastpost) VALUES ('$sNickName', '$sLevel', '', '$titulo', '$msg', '1', now(), '$autor', 0, '1', '$data');";
	mysql_query($inser);
}
} //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx FIM DO TÓPICO
		
// VERIFICA SE CHAMOU NOVO TOPICO, SE SIM, COLOCA INPUT PARA DIGITAR TEXTO...
if (isset($_GET["a"])){ if(!checasessao()){echo 'Você precisa estar logado para abrir um tópico<br/><br/>';}else{
//
 ?>

	<table class="ranking_full" cellpadding="0" cellspacing="0">
		<tr style="background-color:#ccc">	
			<th class="rank_placing"style="width:30%"><? echo getImgLevel($_SESSION["s_usuario"]) ." " . getNick($_SESSION["s_usuario"]);?> </th>
			<th class="rank_icon">Novo tópico</th>
			<th class="player_exp">Data: <?echo date('now'); ?></th>
		</tr>
		<form action="" method="post">
		<tr>
			<td colspan="3">Título: <input type="text" name="titulo"  style="width:400px;"</td>
		</tr>
		<tr>
			<td colspan="3"><textarea name="msg" rows="6" cols="40" id="replicando" style="width:477px;"></textarea></td>
</tr>
<tr>
	<td>Repita:</td>
	<td><img src="CaptchaSecurityImages.php?width=180&height=50&characters=3" /></td>
	<td><input type="text" name="cv" style="width:40px;"><br><INPUT TYPE="image" name="salvar" SRC="arquivos/foru/img/btn_enviar.gif" BORDER="0" ALT="Enviar"></td>
			
		</tr>
		</form>
</table><br />

<script src="js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
	<script type="text/javascript">
tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
    elements : "replicando",
    theme_advanced_buttons1 : "mybutton,bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
    theme_advanced_buttons2 : "",
    theme_advanced_buttons3 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    plugins : 'inlinepopups',
    setup : function(ed) {
        // Add a custom button
        ed.addButton('mybutton', {
            title : 'My button',
            image : 'img/example.gif',
            onclick : function() {
				// Add you own code to execute something on click
				ed.focus();
                ed.selection.setContent('<strong></strong>');
            }
        });
    }
});
</script>

<?
 }}
	
	
	
	
// NÚMERO DE TOPICOS POR PÁGINA	
$numreg = 15;
$inicial = $pg * $numreg;
$sql2 = mysql_query("Select Count(*) as total From forumlivre", $link);
$quantreg = mysql_result($sql2, 0, 'total');

// exibe tópico de acordo com id.
$id_forum =  $_GET["id"];
$sql_forum = mysql_query("select * from forumlivre where id='$id_forum'");
$forum = mysql_fetch_array($sql_forum);

if (isset($item)){ //SE TIVER ID, MOSTRAR SOMENTE O TOPICO RELACIONADO A ID
?>
<table class="ranking_full" cellpadding="0" cellspacing="0">
	<tr style="background-color:#ccc">	
		<th class="rank_placing"style="width:30%"><? echo '<img src="images/rank/rank_' . $forum["CountryGrade"] .  '.gif" width="12" height="12"> '. getNick($forum["Author"]);?> </th>
		<th class="rank_icon"><?echo $forum["Title"] ?></th>
		<th class="player_exp">Data: <?echo $forum["Date"] ?></th>
	</tr>

<?
// mostra tópico
echo '
	<tr style="border-bottom:1px solid #ccc;height:30px;font-size:90%;text-align:left;">
		<td style="" width="5%" > <img src="arquivos/foru/img/q.gif"></td>
		<td style="text-align:left" width="60%">'. $forum["Text"] .'</td>
		<td style="text-align:left" width="15%"></td>
	</tr>
</table><br />';

// MOSTRA AS RESPOSTAS DO TÓPICO ATUAL
$sql_subforum = mysql_query("select * from forumlivre2 where Msg_Id='$id_forum'");
while($forum = mysql_fetch_array($sql_subforum)){
?>
<table class="ranking_full" cellpadding="0" cellspacing="0" style="border-color: #ccc">
	<tr >	
		<th class="rank_placing" style="background-color:#eee;width:30%;border-color: #ccc"><? echo '<span><img src="images/rank/rank_' . $forum["CountryGrade"] .  '.gif" width="12" height="12"> '. $forum["NickName"];?> </span></th>
		<th class="rank_icon" style="background-color:#eee;border-color: #ccc">Resposta:</th>
		<th class="player_exp" style="background-color:#eee;border-color: #ccc">Data: <?echo $forum["Date"]?></th>
	</tr>
	<?

	echo '
		<tr style="border-bottom:1px solid #ccc;height:30px;font-size:90%;text-align:left;">
			<td style="" width="5%" > <img src="arquivos/foru/img/q.gif"></td>
			<td style="text-align:left" width="60%">'. $forum["Comment"] .'</td>
			<td style="text-align:left" width="15%"></td>
		</tr>
		';
	} echo '</table>';
	


//verifica se tem autorização para postar msg para este tópico
if (!checasessao()){
echo "Para replicar o post, você precisa estar logado";
} else {
?>
<br />
<form action="?page=forum&id=<?=$id_forum?>" method="post">
<input type="hidden" value="<?=$id_forum?>">
<textarea name="submsg" rows="3" cols="40" style="width:477px"></textarea><br />
Repita:<img src="CaptchaSecurityImages.php?width=80&height=30&characters=3" /><input type="text" name="cv" style="width:40px;"><INPUT TYPE="image" name="salvar" SRC="arquivos/foru/img/btn_enviar.gif" BORDER="0" ALT="Enviar">
</form>
<? }
// exibe botão de voltar para os ot
echo'<br /><br />
<a href="?page=forum"><img src="arquivos/foru/img/bt_voltar.gif"></a>
</div>

';

} else { // SE NÃO TIVER ID, MOSTRAR TODOS OS ULTIMOS TOPICOS ! MOSTRA TUDO DO FÓRUM...
	?>
	<table>
		<tr>
			<td><a href="?page=forum&a=novo_topico"><img src="arquivos/foru/img/bt_novamsg.jpg" alt="Nova MSG"></a><br /></td>
		</tr>
		<tr>
			<form action="" method="post">
			<td>Procurar por:
				<select name="tbusca">
					<option value="0" selected>Tópicos:</option>
					<option value="1">Usuários:</option>
				</select>
				<input type="text" name="busca"><input type="image" src="arquivos/foru/img/bt_vai.gif"></td>
		  </form>
		</tr>
	</table>
	

								<div class="clear_all"></div>
						<table class="ranking_full" cellpadding="0" cellspacing="0">
							<tr>	
								<th class="rank_placing">Id</th>
								<th class="rank_icon"></th>
								<th class="rank_icon">Assunto</th>
								<th class="player_nick">Autor</th>
								<th class="player_exp">Data</th>
								
							</tr>
							
									<?php
									$_POST["busca"] = (get_magic_quotes_gpc ()) ? stripslashes ($_POST["busca"]) : $_POST["busca"]; 
									
									if (!is_numeric($_POST["tbusca"])){
										$_POST["tbusca"] = 0;
									}
									
									if (isset($_POST["busca"])){
										if ($_POST["tbusca"] == 0){
											//echo "topicos";
									$chave = $_POST["busca"];
									$sql_forum = mysql_query("select * from forumlivre where class != 'fixo' and Title like '%$chave%' order by Date desc LIMIT $inicial,$numreg ");
									$sql_forum_fixo = mysql_query("select * from forumlivre where class = 'fixo' and Title like '%$chave%' order by Date desc LIMIT $inicial,$numreg ");

										} else{
									$chave = $_POST["busca"];
									$sql_forum = mysql_query("select * from forumlivre where class != 'fixo' and NickName = '$chave' order by Date desc LIMIT $inicial,$numreg ");
									$sql_forum_fixo = mysql_query("select * from forumlivre where class = 'fixo' and NickName = '$chave' order by Date desc LIMIT $inicial,$numreg ");
											}
										
									} else{

									$sql_forum = mysql_query("select * from forumlivre where class != 'fixo' order by Date desc LIMIT $inicial,$numreg ");
									$sql_forum_fixo = mysql_query("select * from forumlivre where class = 'fixo' order by Date desc LIMIT $inicial,$numreg ");
										
										} 
									
									while($forum_fixo = mysql_fetch_array($sql_forum_fixo)){
									echo '
									<tr style="border-bottom:1px solid #ccc;height:30px;font-size:90%;text-align:left;">
										<td style="" width="5%"> ' . $forum_fixo["Id"] . '</td>
										<td style="" width="5%"><img src="arquivos/foru/img/lock.gif"></td>
										<td style="text-align:left" width="60%"><b>Fixo: </b><a href="?page=forum&id=' . $forum_fixo["Id"] .'">'. $forum_fixo["Title"] .'</a></td>
										<td style="text-align:left" width="15%"><img src="images/rank/rank_' . $forum_fixo["CountryGrade"] .  '.gif" width="12" height="12"> '. getNick($forum_fixo["Author"]) . '</td>
										<td style="text-align:left" width="15%">'. $forum_fixo["Date"] . '</td>
									</tr>
									
									';
									}									
									while($forum = mysql_fetch_array($sql_forum)){
									echo '
									<tr style="border-bottom:1px solid #ccc;height:30px;font-size:90%;text-align:left;">
										<td style="" width="5%"> ' . $forum["Id"] . '</td>
										<td style="" width="5%"><img src="arquivos/foru/img/q.gif"></td>
										<td style="text-align:left" width="60%"><a href="?page=forum&id=' . $forum["Id"] .'">'. $forum["Title"] .'</a></td>
										<td style="text-align:left" width="15%"><img src="images/rank/rank_' . $forum["CountryGrade"] .  '.gif" width="12" height="12"> '. getNick($forum["Author"]) . '</td>
										<td style="text-align:left" width="15%">'. $forum["Date"] . '</td>
									</tr>
									
									';
									}
									//echo '<li><span class="not_data">'. $noticia["data"] . '</span> - <span class="assunto"><a href="#" onclick="MM_openBrWindow(\'teen_news.php?noticia&cod=e23fadaf3fbb0a3r3e23fadaf3fbb0a3r3e23fadaf3fbb0a3r300bemadsfjaa.._ililili&id='. $noticia["id"] .'\',\'pet\',\'width=480,height=570\')">'. $noticia["assunto"] .'</a></span>';
									?>
</table>
                                </div> 
                                <? } // fim if topicos?>	

</div>
<div id="center_conteudo_footer"> <div id="centro_footer_texto_topo"><a href="#btopo" title="Topo"><img src="images/botoes/up.png" width="18" height="26" /></a></div>
</div>
<script src="js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
	<script type="text/javascript">
tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
    elements : "replicando",
    theme_advanced_buttons1 : "mybutton,bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
    theme_advanced_buttons2 : "",
    theme_advanced_buttons3 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    plugins : 'inlinepopups',
    setup : function(ed) {
        // Add a custom button
        ed.addButton('mybutton', {
            title : 'My button',
            image : 'img/example.gif',
            onclick : function() {
				// Add you own code to execute something on click
				ed.focus();
                ed.selection.setContent('<strong></strong>');
            }
        });
    }
});
</script>
