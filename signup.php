<?php

require_once("config/globals.php");
require_once("models/Auth.php");
require_once("models/Redirect.php");

$auth = new Auth($pdo, $base);

$userInfo = $auth->checkToken(false);

if($userInfo){
    Redirect::local($base, 'index.php');
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

        <div class="login register">
            <form action="<?=$base?>signup_action.php" class="form-register">
                <div class="form-register-head">
                    <div class="icon-user">
                        <i class="bi bi-person"></i>
                    </div>

                    <h2>Criar Conta</h2>
                </div>


                <div class="form-register-body">

                <div class="alert message m-hide" role="alert">
                    
                </div>
                    
                    <label>
                        <i class="bi bi-person-fill"></i>
                        <input type="text" name="name" placeholder="Nome completo">
                    </label>

                    <label>
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" name="email" placeholder="Seu Email">
                    </label>

                    <label>
                        <i class="bi bi-people-fill"></i>
                        <select class="form-select" aria-label="Default select example" name="grade">
                            <option value="1">1º ano</option>
                            <option value="2">2º ano</option>
                            <option value="3">3° ano</option>
                        </select>
                    </label>

                    <label>
                        <i class="bi bi-calendar-event-fill"></i>
                        <select class="form-select" aria-label="Default select example" name="shift">
                            <option value="Matutino">Matutino</option>
                            <option value="Vespertino">Vespertino</option>
                        </select>
                    </label>

                    <label>
                        <i class="bi bi-incognito"></i>
                        <input type="password" name="password" placeholder="Sua Senha">
                    </label>

                    <label>
                        <i class="bi bi-incognito"></i>
                        <input type="password" name="confirm_password" placeholder="Confirme a Senha">
                    </label>
                   
                    <button class="btn btn-primary">Criar</button>

                    <div class="links">
                        <a href="">Esqueceu a senha?</a>
                        <a href="<?=$base?>login.php">Já tem uma conta?</a>
                    </div>
                </div>
            </form>
        </div>

    
<?php require_once("partials/footer.php"); ?>