// Adiciona carregamento suave de imagens
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.photo-image');
            
            images.forEach(img => {
                // Adiciona efeito de carregamento
                img.style.opacity = '0.8';
                img.style.transition = 'opacity 0.3s';
                
                img.onload = function() {
                    this.style.opacity = '1';
                };
                
                // Se a imagem falhar ao carregar
                img.onerror = function() {
                    this.style.opacity = '1';
                };
            });
        });