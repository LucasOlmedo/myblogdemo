<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title><?=$tpl['title']?></title>
    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
	 <link href="assets/css/blog.css" rel="stylesheet">
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
  </head>
  <body>
   <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item " href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a>
          <a class="blog-nav-item" href="index.php?r=contact"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Fale Conosco</a>
          <div class="pull-right">
              <?php if(@session_start()){ ?>
					<?="<span class=\"label label-danger\" style=\"margin:8px;\">".@$_SESSION["usuario_name"]."</span>"?>
              <?php }?>
                <a class="blog-nav-item" href="index.php?r=admin"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Área restrita</a>
          </div>
        </nav>
      </div>
    </div>

	<div class="container">
		<div class="blog-header">
			<h1 class="blog-title">MyBlog!</h1>
			<p class="lead blog-description">Projeto de blog desenvolvido para demonstração. Não comercial.</p>
		</div>
	</div>

	 <?php include($tpl['page'].".tpl.php"); ?>

	 <div class="blog-footer">
		<p>Desenvolvido por Lucas Olmedo Silva - Todos os direitos reservados. ©</p>
	 </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>
  </body>
</html>