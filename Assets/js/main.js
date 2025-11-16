// Main JavaScript for Gunbol Website

document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Form validation enhancement
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Remove previous error states
            const inputs = form.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.classList.remove('error');
            });

            let isValid = true;

            // Check required fields
            inputs.forEach(input => {
                if (input.hasAttribute('required') && !input.value.trim()) {
                    isValid = false;
                    input.classList.add('error');
                    input.style.borderColor = '#ef4444';
                }
            });

            // Check password confirmation
            const password = form.querySelector('input[name="password"]');
            const passwordConfirm = form.querySelector('input[name="password_confirm"]');
            if (password && passwordConfirm) {
                if (password.value !== passwordConfirm.value) {
                    isValid = false;
                    passwordConfirm.classList.add('error');
                    passwordConfirm.style.borderColor = '#ef4444';
                    showError(passwordConfirm, 'As senhas não coincidem');
                }
            }

            // Check email confirmation
            const email = form.querySelector('input[name="email"]');
            const emailConfirm = form.querySelector('input[name="email_confirm"]');
            if (email && emailConfirm) {
                if (email.value !== emailConfirm.value) {
                    isValid = false;
                    emailConfirm.classList.add('error');
                    emailConfirm.style.borderColor = '#ef4444';
                    showError(emailConfirm, 'Os emails não coincidem');
                }
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    });

    // Real-time validation
    const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('error')) {
                validateField(this);
            }
        });
    });

    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe feature cards and stat cards
    document.querySelectorAll('.feature-card, .stat-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });

    // Add loading state to buttons
    const submitButtons = document.querySelectorAll('button[type="submit"], input[type="submit"]');
    submitButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            if (form && form.checkValidity()) {
                this.style.opacity = '0.7';
                this.style.pointerEvents = 'none';
                this.textContent = 'Processando...';
            }
        });
    });
});

// Validate individual field
function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';

    // Remove previous error message
    const existingError = field.parentElement.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }

    // Required validation
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'Este campo é obrigatório';
    }

    // Email validation
    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            errorMessage = 'Email inválido';
        }
    }

    // Username validation (for login/nick fields)
    if ((field.name === 'login' || field.name === 'nick' || field.name === 'username') && value) {
        const usernameRegex = /^[a-zA-Z0-9]{6,12}$/;
        if (!usernameRegex.test(value)) {
            isValid = false;
            errorMessage = 'Deve ter 6-12 caracteres alfanuméricos';
        }
    }

    // Password validation
    if (field.type === 'password' && value) {
        if (value.length < 6 || value.length > 12) {
            isValid = false;
            errorMessage = 'Senha deve ter entre 6 e 12 caracteres';
        }
    }

    // Update field appearance
    if (isValid) {
        field.classList.remove('error');
        field.style.borderColor = '';
    } else {
        field.classList.add('error');
        field.style.borderColor = '#ef4444';
        if (errorMessage) {
            showError(field, errorMessage);
        }
    }

    return isValid;
}

// Show error message
function showError(field, message) {
    const existingError = field.parentElement.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }

    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.style.color = '#ef4444';
    errorDiv.style.fontSize = '0.875rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;
    field.parentElement.appendChild(errorDiv);
}

// Auto-hide alerts after 5 seconds
document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
        alert.style.opacity = '0';
        alert.style.transition = 'opacity 0.5s ease';
        setTimeout(() => {
            alert.remove();
        }, 500);
    }, 5000);
});

// Hero Slider
let currentSlideIndex = 0;
let slideInterval = null;

function initSlider() {
    const slides = document.querySelectorAll('.hero-slider .slide');
    const dots = document.querySelectorAll('.slider-dots .dot');
    
    if (slides.length === 0) return;

    function showSlide(index) {
        if (index >= slides.length) {
            currentSlideIndex = 0;
        } else if (index < 0) {
            currentSlideIndex = slides.length - 1;
        } else {
            currentSlideIndex = index;
        }

        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            if (i === currentSlideIndex) {
                slide.classList.add('active');
            }
        });

        dots.forEach((dot, i) => {
            dot.classList.remove('active');
            if (i === currentSlideIndex) {
                dot.classList.add('active');
            }
        });
    }

    window.changeSlide = function(direction) {
        showSlide(currentSlideIndex + direction);
    };

    window.currentSlide = function(index) {
        showSlide(index - 1);
    };

    // Auto-play slider
    slideInterval = setInterval(() => {
        showSlide(currentSlideIndex + 1);
    }, 5000);

    // Pause on hover
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        heroSection.addEventListener('mouseenter', () => {
            if (slideInterval) {
                clearInterval(slideInterval);
            }
        });
        heroSection.addEventListener('mouseleave', () => {
            slideInterval = setInterval(() => {
                showSlide(currentSlideIndex + 1);
            }, 5000);
        });
    }
}

// Initialize slider when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSlider);
} else {
    initSlider();
}

// Partículas de Fuligem
function createSparkle() {
    const container = document.getElementById('particlesContainer');
    if (!container) return;

    // Garantir que o container tenha a altura total do documento
    const docHeight = Math.max(
        document.body.scrollHeight,
        document.body.offsetHeight,
        document.documentElement.clientHeight,
        document.documentElement.scrollHeight,
        document.documentElement.offsetHeight
    );
    container.style.height = docHeight + 'px';

    const sparkle = document.createElement('div');
    sparkle.className = 'particle-sparkle';
    
    // Cores variadas para as partículas
    const colors = [
        '#6366f1', // Azul primário
        '#8b5cf6', // Roxo secundário
        '#ec4899', // Rosa
        '#f59e0b', // Laranja
        '#10b981', // Verde
        '#3b82f6', // Azul claro
        '#a855f7', // Roxo claro
        '#f97316', // Laranja escuro
        '#06b6d4', // Ciano
        '#ef4444'  // Vermelho
    ];
    
    // Posição inicial aleatória no rodapé (final do site)
    const startX = Math.random() * 100;
    const drift = (Math.random() - 0.5) * 80; // Deriva horizontal
    const duration = 10 + Math.random() * 10; // Duração entre 10-20 segundos
    const delay = Math.random() * 1; // Delay inicial aleatório
    const size = 3 + Math.random() * 3; // Tamanho entre 3-6px
    const color = colors[Math.floor(Math.random() * colors.length)];
    
    // Calcular altura total para animação
    const totalHeight = docHeight;
    const translateY = -(totalHeight + 100); // Subir até o topo + margem
    
    sparkle.style.left = startX + '%';
    sparkle.style.bottom = '0px'; // Começar exatamente no rodapé
    sparkle.style.width = size + 'px';
    sparkle.style.height = size + 'px';
    sparkle.style.backgroundColor = color;
    sparkle.style.color = color;
    sparkle.style.setProperty('--drift', drift + 'px');
    sparkle.style.setProperty('--translateY', translateY + 'px');
    sparkle.style.animationDuration = duration + 's';
    sparkle.style.animationDelay = delay + 's';
    
    container.appendChild(sparkle);
    
    // Remover partícula após animação
    setTimeout(() => {
        if (sparkle.parentNode) {
            sparkle.parentNode.removeChild(sparkle);
        }
    }, (duration + delay) * 1000);
}

// Criar partículas continuamente
function initSparkles() {
    const container = document.getElementById('particlesContainer');
    if (!container) return;
    
    // Atualizar altura do container quando a página mudar de tamanho
    function updateContainerHeight() {
        const docHeight = Math.max(
            document.body.scrollHeight,
            document.body.offsetHeight,
            document.documentElement.clientHeight,
            document.documentElement.scrollHeight,
            document.documentElement.offsetHeight
        );
        container.style.height = docHeight + 'px';
    }
    
    // Atualizar altura inicial
    updateContainerHeight();
    
    // Atualizar altura quando a janela redimensionar ou scrollar
    window.addEventListener('resize', updateContainerHeight);
    window.addEventListener('scroll', updateContainerHeight);
    
    // Criar partículas periodicamente
    setInterval(() => {
        // Criar 2-4 partículas por vez
        const count = 2 + Math.floor(Math.random() * 3);
        for (let i = 0; i < count; i++) {
            setTimeout(() => createSparkle(), i * 200);
        }
    }, 1000); // Criar novo grupo a cada segundo
}

// Inicializar partículas quando DOM estiver pronto
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSparkles);
} else {
    initSparkles();
}

// Sets Carousel Scroll
function scrollSetsCarousel(direction) {
    const carousel = document.getElementById('setsCarousel');
    if (!carousel) return;
    
    const scrollAmount = 250; // Quantidade de pixels para scrollar
    const currentScroll = carousel.scrollLeft;
    const newScroll = currentScroll + (direction * scrollAmount);
    
    carousel.scrollTo({
        left: newScroll,
        behavior: 'smooth'
    });
}

// News Navigation
function scrollNews(direction) {
    // Esta função pode ser expandida para navegar entre diferentes notícias
    // Por enquanto, apenas placeholder
    console.log('News navigation:', direction);
}

// Screenshot Modal
function openScreenshotModal(imageSrc) {
    const modal = document.getElementById('screenshotModal');
    const modalImage = document.getElementById('screenshotModalImage');
    
    if (modal && modalImage) {
        modalImage.src = imageSrc;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeScreenshotModal(event) {
    if (event) {
        event.stopPropagation();
    }
    
    const modal = document.getElementById('screenshotModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Fechar modal com ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeScreenshotModal();
    }
});

// Mobile Menu Toggle
function toggleMobileMenu() {
    const navMenu = document.querySelector('.nav-menu');
    const toggleBtn = document.querySelector('.mobile-menu-toggle');
    
    if (navMenu) {
        navMenu.classList.toggle('active');
        if (toggleBtn) {
            const icon = toggleBtn.querySelector('i');
            if (icon) {
                if (navMenu.classList.contains('active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        }
    }
}

// Fechar menu mobile ao clicar em um link
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const navMenu = document.querySelector('.nav-menu');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768 && navMenu) {
                navMenu.classList.remove('active');
                const toggleBtn = document.querySelector('.mobile-menu-toggle');
                if (toggleBtn) {
                    const icon = toggleBtn.querySelector('i');
                    if (icon) {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                }
            }
        });
    });
    
    // Inicializar modais
    initModals();
});

// Modal Functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Fechar modal ao clicar no backdrop
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('auth-modal')) {
        closeModal(event.target.id);
    }
});

// Fechar modal com ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const activeModal = document.querySelector('.auth-modal.active');
        if (activeModal) {
            closeModal(activeModal.id);
        }
    }
});

// Login Form Handler
function initModals() {
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleLogin();
        });
    }
    
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleRegister();
        });
    }
}

function handleLogin() {
    const form = document.getElementById('loginForm');
    const alertDiv = document.getElementById('loginAlert');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    const formData = new FormData(form);
    const username = formData.get('username');
    const password = formData.get('password');
    
    if (!username || !password) {
        showAlert(alertDiv, 'Por favor, preencha todos os campos', 'error');
        return;
    }
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Entrando...';
    
    const apiPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/login_ajax.php';
    fetch(apiPath, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(alertDiv, data.message, 'success');
            setTimeout(() => {
                const redirectPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + (data.redirect || 'dashboard.php');
                window.location.href = redirectPath;
            }, 1000);
        } else {
            showAlert(alertDiv, data.message, 'error');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Entrar';
        }
    })
    .catch(error => {
        showAlert(alertDiv, 'Erro ao fazer login. Tente novamente.', 'error');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Entrar';
    });
}

function handleRegister() {
    const form = document.getElementById('registerForm');
    const alertDiv = document.getElementById('registerAlert');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    if (!form || !alertDiv || !submitBtn) {
        console.error('Elementos do formulário não encontrados');
        return;
    }
    
    const formData = new FormData(form);
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Criando conta...';
    
    // Limpar alertas anteriores
    alertDiv.style.display = 'none';
    alertDiv.innerHTML = '';
    
    const apiPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/register_ajax.php';
    
    fetch(apiPath, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro na resposta do servidor: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Exibir mensagem com número da conta
            let message = data.message || 'Conta criada com sucesso!';
            if (data.user_number) {
                message = 'Você é o número ' + data.user_number + '! Conta criada com sucesso!';
            }
            showAlert(alertDiv, message, 'success');
            
            // Se houver redirect, redirecionar após 2 segundos
            if (data.redirect) {
                setTimeout(() => {
                    const redirectPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + data.redirect;
                    window.location.href = redirectPath;
                }, 2000);
            } else {
                // Se não houver redirect, apenas reabilitar o botão
                submitBtn.disabled = false;
                submitBtn.textContent = 'Criar Conta';
            }
        } else {
            showAlert(alertDiv, data.message || 'Erro ao criar conta. Tente novamente.', 'error');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Criar Conta';
        }
    })
    .catch(error => {
        console.error('Erro no registro:', error);
        showAlert(alertDiv, 'Erro ao criar conta: ' + error.message + '. Verifique sua conexão e tente novamente.', 'error');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Criar Conta';
    });
}

function showAlert(alertDiv, message, type) {
    if (!alertDiv) return;
    
    alertDiv.className = 'alert alert-' + type;
    alertDiv.innerHTML = message;
    alertDiv.style.display = 'block';
    
    // Scroll to alert
    alertDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

// Ranking Functions
let currentRankingPage = 1;
let rankingSearchTimeout = null;

function getRankingFilters() {
    const searchInput = document.getElementById('rankingSearch');
    const sortSelect = document.getElementById('rankingSortBy');
    
    return {
        search: searchInput ? searchInput.value.trim() : '',
        sort_by: sortSelect ? sortSelect.value : 'rank'
    };
}

function loadRanking(page = 1, filters = null) {
    if (!filters) {
        filters = getRankingFilters();
    }
    
    currentRankingPage = page;
    const tableBody = document.getElementById('rankingTableBody');
    const paginationDiv = document.getElementById('rankingPagination');
    
    if (tableBody) {
        tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Carregando...</td></tr>';
    }
    
    // Construir URL com parâmetros
    const params = new URLSearchParams({
        page: page,
        sort_by: filters.sort_by || 'rank'
    });
    
    if (filters.search) {
        params.append('search', filters.search);
    }
    
    const apiPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/ranking_ajax.php?' + params.toString();
    
    fetch(apiPath)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao carregar ranking');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                if (tableBody) {
                    tableBody.innerHTML = data.html;
                }
                if (paginationDiv) {
                    paginationDiv.innerHTML = data.pagination;
                }
            } else {
                if (tableBody) {
                    tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Erro ao carregar ranking</td></tr>';
                }
            }
        })
        .catch(error => {
            console.error('Erro ao carregar ranking:', error);
            if (tableBody) {
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Erro ao carregar ranking</td></tr>';
            }
        });
}

function loadRankingPage(page, filters = null) {
    loadRanking(page, filters);
}

function handleRankingSearch(event) {
    // Se pressionar Enter, buscar imediatamente
    if (event.key === 'Enter') {
        if (rankingSearchTimeout) {
            clearTimeout(rankingSearchTimeout);
        }
        loadRanking(1, getRankingFilters());
        return;
    }
    
    // Debounce: aguardar 500ms após parar de digitar
    if (rankingSearchTimeout) {
        clearTimeout(rankingSearchTimeout);
    }
    
    rankingSearchTimeout = setTimeout(() => {
        loadRanking(1, getRankingFilters());
    }, 500);
}

function clearRankingSearch() {
    const searchInput = document.getElementById('rankingSearch');
    const sortSelect = document.getElementById('rankingSortBy');
    
    if (searchInput) {
        searchInput.value = '';
    }
    if (sortSelect) {
        sortSelect.value = 'rank';
    }
    
    loadRanking(1, { search: '', sort_by: 'rank' });
}

// Avatar Functions
function getTypeIcon(type) {
    const icons = {
        'Helm': '<i class="fas fa-hard-hat"></i>',
        'Body': '<i class="fas fa-tshirt"></i>',
        'Accessory': '<i class="fas fa-gem"></i>',
        'Weapon': '<i class="fas fa-sword"></i>',
    };
    return icons[type] || '<i class="fas fa-question"></i>';
}

function loadAvatars() {
    const avatarsList = document.getElementById('avatarsList');
    const closetList = document.getElementById('closetList');
    
    if (avatarsList) {
        avatarsList.innerHTML = '<tr><td colspan="4" class="text-center">Carregando...</td></tr>';
    }
    if (closetList) {
        closetList.innerHTML = '<tr><td colspan="4" class="text-center">Carregando...</td></tr>';
    }
    
    const apiPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/avatars_ajax.php';
    
    fetch(apiPath)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Renderizar avatares
                if (avatarsList) {
                    if (data.avatars && data.avatars.length > 0) {
                        avatarsList.innerHTML = data.avatars.map(avatar => {
                            const itemCode = avatar.Item || '';
                            const avatarName = avatar.Name || 'Desconhecido';
                            const avatarType = avatar.Type || 'Unknown';
                            const typeIcon = getTypeIcon(avatarType);
                            
                            return `
                                <tr data-item="${itemCode}">
                                    <td>
                                        <div class="avatar-image">
                                            <img src="get_avatar_image.php?item=${itemCode}" alt="${avatarName}" onerror="this.src='Assets/images/no_avatar.png'">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-type-icon">${typeIcon}</div>
                                    </td>
                                    <td>
                                        <div class="avatar-name">${avatarName}</div>
                                    </td>
                                    <td>
                                        <div class="avatar-actions">
                                            <button class="btn-delete" onclick="deleteAvatar('${itemCode}', false)">
                                                DELETE
                                            </button>
                                            <button class="btn-closet" onclick="moveToCloset('${itemCode}')">
                                                CLOSET
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        }).join('');
                    } else {
                        avatarsList.innerHTML = '<tr><td colspan="4" class="text-center">Nenhum avatar encontrado</td></tr>';
                    }
                }
                
                // Renderizar closet
                if (closetList) {
                    if (data.closet_avatars && data.closet_avatars.length > 0) {
                        closetList.innerHTML = data.closet_avatars.map(avatar => {
                            const itemCode = avatar.Item || '';
                            const avatarName = avatar.Name || 'Desconhecido';
                            const avatarType = avatar.Type || 'Unknown';
                            const typeIcon = getTypeIcon(avatarType);
                            
                            return `
                                <tr data-item="${itemCode}">
                                    <td>
                                        <div class="avatar-image">
                                            <img src="get_avatar_image.php?item=${itemCode}" alt="${avatarName}" onerror="this.src='Assets/images/no_avatar.png'">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-type-icon">${typeIcon}</div>
                                    </td>
                                    <td>
                                        <div class="avatar-name">${avatarName}</div>
                                    </td>
                                    <td>
                                        <div class="avatar-actions">
                                            <button class="btn-delete" onclick="deleteAvatar('${itemCode}', true)">
                                                DELETE
                                            </button>
                                            <button class="btn-recover" onclick="recoverFromCloset('${itemCode}')">
                                                RECUPERAR
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        }).join('');
                    } else {
                        closetList.innerHTML = '<tr><td colspan="4" class="text-center">Nenhum avatar no closet</td></tr>';
                    }
                }
            } else {
                const errorMsg = data.message || 'Erro desconhecido';
                if (avatarsList) {
                    avatarsList.innerHTML = '<tr><td colspan="4" class="text-center">Erro: ' + errorMsg + '</td></tr>';
                }
                if (closetList) {
                    closetList.innerHTML = '<tr><td colspan="4" class="text-center">Erro: ' + errorMsg + '</td></tr>';
                }
            }
        })
        .catch(error => {
            console.error('Erro ao carregar avatares:', error);
            if (avatarsList) {
                avatarsList.innerHTML = '<tr><td colspan="4" class="text-center">Erro ao carregar avatares: ' + error.message + '</td></tr>';
            }
            if (closetList) {
                closetList.innerHTML = '<tr><td colspan="4" class="text-center">Erro ao carregar closet: ' + error.message + '</td></tr>';
            }
        });
}

function moveToCloset(item) {
    if (!confirm('Deseja mover este avatar para o closet?')) return;
    
    const formData = new FormData();
    formData.append('action', 'move_to_closet');
    formData.append('item', item);
    
    const apiPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/avatar_closet.php';
    
    fetch(apiPath, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            loadAvatars();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('Erro ao mover avatar');
    });
}

function recoverFromCloset(item) {
    if (!confirm('Deseja recuperar este avatar do closet?')) return;
    
    const formData = new FormData();
    formData.append('action', 'recover_from_closet');
    formData.append('item', item);
    
    const apiPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/avatar_closet.php';
    
    fetch(apiPath, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            loadAvatars();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('Erro ao recuperar avatar');
    });
}

function deleteAvatar(item, fromCloset) {
    if (!confirm('Tem certeza que deseja deletar este avatar? Esta ação não pode ser desfeita!')) return;
    
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('item', item);
    formData.append('from_closet', fromCloset ? '1' : '0');
    
    const apiPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/avatar_closet.php';
    
    fetch(apiPath, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            loadAvatars();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('Erro ao deletar avatar');
    });
}

function sortAvatars() {
    const tbody = document.getElementById('avatarsList');
    if (!tbody) return;
    
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        const nameA = a.querySelector('.avatar-name')?.textContent.trim() || '';
        const nameB = b.querySelector('.avatar-name')?.textContent.trim() || '';
        return nameA.localeCompare(nameB);
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

