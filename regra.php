<?php 
require_once 'base.php'; 
if (!$user_logado) { header("Location: admin.php"); exit; }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Orações SSVP - CCEJ</title>
    <style>
        .prayer-section { background: white; padding: 20px; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .prayer-title { color: var(--primary); font-weight: 900; border-bottom: 2px solid var(--warning); padding-bottom: 8px; margin-bottom: 15px; display: flex; align-items: center; gap: 10px; }
        .role { font-weight: 800; color: var(--accent); font-size: 0.8rem; text-transform: uppercase; display: block; margin-top: 15px; }
        .text { font-size: 1rem; line-height: 1.6; color: #334155; margin-bottom: 5px; }
        .highlight { background: #fefce8; padding: 12px; border-radius: 8px; border-left: 4px solid var(--warning); font-style: italic; font-size: 0.9rem; margin: 15px 0; }
        .btn-tab { padding: 12px 20px; border-radius: 20px; border: none; font-weight: 700; cursor: pointer; background: #e2e8f0; color: #64748b; min-width: 100px; }
        .active-tab { background: var(--primary); color: white; }
        .icon-circle { width: 38px; height: 38px; border-radius: 50% !important; display: flex !important; align-items: center; justify-content: center; text-decoration: none; border: none; }
    </style>
</head>
<body>

<?php include 'menu.php'; ?>

<div class="container main-content" style="padding-top: 85px;">
    
    <div style="display: flex; gap: 10px; margin-bottom: 20px; overflow-x: auto; padding-bottom: 5px;">
        <button onclick="showPrayer('inicio')" id="btn-inicio" class="btn-tab active-tab">INÍCIO</button>
        <button onclick="showPrayer('final')" id="btn-final" class="btn-tab">FINAL</button>
    </div>

    <div id="inicio" class="prayer-content">
        <div class="prayer-section">
            <div class="prayer-title">☀️ No começo das reuniões</div>
            
            <span class="role">Dirigente:</span>
            <p class="text">Em nome do Pai, do Filho e do Espírito Santo. Amém.</p>

            <span class="role">Todos:</span>
            <p class="text">Vinde, Espírito Santo, enchei os corações dos vossos fiéis<br>e acendei neles o fogo do Vosso amor.</p>

            <span class="role">Dirigente:</span>
            <p class="text">Enviai o Vosso Espírito e tudo será criado.</p>

            <span class="role">Todos:</span>
            <p class="text">E renovareis a face da terra.</p>

            <span class="role">Oremos:</span>
            <p class="text">Deus, que iluminastes os corações dos Vossos fiéis com as luzes do Espírito Santo,<br>concedei-nos que, pelo mesmo Espírito, saibamos o que é reto<br>e gozemos sempre de suas divinas consolações.<br>Por Cristo Nosso Senhor. Amém.</p>

            <div class="highlight">Pai Nosso... Ave Maria...</div>

            <span class="role">Dirigente:</span> <p class="text">Sacratíssimo Coração de Jesus</p>
            <span class="role">Todos:</span> <p class="text">Compadecei-vos de nós.</p>

            <span class="role">Dirigente:</span> <p class="text">Rainha concebida sem pecado</p>
            <span class="role">Todos:</span> <p class="text">Rogai por nós.</p>

            <span class="role">Dirigente:</span> <p class="text">São Vicente de Paulo</p>
            <span class="role">Todos:</span> <p class="text">Rogai por nós.</p>

            <span class="role">Dirigente:</span> <p class="text">Bem-Aventurado Antônio Frederico Ozanam</p>
            <span class="role">Todos:</span> <p class="text">Rogai por nós.</p>

            <span class="role">Dirigente:</span> <p class="text">Coração Eucarístico de Jesus</p>
            <span class="role">Todos:</span> <p class="text">Nós temos confiança em Vós.</p>
        </div>
    </div>

    <div id="final" class="prayer-content" style="display:none;">
        <div class="prayer-section">
            <div class="prayer-title">🌙 No final das reuniões</div>
            
            <span class="role">Dirigente:</span>
            <p class="text">Em nome do Pai, do Filho e do Espírito Santo. Amém.</p>

            <div class="highlight">Invocações</div>
            <p class="text"><strong>Nossa Senhora da Conceição Aparecida, Padroeira do Brasil:</strong> Rogai por nós.</p>
            <p class="text"><strong>São José:</strong> Rogai por nós.</p>
            <p class="text"><strong>São Vicente de Paulo:</strong> Rogai por nós.</p>
            <p class="text"><strong>Bem-Aventurado Antônio Frederico Ozanam:</strong> Rogai por nós.</p>

            <span class="role">Oremos:</span>
            <p class="text">Clementíssimo Jesus, que suscitastes na vossa Igreja a pessoa de São Vicente de Paulo,<br>um apóstolo da vossa ardente caridade,<br>inspirai em vossos servos esse mesmo ardor,<br>para que, por vosso amor, deem com a mais boa vontade aos Pobres o que possuem<br>e, mais ainda, se deem a si mesmos.<br>Vós, que com Deus Pai viveis e reinais na unidade do Espírito Santo. Amém.</p>

            <span class="role">Oremos pelos benfeitores da SSVP:</span>
            <p class="text">Dignai-vos, piedosíssimo Jesus, conceder a vossa graça aos benfeitores dos Pobres.<br>Vós que fizestes promessas aos que praticassem em vosso nome obras de misericórdia,<br>cem por um, e o reino do céu. Amém.</p>

            <span class="role">Oremos a Nossa Senhora:</span>
            <p class="text">À vossa proteção recorremos, Santa Mãe de Deus.<br>Não desprezeis as súplicas que em nossas necessidades vos dirigimos,<br>mas livrai-nos de todos os perigos, ó Virgem gloriosa e bendita. Amém.</p>

            <span class="role">Pelos falecidos da SSVP:</span>
            <p class="text">Pela misericórdia de Deus, as almas dos fiéis falecidos descansem em paz. Amém.</p>

            <div class="highlight">Oração pela canonização do Beato Antônio Frederico Ozanam</div>
            <p class="text" style="font-size: 0.95rem;">
                Senhor,<br>
                Fizestes do Beato Antônio Frederico Ozanam uma testemunha do Evangelho,<br>maravilhado pelo mistério da Igreja.<br>
                Inspirastes seu combate contra a miséria e a injustiça<br>e o dotastes de uma generosidade incansável, ao serviço de todos aqueles que sofrem.<br>
                Em família, ele se revelou filho, irmão, esposo e pai excepcional.<br>
                No mundo, sua ardente paixão pela verdade iluminou seu pensamento,<br>seu ensinamento e seus escritos.<br>
                À nossa Sociedade, que concebeu como uma rede universal de caridade,<br>ele soprou o espírito de amor, de audácia e de humildade,<br>herdado de São Vicente de Paulo.<br>
                Em todos os aspectos de sua breve existência, emerge sua visão profética da Sociedade,<br>tanto quanto a influência de suas virtudes.<br>
                Por essa multiplicidade de dons, nós vos agradecemos, Senhor,<br>e solicitamos – se é de vossa vontade – a graça de um milagre,<br>pela intercessão do Beato Antônio Frederico Ozanam.<br>
                Possa a Igreja proclamar sua santidade, se esta for providencial para o momento atual.<br>
                Nós vos pedimos por Nosso Senhor Jesus Cristo. Amém.
            </p>

            <div class="highlight">Conclusão: Rezar 3 (três) Ave Marias em honra a Maria Santíssima.</div>
        </div>
    </div>
</div>

<script>
function showPrayer(tipo) {
    document.querySelectorAll('.prayer-content').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.btn-tab').forEach(el => el.classList.remove('active-tab'));
    document.getElementById(tipo).style.display = 'block';
    document.getElementById('btn-' + tipo).classList.add('active-tab');
    window.scrollTo(0,0);
}
</script>

</body>
</html>