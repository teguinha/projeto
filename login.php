<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login Help Desk</title>
    <link rel="stylesheet" href="logincss.css">
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

        .login-container {
            background: linear-gradient(135deg, #3498db, #8e44ad);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
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

        .create-account button {
            background: linear-gradient(135deg, #3498db, #8e44ad);
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Tela de Login</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Digite seu email">
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha">
            </div>
            <div class="form-group">
                <label for="user-type">Tipo de Usuário</label>
                <select id="user-type" name="tipo">
                    <option value="funcionario">Funcionário</option>
                    <option value="atendente">Atendente</option>
                    <option value="administrador">Administrador</option>
                </select>
            </div>
            <button type="submit">Entrar</button>
        </form>
        <p class="create-account"><button onclick="location.href='cadastro.php'">Criar um cadastro</button></p>

        <?php
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "projeto";

            $conn = new mysqli($servername, $username, $password, $database);

            // Verificar a conexão
            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }

            // Dados do formulário
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $tipo = $_POST["tipo"];

            // Consulta SQL para verificar se o email e a senha correspondem
            $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($tipo === $row["tipo"]) {
                        // Inicie a sessão aqui
                        session_start();

                        // Atribua o tipo de usuário à variável de sessão
                        $_SESSION['tipo'] = $tipo;

                        // Redirecionar com base no tipo
                        if ($tipo === "funcionario") {
                            header("Location: sistema.php");
                            exit();
                        } elseif ($tipo === "atendente") {
                            header("Location: atendente.php");
                            exit();
                        } elseif ($tipo === "administrador") {
                            header("Location: administrador.php");
                            exit();
                        }
                    }
                }
                echo '<p class="error-message">Login falhou. Tipo de usuário incorreto.</p>';
            } else {
                echo '<p class="error-message">Login falhou. Verifique suas credenciais.</p>';
            }

            // Fechar a conexão com o banco de dados
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
