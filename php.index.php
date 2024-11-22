<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "chamados";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Chamados</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { text-align: center; }
        .filters { margin-bottom: 20px; display: flex; gap: 10px; justify-content: center; }
        select, button { padding: 10px; border: 1px solid #ccc; border-radius: 4px; cursor: pointer; }
        button { background-color: #007bff; color: white; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: center; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Gerenciamento de Chamados</h1>

    
    <div class="filters">
        <select id="statusFilter">
            <option value="">Todos os Status</option>
            <option value="Aberto">Aberto</option>
            <option value="Em Andamento">Em Andamento</option>
            <option value="Resolvido">Resolvido</option>
        </select>
        <select id="criticidadeFilter">
            <option value="">Todas as Criticidades</option>
            <option value="Baixa">Baixa</option>
            <option value="Média">Média</option>
            <option value="Alta">Alta</option>
        </select>
        <select id="colaboradorFilter">
            <option value="">Todos os Colaboradores</option>
            <?php
            $colaboradores = $conn->query("SELECT id, nome FROM colaboradores");
            while ($colaborador = $colaboradores->fetch_assoc()) {
                echo "<option value='{$colaborador['id']}'>{$colaborador['nome']}</option>";
            }
            ?>
        </select>
        <button onclick="aplicarFiltros()">Filtrar</button>
    </div>

    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Descrição</th>
                <th>Criticidade</th>
                <th>Status</th>
                <th>Colaborador</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="chamadosTable">
           
        </tbody>
    </table>

    <script>
        function carregarChamados(filtros = {}) {
            const params = new URLSearchParams(filtros).toString();
            fetch(`processar.php?${params}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('chamadosTable');
                    tbody.innerHTML = '';
                    data.forEach(chamado => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${chamado.id}</td>
                                <td>${chamado.cliente}</td>
                                <td>${chamado.descricao}</td>
                                <td>${chamado.criticidade}</td>
                                <td>${chamado.status}</td>
                                <td>${chamado.colaborador || 'Não Atribuído'}</td>
                                <td>
                                    <button onclick="editarChamado(${chamado.id})">Editar</button>
                                </td>
                            </tr>
                        `;
                    });
                });
        }

        function aplicarFiltros() {
            const status = document.getElementById('statusFilter').value;
            const criticidade = document.getElementById('criticidadeFilter').value;
            const colaborador = document.getElementById('colaboradorFilter').value;
            carregarChamados({ status, criticidade, colaborador });
        }

        function editarChamado(id) {
            alert(`Editar chamado ID: ${id}`);
        }

        carregarChamados();
    </script>
</body>
</html>
