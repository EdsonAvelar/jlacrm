{{-- Mobile sidebar toggle component --}}

<a href="#" id="mobile-sidebar-toggle-{{ rand(1000, 9999) }}"
    class="text-reset mobile-sidebar-toggle d-inline-block {{ $class ?? '' }}"
    style="text-decoration: none; cursor: pointer;">
    <i class="mdi mdi-menu-right d-md-none me-1"></i>{{ $title ?? 'Menu' }}
</a>

<style>
    .text-purple {
        color: rgb(89, 0, 184) !important;
    }

    /* Mobile sidebar styles */
    @media (max-width: 767.98px) {
        .leftside-menu {
            display: none;
            transform: none !important;
        }

        .mobile-sidebar-toggle {
            display: inline-flex;
            align-items: center;
        }

        .mobile-sidebar-toggle .mdi-menu-right {
            font-size: 24px;
            margin-right: 5px;
        }

        /* Ensure menu is visible over other elements */
        .leftside-menu.mobile-visible {
            z-index: 1050 !important;
        }
    }

    @media (min-width: 768px) {
        .mobile-sidebar-toggle .mdi-menu-right {
            display: none;
        }
    }
</style>

<script>
    // Use an IIFE para evitar conflitos
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        var toggleButton = document.querySelector('.mobile-sidebar-toggle');
        if (!toggleButton) return;
        
        toggleButton.addEventListener('click', function(e) {
            // Só executa o código se estiver em mobile (menor que 768px)

            var docWidth = document.documentElement.clientWidth;
            console.log(docWidth)
            if (docWidth>= 768) {
                e.preventDefault();
                return; // desativa o clique
            }
            
            e.preventDefault();
            var sideMenu = document.querySelector('.leftside-menu');
            if (!sideMenu) {
                console.error('Sidebar menu element not found!');
                return;
            }
            
            if (sideMenu.classList.contains('mobile-visible')) {
                sideMenu.classList.remove('mobile-visible');
                sideMenu.style.display = 'none';
            } else {
                sideMenu.classList.add('mobile-visible');
                sideMenu.style.display = 'block';
                sideMenu.style.position = 'fixed';
                sideMenu.style.top = '0';
                sideMenu.style.left = '0';
                sideMenu.style.bottom = '0';
                sideMenu.style.width = '250px';
                sideMenu.style.zIndex = '9999';
                sideMenu.style.overflowY = 'auto';
                sideMenu.style.boxShadow = '0 0 35px 0 rgba(0,0,0,0.25)';
                
                setTimeout(function() {
                    document.addEventListener('click', outsideClickHandler);
                }, 10);
            }
        });
        
        function outsideClickHandler(e) {
            var sideMenu = document.querySelector('.leftside-menu');
            if (!sideMenu) return;
            
            if (!sideMenu.contains(e.target) && 
                !e.target.classList.contains('mobile-sidebar-toggle') &&
                !e.target.closest('.mobile-sidebar-toggle')) {
                sideMenu.classList.remove('mobile-visible');
                sideMenu.style.display = 'none';
                document.removeEventListener('click', outsideClickHandler);
            }
        }
        
        var menuLinks = document.querySelectorAll('.leftside-menu a:not([data-bs-toggle="collapse"])');
        menuLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    var sideMenu = document.querySelector('.leftside-menu');
                    if (sideMenu) {
                        sideMenu.classList.remove('mobile-visible');
                        sideMenu.style.display = 'none';
                    }
                }
            });
        });
    });
})();
</script>