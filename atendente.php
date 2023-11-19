<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$database = "projeto";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar a sessão para garantir que apenas atendentes tenham acesso
session_start();

// Se o tipo de usuário não estiver definido na sessão ou for diferente de 'atendente', exibir uma mensagem de erro e sair
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'atendente') {
    echo 'Acesso negado. Você não tem permissão para acessar esta página.';
    exit();
}

// Marcar um chamado como concluído com descrição do técnico
if (isset($_POST['marcar_concluido']) && is_numeric($_POST['marcar_concluido'])) {
    $chamado_id = $_POST['marcar_concluido'];
    $descricao_tecnico = $_POST['descricao_tecnico']; // Descrição do que o técnico fez
    $data_hora_conclusao = date("Y-m-d H:i:s"); // Obtém a data e hora atual

    if (empty($descricao_tecnico)) {
        echo "A descrição do técnico é obrigatória. Por favor, preencha a descrição antes de marcar como concluído.";
    } else {
        $sql = "UPDATE chamados SET status = 'concluído', descricao_tecnico = '$descricao_tecnico', data_hora_conclusao = '$data_hora_conclusao' WHERE id = $chamado_id";
        if ($conn->query($sql) === TRUE) {
            echo 'success'; // Indicar sucesso para o AJAX
            exit();
        } else {
            echo 'error: ' . $conn->error; // Exibir informações detalhadas sobre o erro
            exit();
        }
    }
}

// Consulta para listar chamados pendentes na tabela "chamados" e informações correspondentes na tabela "usuarios"
$sql = "SELECT chamados.id, chamados.id_maquina, chamados.assunto, chamados.descricao, chamados.status, chamados.nome, chamados.cargo, chamados.departamento 
        FROM chamados 
        WHERE chamados.status = 'pendente'";
$result = $conn->query($sql);

if (!$result) {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Página do Atendente</title>
    <style>
        /* ... (Estilos existentes) ... */
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function marcarConcluido(chamadoId) {
            var descricao_tecnico = prompt("Descreva o que foi feito no computador pelo técnico:");
            if (descricao_tecnico !== null) {
                $.ajax({
                    type: 'POST',
                    url: 'atendente.php',
                    data: { marcar_concluido: chamadoId, descricao_tecnico: descricao_tecnico },
                    success: function (data) {
                        if (data === 'success') {
                            alert('Chamado marcado como concluído com sucesso.');
                            atualizarLista();
                        } else {
                            alert('Ocorreu um erro ao marcar o chamado como concluído: ' + data);
                        }
                    },
                    error: function () {
                        alert('Ocorreu um erro ao marcar o chamado como concluído.');
                    }
                });
            }
        }

        function atualizarLista() {
            location.reload();
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Chamados Pendentes</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID da Máquina</th>
                    <th>Assunto</th>
                    <th>Descrição do Chamado</th>
                    <th>Nome do Responsável</th>
                    <th>Cargo do Responsável</th>
                    <th>Departamento do Responsável</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($row["status"] === 'pendente') {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["id_maquina"] . "</td>";
                            echo "<td>" . $row["assunto"] . "</td>";
                            echo "<td>" . $row["descricao"] . "</td>";
                            echo "<td>" . $row["nome"] . "</td>";
                            echo "<td>" . $row["cargo"] . "</td>";
                            echo "<td>" . $row["departamento"] . "</td>";
                            echo "<td>";
                            echo "<button onclick='marcarConcluido(" . $row["id"] . ")'>Marcar como Concluído</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='8'>Nenhum chamado pendente</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="login.php" class="logout button">Sair</a>
    </div>
</body>
</html>
