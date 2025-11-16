<?php
// Detectar caminho base automaticamente (se não foi definido no header)
if (!isset($base_path)) {
    $base_path = '';
    if (strpos(__DIR__, '/admin') !== false || strpos(__DIR__, '\\admin') !== false) {
        $base_path = '../';
    }
}
?>
        <footer class="main-footer">
            <div class="container">
                <div class="footer-content">
                    <p>&copy; <?php echo date('Y'); ?> Gunbol. Todos os direitos reservados.</p>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- Partículas de fuligem -->
    <div class="particles-container" id="particlesContainer"></div>
    
    <script src="<?php echo $base_path; ?>Assets/js/main.js"></script>
</body>
</html>

