<?php 
require_once 'base.php'; 

// --- 1. GESTÃO DE ACESSO E LOGOUT ---
if (isset($_GET['sair'])) {
    session_destroy();
    setcookie('remember_login', '', time() - 3600, '/');
    setcookie('remember_senha', '', time() - 3600, '/');
    header("Location: admin.php");
    exit;
}

// Restaura sessão a partir do cookie "lembrar" e renova por mais 30 dias
if (!$user_logado && isset($_COOKIE['remember_login'], $_COOKIE['remember_senha'])) {
    foreach ($sistema['usuarios'] as $user) {
        if (strtolower($user['login']) === $_COOKIE['remember_login'] && $user['senha'] === $_COOKIE['remember_senha']) {
            $_SESSION['usuario'] = $user;
            $user_logado = $user;
            // Renova o prazo a cada acesso
            $duracao = time() + (30 * 24 * 60 * 60);
            setcookie('remember_login', strtolower($user['login']), $duracao, '/');
            setcookie('remember_senha', $user['senha'], $duracao, '/');
            break;
        }
    }
}

if (isset($_POST['logar'])) {
    $u = strtolower(trim($_POST['user']));
    $p = $_POST['pass'];
    foreach ($sistema['usuarios'] as $user) {
        if (strtolower($user['login']) === $u && $user['senha'] === $p) {
            $_SESSION['usuario'] = $user;
            // Salva cookie por 30 dias se "lembrar" marcado
            if (isset($_POST['lembrar'])) {
                $duracao = time() + (30 * 24 * 60 * 60);
                setcookie('remember_login', strtolower($user['login']), $duracao, '/');
                setcookie('remember_senha', $user['senha'], $duracao, '/');
            }
            header("Location: admin.php");
            exit;
        }
    }
    $erro = "Acesso negado!";
}

if (!$user_logado): ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Login - Agenda Vicentina</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Agenda CCEJ">
    
    <link rel="icon" type="image/webp" href="https://ccej.mailsfera.com.br/img/logo.webp">
    
    <link rel="apple-touch-icon" href="https://ccej.mailsfera.com.br/img/logo.webp">
    
    <meta name="theme-color" content="#1e3a8a">    
    </head>
<body style="background:var(--primary); display:flex; align-items:center; justify-content:center; min-height:100vh; margin:0;">
    <div class="admin-box" style="width:90%; max-width:350px; text-align:center;">
        <img src="https://ccej.mailsfera.com.br/img/logo.webp" style="width:100px; margin-bottom:10px;">
        
        <div style="margin-bottom: 25px;">
            <h2 style="color: var(--primary); margin: 0; font-size: 1.2rem; font-weight: 800; text-transform: uppercase;">Agenda Vicentina</h2>
            <p style="color: #64748b; margin: 5px 0 0; font-size: 0.85rem; font-weight: 600;">Conf. Coração Eucarístico de Jesus</p>
        </div>

        <form method="POST">
            <input type="text" name="user" placeholder="Usuário" required autofocus 
            style="text-transform: lowercase;" oninput="this.value = this.value.toLowerCase()">
            <input type="password" name="pass" placeholder="Senha" required>
            <label style="display:flex; align-items:center; gap:8px; color:#64748b; font-size:0.85rem; font-weight:600; margin-bottom:14px; cursor:pointer;">
                <input type="checkbox" name="lembrar" style="width:18px; height:18px; margin:0; cursor:pointer;">
                Lembrar de mim por 30 dias
            </label>
            <button type="submit" name="logar" class="btn-adm btn-ev">ENTRAR</button>
        </form>
        <?php if(isset($erro)) echo "<p style='color:var(--danger); font-weight:bold; margin-top:10px;'>$erro</p>"; ?>
    </div>
</body>
<?php exit; endif; 

if ($user_logado['nivel'] !== 'admin') { header("Location: index.php"); exit; }

// --- 2. PROCESSAMENTO DE DADOS (CRUD COMPLETO) ---

// MURAL
if (isset($_POST['salvar_mural'])) {
    $sistema['mural'] = $_POST['mural_texto'];
    salvarDados($sistema); header("Location: admin.php"); exit;
}

// LOCAIS E HORÁRIOS
if (isset($_POST['salvar_locais'])) {
    $sistema['locais'] = $_POST['locais_texto'];
    salvarDados($sistema); header("Location: admin.php"); exit;
}

// NOTÍCIAS CENTRAL
if (isset($_POST['salvar_noticia'])) {
    $id_not = $_POST['not_id'];
    $dados_noticia = [
        'id' => ($id_not !== "") ? (int)$id_not : time(),
        'titulo' => $_POST['not_titulo'],
        'texto' => $_POST['not_texto'],
        'expira' => $_POST['not_expira']
    ];
    if ($id_not !== "") {
        foreach ($sistema['noticias'] as $key => $n) { if ($n['id'] == $id_not) { $sistema['noticias'][$key] = $dados_noticia; break; } }
    } else { $sistema['noticias'][] = $dados_noticia; }
    salvarDados($sistema); header("Location: admin.php"); exit;
}

// ATIVIDADES
if (isset($_POST['salvar_ev'])) {
    $id = $_POST['ev_id'];
    $titulo = $_POST['titulo'];
    $nova_atv = ['data' => $_POST['data'], 'titulo' => $titulo, 'desc' => $_POST['desc'], 'arquivado' => false];
    if (stripos($titulo, 'Privilegiada') !== false) {
        foreach($sistema['eventos'] as $idx => $e) { if (stripos($e['titulo'], 'Privilegiada') !== false) { $sistema['eventos'][$idx]['arquivado'] = true; } }
    }
    if ($id !== "") { $sistema['eventos'][$id] = $nova_atv; } else { $sistema['eventos'][] = $nova_atv; }
    salvarDados($sistema); header("Location: admin.php"); exit;
}

// ANIVERSARIANTES
if (isset($_POST['salvar_niver'])) {
    $id_n = $_POST['n_id'];
    $niver = ['data' => $_POST['n_data'], 'nome' => $_POST['n_nome'], 'conferencia' => $_POST['n_conf']];
    if ($id_n !== "") { $sistema['aniversariantes'][$id_n] = $niver; } else { $sistema['aniversariantes'][] = $niver; }
    salvarDados($sistema); header("Location: admin.php"); exit;
}

// USUÁRIOS
if (isset($_POST['salvar_user'])) {
    $id_u = $_POST['u_id'];
    $novo_u = [
        'id' => ($id_u !== "") ? (int)$sistema['usuarios'][$id_u]['id'] : time(),
        'nome' => $_POST['u_nome'],
        'login' => strtolower(trim($_POST['u_login'])), 
        'senha' => $_POST['u_senha'],
        'nivel' => $_POST['u_nivel']
    ];
    if ($id_u !== "") { $sistema['usuarios'][$id_u] = $novo_u; } else { $sistema['usuarios'][] = $novo_u; }
    salvarDados($sistema); header("Location: admin.php"); exit;
}

// EXCLUSÕES
if (isset($_GET['excluir_ev'])) { unset($sistema['eventos'][$_GET['excluir_ev']]); $sistema['eventos'] = array_values($sistema['eventos']); salvarDados($sistema); header("Location: admin.php"); exit; }
if (isset($_GET['excluir_niver'])) { unset($sistema['aniversariantes'][$_GET['excluir_niver']]); $sistema['aniversariantes'] = array_values($sistema['aniversariantes']); salvarDados($sistema); header("Location: admin.php"); exit; }
if (isset($_GET['del_noticia'])) {
    $id_del = $_GET['del_noticia'];
    foreach ($sistema['noticias'] as $key => $n) { if ($n['id'] == $id_del) { unset($sistema['noticias'][$key]); break; } }
    $sistema['noticias'] = array_values($sistema['noticias']); salvarDados($sistema); header("Location: admin.php"); exit;
}
if (isset($_GET['excluir_user'])) { if(count($sistema['usuarios']) > 1) { unset($sistema['usuarios'][$_GET['excluir_user']]); $sistema['usuarios'] = array_values($sistema['usuarios']); salvarDados($sistema); } header("Location: admin.php"); exit; }
if (isset($_GET['arquivar_ev'])) { $sistema['eventos'][$_GET['arquivar_ev']]['arquivado'] = true; salvarDados($sistema); header("Location: admin.php"); exit; }

// VARIÁVEIS DE EDIÇÃO
$edit_ev = isset($_GET['edit_ev']) ? $sistema['eventos'][$_GET['edit_ev']] : null;
$edit_niver = isset($_GET['edit_niver']) ? $sistema['aniversariantes'][$_GET['edit_niver']] : null;
$edit_u = isset($_GET['edit_user']) ? $sistema['usuarios'][$_GET['edit_user']] : null;
$edit_not = null;
if (isset($_GET['edit_noticia'])) { foreach ($sistema['noticias'] as $n) { if ($n['id'] == $_GET['edit_noticia']) { $edit_not = $n; break; } } }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <title>Painel Gestão - Agenda Vicentina</title>
    <style>
        .ql-container { font-family: 'Inter', sans-serif; font-size: 16px; height: 150px; background: white; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; }
        .ql-toolbar { background: #f8fafc; border-top-left-radius: 8px; border-top-right-radius: 8px; }
        .editor-label { font-size: 0.75rem; font-weight: 800; color: var(--primary); margin: 10px 0 5px 0; display: block; }
    </style>
</head>
<body class="admin-body">

<header>
    <div class="header-content">
        <strong>PAINEL DE GESTÃO</strong>
        <a href="index.php" style="color:white; text-decoration:none; font-size:0.7rem; border:1px solid white; padding:5px 10px; border-radius:8px;">VOLTAR</a>
    </div>
</header>

<main class="main-content container">
    <div class="tabs-nav">
        <button class="tab-btn active" onclick="openTab(event, 'aba-atividades')">📅 ATIVIDADES</button>
        <button class="tab-btn" onclick="openTab(event, 'aba-noticias')">📢 NOTÍCIAS CENTRAL</button>
        <button class="tab-btn" onclick="openTab(event, 'aba-niver')">🎂 ANIVERSÁRIOS</button>
        <button class="tab-btn" onclick="openTab(event, 'aba-usuarios')">👥 USUÁRIOS</button>
        <button class="tab-btn" onclick="openTab(event, 'aba-mural')">📢 MURAL</button>
        <button class="tab-btn" onclick="openTab(event, 'aba-locais')">📍 LOCAIS</button>        
    </div>

    <div id="aba-atividades" class="tab-content active">
        <div class="admin-box" style="border-top: 4px solid var(--primary);">
            <h3>📅 Gestão de Atividades</h3>
            <form method="POST" onsubmit="syncQuill('atv')">
                <input type="hidden" name="ev_id" value="<?php echo $_GET['edit_ev'] ?? ''; ?>">
                <input type="text" name="data" placeholder="Data (Ex: 26/04)" value="<?php echo $edit_ev['data'] ?? ''; ?>" required>
                <input type="text" name="titulo" placeholder="Título" value="<?php echo $edit_ev['titulo'] ?? ''; ?>" required>
                <label class="editor-label">DESCRIÇÃO/LOCAL:</label>
                <div id="editor-atv"><?php echo $edit_ev['desc'] ?? ''; ?></div>
                <input type="hidden" name="desc" id="input-atv">
                <button type="submit" name="salvar_ev" class="btn-adm btn-ev">SALVAR ATIVIDADE</button>
            </form>
            <div class="admin-list">
                <?php foreach($sistema['eventos'] as $id => $ev): if(!($ev['arquivado'] ?? false)): ?>
                    <div class="admin-item">
                        <div class="info"><span class="tag-date"><?php echo $ev['data']; ?></span> <strong><?php echo $ev['titulo']; ?></strong></div>
                        <div class="actions">
                            <a href="admin.php?edit_ev=<?php echo $id; ?>" class="btn-alt">ALT</a>
                            <a href="admin.php?arquivar_ev=<?php echo $id; ?>" class="btn-del" style="background:#fff7ed; color:#c2410c;">ARQ</a>
                        </div>
                    </div>
                <?php endif; endforeach; ?>
            </div>
        </div>
    </div>

    <div id="aba-noticias" class="tab-content">
        <div class="admin-box" style="border-top: 4px solid var(--primary);">
            <h3>📢 <?php echo $edit_not ? 'Editar Notícia' : 'Nova Notícia do Central'; ?></h3>
            <form method="POST" onsubmit="syncQuill('not')">
                <input type="hidden" name="not_id" value="<?php echo $edit_not['id'] ?? ''; ?>">
                <input type="text" name="not_titulo" placeholder="Título" value="<?php echo $edit_not['titulo'] ?? ''; ?>" required>
                <label class="editor-label">CONTEÚDO DA NOTÍCIA:</label>
                <div id="editor-not"><?php echo $edit_not['texto'] ?? ''; ?></div>
                <input type="hidden" name="not_texto" id="input-not">
                <label class="editor-label">EXIBIR ATÉ:</label>
                <input type="date" name="not_expira" value="<?php echo $edit_not['expira'] ?? ''; ?>" required>
                <button type="submit" name="salvar_noticia" class="btn-adm btn-ev"><?php echo $edit_not ? 'ATUALIZAR' : 'PUBLICAR'; ?></button>
                <?php if($edit_not): ?> <a href="admin.php" class="btn-alt" style="display:block; text-align:center; margin-top:5px;">CANCELAR</a> <?php endif; ?>
            </form>
            <div class="admin-list">
                <?php foreach ($sistema['noticias'] as $n): ?>
                    <div class="admin-item">
                        <div class="info"><span class="tag-date"><?php echo date('d/m', strtotime($n['expira'])); ?></span> <strong><?php echo htmlspecialchars($n['titulo']); ?></strong></div>
                        <div class="actions"><a href="admin.php?edit_noticia=<?php echo $n['id']; ?>" class="btn-alt">ALT</a> <a href="admin.php?del_noticia=<?php echo $n['id']; ?>" class="btn-del" onclick="return confirm('Excluir?')">X</a></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div id="aba-niver" class="tab-content">
        <div class="admin-box" style="border-top: 4px solid var(--pink);">
            <h3>🎂 Gestão de Aniversariantes</h3>
            <form method="POST">
                <input type="hidden" name="n_id" value="<?php echo $_GET['edit_niver'] ?? ''; ?>">
                <div style="display:flex; gap:10px;">
                    <input type="text" name="n_data" placeholder="DD/MM" style="width:100px" value="<?php echo $edit_niver['data'] ?? ''; ?>" required>
                    <input type="text" name="n_nome" placeholder="Nome" value="<?php echo $edit_niver['nome'] ?? ''; ?>" required>
                </div>
                <input type="text" name="n_conf" placeholder="Conferência" value="<?php echo $edit_niver['conferencia'] ?? ''; ?>">
                <button type="submit" name="salvar_niver" class="btn-adm" style="background:var(--pink)">SALVAR</button>
            </form>
            <div class="admin-list"><?php foreach($sistema['aniversariantes'] as $id => $n): ?><div class="admin-item"><div class="info"><span class="tag-date" style="background:#fce7f3; color:var(--pink)"><?php echo $n['data']; ?></span> <strong><?php echo encurtarNome($n['nome']); ?></strong></div><div class="actions"><a href="admin.php?edit_niver=<?php echo $id; ?>" class="btn-alt">ALT</a><a href="admin.php?excluir_niver=<?php echo $id; ?>" class="btn-del">X</a></div></div><?php endforeach; ?></div>
        </div>
    </div>

    <div id="aba-usuarios" class="tab-content">
        <div class="admin-box" style="border-top: 4px solid #4ade80;">
            <h3>👥 Gestão de Usuários</h3>
            <form method="POST">
                <input type="hidden" name="u_id" value="<?php echo $_GET['edit_user'] ?? ''; ?>">
                <input type="text" name="u_nome" placeholder="Nome Completo" value="<?php echo $edit_u['nome'] ?? ''; ?>" required>
                <div style="display:flex; gap:10px;"><input type="text" name="u_login" placeholder="Login" value="<?php echo $edit_u['login'] ?? ''; ?>" required><input type="text" name="u_senha" placeholder="Senha" value="<?php echo $edit_u['senha'] ?? ''; ?>" required></div>
                <select name="u_nivel" style="width:100%; padding:12px; margin-bottom:10px; border-radius:8px; border:1px solid #cbd5e1;"><option value="user" <?php echo ($edit_u && $edit_u['nivel']=='user')?'selected':''; ?>>User</option><option value="admin" <?php echo ($edit_u && $edit_u['nivel']=='admin')?'selected':''; ?>>Admin</option></select>
                <button type="submit" name="salvar_user" class="btn-adm" style="background:#22c55e">SALVAR</button>
            </form>
            <div class="admin-list"><?php foreach($sistema['usuarios'] as $id => $u): ?><div class="admin-item"><div class="info"><span class="tag-date"><?php echo strtoupper($u['nivel']); ?></span> <strong><?php echo encurtarNome($u['nome']); ?></strong></div><div class="actions"><a href="admin.php?edit_user=<?php echo $id; ?>" class="btn-alt">ALT</a><a href="admin.php?excluir_user=<?php echo $id; ?>" class="btn-del">X</a></div></div><?php endforeach; ?></div>
        </div>
    </div>

    <div id="aba-mural" class="tab-content">
        <div class="admin-box" style="border-top: 4px solid var(--warning);">
            <h3>📢 Mural de Avisos</h3>
            <form method="POST"><textarea name="mural_texto" rows="4"><?php echo $sistema['mural'] ?? ''; ?></textarea><button type="submit" name="salvar_mural" class="btn-adm btn-mu">ATUALIZAR MURAL</button></form>
        </div>
    </div>

    <div id="aba-locais" class="tab-content">
        <div class="admin-box" style="border-top: 4px solid var(--primary);">
            <h3>📍 Horários das Conferências</h3>
            <form method="POST"><textarea name="locais_texto" rows="8"><?php echo $sistema['locais'] ?? ''; ?></textarea><button type="submit" name="salvar_locais" class="btn-adm btn-ev">ATUALIZAR LOCAIS</button></form>
        </div>
    </div>
</main>

<script>
var quillAtv = new Quill('#editor-atv', { theme: 'snow', modules: { toolbar: [['bold', 'italic', 'underline'], [{ 'list': 'bullet' }], ['link', 'clean']] } });
var quillNot = new Quill('#editor-not', { theme: 'snow', modules: { toolbar: [['bold', 'italic', 'underline'], [{ 'list': 'bullet' }], ['link', 'clean']] } });

function syncQuill(type) {
    if(type === 'atv') document.getElementById('input-atv').value = quillAtv.root.innerHTML;
    if(type === 'not') document.getElementById('input-not').value = quillNot.root.innerHTML;
}

function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) { tabcontent[i].classList.remove("active"); }
    tablinks = document.getElementsByClassName("tab-btn");
    for (i = 0; i < tablinks.length; i++) { tablinks[i].classList.remove("active"); }
    document.getElementById(tabName).classList.add("active");
    evt.currentTarget.classList.add("active");
    localStorage.setItem('activeTab', tabName);
}

window.onload = function() {
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) { var btn = document.querySelector('[onclick*="'+activeTab+'"]'); if(btn) btn.click(); }
}
</script>
</body></html>