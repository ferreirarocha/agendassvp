<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');

// Unificando para o arquivo que contém seus dados reais
$arquivo = '../../config/ccej/agenda_data.json';

if (!file_exists($arquivo)) {
    $sistema = [
        'usuarios' => [
            ['id' => 1, 'nome' => 'Marcos Rocha', 'login' => 'marcos', 'senha' => '123', 'nivel' => 'admin']
        ],
        'eventos' => [],
        'mural' => 'Bem-vindo à Agenda Vicentina!',
        'aniversariantes' => [],
        'presencas' => [],
        'noticias' => [], // Novo campo para notícias do Central
        'locais' => ''    // Novo campo para o modal de horários
    ];
    file_put_contents($arquivo, json_encode($sistema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
} else {
    $sistema = json_decode(file_get_contents($arquivo), true);
    
    // GARANTIA: Se o arquivo já existe mas não tem esses campos novos, nós os criamos aqui
    $atualizar = false;
    if (!isset($sistema['noticias'])) { $sistema['noticias'] = []; $atualizar = true; }
    if (!isset($sistema['locais'])) { $sistema['locais'] = ''; $atualizar = true; }
    
    if ($atualizar) {
        file_put_contents($arquivo, json_encode($sistema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}

function salvarDados($dados) {
    global $arquivo;
    file_put_contents($arquivo, json_encode($dados, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

function encurtarNome($nome) {
    $partes = explode(' ', trim($nome));
    $total = count($partes);

    if ($total <= 2) return $nome; 

    $primeiro = $partes[0];
    $ultimo = $partes[$total - 1];
    $meio = "";

    for ($i = 1; $i < $total - 1; $i++) {
        if (strlen($partes[$i]) > 2) {
            $meio .= " " . mb_substr($partes[$i], 0, 1) . ".";
        }
    }

    return $primeiro . $meio . " " . $ultimo;
}

$user_logado = $_SESSION['usuario'] ?? null;
