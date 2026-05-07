<?php 
require_once 'base.php'; 
if (!$user_logado) { header("Location: admin.php"); exit; }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Orações SSVP - CCEJ</title>
    <style>
        :root { --primary: #1e3a8a; --accent: #8b5cf6; --warning: #f59f00; --bg: #f1f5f9; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); margin: 0; padding: 0; color: #1e293b; }
        
        /* Header Padrão do Sistema */
        header { position: fixed; top: 0; width: 100%; height: 65px; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { width: 95%; max-width: 800px; display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; }
        
        /* Botões Circulares do Menu (Sem ícones externos) */
        .circle-btn { width: 35px; height: 35px; border-radius: 50%; background: rgba(255,255,255,0.2); color: white; border: none; display: flex; align-items: center; justify-content: center; text-decoration: none; font-weight: 900; font-size: 0.8rem; }

        /* Abas */
        .tabs-wrapper { position: fixed; top: 65px; width: 100%; background: var(--bg); z-index: 999; display: flex; gap: 8px; overflow-x: auto; padding: 10px 15px; border-bottom: 1px solid #e2e8f0; box-sizing: border-box; }
        .btn-tab { padding: 10px 20px; border-radius: 20px; border: none; font-weight: 700; cursor: pointer; background: #cbd5e1; color: #475569; white-space: nowrap; font-size: 0.85rem; }
        .btn-tab.active { background: var(--primary); color: white; }

        /* Conteúdo */
        .container { padding: 15px; max-width: 800px; margin: 135px auto 30px auto; }
        .prayer-card { background: white; padding: 25px; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-left: 5px solid var(--primary); }
        .prayer-title { color: var(--primary); font-weight: 900; border-bottom: 2px solid var(--warning); padding-bottom: 8px; margin-bottom: 18px; font-size: 1.15rem; }
        .role { font-weight: 800; color: var(--accent); font-size: 0.8rem; text-transform: uppercase; display: block; margin-top: 20px; margin-bottom: 5px; }
        .text { font-size: 1.05rem; line-height: 1.7; color: #1e293b; margin: 0 0 15px 0; white-space: pre-line;     text-align: justify; }
        .highlight { background: #fefce8; padding: 15px; border-radius: 8px; border-left: 4px solid var(--warning); font-style: italic; font-size: 0.95rem; margin: 25px 0; }
    </style>
</head>
<body>

<?php include 'menu.php'; ?>

<div class="tabs-wrapper">
    <button onclick="changeTab('complementares')" id="tab-complementares" class="btn-tab">ORAÇÕES</button>
    
    <a href="https://www.ssvpbrasil.org.br/source/files/originals/Regra_SSVP_2023-968691.pdf" 
       target="_blank" 
       class="btn-tab" 
       style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
       LER REGRA
    </a>
</div>

<div class="container">


    <div id="complementares" class="tab-content" style="display:none;">
        
        <div class="prayer-card">
            <div class="prayer-title">🌱 Renovação do Compromisso Vicentino - (Artigos 16, § 4º; 28, I; e 29 do Regulamento no Brasil)</div>
            <p class="text">Hoje, Senhor, diante de Vós, meu pastor, e de meus irmãos de caminhada, assumo o meu compromisso vicentino, com Cristo, com a Igreja, com Maria e com meus irmãos para os quais fui enviado, dizendo:

            Ó Deus Todo-Poderoso, que, sem nenhum mérito de minha parte, me chamastes a participar como obreiro vicentino, a exemplo de São Vicente de Paulo e de Ozanam, consagro a Vós minha ação de graças pela escolha.

            Quero unir-me e identificar-me mais convosco, Senhor Jesus, meu mestre e modelo, renunciando a mim mesmo, para consagrar-me totalmente aos deveres de minha vocação. Prometo fidelidade na distribuição do pão da palavra e do pão que alimenta.

            Prometo, em espírito de humildade e por amor, obedecer ao Regulamento da Sociedade de São Vicente de Paulo e ser obediente à hierarquia de nossa Organização, gerando, assim, mais união e fraternidade entre nós.

            Ajudai-me, Senhor, a ser fiel administrador dos Vossos dons, não visando bens materiais e promoção pessoal, mas unicamente a Vossa glória e o bem dos necessitados.

            A Vós, meu Deus, entrego a minha vida e meus sofrimentos, meus êxitos e meus fracassos. Que a graça de Cristo, a proteção da Virgem Maria e a intercessão de São Vicente de Paulo e do Bem-Aventurado Ozanam, estejam comigo hoje e para sempre. Amém!</p>
        </div>

        <div class="prayer-card">
            <div class="prayer-title">🌱 2.5) Oração pelas vocações vicentinas: “O Pai escolhe, o Filho chama e o Espírito Santo envia!”</div>
            <p class="text">Senhor da messe e Pastor do rebanho, fazei ressoar em nossos ouvidos vosso forte e suave convite: “Vem e segue-me!”

            Derramai sobre nós o vosso Espírito. Que Ele nos dê sabedoria para ver o caminho e generosidade para seguir vossa voz. Senhor, que a messe não se perca por falta de operários. Despertai nossas comunidades para a missão. Ensinai nossa vida a ser serviço. Fortalecei os que querem dedicar-se ao Reino na vida consagrada e religiosa.

            Senhor, que o rebanho não pereça por falta de pastores. Sustentai a fidelidade de nossos Bispos, Padres e Ministros. Dai perseverança a nossos seminaristas. Despertai o coração de nossos jovens para o ministério pastoral em vossa Igreja. Senhor da messe e Pastor do rebanho, chamai-nos para o serviço de vosso povo. Maria, Mãe da Igreja, modelo dos servidores do Evangelho: ajudai-nos a responder “sim”. Amém.</p>
        </div>

        <div class="prayer-card">
            <div class="prayer-title">🌱 2.6) Oração pelas vocações vicentinas</div>
            <p class="text">São Vicente de Paulo, missionário e evangelizador dos Pobres, concedei-nos, através da vossa intercessão:
            Jovens corajosos, que estejam dispostos a acender o fogo do amor divino em todos os seres, para continuarem a missão do Filho de Deus.
            
            Jovens comunicativos, que revelem aos mais Pobres e excluídos que o Reino de Deus está perto, de modo especial para eles.
            
            Jovens convertidos a Nosso Senhor Jesus Cristo, que se dirijam cheios de amor à humanidade, para tirá-la da miséria material e espiritual.
            
            Jovens profetas, que transmitam tudo o que foi predito pelos profetas, para efetivar realmente o Evangelho.
            
            Jovens que desejem participar de sua glória no céu, participando do sofrimento dos Pobres, dos aflitos e martirizados.
            
            Jovens que tratem com compreensão e cordialidade os mais pobres, colocando-se a seu serviço.
            
            Jovens que se interessem por uma vida interior que se manifesta na fé, na esperança e na caridade, numa atitude de entrega a Deus.
            
            Enviai, Senhor, através de São Vicente de Paulo, vocações generosas, Padres, Religiosas, Leigos e Leigas, felizes em dedicarem o tempo breve de suas vidas ao amor e à justiça. Amém.</p>
        </div>

        <div class="prayer-card">
            <div class="prayer-title">🌱  2.7) Oração para uso dos vicentinos antes da visita domiciliar aos assistidos</div>
            <p class="text">Meu Jesus, ajudai-me no bem que, em vosso nome, desejo fazer; porque, só por mim, nada posso. 
            
            Estai comigo. Enchei meu coração daqueles sentimentos que desejo inspirar ao coração desse homem (senhora ou família). 
           
            Ponde persuasão em meus lábios, verdade em minhas palavras, prudência em meus Conselhos e paciência em minha expectativa. Fazei que a vossa graça ilumine esse meu irmão, enquanto me ouvir... 
           
            Nada atribuirei a mim no êxito com que vos peço abençoeis minha missão. Sei que sou um instrumento indigno e que nada valho. Porém, tudo me será possível, se vos dignardes assistir-me, ó Jesus, Bom 
            
            Pastor. Pai dos Pobres, consolador dos aflitos, que com vosso eterno Pai e o Divino Espírito viveis e reinais, em perfeita unidade, por séculos sem fim. Amém.</p>
        </div>

        <div class="prayer-card">
            <div class="prayer-title">🌱 ️2.8) Oração “De Profundis”83, pelos membros já falecidos da SSVP</div>
            <p class="text">Das profundezas dos abismos, clamei a Vós, meu Senhor: Senhor, ouvi a minha voz. Dai ouvidos atentos à voz da minha súplica. 
            
            Se Vós atenderdes às minhas iniquidades, Senhor, quem poderá subsistir na vossa presença? Porém, eu, Senhor, esperei em Vós, por causa da vossa Lei, e porque em Vós tudo é clemência. Esperou a minha alma no Senhor, susteve-se a minha alma na sua palavra. 
            
            Espere assim todo Israel no Senhor, desde a aurora até a noite. Porque o Senhor é cheio de misericórdia, e nele se encontra redenção copiosa. E ele mesmo há de remir Israel de todas as iniquidades.

            <b>Dirigente:</b> Dai-lhes, Senhor, o eterno descanso.
            <b>Todos:</b> Entre os resplendores da luz perpétua.
            <b>Dirigente:</b> Descansem em paz. Todos: Amém.</p>
        </div>

        <div class="prayer-card">
            <div class="prayer-title">🌱 2.9) Ato de Consagração da Sociedade de São Vicente de Paulo ao Sagrado 
Coração de Jesus</div>
            <p class="text">Clementíssimo Jesus, que, por misericordioso desígnio, vos dignastes abrir o vosso dulcíssimo Coração aos homens, para os salvardes e enriquecerdes com inefáveis tesouros de amor que encerra. 
            
            A Vossos pés vêm hoje os membros das Conferências de São Vicente de Paulo consagrar-se inteiramente a esse divino e amantíssimo Coração. 
            
            Reconhecemos que este oceano infinito de Caridade é a origem e fonte de todas as graças e de todos os benefícios que a nossa Sociedade tem operado no mundo. Amém.</p>
        </div>

    </div>
</div>

<script>
function changeTab(id) {
    document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
    document.querySelectorAll('.btn-tab').forEach(b => b.classList.remove('active'));
    document.getElementById(id).style.display = 'block';
    document.getElementById('tab-'+id).classList.add('active');
    window.scrollTo(0,0);
}
</script>
</body>
</html>