// ============================================
// SISTEMA COMPLETO DE TEMA DARK/LIGHT MODE
// ============================================
// Arquivo: /js/theme.js
// Adicione em TODAS as páginas: <script src="../js/theme.js"></script>

(function() {
    'use strict';

    // ============================================
    // APLICAR TEMA IMEDIATAMENTE (EVITA FLASH)
    // ============================================
    const savedTheme = localStorage.getItem('theme') || 'dark';
    const savedColor = localStorage.getItem('corTema') || '#D13438';
    
    // Aplica antes do DOM carregar
    document.documentElement.setAttribute('data-theme', savedTheme);
    document.documentElement.style.setProperty('--accent-color', savedColor);

    console.log('🎨 Sistema de Tema Inicializado');
    console.log('📱 Tema:', savedTheme);
    console.log('🎨 Cor:', savedColor);

    // ============================================
    // FUNÇÃO: DEFINIR TEMA
    // ============================================
    function setTheme(theme) {
        if (theme !== 'dark' && theme !== 'light') {
            console.error('❌ Tema inválido. Use "dark" ou "light"');
            return;
        }
        
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        
        console.log('✅ Tema alterado para:', theme);
        
        // Atualiza UI da página de tema
        updateThemeButtons(theme);
        
        // Atualiza botão flutuante (se existir)
        updateFloatingButton(theme);
    }

    // ============================================
    // FUNÇÃO: DEFINIR COR
    // ============================================
    function setColor(color) {
        if (!color || !color.startsWith('#')) {
            console.error('❌ Cor inválida. Use formato hex (#RRGGBB)');
            return;
        }
        
        document.documentElement.style.setProperty('--accent-color', color);
        localStorage.setItem('corTema', color);
        
        console.log('✅ Cor alterada para:', color);
        
        // Atualiza preview e swatches
        updateColorPreview(color);
        updateColorSwatches(color);
    }

    // ============================================
    // ATUALIZAR BOTÕES DE TEMA (DARK/LIGHT)
    // ============================================
    function updateThemeButtons(theme) {
        const themeButtons = document.querySelectorAll('.theme-btn');
        themeButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.theme === theme) {
                btn.classList.add('active');
            }
        });
    }

    // ============================================
    // ATUALIZAR PREVIEW DE COR
    // ============================================
    function updateColorPreview(color) {
        const previewHeader = document.getElementById('previewHeader');
        if (previewHeader) {
            previewHeader.style.backgroundColor = color;
        }
    }

    // ============================================
    // ATUALIZAR SWATCHES DE COR
    // ============================================
    function updateColorSwatches(color) {
        const swatches = document.querySelectorAll('.swatch');
        swatches.forEach(s => {
            s.classList.remove('active');
            if (s.dataset.color === color) {
                s.classList.add('active');
            }
        });
    }

    // ============================================
    // ATUALIZAR BOTÃO FLUTUANTE
    // ============================================
    function updateFloatingButton(theme) {
        const icon = document.querySelector('.theme-toggle i');
        if (icon) {
            icon.className = theme === 'dark' ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
        }
    }

    // ============================================
    // CRIAR BOTÃO FLUTUANTE (OPCIONAL)
    // ============================================
    function createFloatingButton() {
        if (document.querySelector('.theme-toggle')) {
            return; // Já existe
        }
        
        const button = document.createElement('button');
        button.className = 'theme-toggle';
        button.setAttribute('aria-label', 'Alternar tema');
        button.setAttribute('title', 'Alternar entre tema claro e escuro');
        
        const icon = document.createElement('i');
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
        icon.className = currentTheme === 'dark' ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
        
        button.appendChild(icon);
        document.body.appendChild(button);
        
        // Alternar ao clicar
        button.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-theme');
            const newTheme = current === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
            
            // Animação
            button.classList.add('rotating');
            setTimeout(() => button.classList.remove('rotating'), 500);
        });
        
        console.log('✅ Botão flutuante criado');
    }

    // ============================================
    // SINCRONIZAR ENTRE ABAS
    // ============================================
    window.addEventListener('storage', function(e) {
        if (e.key === 'theme') {
            const newTheme = e.newValue || 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            updateThemeButtons(newTheme);
            updateFloatingButton(newTheme);
            console.log('🔄 Tema sincronizado:', newTheme);
        }
        
        if (e.key === 'corTema') {
            const newColor = e.newValue || '#D13438';
            document.documentElement.style.setProperty('--accent-color', newColor);
            updateColorPreview(newColor);
            updateColorSwatches(newColor);
            console.log('🔄 Cor sincronizada:', newColor);
        }
    });

    // ============================================
    // INICIALIZAR LISTENERS DA PÁGINA DE TEMA
    // ============================================
    function initThemePage() {
        // Listeners para BOTÕES DE TEMA (Dark/Light)
        const themeButtons = document.querySelectorAll('.theme-btn');
        if (themeButtons.length > 0) {
            themeButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const novoTema = btn.dataset.theme;
                    setTheme(novoTema);
                });
            });
            console.log('✅ Botões de tema inicializados');
        }

        // Listeners para SWATCHES DE COR
        const swatches = document.querySelectorAll('.swatch');
        if (swatches.length > 0) {
            swatches.forEach(swatch => {
                swatch.addEventListener('click', () => {
                    const novaCor = swatch.dataset.color;
                    setColor(novaCor);
                });
            });
            console.log('✅ Swatches de cor inicializados');
        }
    }

    // ============================================
    // INICIALIZAÇÃO COMPLETA
    // ============================================
    function init() {
        const currentTheme = localStorage.getItem('theme') || 'dark';
        const currentColor = localStorage.getItem('corTema') || '#D13438';
        
        // Aplica tema e cor
        document.documentElement.setAttribute('data-theme', currentTheme);
        document.documentElement.style.setProperty('--accent-color', currentColor);
        
        // Atualiza UI
        updateThemeButtons(currentTheme);
        updateColorPreview(currentColor);
        updateColorSwatches(currentColor);
        updateFloatingButton(currentTheme);
        
        // Inicializa página de tema (se existir)
        initThemePage();
        
        // Cria botão flutuante (opcional - descomente se quiser)
        // createFloatingButton();
        
        console.log('✅ Sistema de Tema carregado');
    }

    // Executa quando DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // ============================================
    // API GLOBAL (Para controle externo)
    // ============================================
    window.themeManager = {
        // Obter tema atual
        getTheme: () => document.documentElement.getAttribute('data-theme'),
        
        // Definir tema
        setTheme: setTheme,
        
        // Alternar tema
        toggle: () => {
            const current = document.documentElement.getAttribute('data-theme');
            const newTheme = current === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
        },
        
        // Obter cor atual
        getColor: () => localStorage.getItem('corTema') || '#D13438',
        
        // Definir cor
        setColor: setColor,
        
        // Resetar para padrão
        reset: () => {
            setTheme('dark');
            setColor('#D13438');
            console.log('🔄 Tema resetado para padrão');
        }
    };

    console.log('📖 API disponível: window.themeManager');

})();