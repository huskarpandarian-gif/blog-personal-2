<?php
declare(strict_types=1);

$secciones = [
    'inicio' => ['titulo' => 'Inicio', 'archivo' => null],
    'sobre-mi' => ['titulo' => 'Sobre mí', 'archivo' => __DIR__ . '/secciones/sobre-mi.php'],
    'estudios' => ['titulo' => 'Estudios', 'archivo' => __DIR__ . '/secciones/estudios.php'],
    'experiencia' => ['titulo' => 'Experiencia', 'archivo' => __DIR__ . '/secciones/experiencia.php'],
    'contacto' => ['titulo' => 'Contacto', 'archivo' => __DIR__ . '/secciones/contacto.php'],
];

$actual = $_GET['seccion'] ?? 'inicio';
if (!isset($secciones[$actual])) {
    http_response_code(404);
    $actual = 'inicio';
}
$titulo = $secciones[$actual]['titulo'];

function e(string $valor): string {
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

function enlace(string $slug, string $texto, string $actual): string {
    $clase = $slug === $actual ? 'nav-link active' : 'nav-link';
    return '<a class="' . $clase . '" href="/' . e($slug === 'inicio' ? '' : '?seccion=' . $slug) . '">' . e($texto) . '</a>';
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Blog personal, formación y experiencia profesional.">
    <title><?= e($titulo) ?> | Mi espacio personal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#f5f7fb;--ink:#172033;--muted:#68738a;--line:#e7ebf2;--blue:#4169e1;--blue2:#2949b8;--card:#fff}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:var(--bg);color:var(--ink);font-family:"DM Sans",sans-serif;line-height:1.65}
        a{color:inherit;text-decoration:none}.shell{max-width:1120px;margin:auto;padding:28px 24px 56px}
        .topbar{display:flex;justify-content:space-between;align-items:center;gap:20px;margin-bottom:28px}
        .brand{font-family:Manrope,sans-serif;font-weight:800;letter-spacing:-.6px;font-size:20px}.brand span{color:var(--blue)}
        .status{font-size:12px;color:#25815d;background:#e8f7ef;border:1px solid #d1efdf;border-radius:30px;padding:7px 12px;font-weight:700}
        .layout{display:grid;grid-template-columns:290px 1fr;gap:24px;align-items:start}
        .profile,.content-card{background:var(--card);border:1px solid var(--line);border-radius:22px;box-shadow:0 12px 35px rgba(24,39,75,.045)}
        .profile{padding:26px;position:sticky;top:20px}
        .photo-wrap{width:112px;height:112px;border-radius:28px;background:linear-gradient(135deg,#dbe6ff,#edf1ff);display:grid;place-items:center;overflow:hidden;margin-bottom:20px;border:4px solid #f4f6ff}
        .photo-wrap img{width:100%;height:100%;object-fit:cover}.photo-placeholder{font:800 34px Manrope;color:var(--blue)}
        .eyebrow{font-size:11px;letter-spacing:1.7px;text-transform:uppercase;color:var(--blue);font-weight:800}
        h1,h2,h3{font-family:Manrope,sans-serif;line-height:1.2;letter-spacing:-.7px}h1{font-size:29px;margin:8px 0 5px}h2{font-size:30px;margin:8px 0 14px}h3{font-size:17px;margin:0 0 7px}
        .role{color:var(--muted);font-size:14px;margin:0 0 18px}.bio{font-size:13px;color:var(--muted);margin:0 0 22px}
        .nav{display:grid;gap:7px;margin-top:20px}.nav-link{padding:10px 12px;border-radius:11px;color:#59647a;font-size:14px;font-weight:600;transition:.2s}
        .nav-link:hover,.nav-link.active{background:#eef2ff;color:var(--blue2)}
        .profile-foot{border-top:1px solid var(--line);margin-top:22px;padding-top:16px;color:#8a93a5;font-size:11px}
        .content-card{padding:38px;min-height:600px}.hero{padding:22px 0 30px}.hero h2{font-size:clamp(32px,5vw,48px);max-width:680px}
        .hero h2 span{color:var(--blue)}.lead{font-size:16px;color:var(--muted);max-width:650px}
        .actions{display:flex;flex-wrap:wrap;gap:10px;margin-top:24px}.btn{display:inline-flex;align-items:center;gap:8px;padding:11px 17px;border-radius:11px;background:var(--blue);color:white;font-size:13px;font-weight:700}.btn.secondary{background:#f0f3fa;color:#35415b}
        .section-head{margin-bottom:24px}.section-head p{color:var(--muted);max-width:680px}
        .grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;margin-top:24px}
        .info-card{border:1px solid var(--line);border-radius:16px;padding:19px;background:#fff}.icon{width:38px;height:38px;border-radius:12px;background:#eef2ff;color:var(--blue);display:grid;place-items:center;font-size:18px;margin-bottom:13px}
        .info-card p{color:var(--muted);font-size:13px;margin:0}.tag{display:inline-block;margin-top:12px;background:#f1f4fa;color:#536079;padding:5px 9px;border-radius:30px;font-size:11px;font-weight:700}
        .timeline{border-left:2px solid #e4eaff;margin:24px 0 0 9px;padding-left:23px;display:grid;gap:24px}.timeline-item{position:relative}.timeline-item:before{content:"";position:absolute;left:-30px;top:5px;width:12px;height:12px;border-radius:50%;background:var(--blue);box-shadow:0 0 0 5px #eef2ff}.date{font-size:11px;color:var(--blue);font-weight:800;letter-spacing:1px;text-transform:uppercase}
        .contact-list{display:grid;gap:12px;margin-top:22px}.contact-item{padding:15px;border:1px solid var(--line);border-radius:13px;color:#536079}
        footer{text-align:center;color:#929bad;font-size:12px;padding:24px 0 0}
        @media(max-width:800px){.layout{grid-template-columns:1fr}.profile{position:static}.content-card{padding:26px}.topbar{align-items:flex-start}.grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="shell">
    <header class="topbar">
        <a class="brand" href="/">MI<span>.</span>ESPACIO</a>
        <span class="status">● Disponible para aprender y colaborar</span>
    </header>
    <div class="layout">
        <aside class="profile">
            <div class="photo-wrap">
                <img src="/assets/foto-perfil.jpg" alt="Fotografía de perfil" onerror="this.style.display='none'">
                <span class="photo-placeholder">PT</span>
            </div>
            <div class="eyebrow">Blog personal</div>
            <h1>Domínguez Alba Carlos Daniel</h1>
            <p class="role">Profesional en formación · Tecnología y gestión pública</p>
            <p class="bio">Un espacio para compartir mi formación, experiencias, proyectos y el camino que sigo construyendo en el mundo de la tecnología.</p>
            <nav class="nav" aria-label="Navegación principal">
                <?= enlace('inicio', '⌂　 Inicio', $actual) ?>
                <?= enlace('sobre-mi', '✦　 Sobre mí', $actual) ?>
                <?= enlace('estudios', '▤　 Estudios', $actual) ?>
                <?= enlace('experiencia', '▣　 Experiencia', $actual) ?>
                <?= enlace('contacto', '✉　 Contacto', $actual) ?>
            </nav>
            <div class="profile-foot">Universidad Nacional del Santa · UGEL Santa</div>
        </aside>
        <main class="content-card">
            <?php if ($actual === 'inicio'): ?>
                <section class="hero">
                    <div class="eyebrow">Bienvenido a mi espacio</div>
                    <h2>Aprender, crear y <span>seguir creciendo.</span></h2>
                    <p class="lead">Soy una persona interesada en la tecnología, el desarrollo de software y la mejora de procesos. Aquí comparto un poco de mi historia académica y experiencia.</p>
                    <div class="actions">
                        <a class="btn" href="/?seccion=sobre-mi">Conóceme mejor <span>→</span></a>
                        <a class="btn secondary" href="/?seccion=contacto">Ponte en contacto</a>
                    </div>
                </section>
                <div class="eyebrow">Un poco sobre mi recorrido</div>
                <div class="grid">
                    <article class="info-card"><div class="icon">🎓</div><h3>Formación</h3><p>Estudios universitarios en la Universidad Nacional del Santa, con interés en seguir fortaleciendo mis conocimientos.</p><span class="tag">Universidad Nacional del Santa</span></article>
                    <article class="info-card"><div class="icon">🏢</div><h3>Experiencia</h3><p>Experiencia de prácticas y labores vinculadas al entorno administrativo de la UGEL Santa.</p><span class="tag">UGEL Santa</span></article>
                    <article class="info-card"><div class="icon">💻</div><h3>Tecnología</h3><p>Interés en programación, desarrollo web, bases de datos, servicios cloud y soluciones digitales.</p><span class="tag">Desarrollo de software</span></article>
                    <article class="info-card"><div class="icon">🚀</div><h3>Mi objetivo</h3><p>Convertir ideas en proyectos útiles, aprender constantemente y aportar valor a través de la tecnología.</p><span class="tag">Aprendizaje continuo</span></article>
                </div>
            <?php elseif ($secciones[$actual]['archivo']): ?>
                <?php require $secciones[$actual]['archivo']; ?>
            <?php endif; ?>
        </main>
    </div>
    <footer>© <?= date('Y') ?> · Mi espacio personal · Hecho con dedicación</footer>
</div>
</body>
</html>
