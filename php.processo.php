<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$database = "sistema_chamados";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(["erro" => "Conexão falhou"]));
}

$status = $_GET['status'] ?? '';
$criticidade = $_GET['criticidade'] ?? '';
$colaborador = $_GET['colaborador'] ?? '';

$sql = "SELECT c.id, cl.nome AS cliente, c.descricao, c.criticidade, c.status, co.nome AS colaborador 
        FROM chamados c
        LEFT JOIN clientes cl ON c.cliente_id = cl.id
        LEFT JOIN colaboradores co ON c.colaborador_id = co.id
        WHERE 1=1";

if ($status) {
    $sql .= " AND c.status = '$status'";
}
if ($criticidade) {
    $sql .= " AND c.criticidade = '$criticidade'";
}
if ($colaborador) {
    $sql .= " AND c.colaborador_id = $colaborador";
}

$result = $conn->query($sql);

$chamados = [];
while ($row = $result->fetch_assoc()) {
    $chamados[] = $row;
}

echo json_encode($chamados);
?>
