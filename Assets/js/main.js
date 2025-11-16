// Main JavaScript for Gunbound Website

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

    // Add loading state to buttons (excluir botão de tweets e formulários de perfil)
    const submitButtons = document.querySelectorAll('button[type="submit"]:not(#tweetForm button):not(#editNicknameForm button):not(#editPasswordForm button):not(#editEmailForm button):not(#editAvatarForm button), input[type="submit"]:not(#tweetForm input):not(#editNicknameForm input):not(#editPasswordForm input):not(#editEmailForm input):not(#editAvatarForm input)');
    submitButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            if (form && form.id !== 'tweetForm' && 
                form.id !== 'editNicknameForm' && 
                form.id !== 'editPasswordForm' && 
                form.id !== 'editEmailForm' && 
                form.id !== 'editAvatarForm' && 
                form.checkValidity()) {
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
            // Exibir popup com informações do registro
            if (data.registration_info) {
                showRegistrationInfoModal(data.registration_info, data.user_number);
            } else {
                // Fallback caso não tenha informações
                let message = data.message || 'Conta criada com sucesso!';
                if (data.user_number) {
                    message = 'Você é o número ' + data.user_number + '! Conta criada com sucesso!';
                }
                showAlert(alertDiv, message, 'success');
            }
            
            // Se houver redirect, redirecionar após fechar o modal (não mais após 2 segundos)
            // O redirecionamento será feito quando o usuário fechar o modal
            window.registrationRedirect = data.redirect;
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
            console.log('Resposta da API de avatares:', data);
            if (data.success) {
                // Renderizar avatares
                if (avatarsList) {
                    console.log('Avatares recebidos:', data.avatars);
                    console.log('Quantidade de avatares:', data.avatars ? data.avatars.length : 0);
                    if (data.avatars && Array.isArray(data.avatars) && data.avatars.length > 0) {
                        console.log('Renderizando ' + data.avatars.length + ' avatares');
                        avatarsList.innerHTML = data.avatars.map(avatar => {
                            const itemCode = String(avatar.Item || avatar.item || '');
                            const avatarName = String(avatar.Name || avatar.name || 'Desconhecido');
                            const avatarType = String(avatar.Type || avatar.type || 'Unknown');
                            const typeIcon = getTypeIcon(avatarType);
                            
                            // Escapar caracteres especiais para evitar problemas com aspas
                            const safeItemCode = itemCode.replace(/'/g, "\\'");
                            
                            return `
                                <tr data-item="${safeItemCode}">
                                    <td>
                                        <div class="avatar-image">
                                            <img src="${BASE_PATH || ''}get_avatar_image.php?item=${itemCode}" alt="${avatarName.replace(/"/g, '&quot;')}" onerror="this.src='${BASE_PATH || ''}Assets/images/no_avatar.png'">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-type-icon">${typeIcon}</div>
                                    </td>
                                    <td>
                                        <div class="avatar-name">${avatarName.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</div>
                                    </td>
                                    <td>
                                        <div class="avatar-actions">
                                            <button class="btn-delete" onclick="deleteAvatar('${safeItemCode}', false)">
                                                DELETE
                                            </button>
                                            <button class="btn-closet" onclick="moveToCloset('${safeItemCode}')">
                                                CLOSET
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        }).join('');
                    } else {
                        console.log('Nenhum avatar encontrado. Debug:', data.debug);
                        avatarsList.innerHTML = '<tr><td colspan="4" class="text-center">Nenhum avatar encontrado' + (data.debug ? '<br><small>Debug: user_id=' + (data.debug.user_id || 'N/A') + ', test_count=' + (data.debug.test_count || 0) + ', avatars_count=' + (data.debug.avatars_count || 0) + '</small>' : '') + '</td></tr>';
                    }
                }
                
                // Renderizar closet
                if (closetList) {
                    if (data.closet_avatars && Array.isArray(data.closet_avatars) && data.closet_avatars.length > 0) {
                        console.log('Renderizando ' + data.closet_avatars.length + ' avatares do closet');
                        closetList.innerHTML = data.closet_avatars.map(avatar => {
                            const itemCode = String(avatar.Item || avatar.item || '');
                            const avatarName = String(avatar.Name || avatar.name || 'Desconhecido');
                            const avatarType = String(avatar.Type || avatar.type || 'Unknown');
                            const typeIcon = getTypeIcon(avatarType);
                            
                            // Escapar caracteres especiais
                            const safeItemCode = itemCode.replace(/'/g, "\\'");
                            
                            return `
                                <tr data-item="${safeItemCode}">
                                    <td>
                                        <div class="avatar-image">
                                            <img src="${BASE_PATH || ''}get_avatar_image.php?item=${itemCode}" alt="${avatarName.replace(/"/g, '&quot;')}" onerror="this.src='${BASE_PATH || ''}Assets/images/no_avatar.png'">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-type-icon">${typeIcon}</div>
                                    </td>
                                    <td>
                                        <div class="avatar-name">${avatarName.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</div>
                                    </td>
                                    <td>
                                        <div class="avatar-actions">
                                            <button class="btn-delete" onclick="deleteAvatar('${safeItemCode}', true)">
                                                DELETE
                                            </button>
                                            <button class="btn-recover" onclick="recoverFromCloset('${safeItemCode}')">
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
                console.error('Erro na resposta da API:', data);
                const errorMsg = data.message || 'Erro desconhecido';
                if (avatarsList) {
                    avatarsList.innerHTML = '<tr><td colspan="4" class="text-center">Erro: ' + errorMsg + (data.debug ? ' (Debug: ' + JSON.stringify(data.debug) + ')' : '') + '</td></tr>';
                }
                if (closetList) {
                    closetList.innerHTML = '<tr><td colspan="4" class="text-center">Erro: ' + errorMsg + (data.debug ? ' (Debug: ' + JSON.stringify(data.debug) + ')' : '') + '</td></tr>';
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

// Sistema de Popup para Confirmações e Alertas
let confirmCallback = null;

function showConfirmModal(message, title = 'Confirmação', okText = 'OK', cancelText = 'Cancelar') {
    return new Promise((resolve) => {
        const modal = document.getElementById('confirmModal');
        const messageEl = document.getElementById('confirmModalMessage');
        const titleEl = document.getElementById('confirmModalTitle');
        const okBtn = document.getElementById('confirmModalOk');
        const cancelBtn = document.getElementById('confirmModalCancel');
        
        messageEl.textContent = message;
        titleEl.textContent = title;
        okBtn.textContent = okText;
        cancelBtn.textContent = cancelText;
        
        confirmCallback = resolve;
        modal.style.display = 'flex';
    });
}

function closeConfirmModal(result) {
    const modal = document.getElementById('confirmModal');
    modal.style.display = 'none';
    if (confirmCallback) {
        confirmCallback(result);
        confirmCallback = null;
    }
}

function showAlertModal(message, title = 'Aviso') {
    return new Promise((resolve) => {
        const modal = document.getElementById('alertModal');
        const messageEl = document.getElementById('alertModalMessage');
        
        messageEl.textContent = message;
        
        modal.style.display = 'flex';
        
        // Auto-close após 3 segundos se o usuário não clicar
        setTimeout(() => {
            if (modal.style.display === 'flex') {
                closeAlertModal();
                resolve();
            }
        }, 3000);
    });
}

function closeAlertModal() {
    const modal = document.getElementById('alertModal');
    modal.style.display = 'none';
}

// Token Redemption
document.addEventListener('DOMContentLoaded', function() {
    const redeemTokenForm = document.getElementById('redeemTokenForm');
    if (redeemTokenForm) {
        redeemTokenForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const tokenCode = document.getElementById('token_code').value.trim().toUpperCase();
            const alertDiv = document.getElementById('tokenRedeemAlert');
            const submitBtn = redeemTokenForm.querySelector('button[type="submit"]');
            
            if (!tokenCode) {
                showTokenAlert(alertDiv, 'Digite o código do token', 'error');
                return;
            }
            
            // Desabilitar botão
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';
            
            const apiPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/redeem_token.php';
            const formData = new FormData();
            formData.append('token_code', tokenCode);
            
            fetch(apiPath, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                
                if (data.success) {
                    showTokenAlert(alertDiv, data.message, 'success');
                    redeemTokenForm.reset();
                    // Recarregar página após 2 segundos para atualizar dados
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showTokenAlert(alertDiv, data.message || 'Erro ao resgatar token', 'error');
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                showTokenAlert(alertDiv, 'Erro ao resgatar token: ' + error.message, 'error');
            });
        });
    }
});

function showTokenAlert(alertDiv, message, type) {
    if (!alertDiv) return;
    
    alertDiv.className = 'alert alert-' + type;
    alertDiv.innerHTML = '<i class="fas fa-' + (type === 'success' ? 'check-circle' : 'exclamation-circle') + '"></i> ' + message;
    alertDiv.style.display = 'block';
    
    setTimeout(() => {
        alertDiv.style.display = 'none';
    }, 5000);
}

// Função para exibir modal de informações de registro
function showRegistrationInfoModal(registrationInfo, userNumber) {
    const modal = document.getElementById('registrationInfoModal');
    const content = document.getElementById('registrationInfoContent');
    
    if (!modal || !content) return;
    
    // Formatar valores
    const cashFormatted = registrationInfo.cash.toLocaleString('pt-BR');
    const moneyFormatted = registrationInfo.money.toLocaleString('pt-BR');
    
    // Criar HTML com as informações
    let html = '<div style="text-align: left;">';
    
    if (userNumber) {
        html += `<div style="background: #e8f5e9; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; text-align: center;">`;
        html += `<h4 style="margin: 0; color: #2e7d32; font-size: 1.2rem;">`;
        html += `<i class="fas fa-star" style="color: #ffd700;"></i> Você é o número <strong>#${userNumber}</strong>!`;
        html += `</h4></div>`;
    }
    
    html += '<div style="margin-bottom: 1rem;">';
    html += '<h4 style="color: #333; margin-bottom: 0.75rem; font-size: 1.1rem;"><i class="fas fa-user"></i> Informações da Conta</h4>';
    html += '<div style="background: #f5f5f5; padding: 0.75rem; border-radius: 6px; margin-bottom: 0.5rem;">';
    html += `<strong>Login:</strong> <span style="color: #667eea;">${escapeHtml(registrationInfo.login)}</span>`;
    html += '</div>';
    html += '<div style="background: #f5f5f5; padding: 0.75rem; border-radius: 6px; margin-bottom: 0.5rem;">';
    html += `<strong>Nickname:</strong> <span style="color: #667eea;">${escapeHtml(registrationInfo.nick)}</span>`;
    html += '</div>';
    html += '<div style="background: #f5f5f5; padding: 0.75rem; border-radius: 6px;">';
    html += `<strong>Email:</strong> <span style="color: #667eea;">${escapeHtml(registrationInfo.email)}</span>`;
    html += '</div>';
    html += '</div>';
    
    html += '<div style="margin-bottom: 1rem;">';
    html += '<h4 style="color: #333; margin-bottom: 0.75rem; font-size: 1.1rem;"><i class="fas fa-coins"></i> Recursos Recebidos</h4>';
    html += '<div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 0.5rem;">';
    html += `<div style="display: flex; justify-content: space-between; align-items: center;">`;
    html += `<span><i class="fas fa-dollar-sign"></i> <strong>Cash:</strong></span>`;
    html += `<span style="font-size: 1.2rem; font-weight: bold;">${cashFormatted}</span>`;
    html += `</div></div>`;
    html += '<div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 1rem; border-radius: 8px;">';
    html += `<div style="display: flex; justify-content: space-between; align-items: center;">`;
    html += `<span><i class="fas fa-coins"></i> <strong>Gold:</strong></span>`;
    html += `<span style="font-size: 1.2rem; font-weight: bold;">${moneyFormatted}</span>`;
    html += `</div></div>`;
    html += '</div>';
    
    html += '<div>';
    html += '<h4 style="color: #333; margin-bottom: 0.75rem; font-size: 1.1rem;"><i class="fas fa-gift"></i> Item de Boas-Vindas</h4>';
    html += '<div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; padding: 1rem; border-radius: 8px;">';
    html += `<div style="text-align: center;">`;
    html += `<div style="font-size: 1.1rem; margin-bottom: 0.5rem;"><strong>${escapeHtml(registrationInfo.item_name)}</strong></div>`;
    html += `<div style="font-size: 0.9rem; opacity: 0.9;"><i class="fas fa-clock"></i> Expira em ${registrationInfo.item_expire_days} dias</div>`;
    html += `</div></div>`;
    html += '</div>';
    
    html += '</div>';
    
    content.innerHTML = html;
    modal.style.display = 'flex';
}

function closeRegistrationInfoModal() {
    const modal = document.getElementById('registrationInfoModal');
    if (modal) {
        modal.style.display = 'none';
        
        // Redirecionar se houver um redirect definido
        if (window.registrationRedirect) {
            const redirectPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + window.registrationRedirect;
            window.location.href = redirectPath;
            window.registrationRedirect = null;
        }
    }
}

// Função auxiliar para escapar HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Fechar modais ao clicar fora
document.addEventListener('click', function(event) {
    const confirmModal = document.getElementById('confirmModal');
    const alertModal = document.getElementById('alertModal');
    const registrationInfoModal = document.getElementById('registrationInfoModal');
    
    if (event.target === confirmModal) {
        closeConfirmModal(false);
    }
    if (event.target === alertModal) {
        closeAlertModal();
    }
    if (event.target === registrationInfoModal) {
        closeRegistrationInfoModal();
    }
});

function moveToCloset(item) {
    console.log('moveToCloset chamado com item:', item);
    showConfirmModal('Deseja mover este avatar para o closet?', 'Mover para Closet', 'Sim', 'Não')
        .then((confirmed) => {
            console.log('Confirmação:', confirmed);
            if (!confirmed) return;
            
            const formData = new FormData();
            formData.append('action', 'move_to_closet');
            formData.append('item', item);
            
            const apiPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/avatar_closet.php';
            console.log('Enviando requisição para:', apiPath, 'com item:', item);
            
            fetch(apiPath, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Resposta recebida:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Dados recebidos:', data);
                if (data.success) {
                    showAlertModal(data.message, 'Sucesso');
                    loadAvatars();
                } else {
                    showAlertModal(data.message || 'Erro desconhecido', 'Erro');
                }
            })
            .catch(error => {
                console.error('Erro na requisição:', error);
                showAlertModal('Erro ao mover avatar: ' + error.message, 'Erro');
            });
        });
}

function recoverFromCloset(item) {
    showConfirmModal('Deseja recuperar este avatar do closet?', 'Recuperar do Closet', 'Sim', 'Não')
        .then((confirmed) => {
            if (!confirmed) return;
            
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
                    showAlertModal(data.message, 'Sucesso');
                    loadAvatars();
                } else {
                    showAlertModal(data.message, 'Erro');
                }
            })
            .catch(error => {
                showAlertModal('Erro ao recuperar avatar', 'Erro');
            });
        });
}

function deleteAvatar(item, fromCloset) {
    showConfirmModal('Tem certeza que deseja deletar este avatar? Esta ação não pode ser desfeita!', 'Confirmar Exclusão', 'Sim, Deletar', 'Cancelar')
        .then((confirmed) => {
            if (!confirmed) return;
    
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
                    showAlertModal(data.message, 'Sucesso');
                    loadAvatars();
                } else {
                    showAlertModal(data.message, 'Erro');
                }
            })
            .catch(error => {
                showAlertModal('Erro ao deletar avatar', 'Erro');
            });
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

// Variáveis para controlar o polling de tweets
let tweetsPollInterval = null;
let lastTweetId = null;

// Tweets Functions
function loadTweets() {
    const tweetsList = document.getElementById('tweetsList');
    if (!tweetsList) return;
    
    tweetsList.innerHTML = '<div class="tweet-loading">Carregando tweets...</div>';
    
    const apiPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/tweets_ajax.php?action=get';
    
    fetch(apiPath)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro HTTP: ' + response.status);
            }
            return response.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);
                console.log('Dados recebidos:', data);
                
                if (data.success && Array.isArray(data.tweets)) {
                    if (data.tweets.length === 0) {
                        tweetsList.innerHTML = '<div class="tweet-empty">Nenhum tweet ainda. Seja o primeiro a postar!</div>';
                        return;
                    }
                    
                    tweetsList.innerHTML = data.tweets.map(tweet => {
                        const date = new Date(tweet.created_at);
                        const formattedDate = date.toLocaleDateString('pt-BR', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        }) + ' ' + date.toLocaleTimeString('pt-BR', {
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        });
                        
                        const rankImagePath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'Assets/rank/' + (tweet.rank_image || 'Image 2.bmp');
                        const profileImagePath = tweet.profile_image && tweet.profile_image.trim() !== '' 
                            ? escapeHtml(tweet.profile_image) 
                            : (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'Assets/images/default-avatar.png';
                        
                        return `
                            <div class="tweet-item" data-tweet-id="${tweet.id}">
                                <div class="tweet-avatar-section">
                                    <div class="tweet-avatar-wrapper">
                                        ${tweet.profile_image && tweet.profile_image.trim() !== '' 
                                            ? `<img src="${escapeHtml(tweet.profile_image)}" alt="${escapeHtml(tweet.nickname || 'Desconhecido')}" class="tweet-avatar" onerror="this.onerror=null; this.src='${(typeof BASE_PATH !== 'undefined' ? BASE_PATH : '')}Assets/images/default-avatar.png'">`
                                            : `<div class="tweet-avatar-placeholder">
                                                <i class="fas fa-user"></i>
                                            </div>`
                                        }
                                    </div>
                                </div>
                                <div class="tweet-content-section">
                                    <div class="tweet-header">
                                        <div class="tweet-user-info">
                                            <span class="tweet-username">${escapeHtml(tweet.nickname || 'Desconhecido')}</span>
                                            <img src="${rankImagePath}" alt="${escapeHtml(tweet.rank_name || 'Sem Rank')}" class="tweet-rank-icon" onerror="this.style.display='none'">
                                        </div>
                                        <span class="tweet-date">${formattedDate}</span>
                                    </div>
                                    <div class="tweet-message">${escapeHtml(tweet.message || '')}</div>
                                </div>
                            </div>
                        `;
                    }).join('');
                    
                    // Atualizar o último ID de tweet após carregar
                    if (data.tweets.length > 0) {
                        lastTweetId = data.tweets[0].id;
                    }
                } else {
                    const errorMsg = data.message || 'Erro desconhecido';
                    console.error('Erro na resposta:', data);
                    tweetsList.innerHTML = '<div class="tweet-error">Erro ao carregar tweets: ' + escapeHtml(errorMsg) + '</div>';
                }
            } catch (parseError) {
                console.error('Erro ao fazer parse do JSON:', parseError);
                console.error('Resposta recebida:', text);
                tweetsList.innerHTML = '<div class="tweet-error">Erro ao processar resposta do servidor</div>';
            }
        })
        .catch(error => {
            console.error('Erro ao carregar tweets:', error);
            tweetsList.innerHTML = '<div class="tweet-error">Erro ao carregar tweets: ' + escapeHtml(error.message) + '</div>';
        });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Verificar se há novos tweets sem recarregar tudo
function checkForNewTweets() {
    const tweetsList = document.getElementById('tweetsList');
    if (!tweetsList) return;
    
    // Verificar se o formulário está sendo usado (não atualizar durante envio)
    const tweetForm = document.getElementById('tweetForm');
    if (tweetForm) {
        const submitBtn = tweetForm.querySelector('button[type="submit"]');
        if (submitBtn && submitBtn.disabled) {
            return; // Não atualizar se está enviando
        }
    }
    
    const apiPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/tweets_ajax.php?action=get&limit=1';
    
    fetch(apiPath)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro HTTP: ' + response.status);
            }
            return response.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.success && Array.isArray(data.tweets) && data.tweets.length > 0) {
                    const newestTweet = data.tweets[0];
                    // Se o tweet mais recente tem ID diferente do último conhecido, recarregar tudo
                    if (newestTweet.id !== lastTweetId) {
                        loadTweets(); // Recarregar todos os tweets
                    }
                }
            } catch (e) {
                // Ignorar erros de parsing silenciosamente durante polling
                console.error('Erro ao verificar novos tweets:', e);
            }
        })
        .catch(error => {
            // Ignorar erros de rede silenciosamente durante polling
            console.error('Erro ao verificar novos tweets:', error);
        });
}

// Limpar intervalo ao sair da página
window.addEventListener('beforeunload', function() {
    if (tweetsPollInterval) {
        clearInterval(tweetsPollInterval);
    }
});

// Carregar tweets ao carregar a página
document.addEventListener('DOMContentLoaded', function() {
    const tweetForm = document.getElementById('tweetForm');
    const tweetMessage = document.getElementById('tweetMessage');
    const charCount = document.getElementById('charCount');
    
    // Carregar tweets inicialmente
    loadTweets();
    
    // Configurar atualização automática do chat a cada 5 segundos
    if (tweetsPollInterval) {
        clearInterval(tweetsPollInterval);
    }
    tweetsPollInterval = setInterval(function() {
        // Verificar se há novos tweets sem recarregar tudo
        checkForNewTweets();
    }, 5000); // Atualizar a cada 5 segundos
    
    // Atualizar contador de caracteres
    if (tweetMessage && charCount) {
        tweetMessage.addEventListener('input', function() {
            charCount.textContent = this.value.length;
            if (this.value.length > 90) {
                charCount.style.color = '#dc3545';
            } else if (this.value.length > 70) {
                charCount.style.color = '#ff9800';
            } else {
                charCount.style.color = '#6c757d';
            }
        });
    }
    
    // Enviar tweet
    if (tweetForm) {
        tweetForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const message = tweetMessage.value.trim();
            if (!message) {
                showTweetAlert('A mensagem não pode estar vazia', 'error');
                return;
            }
            
            if (message.length > 100) {
                showTweetAlert('A mensagem não pode ter mais de 100 caracteres', 'error');
                return;
            }
            
            const formData = new FormData();
            formData.append('action', 'send');
            formData.append('message', message);
            
            const submitBtn = this.querySelector('button[type="submit"]');
            if (!submitBtn) {
                console.error('Botão de submit não encontrado');
                return;
            }
            
            // Salvar texto original do botão
            const originalButtonText = submitBtn.innerHTML;
            
            // Função para restaurar o botão (sempre garantir que volte ao normal)
            const restoreButton = () => {
                try {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalButtonText; // Garantir que o texto original seja restaurado
                    }
                } catch (e) {
                    console.error('Erro ao restaurar botão:', e);
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar';
                    }
                }
            };
            
            // Desabilitar botão durante envio (NUNCA mudar o texto)
            submitBtn.disabled = true;
            
            // Timeout de segurança: restaurar botão após 10 segundos mesmo se houver erro
            const safetyTimeout = setTimeout(() => {
                console.warn('Timeout de segurança: restaurando botão');
                restoreButton();
            }, 10000);
            
            const apiPath = (typeof BASE_PATH !== 'undefined' ? BASE_PATH : '') + 'api/tweets_ajax.php';
            
            fetch(apiPath, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                clearTimeout(safetyTimeout);
                if (!response.ok) {
                    throw new Error('Erro HTTP: ' + response.status);
                }
                return response.text();
            })
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        // Restaurar botão IMEDIATAMENTE
                        restoreButton();
                        
                        // Mostrar mensagem informando que cash foi deduzido
                        if (data.cash_remaining !== undefined) {
                            showTweetAlert(`Mensagem enviada! Cash restante: ${data.cash_remaining.toLocaleString('pt-BR')}`, 'success');
                        }
                        
                        tweetForm.reset();
                        if (charCount) {
                            charCount.textContent = '0';
                            charCount.style.color = '#6c757d';
                        }
                        // Recarregar tweets imediatamente após enviar
                        loadTweets();
                    } else {
                        restoreButton();
                        showTweetAlert(data.message || 'Erro ao enviar tweet', 'error');
                    }
                } catch (e) {
                    console.error('Erro ao parsear resposta:', e, text);
                    restoreButton();
                    showTweetAlert('Erro ao processar resposta do servidor', 'error');
                }
            })
            .catch(error => {
                clearTimeout(safetyTimeout);
                console.error('Erro ao enviar tweet:', error);
                restoreButton();
                showTweetAlert('Erro ao enviar tweet: ' + error.message, 'error');
            });
        });
    }
});

function showTweetAlert(message, type) {
    const alertDiv = document.getElementById('tweetAlert');
    if (alertDiv) {
        alertDiv.textContent = message;
        alertDiv.className = 'alert ' + (type === 'success' ? 'success' : 'error');
        alertDiv.style.display = 'block';
        
        setTimeout(() => {
            alertDiv.style.display = 'none';
        }, 5000);
    }
}

