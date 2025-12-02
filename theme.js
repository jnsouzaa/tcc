// ============================================
// SISTEMA DE TEMA DARK/LIGHT MODE GLOBAL
// ============================================
// Salve como: /js/theme.js
// Adicione em TODAS as páginas: <script src="../js/theme.js"></script>

(function() {
    'use strict';

    // ============================================
    // APLICAR TEMA IMEDIATAMENTE (EVITA FLASH)
    // ============================================
    // Este código roda ANTES do DOM carregar para evitar "flash" de cor errada
    const savedTheme = localStorage.getItem('theme') || 'dark';
    const savedColor = localStorage.getItem('corTema') || '#D13438';
    document.documentElement.setAttribute('data-theme', savedTheme);
    document.documentElement.style.setProperty('--accent-color', savedColor);

    // ============================================
    // ALTERNAR TEMA
    // ============================================
    function toggleTheme() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        // Aplica o novo tema
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        
        console.log('✅ Tema alterado para:', newTheme);
        
        // Atualiza o ícone do botão
        updateThemeIcon(newTheme);
        
        // Animação de rotação
        const toggleBtn = document.querySelector('.theme-toggle');
        if (toggleBtn) {
            toggleBtn.classList.add('rotating');
            setTimeout(() => toggleBtn.classList.remove('rotating'), 500);
        }
    }

    // ============================================
    // ATUALIZAR ÍCONE DO BOTÃO
    // ============================================
    function updateThemeIcon(theme) {
        const icon = document.querySelector('.theme-toggle i');
        if (icon) {
            // Dark mode = mostra sol ☀️ (para mudar para light)
            // Light mode = mostra lua 🌙 (para mudar para dark)
            if (theme === 'dark') {
                icon.className = 'fa-solid fa-sun';
            } else {
                icon.className = 'fa-solid fa-moon';
            }
        }
    }

    // ============================================
    // CRIAR BOTÃO FLUTUANTE DE TOGGLE
    // ============================================
    function createThemeToggle() {
        // Verifica se já existe o botão
        if (document.querySelector('.theme-toggle')) {
            console.log('⚠️ Botão de tema já existe');
            return;
        }
        
        // Cria o botão
        const button = document.createElement('button');
        button.className = 'theme-toggle';
        button.setAttribute('aria-label', 'Alternar tema');
        button.setAttribute('title', 'Alternar entre tema claro e escuro');
        
        // Cria o ícone
        const icon = document.createElement('i');
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
        icon.className = currentTheme === 'dark' ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
        
        button.appendChild(icon);
        document.body.appendChild(button);
        
        // Adiciona o evento de clique
        button.addEventListener('click', toggleTheme);
        
        console.log('✅ Botão de tema criado com sucesso!');
    }

    // ============================================
    // SINCRONIZAR TEMA ENTRE ABAS/JANELAS
    // ============================================
    window.addEventListener('storage', function(e) {
        // Detecta mudanças de tema em outras abas
        if (e.key === 'theme') {
            const newTheme = e.newValue || 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            updateThemeIcon(newTheme);
            console.log('🔄 Tema sincronizado de outra aba:', newTheme);
        }
        
        // Detecta mudanças de cor em outras abas
        if (e.key === 'corTema') {
            const newColor = e.newValue || '#D13438';
            document.documentElement.style.setProperty('--accent-color', newColor);
            console.log('🎨 Cor sincronizada de outra aba:', newColor);
        }
    });

    // ============================================
    // INICIALIZAR QUANDO DOM ESTIVER PRONTO
    // ============================================
    function init() {
        const currentTheme = localStorage.getItem('theme') || 'dark';
        const currentColor = localStorage.getItem('corTema') || '#D13438';
        
        console.log('🎨 Tema Atual:', currentTheme);
        console.log('🎨 Cor Atual:', currentColor);
        
        // Garante que o tema está aplicado
        document.documentElement.setAttribute('data-theme', currentTheme);
        document.documentElement.style.setProperty('--accent-color', currentColor);
        
        // Cria o botão flutuante
        createThemeToggle();
        
        // Atualiza o ícone do botão
        updateThemeIcon(currentTheme);
    }

    // Executa quando DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        // DOM já está pronto
        init();
    }

    // ============================================
    // API GLOBAL PARA CONTROLE EXTERNO
    // ============================================
    window.themeManager = {
        // Alternar entre dark/light
        toggle: function() {
            toggleTheme();
        },
        
        // Obter tema atual
        getTheme: function() {
            return document.documentElement.getAttribute('data-theme');
        },
        
        // Definir tema específico
        setTheme: function(theme) {
            if (theme !== 'dark' && theme !== 'light') {
                console.error('❌ Tema inválido. Use "dark" ou "light"');
                return;
            }
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            updateThemeIcon(theme);
            console.log('✅ Tema definido para:', theme);
        },
        
        // Obter cor atual
        getColor: function() {
            return localStorage.getItem('corTema') || '#D13438';
        },
        
        // Definir cor de destaque
        setColor: function(color) {
            document.documentElement.style.setProperty('--accent-color', color);
            localStorage.setItem('corTema', color);
            console.log('✅ Cor definida para:', color);
        }
    };

    console.log('✅ Sistema de Tema carregado com sucesso!');
    console.log('📖 Use window.themeManager para controle programático');

})();
