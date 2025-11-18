<?php
session_start();
require_once 'config/db.php';

$usuario_logado = false;
$nome_usuario = '';
$usuario_data = []; 

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $usuario_logado = true;
    $id_usuario = $_SESSION['id_usuario'];
    
    $stmt_usuario = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt_usuario->execute([$id_usuario]);
    $usuario_data = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
    $nome_usuario = $usuario_data['nome'] ?? 'Usuário';
}

$cursos = [
    [
        'id' => 1,
        'nome' => 'Mecânica de Precisão',
        'descricao_curta' => 'Fundamentos da mecânica de motores com foco em precisão e performance.',
        'imagem_url' => 'img/cursos/mecanica.jpg'
    ],
    [
        'id' => 2,
        'nome' => 'Elétrica Automotiva',
        'descricao_curta' => 'Diagnóstico e reparo de sistemas elétricos, de baterias a centrais eletrônicas.',
        'imagem_url' => 'img/cursos/eletrica.jpg'
    ],
    [
        'id' => 3,
        'nome' => 'Pintura e Funilaria',
        'descricao_curta' => 'Técnicas profissionais de reparo de lataria e pintura com acabamento de showroom.',
        'imagem_url' => 'img/cursos/pintura.jpg'
    ],
    [
        'id' => 4,
        'nome' => 'Injeção Eletrônica',
        'descricao_curta' => 'Especialize-se em sistemas de injeção eletrônica e mapeamento de performance.',
        'imagem_url' => 'img/cursos/injecao.jpg'
    ],
    [
        'id' => 5,
        'nome' => 'Preparação de Motores',
        'descricao_curta' => 'Do básico ao avançado em preparação de motores para competição e rua.',
        'imagem_url' => 'img/cursos/performance.jpg'
    ],
    [
        'id' => 6,
        'nome' => 'Estética Automotiva',
        'descricao_curta' => 'Curso completo de polimento, vitrificação e cuidados estéticos automotivos.',
        'imagem_url' => 'img/cursos/detailing.jpg'
    ],
    [
        'id' => 7,
        'nome' => 'Diagnóstico OBD2',
        'descricao_curta' => 'Aprenda a usar scanners para diagnósticos avançados de falhas em tempo real.',
        'imagem_url' => 'img/cursos/obd2.jpg'
    ],
    [
        'id' => 8,
        'nome' => 'Sistemas de Ar Condicionado',
        'descricao_curta' => 'Manutenção completa e reparo de sistemas de climatização automotiva.',
        'imagem_url' => 'img/cursos/arcondicionado.jpg'
    ],
    [
        'id' => 9,
        'nome' => 'Transmissões Automáticas',
        'descricao_curta' => 'Diagnóstico e reparo de câmbios automáticos, automatizados e CVT.',
        'imagem_url' => 'img/cursos/cambio.jpg'
    ],
    [
        'id' => 10,
        'nome' => 'Mecânica de Motocicletas',
        'descricao_curta' => 'Foco em motores, suspensão e elétrica de motocicletas de alta e baixa cilindrada.',
        'imagem_url' => 'img/cursos/moto.jpg'
    ],
    [
        'id' => 11,
        'nome' => 'Gestão de Oficina',
        'descricao_curta' => 'Aprenda a administrar sua oficina, controlar finanças e gerenciar equipes.',
        'imagem_url' => 'img/cursos/gestao.jpg'
    ],
    [
        'id' => 12,
        'nome' => 'Soldagem TIG/MIG',
        'descricao_curta' => 'Técnicas de solda para reparos estruturais, funilaria e customização de chassis.',
        'imagem_url' => 'img/cursos/solda.jpg'
    ],
    [
        'id' => 13,
        'nome' => 'Sistemas de Freios ABS/EBD',
        'descricao_curta' => 'Especialização em diagnóstico e reparo de freios ABS, EBD e controle de tração.',
        'imagem_url' => 'img/cursos/freios.jpg'
    ],
    [
        'id' => 14,
        'nome' => 'Direção Hidráulica e Elétrica',
        'descricao_curta' => 'Manutenção e diagnóstico de sistemas de direção assistida.',
        'imagem_url' => 'img/cursos/direcao.jpg'
    ],
    [
        'id' => 15,
        'nome' => 'Instalação de Som e Acessórios',
        'descricao_curta' => 'Instalação de som, multimídia, alarmes, vidros e travas elétricas.',
        'imagem_url' => 'img/cursos/som.jpg'
    ],
    [
        'id' => 16,
        'nome' => 'Veículos Híbridos e Elétricos',
        'descricao_curta' => 'Manutenção segura e diagnóstico de veículos com alta tensão (EV/HEV).',
        'imagem_url' => 'img/cursos/hibridos.jpg'
    ],
    [
        'id' => 17,
        'nome' => 'Turbo e Supercharger',
        'descricao_curta' => 'Conceitos de sobrealimentação, instalação e acerto de kits turbo e blower.',
        'imagem_url' => 'img/cursos/turbo.jpg'
    ],
    [
        'id' => 18,
        'nome' => 'Reparo de Módulos (ECU)',
        'descricao_curta' => 'Eletrônica embarcada avançada para reparo de centrais de injeção (ECU).',
        'imagem_url' => 'img/cursos/ecu.jpg'
    ],
    [
        'id' => 19,
        'nome' => 'Sistemas de Suspensão',
        'descricao_curta' => 'Setup, manutenção e instalação de suspensões fixas, rosca e a ar.',
        'imagem_url' => 'img/cursos/suspensao.jpg'
    ],
    [
        'id' => 20,
        'nome' => 'Atendimento ao Cliente',
        'descricao_curta' => 'Como criar um atendimento 5 estrelas e fidelizar clientes na sua oficina.',
        'imagem_url' => 'img/cursos/atendimento.jpg'
    ]
];

shuffle($cursos);
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
                <li><a href="#cursos-secao">Cursos</a></li>
                <li><a href="#sobre">Sobre</a></li>
                <li><a href="#">Contato</a></li>
                
                <?php if ($usuario_logado): ?>
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
            <h1 style="font-size: 2rem;">Acelerando o seu Conhecimento Automotivo</h1>
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
                            
                            <button class="btn-inscrever btn-abrir-modal" 
                                    data-curso-id="<?php echo $curso['id']; ?>"
                                    data-curso-nome="<?php echo htmlspecialchars($curso['nome']); ?>" style="cursor: pointer;">
                                Inscrever-se
                            </button>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</section>

<div id="modal-inscricao" class="modal-overlay">
    <div class="modal-content form-wrapper form-inscricao">
        <button class="modal-close"></button>
        
        <h2>Inscrição<br><span id="modal-curso-nome" style="color: rgba(255, 82, 82, 0.7);">Nome do Curso</span></h2>
    
        <form action="backend/processa_inscricao.php" method="post">
            <input type="hidden" name="id_curso" id="modal-curso-id">

            <div class="form-row">
                <div class="form-group full-width">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario_data['nome'] ?? ''); ?>" required placeholder="Digite seu nome:">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario_data['email'] ?? ''); ?>" required placeholder="Digite seu e-mail:">
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($usuario_data['telefone'] ?? ''); ?>" required placeholder="Digite seu número:">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" id="endereco" name="endereco" value="<?php echo htmlspecialchars($usuario_data['endereco'] ?? ''); ?>" placeholder="Digite seu endereço:">
                </div>
                <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" id="cep" name="cep" value="<?php echo htmlspecialchars($usuario_data['cep'] ?? ''); ?>" placeholder="Digite seu CEP:">
                </div>
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($usuario_data['cpf'] ?? ''); ?>" placeholder="Digite seu CPF:">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" value="<?php echo htmlspecialchars($usuario_data['data_nascimento'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="nome_responsavel_1">Nome do Responsável 1</label>
                    <input type="text" id="nome_responsavel_1" name="nome_responsavel_1" value="<?php echo htmlspecialchars($usuario_data['nome_responsavel_1'] ?? ''); ?>" placeholder="Digite o nome do responsável:">
                </div>
                <div class="form-group">
                    <label for="nome_responsavel_2">Nome do Responsável 2</label>
                    <input type="text" id="nome_responsavel_2" name="nome_responsavel_2" value="<?php echo htmlspecialchars($usuario_data['nome_responsavel_2'] ?? ''); ?>" placeholder="Digite o nome do responsável:">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="telefone_responsavel_1">Telefone do Responsável 1</label>
                    <input type="text" id="telefone_responsavel_1" name="telefone_responsavel_1" value="<?php echo htmlspecialchars($usuario_data['telefone_responsavel_1'] ?? ''); ?>" placeholder="Digite o telefone do responsável:">
                </div>
                <div class="form-group">
                    <label for="telefone_responsavel_2">Telefone do Responsável 2</label>
                    <input type="text" id="telefone_responsavel_2" name="telefone_responsavel_2" value="<?php echo htmlspecialchars($usuario_data['telefone_responsavel_2'] ?? ''); ?>" placeholder="Digite o telefone do responsável:">
                </div>
            </div>

            <button type="submit" style="cursor: pointer;">Inscrever-se</button>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script> 
<script>
    document.addEventListener('DOMContentLoaded', () => {
        
        const swiper = new Swiper('.course-carousel', {
            loop: true,
            autoplay: {
                delay: 3000, 
                disableOnInteraction: false, 
                pauseOnMouseEnter: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
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

        const isUserLoggedIn = <?php echo $usuario_logado ? 'true' : 'false'; ?>;
        
        const modal = document.getElementById('modal-inscricao');
        const modalCloseBtn = modal.querySelector('.modal-close');
        const modalCursoNome = document.getElementById('modal-curso-nome');
        const modalCursoIdInput = document.getElementById('modal-curso-id');
        
        const openModalButtons = document.querySelectorAll('.btn-abrir-modal');

        openModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                
                if (!isUserLoggedIn) {
                    window.location.href = 'login.php?erro=Faca login para se inscrever.';
                    return;
                }
                
                const cursoId = this.dataset.cursoId;
                const cursoNome = this.dataset.cursoNome;
                
                modalCursoNome.textContent = cursoNome;
                modalCursoIdInput.value = cursoId;
                
                modal.style.display = 'flex';
            });
        });

        modalCloseBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
        
        const inicioTexto = document.querySelector('.inicio-texto');
        const scrollArrow = document.querySelector('.scroll-down-arrow');
        
        const fadeOutDistance = 400; 

        window.addEventListener('scroll', () => {
            let scrollY = window.scrollY;

            if (scrollY <= fadeOutDistance) {
                let newOpacity = 1 - (scrollY / fadeOutDistance);
                let newTransform = `translateY(${scrollY * -0.5}px)`;

                inicioTexto.style.opacity = newOpacity;
                inicioTexto.style.transform = newTransform;
                
                scrollArrow.style.opacity = newOpacity;
                scrollArrow.style.transform = newTransform;
            } else {
                inicioTexto.style.opacity = 0;
                scrollArrow.style.opacity = 0;
            }
        });

    });
</script>
</body> 
</html>