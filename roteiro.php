<?php 
require_once 'base.php'; 
if (!$user_logado) { header("Location: admin.php"); exit; }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Roteiro de Reunião - SSVP</title>
    <style>
        :root { --primary: #1e3a8a; --warning: #f59f00; --bg: #f1f5f9; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); margin: 0; padding: 0; color: #1e293b; }
        
        .container { 
            padding: 15px; 
            max-width: 800px; 
            margin: 80px auto 30px auto; /* Espaço para o menu fixo */
        }

        .roteiro-card { 
            background: white; 
            padding: 25px; 
            border-radius: 15px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.05); 
            border-left: 6px solid var(--primary);
        }

        .header-roteiro {
            border-bottom: 2px solid var(--warning);
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .header-roteiro h2 { margin: 0; color: var(--primary); font-size: 1.2rem; font-weight: 900; }
        .header-roteiro p { margin: 5px 0 0 0; font-size: 0.85rem; color: #64748b; font-style: italic; }

        .item { 
            display: flex; 
            gap: 15px; 
            border-bottom: 1px solid #f1f5f9; 
            padding: 15px 0; 
            align-items: flex-start; 
        }
        .item:last-child { border-bottom: none; }

        .num { 
            background: var(--primary); 
            color: white; 
            border-radius: 50%; 
            min-width: 28px; 
            height: 28px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 0.9rem; 
            font-weight: 900; 
            margin-top: 2px; 
        }

        .content b { display: block; color: var(--primary); font-size: 1rem; margin-bottom: 4px; }
        .content span { font-size: 0.95rem; line-height: 1.5; color: #334155; display: block; }
        
        .intro-text {
            background: #e0f2fe;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.9rem;
            color: #0369a1;
            margin-bottom: 20px;
            line-height: 1.4;
        }
    </style>
</head>
<body>

<?php include 'menu.php'; ?>

<div class="container">
    <div class="roteiro-card">
        <div class="header-roteiro">
            <h2>REUNIÃO ORDINÁRIA DE CONFERÊNCIA</h2>
            <p>(Artigo 118 do Regulamento no Brasil)</p>
        </div>

        <div class="intro-text">
            <strong>Roteiro:</strong> Roteiro de reuniões de conferencia da SSVP.
        </div>

        <div class="item">
            <div class="num">1</div>
            <div class="content">
                <b>Membros da mesa</b>
                <span>Preocupação com os visitantes e os representantes de escalões superiores da hierarquia da SSVP e da Igreja.</span>
            </div>
        </div>

        <div class="item">
            <div class="num">2</div>
            <div class="content">
                <b>Orações Iniciais</b>
                <span>As tradicionais da Regra (espírito primitivo).</span>
            </div>
        </div>

        <div class="item">
            <div class="num">3</div>
            <div class="content">
                <b>Leitura Espiritual</b>
                <span>Para edificação dos membros. Deve ser curta, feita com pausa e ser ouvida com muita atenção (para que todos possam participar das discussões a respeito do tema). Deve ser preparada com antecedência. <br><br><i>Sugestão: leituras voltadas para assuntos do momento (atuais), podendo se usar a criatividade: Campanha da Fraternidade, Carnaval, Mês de Maria, Mês do Rosário, Mês da Bíblia, entre outras.</i></span>
            </div>
        </div>

        <div class="item">
            <div class="num">4</div>
            <div class="content">
                <b>Leitura e Aprovação da Ata</b>
                <span>A lavratura da ata é obrigatória na SSVP no Brasil. Deverá fazer de forma resumida todos os fatos ocorridos na reunião, ser aprovada por todos os Associados e conter a assinatura (nome completo e função que exerce) de todos os participantes, inclusive os visitantes. As instruções para redigir a ata estão na Instrução Normativa da Secretaria.</span>
            </div>
        </div>

        <div class="item">
            <div class="num">5</div>
            <div class="content">
                <b>Chamada</b>
                <span>É mais um fator de animação. Deve ser feita com descontração e serve para o controle da participação.</span>
            </div>
        </div>

        <div class="item">
            <div class="num">6</div>
            <div class="content">
                <b>Movimento de Caixa</b>
                <span>Apresentação da receita e comprovação da despesa. Destacar a décima semanal. Deve constar em ata apenas: receita total, despesa total (destacando-se a décima e/ou ducentésima) e saldo final.</span>
            </div>
        </div>

        <div class="item">
            <div class="num">7</div>
            <div class="content">
                <b>Agradecimento aos Visitantes</b>
                <span>Ato de grande importância, que deve ser praticado de forma criativa e atender ao espírito da boa educação.</span>
            </div>
        </div>

        <div class="item">
            <div class="num">8</div>
            <div class="content">
                <b>Resultado do Levantamento Socioeconômico</b>
                <span>(Se houver registro no momento).</span>
            </div>
        </div>

        <div class="item">
            <div class="num">9</div>
            <div class="content">
                <b>Notícias dos Trabalhos</b>
                <span>Relato das atividades desenvolvidas pelos membros: objetiva e concisa. Relato das visitas às famílias assistidas.<br><br>Novas nomeações: o máximo de produtividade pelo máximo de boa vontade. A participação deve ser efetiva e de todos.</span>
            </div>
        </div>

        <div class="item">
            <div class="num">10</div>
            <div class="content">
                <b>Palavra Franca</b>
                <span>Deve reinar a liberdade entre todos, pois é o momento na reunião de discutir os assuntos diversos da área.<br><br><strong>Expediente:</strong> o momento oportuno do conhecimento das correspondências recebidas e expedidas.</span>
            </div>
        </div>

        <div class="item">
            <div class="num">11</div>
            <div class="content">
                <b>Palavra dos Visitantes</b>
                <span>Oportunidade de manifestação dos visitantes.</span>
            </div>
        </div>

        <div class="item">
            <div class="num">12</div>
            <div class="content">
                <b>Movimento Financeiro</b>
                <span>Entrega de donativos, subscritores e outros. Logo após, deve se realizar a coleta (sugestão: que seja feita de pé e cantando).</span>
            </div>
        </div>

        <div class="item">
            <div class="num">13</div>
            <div class="content">
                <b>Orações Finais</b>
                <span>As tradicionais da Regra (espírito primitivo).</span>
            </div>
        </div>

    </div>
</div>

</body>
</html>