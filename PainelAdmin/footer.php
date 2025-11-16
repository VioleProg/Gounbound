                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="page-footer" style="background: #1e293b; color: #ffffff; padding: 1.5rem 2rem; text-align: center; margin-top: auto; position: relative;">
        <p style="margin: 0; font-size: 0.85rem;">
             <strong>GunBound</strong> &copy; <?php echo date('Y'); ?> | 
            <a href="../" style="color: #818cf8; text-decoration: none;">Voltar ao Site</a>
        </p>
        <a href="https://discord.gg/uWz9kN7ShB" target="_blank" class="developer-logo" title="Desenvolvido por VioleProg" style="position: absolute; right: 2rem; bottom: 1.5rem;">
            <img src="../Assets/dev/violeprog.png" alt="VioleProg">
        </a>
    </div>
</div>

<script type="text/javascript">
var menu_state = 'shown';

function switch_menu() {
    var menu = document.getElementById('menu');
    var toggle = document.getElementById('toggle-handle');
    
    if (menu_state == 'shown') {
        menu.style.display = 'none';
        toggle.innerHTML = '&raquo;';
        menu_state = 'hidden';
    } else {
        menu.style.display = 'block';
        toggle.innerHTML = '&laquo;';
        menu_state = 'shown';
    }
}
</script>

</body>
</html>
