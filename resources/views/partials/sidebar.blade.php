
<div class="sidebar">
        <div class="sidebar-brand">
            <h2 class="text-white font-bold text-xl flex items-center">
                <span class="gold-accent">Gold</span><span class="text-white">Sales</span>
            </h2>
        </div>
        
        <ul class="sidebar-menu mt-5">
            <li class="sidebar-item">
                <a href="/" class="sidebar-link">
                    <i class="fas fa-tachometer-alt gold-accent"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="penjualan" class="sidebar-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Penjualan</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="produk" class="sidebar-link">
                    <i class="fas fa-box"></i>
                    <span>Produk</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="pelanggan" class="sidebar-link">
                    <i class="fas fa-users"></i>
                    <span>Member</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="laporan-penjualan" class="sidebar-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
            </li>
        </ul>
    </div>

    <script>
        // Function to handle the active state of sidebar navigation
document.addEventListener('DOMContentLoaded', function() {
    // Get all sidebar links
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    
    // Add click event listener to each sidebar link
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Remove active class from all links
            sidebarLinks.forEach(item => {
                item.classList.remove('active');
            });
            
            // Add active class to the clicked link
            this.classList.add('active');
            
            // Optional: Store the active page in localStorage to maintain state across page reloads
            if (this.getAttribute('href') !== '#') {
                localStorage.setItem('activePage', this.getAttribute('href'));
            }
        });
    });
    
    // Set active class based on current URL or localStorage
    const currentPath = window.location.pathname.split('/').pop() || '/';
    const storedActivePage = localStorage.getItem('activePage');
    
    sidebarLinks.forEach(link => {
        const href = link.getAttribute('href');
        
        if ((href === currentPath) || 
            (storedActivePage && href === storedActivePage) || 
            (currentPath === '/' && href === '/')) {
            link.classList.add('active');
        }
    });
});

// If you're using a single-page application, you might want to include this function
// to update the active state without page reload
function updateActiveState(path) {
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    
    sidebarLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === path) {
            link.classList.add('active');
        }
    });
    
    localStorage.setItem('activePage', path);
}
    </script>