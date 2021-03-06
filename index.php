<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso Work Series - PHP Orientado a Objetos!</title>

        <style>
            *{margin: 0; padding: 0; box-sizing: border-box; font-family: 'Arial', sans-serif}
            .register{display: block; width: 100%; max-width: 600px; border: 15px solid #fff; margin: 0 auto; padding: 20px; background: #eee;}
            .register header{margin-bottom: 20px; text-align: center; padding-bottom: 20px; border-bottom: 2px solid #ccc;}
            .openform{background: #80b25c; display: inline-block; font-size: 0.8em; margin-left: 10px;border: 2px solid #fff; outline: 2px solid #80b25c; padding: 5px 10px; cursor: pointer; color: #fff; text-transform: uppercase; margin-top: 10px;}
            .openform:before{content: '+';}
            .openform.closeform{background-color: #b25c5c; outline-color: #b25c5c; padding: 5px 12.5px;}
            .openform.closeform:before{content: '-';}
            .register form{display: none; margin-bottom: 30px;}
            .register input{width: 100%; padding: 10px; margin-bottom: 10px;}
            .register button{background: #09f; border: 2px solid #fff; outline: 2px solid #09f; padding: 10px; cursor: pointer; color: #fff; text-transform: uppercase; margin-top: 10px;}
            .register .close{background: #b25c5c; font-size: 0.8em; margin-left: 10px;border: 2px solid #fff; outline: 2px solid #b25c5c; padding: 10px; cursor: pointer; color: #fff; text-transform: uppercase; margin-top: 10px;}
            .user_box{display: block; padding: 10px; background: #fbfbfb; margin-top: 20px; padding-top: 20px; border-top: 1px dotted #000;}
            .action{cursor: pointer; display: inline-block; margin-top: 10px; padding: 5px 10px; font-size: 0.7em; margin-right: 10px; text-transform: uppercase; background: #555; color: #fff;}
            .del{background: #a72626;}
            .edit{background: #006699;}
            .form_load{display: none; vertical-align: middle; margin-left: 15px; margin-top: -2px;}
            .trigger{display: none; text-transform: uppercase; padding: 15px; background: #ccc; color: #000; margin-bottom: 20px; font-size: 0.8em; font-weight: bolder}
            .trigger-error{background: #e4b4b4;}
            .trigger-success{background: #b4e4b9;}
            .loadmore{display: inline-block; margin-top: 25px; text-transform: uppercase; font-size: 0.7em; background: #555; color: #fff; padding: 10px; cursor: pointer;}
        </style>
    </head>

    <body>
        <section class="register">
            <header>
                <h1>jQuery, AJAX, jSON e PHP</h1>
                <p>Criando Aplicações Real-Time com PHP e jQuery!</p>
                <a class="j_open openform" rel="user_create"></a>
            </header>

            <form name="user_register" class="j_formsubmit user_create" method="post" action="">
                <div class="trigger-box"></div>

                <input class="noclear" type="text" name="action" value="create"/>
                <input type="text" name="user_name" placeholder="Nome:"/>
                <input type="text" name="user_lastname" placeholder="Sobrenome:"/>
                <input type="email" name="user_email" placeholder="Email:"/>
                <input type="password" name="user_password" placeholder="Senha:"/>
                <input type="number" name="user_level" min="1" max="3" placeholder="Nível de Acesso:"/>
                <button>Cadastrar Usuário!</button>
                <img class="form_load" src="img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
            </form>

            <div class="j_list">
                <?php
                require './_app/Config.inc.php';
                $WsUsers = new WsUsers();
                $WsUsers->Execute()->FullRead("SELECT * FROM ws_users ORDER BY user_id DESC LIMIT 2");
                if ($WsUsers->Execute()->getResult()):
                    foreach ($WsUsers->Execute()->getResult() as $Users):
                        extract((array) $Users);
                        ?>
                        <article class="user_box" id="<?= $user_id; ?>">
                            <h1> <?= $user_name; ?> <?= $user_lastname; ?> </h1>
                            <p><?= $user_email; ?> (Nível <?= $user_level; ?>)</p>
                            <a class="action edit j_edit" rel='<?= $user_id; ?>'>Editar</a>
                            <a class="action del" rel='<?= $user_id; ?>'>Deletar</a>
                        </article>
                        <?php
                    endforeach;
                endif;
                ?>
                <div class="j_insert"></div>
            <a rel="j_list" class='j_load loadmore'>Recarregar usuários</a>
            <img class="form_load" src="img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
            </div>
        </section>
        <script src="js/jquery.js"></script>
        <script src="js/script.js"></script>

    </body>
</html>
<!--NTk4Nw==-->