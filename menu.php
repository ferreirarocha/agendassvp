<?php
// menu.php - Central de Comando (Cabeçalho + Navegação + Modal)
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<style>
    :root { --primary: #1e3a8a; --warning: #f59f00; --bg: #f1f5f9; --danger: #ef4444; }
    
    /* Header Padronizado */
    header { 
        position: fixed; top: 0; left: 0; width: 100%; height: 65px; 
        background: var(--primary); color: white; 
        display: flex; align-items: center; justify-content: center; 
        z-index: 10000; box-shadow: 0 2px 10px rgba(0,0,0,0.2); 
    }

    .header-content { 
        width: 95%; max-width: 1000px; 
        display: flex; justify-content: space-between; align-items: center; 
    }
    
    .brand-area { flex: 1; line-height: 1.1; font-weight: 900; font-size: 0.75rem; text-transform: uppercase; }
    .nav-group { flex: 2; display: flex; gap: 12px; align-items: center; justify-content: center; }
    .user-area { flex: 1; text-align: right; }

    /* Botões Circulares Padronizados (Tamanho Único) */
    .nav-circle-btn { 
        width: 42px !important; height: 42px !important; min-width: 42px !important;
        border-radius: 50% !important; background: #fff !important; 
        color: var(--primary) !important; border: none !important; 
        display: flex !important; align-items: center !important; justify-content: center !important; 
        text-decoration: none !important; box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        cursor: pointer; padding: 0 !important; transition: 0.2s;
    }
    
    .nav-circle-btn .material-symbols-outlined {
        font-size: 24px !important;
        font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 24;
    }

    /* Modal com Cards Isolados */
    .modal-overlay { 
        position: fixed; inset: 0; background: rgba(0,0,0,0.85); 
        display: none; align-items: center; justify-content: center; 
        z-index: 20000; padding: 15px; 
    }
    .modal-card { 
        background: #f1f5f9; width: 100%; max-width: 500px; 
        border-radius: 20px; overflow: hidden; display: flex; flex-direction: column;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }
    .modal-header { 
        padding: 15px 20px; background: #fff; border-bottom: 1px solid #e2e8f0; 
        display: flex; justify-content: space-between; align-items: center; 
    }
    .modal-title { margin: 0; color: var(--primary); font-weight: 900; font-size: 1.1rem; }
    .modal-body { padding: 15px; max-height: 65vh; overflow-y: auto; }

    /* Card Isolado dentro do Modal */
    .modal-item-card {
        background: #ffffff !important;
        border-radius: 12px !important;
        padding: 15px !important;
        margin-bottom: 15px !important;
        border-left: 6px solid var(--primary) !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.07) !important;
        text-align: left;
    }
    .modal-item-card p { margin: 0; line-height: 1.5; color: #1e293b; font-weight: 700; font-size: 0.88rem; white-space: pre-wrap; }
    .card-detail { color: #64748b; font-weight: 400; font-size: 0.78rem; display: block; margin-top: 5px; }

    .btn-fechar-menu { 
        width: 90%; margin: 15px auto; padding: 15px; 
        background: var(--primary); color: white; border: none; 
        border-radius: 12px; font-weight: 900; text-transform: uppercase; cursor: pointer;
    }
</style>

<header>
    <div class="header-content">
        <div class="brand-area">AGENDA VICENTINA<br>CCEJ</div>

        <div class="nav-group">
            <a href="index.php" class="nav-circle-btn"><span class="material-symbols-outlined">home</span></a>
            <a href="oracoes.php" class="nav-circle-btn"><span class="material-symbols-outlined">auto_stories</span></a>
            <a href="roteiro.php" class="nav-circle-btn"><span class="material-symbols-outlined">assignment</span></a>
            <button onclick="controlModalGeral(true)" class="nav-circle-btn"><span class="material-symbols-outlined">info</span></button>
        </div>

        <div class="user-area">
            <span style="font-weight: 700; font-size: 0.65rem; display: block; color:#fff;">
                <?php echo isset($user_logado) ? encurtarNome($user_logado['nome']) : 'CONFRADE'; ?>
            </span>
            <a href="admin.php?sair=1" style="color: #ff9999; font-size: 0.6rem; font-weight: 900; text-decoration: none;">SAIR [X]</a>
        </div>
    </div>
</header>

<div id="modalGlobalInfo" class="modal-overlay" onclick="controlModalGeral(false)">
    <div class="modal-card" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 class="modal-title">📍 Locais e Horários</h3>
            <button onclick="controlModalGeral(false)" style="background:none; border:none; color:var(--danger); font-size:1.5rem; font-weight:900; cursor:pointer;">&times;</button>
        </div>
        
        <div class="modal-body">
            <?php 
            if(!empty($sistema['locais'])): 
                $texto_limpo = str_replace("\r", "", $sistema['locais']);
                $linhas = explode("\n", $texto_limpo);
                foreach($linhas as $linha): 
                    if(trim($linha) == "") continue;
            ?>
                <div class="modal-item-card">
                    <p><?php echo str_replace(' - ', '<br><span class="card-detail">▼ ', htmlspecialchars($linha)); ?></span></p>
                </div>
            <?php 
                endforeach;
            else: 
                echo "<div class='modal-item-card' style='text-align:center; border:none;'>Nenhum local cadastrado.</div>";
            endif; 
            ?>
        </div>
        <button onclick="controlModalGeral(false)" class="btn-fechar-menu">FECHAR</button>
    </div>
</div>

<script>
function controlModalGeral(abrir) {
    const m = document.getElementById('modalGlobalInfo');
    if(m) {
        m.style.display = abrir ? 'flex' : 'none';
        document.body.style.overflow = abrir ? 'hidden' : 'auto';
    }
}
</script>