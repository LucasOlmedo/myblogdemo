<meta http-equiv="content-type" content="text/html" charset="utf-8" />
<div class="container marginTop">
	<div class="row">
		<div class="col-xs-12">
			<div class="well well-small">
				<h4><?=$tpl["dados"]["tituloform"]?></h4>
			</div>
		</div>
	</div>
	<form method="POST" action="index.php?r=admin&c=categorias&a=<?=$tpl["dados"]["action"]?>" accept-charset="utf-8">
		<div class="row">
			<div class="col-xs-2">
					<strong>Nome Categoria:</strong>
			</div>
			<div class="col-xs-10">
					<input type="text" name="categoria_title" class="col-xs-12 form-control" value="<?=utf8_encode($tpl["dados"]["categoria_title"])?>" autofocus required />
			</div>
		</div>
		
		<div class="row marginTop">
			<div class="col-xs-2">
					<input type="submit" value="<?=$tpl["dados"]["labelbtnsubmit"]?>" class="btn btn-primary btn-large" />
			</div>
		</div>
        <br>
		<input type="hidden" value="<?=$tpl["dados"]["categoria_id"]?>" name="categoria_id" />
	</form>
</div>