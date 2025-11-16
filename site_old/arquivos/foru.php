<!-- sub contents center -->
					<div class="sub_contents_center">
						<div class="sub_contents_center_area">
							<!-- .. .. -->
							<p class="sub_center_tit"><img src="modulos/foru/img/titulo.gif" alt="Guia do Jogo" class="vat" /></p>
							<p class="sub_center_text"><div style="padding-left:30px; padding-right:30px;"><br>
								

								
						
													
								</div>
								<div class="paging_all">
									<div class="page">

									<?php include("modulos/foru/paginacao.php");?>
															
									</div>

								</div>
									<? } // fim if topicos?>	
							</div>
							<!-- .. . -->

						</div>
				
					<div class="sub_contents_center_bottom"></div>
				
					<script src="modulos/foru/tiny_mce/tiny_mce.js" type="text/javascript"></script>
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



				
