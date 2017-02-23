<?php
class Usuario {

    function listUsuarios($app,$admin=null,$msg=""){
        
        // carrega o model do painel
        
        if($admin==null)
            $admin = $app->loadModel("Admin");

        $usuarios = $admin->getAllUsers($app->connection);

        $param = array(
            "title"=>$app->site_title, 
            "page" => "listarusuarios",
            "dados" => array(
                "usuarios" => $usuarios,
                "msg" => $msg
            )
        );

        $app->loadView("Admin",$param);
    }

    function updateUsuario($app){
        
        $usuario_id = (int)$_GET["id"];

        $admin = $app->loadModel("Admin");

        $obj = $admin->getUserId($app->connection, $usuario_id);

        $param = array(
            
            "title"=>$app->site_title, 
            
           "page" => "formusuario",
            
           "dados" => array(
            
                "tituloform" => "Alterar usuário",
            
                "action"=>"execUpdateUsuario",
            
                "usuario_user"=>$obj["usuario_user"],
            
                "usuario_name"=>$obj["usuario_name"],
            
                "labelbtnsubmit"=>"Alterar Registro",
            
                "auxusuario"=>"disabled='disabled'",
            
                "usuario_id"=>$obj["usuario_id"],
            
                "auxsenha"=>""
            )
        );

        $app->loadView("Admin",$param);
    }

    function execUpdateUsuario($app){
        
        $admin = $app->loadModel("Admin");
        
        // alteração de usuário não é aceita
        // somente nome do usuário e a senha
        
        $nome = tStr($_POST['nome']);

        // lembrando que a senha pode vir vazia
        
        $senha = tStr($_POST['senha']);

        $usuario_id = (int)$_POST["usuario_id"];

        $obj = $admin->updateUsuario($app->connection, $usuario_id, $nome, $senha);

        if($obj) {
            $mensagem = "Alteração efetuada com sucesso!";
        } else {
            $mensagem = "Alteração falhou!";
        }

        $this->listUsuarios($app,$admin,$mensagem);
    }

    function deleteUsuario($app){
        
        $admin = $app->loadModel("Admin");

        $usuario_id = (int)$_GET["id"];

        $obj = $admin->deleteUsuario($app->connection, $usuario_id);

        if($obj) {
            $mensagem = "Exclusão efetuada com sucesso!";
        } else {
            $mensagem = "Exclusão falhou!";
        }

        $this->listUsuarios($app,$admin,$mensagem);
    }

    function insertUsuario($app){
        
        $param = array(
            
            "title"=>$app->site_title, 
            
           "page" => "formusuario",
            
           "dados" => array(
            
                "tituloform" => "Cadastrar novo usuário",
                "action"=>"execInsertUsuario",
            
                "usuario_user"=>"",
            
                "usuario_name"=>"",
            
                "labelbtnsubmit"=>"Cadastrar usuário",
            
                "auxusuario"=>"",
            
                "usuario_id"=>"",
            
                "auxsenha"=>"required"
            )
           );

        $app->loadView("Admin",$param);
    }

    function execInsertUsuario($app){
        
        $admin = $app->loadModel("Admin");

        $usuario = tStr($_POST["usuario"]);
        
        $nome = tStr($_POST["nome"]);
        
        $senha = tStr(md5($_POST["senha"]));
        

        $obj = $admin->insertUsuario($app->connection, $usuario, $nome, $senha);

        if($obj) {
            $mensagem = "Cadastro efetuado com sucesso!";
        } else {
            $mensagem = "Cadastro falhou!";
        }

        $this->listUsuarios($app,$admin,$mensagem);
    }
    
    function viewUsuario($app){
        
        $usuario_id = (int)$_GET["id"];

        $admin = $app->loadModel("Admin");

        $obj = $admin->getUserId($app->connection, $usuario_id);
        
        $posts = $admin->getUserAllPosts($app->connection, $usuario_id);
        
        $param = array(
            
            "title"=>$app->site_title, 
            
            "page" => "viewusuario",
            
            "dados" => array(
            
                 "tituloform" => "Visualizar usuário",
             
                 "usuario_user"=>$obj["usuario_user"],
            
                 "usuario_name"=>$obj["usuario_name"],
            
                 "usuario_pass"=>$obj["usuario_pass"],
            
                 "posts"=>$posts
            
                 /*"post_title"=>$posts["post_title"],
            
                 "categoria_title"=>$posts["categoria_title"],
            
                 "post_creation"=>$posts["post_creation"],
            
                 "post_url"=>$posts["post_url"]*/
            
            )
        );

        $app->loadView("Admin",$param);
    }
}