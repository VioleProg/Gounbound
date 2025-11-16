<?php 
include("header.php");
?>

<a name="maincontent"></a>
    
    <h1>Administração de Usuário</h1>
    
    <p><b>LEMBRE-SE:</b> Pesquise o usuário pelo ID de Login</p>
    
    <div class="admin-section" style="max-width: 600px;">
        <h2>Pesquisar Conta</h2>
        <form id="select_user" action='account.php' method='get' style="padding: 1.5rem;">
            <dl>
                <dt><label for="username">Encontrar um membro:</label></dt>
                <dd>
                    <input class="text medium" type="text" id="username" name="search" 
                           placeholder="Digite o ID do usuário" 
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--admin-border); border-radius: 8px;" required>
                </dd>
            </dl>
            
            <p class="quick" style="margin-top: 1rem;">
                <button type="submit" name="submit" 
                        style="background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); 
                               color: #ffffff; border: none; padding: 0.75rem 1.5rem; 
                               border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-search"></i> Pesquisar
                </button>
            </p>
        </form>
    </div>
    
    <p style="margin-top: 20px;">
        <a href="admin_panel.php" class="button1">Voltar ao Painel</a>
    </p>

<?php include("footer.php"); ?>
