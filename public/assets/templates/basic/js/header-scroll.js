/**
 * Header Scroll Effect - Inteligência MAX
 * Torna o header transparente no topo e sólido ao rolar
 */
(function() {
    'use strict';
    
    // Detectar se estamos na página de login
    const isLoginPage = document.querySelector('.account');
    if (!isLoginPage) return;
    
    const header = document.querySelector('.header');
    if (!header) return;
    
    // Threshold de scroll (pixels)
    const scrollThreshold = 50;
    
    function handleScroll() {
        const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollPosition > scrollThreshold) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }
    
    // Event listeners
    window.addEventListener('scroll', handleScroll, { passive: true });
    window.addEventListener('load', handleScroll);
    
    // Executar na inicialização
    handleScroll();
})();
