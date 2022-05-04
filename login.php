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
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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

    
<?php require_once("partials/footer.php")?>