<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa | IT CLUB TRIMULIA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #e74c3c;
            --primary-dark: #c0392b;
            --primary-light: #ff6b6b;
            --secondary: #1a1a1a;
            --text-light: #f8f9fa;
            --text-muted: #adb5bd;
            --glass: rgba(0, 0, 0, 0.5);
            --glass-border: rgba(255, 255, 255, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
            background: linear-gradient(135deg, #000000, #2c3e50);
            color: var(--text-light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        /* Fiber Optic Canvas */
        #fiberCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        
        /* Login Container */
        .main-w3layouts.wrapper {
            width: 100%;
            max-width: 500px;
            padding: 2rem;
            text-align: center;
        }
        
        .main-agileinfo {
            background: var(--glass);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(231, 76, 60, 0.3);
            border: 1px solid var(--glass-border);
            transition: transform 0.3s ease;
        }
        
        .main-agileinfo:hover {
            transform: translateY(-5px);
        }
        
        h1 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: var(--primary-light);
            text-shadow: 0 0 10px rgba(231, 76, 60, 0.5);
        }
        
        /* Form Styles */
        .agileits-top {
            margin-top: 1.5rem;
        }
        
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
            text-align: left;
        }
        
        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-light);
        }
        
        input {
            width: 100%;
            padding: 12px 15px 12px 40px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            font-size: 1rem;
            color: var(--text-light);
            transition: all 0.3s ease;
        }
        
        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.2);
            outline: none;
        }
        
        input[type="submit"] {
            padding: 12px;
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            cursor: pointer;
            font-weight: 500;
            margin-top: 1rem;
            border: none;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
            transition: all 0.3s ease;
        }
        
        input[type="submit"]:hover {
            background: linear-gradient(to right, var(--primary-light), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.6);
        }
        
        /* Footer */
        .colorlibcopy-agile {
            margin-top: 2rem;
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        
        .colorlibcopy-agile p {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: rgba(231, 76, 60, 0.2);
            border-radius: 20px;
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            .main-agileinfo {
                padding: 1.5rem;
            }
            
            h1 {
                font-size: 1.5rem;
            }
            
            input {
                padding: 10px 15px 10px 35px;
                font-size: 0.9rem;
            }
            
            .form-group i {
                left: 12px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<!-- Canvas untuk Efek Fiber Optic -->
<canvas id="fiberCanvas"></canvas>

<!-- Form Login -->
<div class="main-w3layouts wrapper">
    <div class="main-agileinfo">
        <h1><i class="fas fa-user-graduate"></i> Login Siswa</h1>
        <div class="agileits-top">
            <form action="pro_login_karyawan.php" method="post">
                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input class="text" type="text" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input class="text" type="password" name="password" placeholder="Password" required>
                </div>
                <input type="submit" value="Login">
            </form>
        </div>
    </div>
    <div class="colorlibcopy-agile">
        <p><i class="fas fa-code"></i> IT CLUB TRIMULIA </p>
    </div>
</div>

<!-- Enhanced Fiber Optic Effect -->
<script>
    const canvas = document.getElementById("fiberCanvas");
    const ctx = canvas.getContext("2d");
    
    // Set canvas size
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    
    // Particle system
    class Particle {
        constructor() {
            this.reset();
            this.y = Math.random() * canvas.height;
        }
        
        reset() {
            this.x = Math.random() * canvas.width;
            this.y = -20;
            this.size = Math.random() * 2 + 1;
            this.speed = Math.random() * 3 + 1;
            this.opacity = Math.random() * 0.6 + 0.2;
            this.color = `rgba(231, 76, 60, ${this.opacity})`;
        }
        
        update() {
            this.y += this.speed;
            
            // Draw line from top to particle
            ctx.beginPath();
            ctx.moveTo(this.x, 0);
            ctx.lineTo(this.x, this.y);
            ctx.strokeStyle = `rgba(231, 76, 60, ${this.opacity * 0.3})`;
            ctx.lineWidth = 0.5;
            ctx.stroke();
            
            // Draw particle
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fillStyle = this.color;
            ctx.fill();
            
            // Reset if out of screen
            if (this.y > canvas.height + 20) {
                this.reset();
            }
        }
    }
    
    // Create particles
    const particles = [];
    const particleCount = Math.floor(canvas.width / 10);
    
    for (let i = 0; i < particleCount; i++) {
        particles.push(new Particle());
    }
    
    // Animation loop
    function animate() {
        // Clear with semi-transparent for trail effect
        ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Update and draw particles
        particles.forEach(particle => {
            particle.update();
        });
        
        requestAnimationFrame(animate);
    }
    
    // Start animation
    animate();
    
    // Handle resize
    window.addEventListener('resize', () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    });
</script>

</body>
</html>