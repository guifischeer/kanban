<?php
header('Content-Type: application/json; charset=utf-8');
if (!isset($_GET['cep'])) {
    echo json_encode(['erro' => 'CEP não informado']);
    exit;
}
$cep = preg_replace('/\D/', '', $_GET['cep']);
if (strlen($cep) !== 8) {
    echo json_encode(['erro' => 'CEP inválido']);
    exit;
}
$url = 'https://viacep.com.br/ws/' . $cep . '/json/';
$json = @file_get_contents($url);
if ($json === false) {
    echo json_encode(['erro' => 'Falha ao consultar ViaCEP']);
    exit;
}
echo $json;
