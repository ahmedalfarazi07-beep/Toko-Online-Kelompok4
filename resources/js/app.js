import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Toast notification system
window.showToast = function(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    const colors = {
        success: 'border-green-500',
        error: 'border-red-500',
        warning: 'border-yellow-500',
        info: 'border-blue-500'
    };
    const icons = {
        success: '<svg class="w-5 h-5 shrink-0 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        error: '<svg class="w-5 h-5 shrink-0 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        warning: '<svg class="w-5 h-5 shrink-0 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>',
        info: '<svg class="w-5 h-5 shrink-0 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
    };

    toast.className = `bg-surface/95 backdrop-blur-sm border-l-4 ${colors[type] || colors.info} text-white px-5 py-3 rounded-lg shadow-2xl flex items-center gap-3 max-w-sm animate-slide-in-right`;
    toast.innerHTML = `${icons[type] || icons.info}<p class="text-sm font-medium flex-1">${message}</p>`;

    container.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('animate-slide-out-right');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
};

// Particle animation for hero canvas
class ParticleBackground {
    constructor(canvas) {
        if (!canvas) return;
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.particles = [];
        this.mouseX = 0;
        this.mouseY = 0;
        this.init();
    }

    init() {
        this.resize();
        window.addEventListener('resize', () => this.resize());
        this.canvas.addEventListener('mousemove', (e) => {
            this.mouseX = e.clientX;
            this.mouseY = e.clientY;
        });
        this.createParticles();
        this.animate();
    }

    resize() {
        this.canvas.width = this.canvas.offsetWidth;
        this.canvas.height = this.canvas.offsetHeight;
    }

    createParticles() {
        const count = Math.floor((this.canvas.width * this.canvas.height) / 10000);
        for (let i = 0; i < Math.min(count, 80); i++) {
            this.particles.push({
                x: Math.random() * this.canvas.width,
                y: Math.random() * this.canvas.height,
                vx: (Math.random() - 0.5) * 1.5,
                vy: (Math.random() - 0.5) * 1.5,
                size: Math.random() * 3 + 1,
                opacity: Math.random() * 0.5 + 0.1,
            });
        }
    }

    animate() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        
        this.particles.forEach((p, i) => {
            p.x += p.vx;
            p.y += p.vy;

            if (p.x < 0 || p.x > this.canvas.width) p.vx *= -1;
            if (p.y < 0 || p.y > this.canvas.height) p.vy *= -1;

            // Mouse interaction
            const dx = this.mouseX - p.x;
            const dy = this.mouseY - p.y;
            const dist = Math.sqrt(dx * dx + dy * dy);
            if (dist < 150) {
                p.vx -= dx * 0.0005;
                p.vy -= dy * 0.0005;
            }

            this.ctx.beginPath();
            this.ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
            this.ctx.fillStyle = `rgba(124, 58, 237, ${p.opacity})`;
            this.ctx.fill();

            // Connect nearby particles
            for (let j = i + 1; j < this.particles.length; j++) {
                const dx2 = this.particles[j].x - p.x;
                const dy2 = this.particles[j].y - p.y;
                const dist2 = Math.sqrt(dx2 * dx2 + dy2 * dy2);
                if (dist2 < 120) {
                    this.ctx.beginPath();
                    this.ctx.strokeStyle = `rgba(124, 58, 237, ${0.1 * (1 - dist2 / 120)})`;
                    this.ctx.lineWidth = 0.5;
                    this.ctx.moveTo(p.x, p.y);
                    this.ctx.lineTo(this.particles[j].x, this.particles[j].y);
                    this.ctx.stroke();
                }
            }
        });

        requestAnimationFrame(() => this.animate());
    }
}

// Initialize everything on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Hero particles
    const particleCanvas = document.getElementById('particleCanvas');
    if (particleCanvas) new ParticleBackground(particleCanvas);

    // Typewriter effect
    const typewriterEl = document.getElementById('typewriter-text');
    if (typewriterEl) {
        const text = 'Belanja Mudah, Cepat, dan Terpercaya';
        let index = 0;
        typewriterEl.textContent = '';
        function type() {
            if (index < text.length) {
                typewriterEl.textContent += text.charAt(index);
                index++;
                setTimeout(type, 50);
            }
        }
        setTimeout(type, 500);
    }

    // Scroll reveal with IntersectionObserver
    const revealElements = document.querySelectorAll('.reveal');
    if (revealElements.length) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.1 }
        );
        revealElements.forEach((el) => observer.observe(el));
    }

    // Cart badge bounce animation
    const cartBadge = document.getElementById('cart-badge');
    if (cartBadge) {
        const observer = new MutationObserver(() => {
            cartBadge.classList.remove('animate-scale-bounce');
            void cartBadge.offsetWidth; // reflow
            cartBadge.classList.add('animate-scale-bounce');
        });
        observer.observe(cartBadge, { characterData: true, childList: true, subtree: true });
    }

    // Button ripple effect
    document.querySelectorAll('.btn-ripple').forEach((btn) => {
        btn.addEventListener('click', function (e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const ripple = document.createElement('span');
            ripple.style.cssText = `
                position: absolute;
                width: 20px; height: 20px;
                background: rgba(255,255,255,0.3);
                border-radius: 50%;
                left: ${x - 10}px;
                top: ${y - 10}px;
                transform: scale(0);
                animation: ripple-effect 0.6s ease-out forwards;
                pointer-events: none;
            `;
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    });
});

// Add ripple and toast animation keyframes
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple-effect {
        to { transform: scale(10); opacity: 0; }
    }
    @keyframes slide-in-right {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slide-out-right {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    .animate-slide-in-right {
        animation: slide-in-right 0.3s ease-out forwards;
    }
    .animate-slide-out-right {
        animation: slide-out-right 0.3s ease-in forwards;
    }
`;
document.head.appendChild(style);
