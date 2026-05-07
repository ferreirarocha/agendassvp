<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');

// Unificando para o arquivo que contém seus dados reais
$arquivo = '../../config/ccej/agenda_data.json';

if (!file_exists($arquivo)) {
    // Em vez de criar o arquivo com senhas, exibimos um erro crítico.
    // Isso impede que o sistema rode sem uma configuração segura.
    die("Erro Crítico: O arquivo de configuração não foi encontrado em: " . realpath('../../config/ccej/'));
}

// Carrega os dados
$conteudo = file_get_contents($arquivo);
$sistema = json_decode($conteudo, true);

if ($sistema === null) {
    die("Erro Crítico: O arquivo agenda_data.json está corrompido ou em formato inválido.");
}

// Manutenção de campos novos (Garantia de estrutura)
$atualizar = false;

$camposObrigatorios = [
    'usuarios' => [],
    'eventos' => [],
    'mural' => 'Bem-vindo!',
    'aniversariantes' => [],
    'presencas' => [],
    'noticias' => [],
    'locais' => ''
];

foreach ($camposObrigatorios as $campo => $valorPadrao) {
    if (!isset($sistema[$campo])) {
        $sistema[$campo] = $valorPadrao;
        $atualizar = true;
    }
}

if ($atualizar) {
    file_put_contents($arquivo, json_encode($sistema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
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
