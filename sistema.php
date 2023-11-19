<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Help Desk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        main {
            display: flex;
            justify-content: space-around;
            padding: 20px;
        }

        .ticket-form {
            flex: 1;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
        }

        .ticket-form h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .ticket-list {
            flex: 2;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .ticket-list h2 {
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        strong {
            font-weight: bold;
        }

        span {
            color: #007bff;
        }

        h3 {
            margin: 10px 0;
        }

        p {
            margin: 0;
        }

        .botao-voltar {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            background-color: #dc3545;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .botao-voltar:hover {
            background-color: #bd2130;
        }
    </style>
</head>
<body>
    <header>
        <h1>Sistema de Help Desk</h1>
    </header>
    <main>
        <section class="ticket-form">
            <h2>Criar uma Solicitação de Suporte</h2>
            
            <?php
            $host = "localhost";
            $usuario = "root";
            $senha = ""; 
            $banco = "projeto";

            $conn = new mysqli($host, $usuario, $senha, $banco);

            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }

            $mensagem = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nome = $_POST["nome"];
                $cargo = $_POST["cargo"];
                $departamento = $_POST["departamento"];
                $id_maquina = $_POST["id_maquina"];
                $assunto = $_POST["assunto"];
                $descricao = $_POST["descricao"];
                $data_hora = date("Y-m-d H:i:s");

                $sql = "INSERT INTO chamados (nome, cargo, departamento, id_maquina, assunto, descricao, data_hora, status) VALUES ('$nome', '$cargo', '$departamento', '$id_maquina', '$assunto', '$descricao', '$data_hora', 'pendente')";

                if ($conn->query($sql) === TRUE) {
                    $mensagem = "Solicitação enviada com sucesso!";
                } else {
                    $mensagem = "Erro no envio da solicitação: " . $conn->error;
                }
            }
            ?>

            <p><?php echo $mensagem; ?></p>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div class="form-group">
                    <label for="cargo">Cargo:</label>
                    <input type="text" id="cargo" name="cargo" required>
                </div>
                <div class="form-group">
                    <label for="departamento">Departamento:</label>
                    <input type="text" id="departamento" name="departamento" required>
                </div>
                <div class="form-group">
                    <label for="id_maquina">ID da Máquina:</label>
                    <input type="number" id="id_maquina" name="id_maquina" required>
                </div>
                <div class="form-group">
                    <label for="assunto">Assunto:</label>
                    <input type="text" id="assunto" name="assunto" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" rows="4" required></textarea>
                </div>
                <button type="submit">Enviar Solicitação</button>
            </form>
            <a href="login.php" class="botao-voltar">Voltar à Página Inicial</a>
            <?php $conn->close(); ?>
        </section>
    </main>
</body>
</html>
