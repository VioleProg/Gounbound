                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="page-footer" style="background: #1e293b; color: #ffffff; padding: 1.5rem 2rem; text-align: center; margin-top: auto;">
        <p style="margin: 0; font-size: 0.85rem;">
            Powered by <strong>GunBound Omega</strong> &copy; <?php echo date('Y'); ?> | 
            <a href="../" style="color: #818cf8; text-decoration: none;">Voltar ao Site</a>
        </p>
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
