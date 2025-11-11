<?php
// 1. INICIA A SESSÃO E CONECTA AO BANCO
session_start();
require_once 'config/db.php';

// 2. VERIFICA O LOGIN
$usuario_logado = false;
$nome_usuario = '';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $usuario_logado = true;
    $nome_usuario = $_SESSION['nome_usuario'];
}

// 3. BUSCA OS CURSOS DO BANCO DE DADOS
try {
    $stmt = $pdo->query("SELECT * FROM cursos");
    $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    shuffle($cursos); // Randomiza os cursos
} catch (PDOException $e) {
    $cursos = []; // Em caso de erro, o array fica vazio
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autocademy - Início</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>
<body>
<header>
    <div class="nav">

        <div class="logo">
            <img src="img/logo.png" alt="Logo" style="width: 70px; height: 50px;">
            <h6 id="autocademy">AUTOCADEMY</h6>
        </div>

        <div class="nav-links">
            <ul>
                <li><a href="index.php">Início</a></li>
                <li><a href="#">Cursos</a></li>
                <li><a href="#">Sobre</a></li>
                <li><a href="#">Contato</a></li>
                
                <?php if ($usuario_logado): ?>
                    
                    <li style="color: #fff; margin-left: 10px; font-weight: 500; cursor: pointer;">Olá, <span class="nome-usuario"><?php echo htmlspecialchars(explode(' ', $nome_usuario)[0]); ?>!</span></li>
                    <li><a href="backend/logout.php" class="btn-entrar">Sair</a></li>
                
                <?php else: ?>
                    
                    <li><a href="login.php" class="btn-entrar">Entrar</a></li>
                
                <?php endif; ?>
                </ul>
        </div>
    </div>
</header>
<main>
    <video class="video-fundo" autoplay loop muted playsinline>
        <source src="videos/fundo3.mp4" type="video/mp4">
        Seu navegador não suporta vídeos.
    </video>

    <div class="inicio-texto">
        <h1>AUTOCADEMY</h1>
        <h4 id="subtitulo-inicio">Seja o piloto da sua carreira.</h4> 
    </div>
    <a href="#sobre" class="scroll-down-arrow">
        <span></span> </a>
</main>
    <section id="sobre" style="height: 1000px; padding: 50px;">
       <h1 style="font-size: 3rem; text-align: center;">Bem-vindo a AUTO<span style="color: rgba(255, 82, 82, 0.7);">CADEMY</span></h1>
       <h4 id="subtitulo-sobre">Entenda tudo sobre nossa empresa</h4>
       
       <div class="conteiner-sobre">
            <span class="inner-border-left"></span>
            <span class="inner-border-right"></span>

        <h1 style="font-size: 2rem;">
          Acelerando o seu Conhecimento Automotivo  
        </h1>
        <p style="font-size: 1.5rem;">
A AutoCademy funciona como uma sala de aula automotiva digital, criada para suprir a defasagem do ensino tradicional diante da rápida evolução do mercado. Com foco 100% prático e instrutores especialistas, a plataforma oferece um ambiente estruturado para mecânicos e profissionais dominarem as novas tecnologias do setor.
        </p>
       </div>
    </section>

<section id="cursos-secao">
    
    <h2 class="secao-titulo">Nossos Cursos</h2>

    <div class="swiper course-carousel">
        
        <div class="swiper-wrapper">
            
            <?php foreach ($cursos as $curso): ?>
                <div class="swiper-slide">
                    <div class="course-card">
                        <img src="<?php echo htmlspecialchars($curso['imagem_url']); ?>" alt="<?php echo htmlspecialchars($curso['nome']); ?>" class="card-image">
                        
                        <div class="card-content-base">
                            <h4><?php echo htmlspecialchars($curso['nome']); ?></h4>
                        </div>
                        
                        <div class="card-content-hover">
                            <p><?php echo htmlspecialchars($curso['descricao_curta']); ?></p>
                            <a href="#" class="btn-inscrever">Inscrever-se</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>

</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script> 
<script>
        document.addEventListener('DOMContentLoaded', () => {

            function inicializarSwiper() {
                const swiper = new Swiper('.course-carousel', {
                    loop: true,
                    autoplay: {
                        delay: 3000, 
                        disableOnInteraction: false, 
                        pauseOnMouseEnter: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-prev',
                        prevEl: '.swiper-button-next',
                    },
                    slidesPerView: 1, 
                    spaceBetween: 20,
                    grabCursor: true, 
                    
                    breakpoints: {
                        640: { slidesPerView: 2, spaceBetween: 20 },
                        1024: { slidesPerView: 3, spaceBetween: 30 },
                        1400: { slidesPerView: 4, spaceBetween: 30 }
                    }
                });
            }

            inicializarSwiper();

        });
    </script>
</body> 
</html>