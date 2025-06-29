const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const MAX_MOUSE_DELTA = 50;

    const mouse = {
        x: canvas.width / 2,
        y: canvas.height / 2,
        lastX: canvas.width / 2,
        lastY: canvas.height / 2,
        deltaX: 0,
        deltaY: 0,
        inside: true
    };

    window.addEventListener('mousemove', e => {
        if (!mouse.inside) return; 
        let dx = e.x - mouse.x;
        let dy = e.y - mouse.y;
        dx = Math.max(-MAX_MOUSE_DELTA, Math.min(MAX_MOUSE_DELTA, dx));
        dy = Math.max(-MAX_MOUSE_DELTA, Math.min(MAX_MOUSE_DELTA, dy));
        mouse.deltaX = dx;
        mouse.deltaY = dy;
        mouse.lastX = mouse.x;
        mouse.lastY = mouse.y;
        mouse.x = e.x;
        mouse.y = e.y;
    });

    window.addEventListener('mouseleave', () => {
        mouse.deltaX = 0;
        mouse.deltaY = 0;
        mouse.inside = false;
    });
    window.addEventListener('mouseenter', e => {
        mouse.x = e.x;
        mouse.y = e.y;
        mouse.lastX = e.x;
        mouse.lastY = e.y;
        mouse.deltaX = 0;
        mouse.deltaY = 0;
        mouse.inside = true;
    });

    window.addEventListener('resize', function() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        createParticles();
        mouse.x = canvas.width / 2;
        mouse.y = canvas.height / 2;
    });

    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 1.5 + 1.5;
            this.baseX = this.x;
            this.baseY = this.y;
            this.density = Math.random() * 10 + 2;
            this.speedX = (Math.random() - 0.5) * 0.5;
            this.speedY = (Math.random() - 0.5) * 0.5;
        }

        draw() {
            ctx.fillStyle = 'rgba(0, 105, 180, 255)';
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
        }
        update() {
            this.x += this.speedX;
            this.y += this.speedY;

            // bewegung basierend auf der Maus
            const influenceRadius = 900;
            if (mouse.inside) {
                const dx = mouse.x - this.x;
                const dy = mouse.y - this.y;
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < influenceRadius) {
                    this.speedX += (mouse.deltaX/50) * 0.1 * (1 - distance / influenceRadius);
                    this.speedY += (mouse.deltaY/50) * 0.1 * (1 - distance / influenceRadius);
                }
            }

            // Trägheit/Dämpfung
            this.speedX *= 0.96;
            this.speedY *= 0.96;

            if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
            if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
        }
    }

    let particlesArray = [];
    const numParticles = 250;

    function createParticles() {
        particlesArray = [];
        for (let i = 0; i < numParticles; i++) {
            particlesArray.push(new Particle());
        }
    }

    createParticles();

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        for (let particle of particlesArray) {
            particle.update();
            particle.draw();
        }
        // Dämpfung für Mausbewegung
        mouse.deltaX *= 0.85;
        mouse.deltaY *= 0.85;
        requestAnimationFrame(animate);
    }

    animate();