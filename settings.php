<?php

require_once("config/globals.php");
require_once("models/Auth.php");

$auth = new Auth($pdo, $base);

$userInfo = $auth->checkToken(true);

require_once("partials/header.php");
?>

<div class="container main">
    <div class="user-settings">
        <?php if(isset($_SESSION['message'])):?>
            <div class="alert message alert-danger text-center" role="alert">
                <?=$_SESSION['message']?>
                <?php unset($_SESSION['message'])?>
            </div>
        <?php endif?>
        
        <form method="POST" action="<?=$base?>user_settings_action.php" class="form-user-settings">
            <div class="edit-info-user">
                <div class="form-register-head">
                    <h2>Editar Conta</h2>
                </div>
                <div class="form-register-body">
                
                    <label>
                        <i class="bi bi-person-fill"></i>
                        <input type="text" name="name" placeholder="Nome completo" value="<?=$userInfo->name?>">
                    </label>

                    <label>
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" name="email" placeholder="Seu Email" value="<?=$userInfo->email?>">
                    </label>

                    <label>
                        <i class="bi bi-people-fill"></i>
                        <select class="form-select" aria-label="Default select example" name="grade">
                            <option value="<?=$userInfo->grade?>"><?=$userInfo->grade?>º ano</option>
                            <option value="1">1º ano</option>
                            <option value="2">2º ano</option>
                            <option value="3">3° ano</option>
                        </select>
                    </label>

                    <label>
                        <i class="bi bi-calendar-event-fill"></i>
                        <select class="form-select" aria-label="Default select example" name="shift">
                            <option value="<?=$userInfo->shift?>"><?=$userInfo->shift?></option>
                            <option value="Matutino">Matutino</option>
                            <option value="Vespertino">Vespertino</option>
                        </select>
                    </label>
                    <button class="btn btn-primary">Efetuar Mudanças</button>

                </div>
            </div>

            <div class="edit-reset-password">
                <div class="form-register-head">
                        <h2>Resetar Senha</h2>
                </div>
                <div class="form-register-body">
                    <label>
                        <i class="bi bi-incognito"></i>
                        <input type="password" name="password" placeholder="Sua Senha">
                    </label>

                    <label>
                        <i class="bi bi-incognito"></i>
                        <input type="password" name="confirm_password" placeholder="Confirme a Senha">
                    </label>
                </div>
            </div>
        </form>
    </div>
</div>
<?php require_once("partials/footer.php");?>