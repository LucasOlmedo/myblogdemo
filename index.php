<?php

/*
    Área de requisição para arquivos obrigatórios
*/

require_once "libs/functions.php";
require_once "application.php";

/*
    Configurações de cache
*/

header("Expires: Mon, 21 Out 1999 00:00:00 GMT");
header("Cache-control: no-cache");
header("Pragma: no-cache");

/*
    Variável 'route' será utilizada para fazer a indexação.

    'route' armazena o valor de 'r', que será passada pela URL e capturada via GET.
    Dependendo do valor de 'r', o site redireciona para o módulo selecionado.

    Caso a variável não esteja setada, o seu valor padrão é 'default'.
*/

$route = (isset($_GET["r"])) ? tStr($_GET['r']) : "incial";

/*
    Estrutura de controle dos módulos do site.

    Páginas no site:

    - Login (Área restrita);

    - Dashboard (usuário logado);
    - Controle de posts (usuário logado);
    - Controle de usuários  (usuário logado);
    - Controle de categorias  (usuário logado);

    - Página inicial/postagens (Público);
    - Formulário de contato (Público);

    Switch na variável 'route', com cada módulo do site e o 'default' sendo a Página inicial.
*/

switch($route){

    case "admin" :

        $app = new App();

		/*
            Sessão iniciada
        */

        session_start();

        /*
            Verifica se o usuário está com sessão ativa.
            Caso sim, a tela do dashboard é renderizada, senão, a tela de login é renderizada.
        */

        if(isset($_SESSION["user"])){

            /*
                A variável 'comp' é um componente para acessar um módulo menor dentro do principal.
                A variável 'action' é uma ação dentro de um componente.
            */

            $comp = (isset($_GET['c'])) ? tStr($_GET['c']) : null;
            $action = (isset($_GET['a'])) ? tStr($_GET['a']) : null;

            switch ($comp) {

                case "usuarios" :

                    /*
                        Inclui o controle de usuários e uma nova instância.
                    */

                    include("app/controller/usuario.class.php");

                    $usuario = new Usuario();

                    if($action!=null){
                        $usuario->$action($app);
                    } else {
                        $usuario->listUsuarios($app);
                    }

                    break;

                case "categorias" :

                    /*
                        Inclui o controle de categorias e uma nova instância.
                    */

                    include("app/controller/categoria.class.php");

                    $categorias = new Categoria();

                    if($action!=null){
                        $categorias->$action($app);
                    } else {
                        $categorias->listCategorias($app);
                    }

                    break;

                case "posts" :

                    include("app/controller/post.class.php");

                    $post = new Post();

                    if($action!=null){
                        $post->$action($app);
                    } else {
                        $post->listPosts($app);
                    }

                    break;

                case "imagens" :

                    include("app/controller/imagem.class.php");

                    $imagem = new Imagem();

                    if($action!=null){
                        $imagem->$action($app);
                    } else {
                        $imagem->listImagens($app,(int)$_GET["id"]);
                    }

                    break;

                default :

                    renderAdminHome($app);

                    break;
				}

        } else {
            renderLogin($app);
        }

        break;

    case "doLogin":

        $app = new App();

        $admin = $app->loadModel("Admin");

        /*
            Os valores dos campos do formulário chegam por POST.
            É aplicado um hash md5 no valor capturado pelo campo 'senha' para comparar com os dados do banco.
        */

        $usuario = tStr($_POST["user"]);

        $senha = md5(tStr($_POST["pass"]));

        /*
            Aqui é a consulta que verifica se o usuário digitado é equivalente aos dados no banco.
        */

        $obj = $admin->getUsuarioLoginSenha($app->connection, $usuario, $senha);

        if($obj){

            /*
                Caso for equivalente, então inicia-se a sessão.
                A tela de dashboard é renderizada.
            */

            session_start();

            $_SESSION["usuario_id"] = $obj->usuario_id;
            $_SESSION["user"] = $obj->usuario_user;
            $_SESSION["usuario_name"] = $obj->usuario_name;

            renderAdminHome($app);

        } else {

            /*
                Caso não for equivalente, então é exibido um alert e a tela de login é renderizada novamente.
            */

            echo "<script>alert('Login ou senha incorreto(s)');</script>";

            renderLogin($app);
        }
        break;

    case "logout" :

        $app = new App();

        /*
            Quando entra nessa rota, a sessão é destruída e o usuário é deslogado.
        */

        session_start();
        session_destroy();

        echo "<script>alert('Seu usuário foi desconectado.');</script>";

        /*
            Após isso, é renderizada para a página principal.
        */

        $app = new App();

        $site = $app->loadModel("Site");

        /*
            PDO para carregar os posts.
        */

        $obj = $site->listPost($app->connection, 0);
        $posts = $obj->fetchAll(PDO::FETCH_ASSOC);

        /*
            PDO para carregar as categorias.
        */

        $obj = $site->listCategoria($app->connection);
        $categorias = $obj->fetchAll(PDO::FETCH_ASSOC);

        renderHomePage($app, $categorias, $posts);

        break;

    case "contact":

        $app = new App();

        $site = $app->loadModel("Site");

        $msg = "";

        $class = "";

        /*
            Inicia o envio do formulario.
        */

        if(isset($_POST["frm_enviar"])){

            /*
                Passagem dos parâmetros: Nome, E-mail do remetente e mensagem.
            */

            $name = tStr($_POST["nome"]);
            $email = tStr($_POST["email"]);
            $text = $_POST["mensagem"];

            /*
                Headers e como a mensagem chegará.
            */

            $headers='';
            $headers.="MIME-Version: 1.0 \r\n";
            $headers.="Content-type: text/html; charset=\"UTF-8\" \r\n";
            $headers.= "From: ".$name." <".$email.">";

            $msg  = "Nome: ".$name."<br/>";
            $msg .= "Email: ".$email."<br/>";
            $msg .= "Mensagem: ".$text;

            include("libs/smtp/SMTPconfig.php");
            include("libs/smtp/SMTPclass.php");

            /*
                Servidor, Porta, Usuario, Senha, FROM (DE), TO (PARA), titulo, mensagem, headers
            */

            $SMTPMail = new SMTPClient(
                                        $SmtpServer,
                                        $SmtpPort,
                                        $SmtpUser,
                                        $SmtpPass,
                                        $SmtpUser,
                                        $SmtpUser,
                                        "E-mail enviado atraves do site",
                                        $msg,
                                        $headers
                                    );

            /*
                O envio é verificado e retorna uma das mensagens abaixo.
            */

            if($SMTPMail->SendMail()){
                $msg = "O Email foi enviado com sucesso!";
                $class = "alert-success";
            } else {
                $msg = "O email falhou!";
                $class = "alert-danger";
            }
        }

        $obj = $site->listCategoria($app->connection);
        $categorias = $obj->fetchAll(PDO::FETCH_ASSOC);

        /*
            Após o envio, a página é renderizada novamente.
            'msg' retorna se o envio falhou ou não, e 'class' retorna a classe a ser adicionada no html.
        */

        renderContact($app, $msg, $class, $categorias);

        break;

    case "post":

        $app = new App();

        $site = $app->loadModel("Site");

        /*
            Pega o post com url amigável, usando uma função que previne SQL Injection.
        */

        $url = tStr($_GET['url']);

        /*
            Pega os dados do post, listando também as imagens contidas nele.
        */

        $post = $site->getPost($app->connection, $post_id = null, $url);

        $obj = $site->listImagemPost($app->connection, $post->post_id, "0");
        $imagem = $obj->fetchAll(PDO::FETCH_ASSOC);

        /*
            Retorna uma lista de categorias.
        */

        $obj = $site->listCategoria($app->connection);
        $categorias = $obj->fetchAll(PDO::FETCH_ASSOC);

        renderSinglePost($app, $categorias, $post, $imagem);

        break;

    case "categoria":

        $app = new App();

        $site = $app->loadModel("Site");

        /*
            PDO para carregar os posts.
        */

        $obj = $site->listPost($app->connection, "0", (int)$_GET['id']);
        $posts = $obj->fetchAll(PDO::FETCH_ASSOC);

        /*
            PDO para carregar as categorias.
        */

        $obj = $site->listCategoria($app->connection);
        $categorias = $obj->fetchAll(PDO::FETCH_ASSOC);

        renderHomePage($app, $categorias, $posts);

        break;

    default:

        $app = new App();

        $site = $app->loadModel("Site");

        /*
            PDO para carregar os posts.
        */

        $obj = $site->listPost($app->connection, 0);
        $posts = $obj->fetchAll(PDO::FETCH_ASSOC);

        /*
            PDO para carregar as categorias.
        */

        $obj = $site->listCategoria($app->connection);
        $categorias = $obj->fetchAll(PDO::FETCH_ASSOC);

        renderHomePage($app, $categorias, $posts);

        break;
}

/*
    Funções de renderização para as páginas do blog.
*/

function renderHomePage($app, $categorias, $posts){
    $param = array(
        "title" => $app->site_title,
        "page" => "inicial",
        "inicial" => array(
            "posts" => $posts,
            "categorias" => $categorias,
        )
    );

    $app->loadView("Site", $param);
}

function renderSinglePost($app, $categorias, $post, $imagem){
    $param = array(
        "title" => $app->site_title,
        "page" => "verpost",
        "verpost" => array(
            "post" => $post,
            "categorias" => $categorias,
            "imagem" => $imagem
        )
    );

    $app->loadView("Site", $param);
}

function renderContact($app, $msg, $class, $categorias){
     $param = array(
        "title"=>$app->site_title,
        "page" => "contato",
        "contato" => array(
            "msg" => $msg,
            "class"=> $class,
            "categorias" => $categorias,
        )
    );

    $app->loadView("Site",$param);
}

function renderAdminHome($app){

		$site = $app->loadModel("Site");

		$obj = $site->listPost($app->connection);

		$posts = $obj->fetchAll(PDO::FETCH_ASSOC);

		$param = array("title"=>$app->site_title,
					   "page" => "inicialadmin",
					   "dados" => array(
						"posts" => $posts
					   )
				);

		$app->loadView("Admin",$param);

	}

function renderLogin($app){

    $param = array("title"=>$app->site_title);

    $app->loadView("Login",$param);

}