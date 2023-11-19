<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Usuários Registrados</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Senha</th>
                <th>Tipo</th>
            </tr>
            <?php
            // Configuração do banco de dados (substitua com suas credenciais)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "projeto";

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }

            // Consulta SQL para recuperar informações dos usuários
            $userQuery = "SELECT * FROM usuarios";
            $userResult = $conn->query($userQuery);

            if ($userResult->num_rows > 0) {
                while ($userRow = $userResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $userRow["id"] . "</td>";
                    echo "<td>" . $userRow["email"] . "</td>";
                    echo "<td>" . $userRow["senha"] . "</td>";
                    echo "<td>" . $userRow["tipo"] . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>

        <h1>Chamados Registrados</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>ID da Máquina</th>
                <th>Assunto</th>
				<th>nome</th>
				<th>departamento</th>
				<th>cargo</th>
                <th>Descrição do Usuário</th>
                <th>Data e Hora de Criação</th>
                <th>Status</th>
                <th>Descrição do Técnico</th>
                <th>Data e Hora de Conclusão</th>
            </tr>
            <?php
            // Consulta SQL para recuperar informações dos chamados
            $chamadosQuery = "SELECT * FROM chamados";
            $chamadosResult = $conn->query($chamadosQuery);

            if ($chamadosResult->num_rows > 0) {
                while ($chamadosRow = $chamadosResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $chamadosRow["id"] . "</td>";
                    echo "<td>" . $chamadosRow["id_maquina"] . "</td>";
                    echo "<td>" . $chamadosRow["assunto"] . "</td>";
                    echo "<td>" . $chamadosRow["nome"] . "</td>";
                    echo "<td>" . $chamadosRow["departamento"] . "</td>";
                    echo "<td>" . $chamadosRow["cargo"] . "</td>";
                    echo "<td>" . $chamadosRow["descricao"] . "</td>";
                    echo "<td>" . $chamadosRow["data_hora"] . "</td>"; // Adicione a data e hora de criação
                    echo "<td>" . $chamadosRow["status"] . "</td>";
                    echo "<td>" . $chamadosRow["descricao_tecnico"] . "</td>";
                    echo "<td>" . $chamadosRow["data_hora_conclusao"] . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
		<a href="login.php" class="botao-voltar">Voltar à Página Principal</a>
    </div>
</body>
</html>
