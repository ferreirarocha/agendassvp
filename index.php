<?php 
require_once 'base.php'; 

if (!$user_logado) { header("Location: admin.php"); exit; }

// Lógica de Registro de Presença (Toggle)
if (isset($_GET['check'])) {
    $ev_id = $_GET['check']; $u_id = $user_logado['id'];
    if (!isset($sistema['presencas'][$ev_id])) $sistema['presencas'][$ev_id] = [];
    if (in_array($u_id, $sistema['presencas'][$ev_id])) {
        $sistema['presencas'][$ev_id] = array_values(array_diff($sistema['presencas'][$ev_id], [$u_id]));
        $marcado = false;
    } else {
        $sistema['presencas'][$ev_id][] = $u_id;
        $marcado = true;
    }
    salvarDados($sistema);
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        header('Content-Type: application/json');
        echo json_encode(['marcado' => $marcado]);
        exit;
    }
    header("Location: index.php"); exit;
}

function exibirCard($id, $ev, $is_vigente = false, $is_passado = false) {
    global $sistema, $user_logado;
    $marcado = (isset($sistema['presencas'][$id]) && in_array($user_logado['id'], $sistema['presencas'][$id]));
    $is_intervalo = (strpos($ev['data'], '-') !== false);
    
    // Lógica do dia da semana (já implementada)
    $partes = explode('/', $ev['data']);
    $dia = $partes[0];
    $mes = $partes[1];
    $ano = isset($partes[2]) ? $partes[2] : date('Y');
    $data_ts = strtotime("$ano-$mes-$dia");
    $dias_trad = ["DOM", "SEG", "TER", "QUA", "QUI", "SEX", "SÁB"];
    $dia_semana = $dias_trad[date('w', $data_ts)];
    ?>

    <div class="card-wrapper <?php echo ($marcado ? 'done-wrapper ' : '') . ($is_vigente ? 'vigente-wrapper' : ''); ?>"
         style="<?php echo $is_passado ? 'opacity:0.6; filter:grayscale(0.5);' : ''; ?>">
        <div class="card <?php echo ($is_vigente ? 'card-vigente ' : '') . ($marcado ? 'done' : ''); ?>">

            <div class="card-top-row">
                <!-- Data -->
                <div class="date-box">
                    <span class="date-day"><?php echo $dia; ?></span>
                    <small style="font-weight: 700; color: #64748b; font-size: 0.68rem; line-height:1.2;"><?php echo $mes; ?></small>
                    <small style="font-weight: 900; color: #1e3a8a; font-size: 0.65rem;"><?php echo $dia_semana; ?></small>
                </div>

                <!-- Divisor vertical -->
                <div class="date-divider"></div>

                <!-- Título -->
                <div class="header-card">
                    <?php if($is_vigente): ?>
                        <img src="https://ccej.mailsfera.com.br/img/image769.png" class="img-vigente" alt="Em Vigor">
                    <?php endif; ?>
                    <div class="title"><?php echo htmlspecialchars($ev['titulo']); ?></div>
                </div>

                <!-- Checkbox -->
                <div class="check-container-top">

<button class="check-btn <?php echo $marcado ? 'checked' : ''; ?>" 
        onclick="toggleCheck(this, <?php echo $id; ?>)">✓</button>


                </div>
            </div>

            <div class="info-area">
                <?php if($is_intervalo): ?>
<div class="tag-intervalo">🗓️ <?php echo $ev['data']; ?></div>
                <?php endif; ?>
                <div class="desc"><?php echo $ev['desc']; ?></div>
            </div>

        </div>
    </div>
    <?php
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Agenda Vicentina - CCEJ</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Agenda CCEJ">
    <link rel="icon" type="image/webp" href="https://ccej.mailsfera.com.br/img/logo.webp">
    <link rel="apple-touch-icon" href="https://ccej.mailsfera.com.br/img/logo.webp">
    <meta name="theme-color" content="#1e3a8a">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />    

    <!-- CSS crítico inline: garante splash azul ANTES de qualquer arquivo externo -->
    <style>
        body { margin:0; background: #1e3a8a; }
        #splash {
            position: fixed;
            inset: 0;
            background: #1e3a8a;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.6s ease;
        }
        #splash.hide { opacity: 0; pointer-events: none; }
        .splash-ring-wrapper {
            position: relative;
            width: 130px;
            height: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #splash-logo { width: 80px; height: 80px; object-fit: contain; }
        .splash-ring {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 4px solid rgba(255,255,255,0.15);
            border-top-color: #f59f00;
            border-right-color: #f59f00;
            animation: spinRing 1.2s linear infinite;
        }
        @keyframes spinRing { to { transform: rotate(360deg); } }
    </style>

    <!-- CSS externo depois do inline -->
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    
<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js');
    }
</script>

</head>
<body>
<div id="splash">
    <div class="splash-ring-wrapper">
        <div class="splash-ring"></div>
        <img src="https://ccej.mailsfera.com.br/img/logo.webp" id="splash-logo" alt="Logo">
    </div>
</div>


<?php include 'menu.php'; ?>

<div class="container main-content">
    
    <?php if(!empty($sistema['mural'])): ?>
        <div class="news-box">
            <strong style="font-size: 0.75rem; text-transform: uppercase;">📢 Mural</strong>
            <p style="margin: 8px 0 0 0; font-weight: 700;"><?php echo nl2br(htmlspecialchars($sistema['mural'])); ?></p>
        </div>
    <?php endif; ?>






<?php
    $hoje = date('Y-m-d');
    $noticias_ativas = array_filter($sistema['noticias'] ?? [], function($n) use ($hoje) {
        return (isset($n['expira']) && $n['expira'] >= $hoje);
    });
    $total_noticias = count($noticias_ativas);
    ?>

    <?php if ($total_noticias > 0): ?>
    <details class="noticias-container">
        <summary>
            <div style="display: flex; justify-content: space-between; width: 100%; align-items: center; padding-right: 10px;">
                <span>📢 NOTÍCIAS CONSELHO CENTRAL</span>
                <span class="badge-noticias"><?php echo $total_noticias; ?></span>
            </div>
        </summary>
        <div class="noticias-content">
            <?php foreach ($noticias_ativas as $noticia): ?>
                <div class="noticia-item">
                    <strong style="color: var(--primary); display: block; margin-bottom: 5px;">
                        <?php echo htmlspecialchars($noticia['titulo']); ?>
                    </strong>
                    <small style="color: #94a3b8; font-size: 0.85rem; display: block; margin-top: 10px; font-weight: 700;">
                        📌 Data: <?php echo date('d/m', strtotime($noticia['expira'])); ?>
                    </small>                    
                    <div class="desc" style="margin: 0;">
                        <?php 
                            // Aqui também, tiramos o htmlspecialchars para o HTML do Quill funcionar
                            echo $noticia['texto']; 
                        ?>
                    </div>
        

                </div>
            <?php endforeach; ?>
        </div>
    </details>
    <?php endif; ?>
    
    
    

<?php 
    $hoje_dia = (int)date('d');
    $mes_atual = (int)date('m');
    $niver_futuros = [];

    foreach(($sistema['aniversariantes'] ?? []) as $n) {
        $p = explode('/', $n['data']);
        $dia_n = (int)$p[0];
        $mes_n = isset($p[1]) ? (int)$p[1] : 0;
        if ($mes_n === $mes_atual && $dia_n >= $hoje_dia) {
            $niver_futuros[] = $n;
        }
    }

    if (!empty($niver_futuros)): 
        $total_niver = count($niver_futuros);
    ?>
        <details class="aniversariantes-container" style="border-left: 36px solid #1e3a8a;">
            <summary>
                <div style="display: flex; justify-content: space-between; width: 100%; align-items: center; padding-right: 10px;">
                    <span style="color: #1e3a8a; font-weight: 800;">🎂 ANIVERSARIANTES PRÓXIMOS</span>
                    <span class="badge-niver"><?php echo $total_niver; ?></span>
                </div>
            </summary>
            
            <div class="aniversariantes-content">
                <?php foreach($niver_futuros as $n): ?>
                    <div class="noticia-item" style="border-top: 1px solid #fff1f2; padding: 12px 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <strong style="color: #475569; font-size: 0.9rem;">
                                <?php echo encurtarNome($n['nome']); ?>
                            </strong>
                            <span class="tag-date" style="background:#fce7f3; color:var(--pink); margin:0;">
                                <?php echo $n['data']; ?>
                            </span>
                        </div>
                        <?php if(!empty($n['conferencia'])): ?>
                            <div style="font-size: 0.7rem; color: #94a3b8; margin-top: 3px; font-weight: 600;">
                                📍 <?php echo htmlspecialchars($n['conferencia']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </details>
    <?php endif; ?>

    <h4 style="color: var(--primary); margin: 30px 0 15px 5px; font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase; font-weight: 900;">Atividades</h4>
    
    <?php 
    $hoje_time = strtotime(date('Y-m-d'));
    $id_vigente = null; 
    $data_vigente = 0; 
    $futuros = []; 
    $passados = [];

    // 1. Processamento e Separação
    foreach ($sistema['eventos'] as $id => $ev) {
        if (isset($ev['arquivado']) && $ev['arquivado']) continue;

        // Converte a data para timestamp para ordenação
        $data_base = (strpos($ev['data'], '-') !== false) ? trim(explode('-', $ev['data'])[0]) : $ev['data'];
        $p = explode('/', $data_base);
        // Garante formato Y-m-d para o strtotime
        $dt_formatada = date('Y').'-'.($p[1]??'01').'-'.($p[0]??'01');
        $timestamp = strtotime($dt_formatada);

        // Identifica a Privilegiada em vigor (mais recente)
        if (stripos($ev['titulo'], 'Privilegiada') !== false) {
            if ($timestamp > $data_vigente) { 
                $data_vigente = $timestamp; 
                $id_vigente = $id; 
            }
        }

        // Adiciona aos arrays com o timestamp para ordenar depois
        if ($timestamp >= $hoje_time) {
            $futuros[$id] = ['dados' => $ev, 'time' => $timestamp];
        } else {
            $passados[$id] = ['dados' => $ev, 'time' => $timestamp];
        }
    }

    // 2. Ordenação Cronológica
    // Futuros: Ordem Crescente (do dia 01 para o 31)
    uasort($futuros, function($a, $b) { return $a['time'] <=> $b['time']; });
    // Passados: Ordem Decrescente (mais recente no topo do histórico)
    uasort($passados, function($a, $b) { return $b['time'] <=> $a['time']; });

    // 3. Exibição
    // Destaque Vigente
    if ($id_vigente !== null) {
        exibirCard($id_vigente, $sistema['eventos'][$id_vigente], true);
        unset($futuros[$id_vigente]); // Remove do loop futuro para não repetir
    }

    // Lista Cronológica de Futuros
    foreach($futuros as $id => $item) {
        exibirCard($id, $item['dados']);
    }

    // Histórico
    if (!empty($passados)): ?>
        <details style="margin-top: 30px; background: #e2e8f0; border: none;">
            <summary style="color: #64748b; text-align: center;">📁 Histórico de Atividades</summary>
            <div style="padding: 10px;">
                <?php foreach($passados as $id => $item) exibirCard($id, $item['dados'], false, true); ?>
            </div>
        </details>
    <?php endif; ?>

    <?php if ($user_logado['nivel'] == 'admin'): ?>
        <div style="text-align: center; margin-top: 40px; padding-bottom: 20px;">
            <a href="admin.php" style="text-decoration: none; font-weight: 800; color: var(--primary); font-size: 0.7rem; border: 2px solid var(--primary); padding: 10px 20px; border-radius: 12px;">⚙️ GESTÃO</a>
        </div>
    <?php endif; ?>
</div>

<div id="modalInfo" class="modal-overlay" onclick="fecharModal(event)">
    <div class="modal-card" onclick="event.stopPropagation()">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px;">
            <strong style="color: var(--primary);">📍 Locais e Horários</strong>
            <button onclick="fecharModal(event)" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--danger); font-weight: 900;">&times;</button>
        </div>
        
        <div style="max-height: 70vh; overflow-y: auto;">
            <?php 
            if(!empty($sistema['locais'])): 
                $linhas = explode("\n", $sistema['locais']);
                foreach($linhas as $linha): 
                    if(trim($linha) == "") continue;
            ?>
                <div class="modal-item">
                    <p style="font-size: 0.85rem; color: #1e293b; font-weight: 600;">
                        <?php echo nl2br(str_replace(' - ', '<br><span style="color:#64748b; font-weight:400; font-size:0.75rem;">▼ ', htmlspecialchars($linha))); ?></span>
                    </p>
                </div>
            <?php 
                endforeach;
            else: 
                echo "<p style='text-align:center; color:#94a3b8;'>Nenhum local cadastrado.</p>";
            endif; 
            ?>
        </div>

        <button onclick="fecharModal(event)" class="btn-adm" style="background: var(--primary); margin-top: 15px;">FECHAR</button>
    </div>
</div>

<script>
function abrirModal() { document.getElementById('modalInfo').style.display = 'flex'; }
function fecharModal(e) { document.getElementById('modalInfo').style.display = 'none'; }

function toggleCheck(btn, id) {
    fetch('index.php?check=' + id, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        const card = btn.closest('.card');
        if (data.marcado) {
            btn.classList.add('checked');
            card.classList.add('done');
        } else {
            btn.classList.remove('checked');
            card.classList.remove('done');
        }
    });
}
</script>

<script>
// Splash
window.addEventListener('load', () => {
    const splash = document.getElementById('splash');
    if (!splash) return;
    if (window.innerWidth > 768) { splash.remove(); return; }
    setTimeout(() => {
        splash.classList.add('hide');
        setTimeout(() => splash.remove(), 600);
    }, 2000);
});

// Salva snapshot apenas quando online
if (navigator.onLine) {
    localStorage.setItem('agenda_snapshot', document.documentElement.outerHTML);
    localStorage.setItem('agenda_usuario', '<?php echo addslashes(encurtarNome($user_logado['nome'])); ?>');
}

// Aviso offline — só mostra se NÃO tiver snapshot E não for o próprio snapshot rodando
window.addEventListener('offline', () => {
    const aviso = document.createElement('div');
    aviso.id = 'aviso-offline';
    aviso.innerHTML = '📵 Sem internet — exibindo última versão salva';
    aviso.style.cssText = 'position:fixed;bottom:0;left:0;right:0;background:#f59f00;color:#1e3a8a;text-align:center;padding:10px;font-weight:800;font-size:0.8rem;z-index:9998;';
    document.body.appendChild(aviso);
});

window.addEventListener('online', () => {
    const aviso = document.getElementById('aviso-offline');
    if (aviso) aviso.remove();
});
</script>
</body>
</html>