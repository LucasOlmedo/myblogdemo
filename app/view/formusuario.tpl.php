<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<div class="container marginTop">
	<div class="row">
		<div class="col-xs-12">
			<div class="well well-small">
				<h4><?=$tpl["dados"]["tituloform"]?></h4>
			</div>
		</div>
	</div>
	<form method="POST" action="index.php?r=admin&c=usuarios&a=<?=$tpl["dados"]["action"]?>" accept-charset="utf-8">
		<div class="row">
			<div class="col-xs-2">
					<strong>Usuário:</strong>
			</div>
			<div class="col-xs-10">
					<input type="text" name="usuario" class="col-xs-12 form-control" value="<?=$tpl["dados"]["usuario_user"]?>" <?=$tpl["dados"]["auxusuario"]?> autofocus required />
			</div>
		</div>
		<div class="row marginTop">
			<div class="col-xs-2">
					<strong>Nome:</strong>
			</div>
			<div class="col-xs-10">
					<input type="text" name="nome" class="col-xs-12 form-control" value="<?=$tpl["dados"]["usuario_name"]?>" autofocus required/>
			</div>
		</div>
		
		<div class="row marginTop">
			<div class="col-xs-2">
					<strong>Senha:</strong>
			</div>
			<div class="col-xs-10">
					<input type="password" name="senha" class="col-xs-12 form-control" value="" <?=$tpl["dados"]["auxsenha"]?> />
			</div>
		</div>
		<div class="row marginTop">
			<div class="col-xs-2">
					<input type="submit" value="<?=$tpl["dados"]["labelbtnsubmit"]?>" class="btn btn-primary btn-large" />
			</div>
		</div>
        <br>
		<input type="hidden" value="<?=$tpl["dados"]["usuario_id"]?>" name="usuario_id" />
	</form>
</div>