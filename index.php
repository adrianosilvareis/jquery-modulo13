<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso Work Series - PHP Orientado a Objetos!</title>

        <style>
            *{margin: 0; padding: 0; box-sizing: border-box;}
            .register{display: block; width: 100%; max-width: 600px; border: 15px solid #fff; margin: 0 auto; padding: 20px; background: #eee;}
            .register header{margin-bottom: 20px; text-align: center; padding-bottom: 20px; border-bottom: 2px solid #ccc;}
            .register form{display: block; margin-bottom: 30px;}
            .register input{width: 100%; padding: 10px; margin-bottom: 10px;}
            .register button{background: #09f; border: 2px solid #fff; outline: 2px solid #09f; padding: 10px; cursor: pointer; color: #fff; text-transform: uppercase; margin-top: 10px;}
            .user_box{display: block; padding: 10px; background: #fbfbfb; margin-top: 20px; padding-top: 20px; border-top: 1px dotted #000;}
            .action{cursor: pointer; display: inline-block; margin-top: 10px; padding: 5px 10px; font-size: 0.7em; margin-right: 10px; text-transform: uppercase; background: #555; color: #fff;}
            .del{background: #a72626;}
            .edit{background: #006699;}
            .form_load{display: none; vertical-align: middle; margin-left: 15px; margin-top: -2px;}
            .trigger{display: none; padding: 15px; background: #ccc; color: #000; margin-bottom: 20px; font-size: 0.8em; font-weight: bolder}
            .trigger-error{background: #e4b4b4;}
            .trigger-success{background: #b4e4b9;}
        </style>
    </head>

    <body>
        <section class="register">
            <header>
                <h1>jQuery, AJAX, jSON e PHP</h1>
                <p>Criando Aplicações Real-Time com PHP e jQuery!</p>
            </header>

            <form name="user_register" method="post" action="">
                <div class="trigger trigger-error">ERRO</div>
                <div class="trigger trigger-success">SUCESSO</div>

                <input type="text" name="user_name" placeholder="Nome:"/>
                <input type="text" name="user_lastname" placeholder="Sobrenome:"/>
                <input type="email" name="user_email" placeholder="Email:"/>
                <input type="password" name="user_password" placeholder="Senha:"/>
                <input type="number" name="user_level" min="1" max="3" placeholder="Nível de Acesso:"/>
                <button>Cadastrar Usuário!</button>
                <img class="form_load" src="img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
            </form>

            <article class="user_box">
                <h1>Robson V. Leite <span></span></h1>
                <p>cursos@upinside.com.br (Nível 3)</p>
                <span class="action edit j_edit">Editar</span>
                <span class="action del">Deletar</span>
            </article>
        </section>

        <script src="js/jquery.js"></script>
        <script src="js/script.js"></script>

    </body>
</html>
<!--NTk4Nw==-->