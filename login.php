<?php

require_once("config/globals.php");
require_once("models/Auth.php");
require_once("models/Redirect.php");

$auth = new Auth($pdo, $base);

$userInfo = $auth->checkToken(false);

if($userInfo){
    Redirect::local($base, 'index.php');
}

$message = "";

if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fórum JBD</title>
    <link rel="stylesheet" href="<?=$base?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$base?>assets/css/style.css">
</head>
<body>

    <header>
       <h1>Fórum JBD</h1>     
    </header>

        <div class="login">
            <form method="POST" action="<?=$base?>login_action.php" class="form-login">
                <div class="form-login-head">
                    <div class="icon-user">
                        <i class="bi bi-person"></i>
                    </div>

                    <h2>Login</h2>
                </div>

                <div class="form-login-body">

                    <?php if($message):?>
                        <div class="alert message alert-danger" role="alert">
                            <?=$message?>
                            <?php unset($_SESSION['message'])?>
                        </div>
                    <?php endif?>

                    <label>
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" name="email" placeholder="Seu Email">
                    </label>

                    <label>
                        <i class="bi bi-incognito"></i>
                        <input type="password" name="password" placeholder="Sua Senha">
                    </label>
                   
                    <button class="btn btn-primary">Login</button>

                    <div class="links">
                        <a href="">Esqueceu a senha?</a>
                        <a href="<?=$base?>signup.php">Criar Conta</a>
                    </div>
                </div>
            </form>
        </div>

    
    <script src="<?=$base?>assets/js/bootstrap.min.js"></script>
    <script src="<?=$base?>assets/js/script.js"></script>
</body>
</html>