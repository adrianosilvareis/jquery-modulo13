<?php

$getPost = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$setPost = array_map('strip_tags', $getPost);
$post = array_map('trim', $setPost);

$Action = $post['action'];
$jSon = array();
unset($post['action']);
sleep(1);

if ($Action):
    require '../_app/Config.inc.php';
    $WsUsers = new WsUsers();
endif;

switch ($Action):
    case 'create':
        if (in_array('', $post)):
            $jSon['error'] = "<b>OPPPSSS:</b> Para cadastraro um usuário preencha todos os campos";
        elseif (!Check::Email($post['user_email']) || !filter_var($post['user_email'], FILTER_VALIDATE_EMAIL)):
            $jSon['error'] = "<b>OPPPSSS:</b> Favor informe um email válido!";
        elseif (strlen($post['user_password']) < 5 || strlen($post['user_password']) > 10):
            $jSon['error'] = "<b>OPPPSSS:</b> Sua Senha deve ter entre 5 e 10 caracteres!";
        else:
            $WsUsers->setUser_email($post['user_email']);
            $WsUsers->Execute()->FullRead("SELECT user_id FROM ws_users WHERE #user_email#");
            if ($WsUsers->Execute()->getResult()):
                $jSon['error'] = "<b>OPPPSSS:</b> O email {$post['user_email']} ja esta em uso!";
            else:
                $WsUsers->setThis((object) $post);
                $WsUsers->Execute()->insert();
                $jSon['success'] = "Cadastro com sucesso!";
                $jSon['result'] = "<article style='display: none' class='user_box j_register' id='{$WsUsers->Execute()->MaxFild('user_id')}'><h1> {$post['user_name']} {$post['user_lastname']} </h1><p>{$post['user_email']} (Nível {$post['user_level']})</p><a class='action edit j_edit' rel='{$WsUsers->Execute()->MaxFild('user_id')}'>Editar</a><a class='action del' rel='{$WsUsers->Execute()->MaxFild('user_id')}'>Deletar</a></article>";
            endif;
        endif;
        break;
    case 'loadmore':
        $jSon['result'] = null;
        $WsUsers = new WsUsers();
        $WsUsers->Execute()->FullRead("SELECT * FROM ws_users ORDER BY user_id DESC LIMIT :limit OFFSET :offset", "limit=2&offset={$post['offset']}", true);
        if ($WsUsers->Execute()->getResult()):
            foreach ($WsUsers->Execute()->getResult() as $Users):
                extract((array) $Users);
                $jSon['result'] .= "<article style='display: none' class='user_box' id='{$user_id}'><h1> {$user_name} {$user_lastname} </h1><p>{$user_email} (Nível {$user_level})</p><a class='action edit j_edit' rel='{$user_id}'>Editar</a><a class='action del' rel='{$user_id}'>Deletar</a></article>";
            endforeach;
        else:
            $jSon['result'] = "<div style='margin: 15px 0 0 0' class='trigger trigger-error'>Não existem resultados</div>";
        endif;
        break;
    default :
        $jSon['error'] = "Erro ao selecionar ação!";
endswitch;

echo json_encode($jSon);
