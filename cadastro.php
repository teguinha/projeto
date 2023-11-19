<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastro.css">
    <title>Tela de Cadastro</title>
</head>
<body>
    <div class="container">
        <?php
        // Configuração do banco de dados
        $host = "localhost";
        $usuario = "root";
        $senha = "";
        $banco = "projeto";

        // Conexão com o banco de dados
        $conn = new mysqli($host, $usuario, $senha, $banco);

        // Verifica se a conexão foi bem-sucedida
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        $mensagem = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Coleta os dados do formulário
            $email = $_POST["email"];
            $senha = $_POST["senha"];
            $tipo = $_POST["tipo"];
            $id_maquina = $_POST["id_maquina"];

            // Verifica se o email já está cadastrado
            $check_sql = "SELECT * FROM usuarios WHERE email = '$email'";
            $result = $conn->query($check_sql);

            if ($result) {
                if ($result->num_rows > 0) {
                    $mensagem = "O email já está cadastrado. Use outro email.";
                } else {
                    // Prepara e executa a consulta de inserção
                    $sql = "INSERT INTO usuarios (email, senha, tipo, id_maquina) 
                            VALUES ('$email', '$senha', '$tipo', '$id_maquina')";

                    if ($conn->query($sql) === TRUE) {
                        $mensagem = "Dados inseridos com sucesso!";
                    } else {
                        $mensagem = "Erro na inserção de dados: " . $conn->error;
                    }
                }
            }
        }
        ?>

        <form class="cadastro-form" class="form" method="POST" action="">
            <h1>Cadastro</h1>
            <div class="form-group">
                <label for="email">Email (utilizado como login):</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <!-- Novo campo para o número da máquina -->
            <div class="form-group">
                <label for="id_maquina">Número da Sua Máquina:</label>
                <input type="text" id="id_maquina" name="id_maquina" required>
            </div>
            <!-- Fim do novo campo -->
            <div class="form-group">
                <label for="user-type">Tipo de Usuário</label>
                <select id="user-type" name="tipo">
                    <option value="funcionario">Funcionário</option>
                    <option value="atendente">Atendente</option>
                    <option value="administrador">Administrador</option>
                </select>
            </div>
            <button type="submit">Cadastrar</button>
        </form>

        <p id="mensagem" style="color: white; display: <?php echo empty($mensagem) ? 'none' : 'block'; ?>"><?php echo $mensagem; ?></p>
        <?php if (!empty($mensagem)) : ?>
            <a href="login.php" class="botao-voltar">Voltar à Página Principal</a>
        <?php endif; ?>
    </div>
</body>
</html>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #3498db;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background: linear-gradient(135deg, #3498db, #8e44ad);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .cadastro-form {
        max-width: 300px;
        margin: 0 auto;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }

    h1 {
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        text-align: left;
        font-weight: bold;
        color: #333;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    select {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    button {
        background: linear-gradient(135deg, #3498db, #8e44ad);
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 10px 20px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background: linear-gradient(135deg, #2980b9, #662d91);
    }

    .botao-voltar {
        display: inline-block;
        margin-top: 10px;
        text-decoration: none;
        background-color: #333;
        color: #fff;
        padding: 8px 16px;
        border-radius: 4px;
    }

    .botao-voltar:hover {
        background-color: #555;
    }
</style>
