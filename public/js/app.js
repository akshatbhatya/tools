// =============================================
// WEB TOOLS HUB - MAIN JAVASCRIPT
// =============================================

document.addEventListener('DOMContentLoaded', function() {
    // Navigation functionality
    initNavigation();
    
    // Smooth scrolling for anchor links
    initSmoothScroll();
    
    // Navbar scroll effect
    initNavbarScroll();
});

// =============================================
// NAVIGATION
// =============================================
function initNavigation() {
    const menuToggle = document.getElementById('menuToggle');
    const navbarMenu = document.getElementById('navbarMenu');
    
    if (menuToggle && navbarMenu) {
        menuToggle.addEventListener('click', function() {
            navbarMenu.classList.toggle('active');
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!menuToggle.contains(event.target) && !navbarMenu.contains(event.target)) {
                navbarMenu.classList.remove('active');
            }
        });
        
        // Close menu when clicking on a link
        const navLinks = navbarMenu.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                navbarMenu.classList.remove('active');
            });
        });
    }
}

// =============================================
// SMOOTH SCROLLING
// =============================================
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#' || href === '') return;
            
            e.preventDefault();
            const target = document.querySelector(href);
            
            if (target) {
                const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// =============================================
// NAVBAR SCROLL EFFECT
// =============================================
function initNavbarScroll() {
    const navbar = document.getElementById('navbar');
    
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }
}

// =============================================
// FILE UPLOAD UTILITIES
// =============================================
function handleFileUpload(inputElement, callback) {
    inputElement.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files.length > 0) {
            callback(files);
        }
    });
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i];
}

function downloadFile(blob, filename) {
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

// =============================================
// LOADING SPINNER
// =============================================
function showLoading(element) {
    const spinner = document.createElement('div');
    spinner.className = 'animate-spin';
    spinner.innerHTML = '⏳';
    spinner.style.cssText = 'font-size: 2rem; text-align: center; padding: 2rem;';
    element.appendChild(spinner);
    return spinner;
}

function hideLoading(spinner) {
    if (spinner && spinner.parentNode) {
        spinner.parentNode.removeChild(spinner);
    }
}

// =============================================
// TOAST NOTIFICATIONS
// =============================================
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: ${type === 'success' ? 'var(--gradient-primary)' : 'var(--gradient-secondary)'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-xl);
        z-index: 9999;
        animation: fadeIn 0.3s ease;
    `;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}

// =============================================
// COPY TO CLIPBOARD
// =============================================
function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            showToast('Copied to clipboard!');
        });
    } else {
        // Fallback for older browsers
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        showToast('Copied to clipboard!');
    }
}
