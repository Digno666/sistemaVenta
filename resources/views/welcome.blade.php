Aquí tienes el código completo con la nueva sección de navegación "CONTACTO" que enlaza con la sección "¿LISTO PARA CAMBIAR?", y sin el copyright como solicitaste.
```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>BODY FIT | Gimnasio de Alto Rendimiento</title>
    <!-- Google Fonts + Font Awesome CDN -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #000000;
            color: #f0f0f0;
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        /* ========== COLORES PRINCIPALES: ROJO Y NEGRO ========== */
        :root {
            --rojo-bold: #E11D1D;
            --rojo-hover: #c41717;
            --negro-profundo: #0A0A0A;
            --negro-carbono: #111111;
            --gris-oscuro: #1E1E1E;
            --texto-claro: #EAEAEA;
            --texto-gris: #B0B0B0;
        }

        /* Scrollbar personalizada (rojo/negro) */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--negro-carbono);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--rojo-bold);
            border-radius: 10px;
        }

        /* Contenedor general */
        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 30px;
        }

        /* ----- HEADER (NAVEGACIÓN) ----- */
        header {
            background-color: rgba(0, 0, 0, 0.92);
            backdrop-filter: blur(3px);
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(225, 29, 29, 0.4);
            transition: 0.2s;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 0;
            flex-wrap: wrap;
        }

        .logo h1 {
            font-size: 1.9rem;
            font-weight: 800;
            letter-spacing: -1px;
            background: linear-gradient(135deg, #FFFFFF 30%, #E11D1D 80%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .logo span {
            font-size: 0.9rem;
            font-weight: 400;
            color: var(--rojo-bold);
            letter-spacing: 1px;
        }

        .nav-links {
            display: flex;
            gap: 2.2rem;
            list-style: none;
        }
        .nav-links a {
            text-decoration: none;
            color: var(--texto-claro);
            font-weight: 600;
            font-size: 1rem;
            transition: 0.2s;
            letter-spacing: 0.5px;
        }
        .nav-links a:hover {
            color: var(--rojo-bold);
        }
        .btn-nav {
            background: var(--rojo-bold);
            padding: 8px 20px;
            border-radius: 40px;
            color: white !important;
            font-weight: 700;
            transition: 0.2s;
        }
        .btn-nav:hover {
            background: var(--rojo-hover);
            transform: scale(1.02);
        }

        /* menu responsive */
        .menu-icon {
            display: none;
            font-size: 1.8rem;
            cursor: pointer;
            color: white;
        }

        /* ========== SECCIÓN 1: HERO CON IMAGEN DE FONDO ========== */
        .hero {
            position: relative;
            width: 100%;
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.6) 100%), url('https://images.pexels.com/photos/841130/pexels-photo-841130.jpeg?auto=compress&cs=tinysrgb&w=1600') center/cover no-repeat fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-top: 0;
        }

        .hero-content {
            max-width: 850px;
            padding: 20px;
            animation: fadeUp 0.8s ease-out;
        }
        .hero-content h2 {
            font-size: 3.2rem;
            font-weight: 800;
            letter-spacing: -1px;
            text-transform: uppercase;
        }
        .hero-content h2 span {
            color: var(--rojo-bold);
            text-shadow: 0 0 8px rgba(225,29,29,0.5);
        }
        .hero-content p {
            font-size: 1.2rem;
            margin: 20px 0 30px;
            color: #ddd;
            font-weight: 400;
        }
        .btn-hero {
            background: var(--rojo-bold);
            border: none;
            padding: 14px 38px;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 50px;
            color: white;
            cursor: pointer;
            transition: 0.2s;
            box-shadow: 0 6px 14px rgba(225,29,29,0.3);
        }
        .btn-hero:hover {
            background: white;
            color: var(--rojo-bold);
            transform: translateY(-3px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.3);
        }

        /* ========== SECCIONES GENERALES ========== */
        section {
            padding: 90px 0;
        }
        .section-dark {
            background-color: var(--negro-profundo);
        }
        .section-light-dark {
            background-color: var(--negro-carbono);
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 50px;
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .section-title:after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: var(--rojo-bold);
            margin: 12px auto 0;
            border-radius: 4px;
        }

        /* CARDS / SERVICIOS */
        .cards-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 35px;
        }
        .service-card {
            background: #111;
            border-radius: 20px;
            overflow: hidden;
            width: 300px;
            transition: all 0.25s ease;
            border: 1px solid rgba(225,29,29,0.2);
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
        }
        .service-card:hover {
            transform: translateY(-8px);
            border-color: var(--rojo-bold);
            box-shadow: 0 20px 30px rgba(225,29,29,0.2);
        }
        .card-img {
            height: 190px;
            overflow: hidden;
        }
        .card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.3s;
        }
        .service-card:hover .card-img img {
            transform: scale(1.05);
        }
        .card-info {
            padding: 25px 20px;
        }
        .card-info h3 {
            font-size: 1.6rem;
            margin-bottom: 12px;
            color: var(--rojo-bold);
        }
        .card-info p {
            color: #bcbcbc;
            line-height: 1.5;
        }

        /* SECCIÓN HORARIOS Y PRECIOS */
        .info-row {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            justify-content: space-between;
            align-items: center;
        }
        .info-box {
            background: #0e0e0e;
            border-radius: 28px;
            padding: 35px 30px;
            flex: 1;
            border-left: 5px solid var(--rojo-bold);
            transition: 0.2s;
        }
        .info-box h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .info-box i {
            color: var(--rojo-bold);
            font-size: 2rem;
        }
        .schedule-list {
            list-style: none;
        }
        .schedule-list li {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #2a2a2a;
            font-weight: 500;
        }
        .price-badge {
            font-weight: 800;
            color: var(--rojo-bold);
            font-size: 1.3rem;
        }
        .btn-outline-red {
            background: transparent;
            border: 2px solid var(--rojo-bold);
            padding: 12px 28px;
            border-radius: 40px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 25px;
            display: inline-block;
        }
        .btn-outline-red:hover {
            background: var(--rojo-bold);
            color: black;
        }

        /* FOOTER - VERSIÓN COMPACTA (menos height, sin horarios) */
        footer {
            background: #050505;
            padding: 35px 0 25px;
            border-top: 2px solid var(--rojo-bold);
        }
        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
            align-items: flex-start;
        }
        .footer-col h4 {
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: var(--rojo-bold);
        }
        .footer-col p, .footer-col a {
            color: #aaa;
            line-height: 1.6;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .footer-col a:hover {
            color: var(--rojo-bold);
        }
        .social-links a {
            font-size: 1.4rem;
            margin-right: 16px;
            color: #ccc;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 980px) {
            .navbar {
                padding: 15px 0;
            }
            .nav-links {
                display: none;
                flex-direction: column;
                width: 100%;
                background: black;
                text-align: center;
                gap: 1rem;
                padding: 20px 0;
            }
            .nav-links.active {
                display: flex;
            }
            .menu-icon {
                display: block;
            }
            .hero-content h2 {
                font-size: 2.3rem;
            }
            .section-title {
                font-size: 2rem;
            }
            .info-row {
                flex-direction: column;
            }
        }

        @media (max-width: 560px) {
            .container {
                padding: 0 20px;
            }
            .hero-content h2 {
                font-size: 1.9rem;
            }
            .btn-hero {
                padding: 12px 28px;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <h1>BODY FIT <span>| STRONG MINDSET</span></h1>
            </div>
            <div class="menu-icon" id="menuToggle">
                <i class="fas fa-bars"></i>
            </div>
            <ul class="nav-links" id="navLinks">
                <li><a href="#inicio">INICIO</a></li>
                <li><a href="#servicios">SERVICIOS</a></li>
                <li><a href="#horarios">HORARIOS</a></li>
                <li><a href="#contacto">CONTACTO</a></li>
                <a href="{{ route('login') }}" class="btn-nav">UNIRSE</a>
            </ul>
        </div>
    </div>
</header>

<main>
    <section id="inicio" class="hero">
        <div class="hero-content">
            <h2>TRANSFORMA TU <span>CUERPO</span><br>SUPERA TUS <span>LÍMITES</span></h2>
            <p>Entrenamiento de alto rendimiento, asesoría profesional y la mejor energía. <br> Únete a BODY FIT y vive la experiencia definitiva.</p>
            <a href="{{ route('login') }}" class="btn-hero">EMPEZAR AHORA</a>
        </div>
    </section>

    <section id="servicios" class="section-dark">
        <div class="container">
            <h2 class="section-title">NUESTROS SERVICIOS</h2>
            <div class="cards-grid">
                <div class="service-card">
                    <div class="card-img"><img src="https://images.pexels.com/photos/1954524/pexels-photo-1954524.jpeg?auto=compress&cs=tinysrgb&w=600" alt="pesas"></div>
                    <div class="card-info">
                        <h3>PESAS & MUSCULACIÓN</h3>
                        <p>Zona equipada con maquinaria de última generación, discos olímpicos y racks para powerlifting.</p>
                    </div>
                </div>
                <div class="service-card">
                    <div class="card-img"><img src="https://images.pexels.com/photos/260447/pexels-photo-260447.jpeg?auto=compress&cs=tinysrgb&w=600" alt="cardio"></div>
                    <div class="card-info">
                        <h3>CARDIO & HIIT</h3>
                        <p>Área de cardio con cintas, elípticas, bicicletas y clases grupales de alta intensidad.</p>
                    </div>
                </div>
                <div class="service-card">
                    <div class="card-img"><img src="https://images.pexels.com/photos/6457387/pexels-photo-6457387.jpeg?auto=compress&cs=tinysrgb&w=600" alt="entrenamiento personal"></div>
                    <div class="card-info">
                        <h3>ENTRENAMIENTO PERSONAL</h3>
                        <p>Coaches certificados diseñan rutinas 100% personalizadas para tus objetivos.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="horarios" class="section-light-dark">
        <div class="container">
            <h2 class="section-title">HORARIOS Y PLANES</h2>
            <div class="info-row">
                <div class="info-box">
                    <h3><i class="far fa-clock"></i> Horario de Apertura</h3>
                    <ul class="schedule-list">
                        <li><span>Lunes - Viernes</span> <span>05:00 AM - 11:00 PM</span></li>
                        <li><span>Sábados</span> <span>06:00 AM - 09:00 PM</span></li>
                        <li><span>Domingos</span> <span>08:00 AM - 03:00 PM</span></li>
                        <li><span>Entrenadores disponibles</span> <span>24/7 Asistencia online</span></li>
                    </ul>
                </div>
                <div class="info-box">
                    <h3><i class="fas fa-dumbbell"></i> Planes Especiales</h3>
                    <ul class="schedule-list">
                        <li><span>Plan BÁSICO</span> <span class="price-badge">$29.990/mes</span></li>
                        <li><span>Plan PREMIUM (acceso total + clases)</span> <span class="price-badge">$49.990/mes</span></li>
                        <li><span>Plan ANUAL (ahorra 30%)</span> <span class="price-badge">$299.990/año</span></li>
                        <li><span>Entrenador personal (sesión)</span> <span class="price-badge">+$15.990</span></li>
                    </ul>
                    <button class="btn-outline-red" onclick="alert('¡Promoción vigente! Primer mes con 20% OFF. Contáctanos.')">VER OFERTAS <i class="fas fa-tags"></i></button>
                </div>
            </div>
        </div>
    </section>
    <section id="contacto" class="section-dark" style="padding: 70px 0;">
        <div class="container" style="text-align: center;">
            <h2 class="section-title" style="margin-bottom: 20px;">¿LISTO PARA CAMBIAR?</h2>
            <p style="max-width: 600px; margin: 0 auto 25px auto; font-size: 1.1rem; color: #ccc;">Escríbenos o visítanos para conocer más sobre nuestros planes y promociones.</p>
            <button class="btn-hero" style="background: var(--rojo-bold); padding: 12px 32px;" onclick="alert('Contáctanos al +56 2 2990 2345 o hola@bodyfit.cl')">CONTACTO DIRECTO <i class="fas fa-phone-alt"></i></button>
        </div>
    </section>
</main>

<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-col">
                <h4>BODY FIT GYM</h4>
                <p>Entrenamiento, disciplina y resultados. Más de 10 años formando atletas y personas comprometidas con su salud.</p>
                <div class="social-links" style="margin-top: 12px;">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>CONTACTO</h4>
                <p><i class="fas fa-map-marker-alt"></i> Av. Los Héroes 2450, Santiago</p>
                <p><i class="fas fa-phone-alt"></i> +56 2 2990 2345</p>
                <p><i class="fas fa-envelope"></i> hola@bodyfit.cl</p>
            </div>
            <!-- Se eliminó la columna de HORARIO ATENCIÓN para reducir height -->
        </div>
    </div>
</footer>

<script>
    // Menú responsive toggle
    const menuToggle = document.getElementById('menuToggle');
    const navLinks = document.getElementById('navLinks');
    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
    // Cerrar menú al hacer click en un enlace
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('active');
        });
    });
    // Smooth scroll para enlaces internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if(targetId === "#" || targetId === "") return;
            const targetElement = document.querySelector(targetId);
            if(targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
</body>
</html>