<div class="container marginTop">
	<div class="row">
		<div class="col-xs-12">
			<div class="well well-small">
				<h4><?=$tpl["dados"]["tituloform"]?></h4>
			</div>
		</div>
	</div>
	<form enctype="multipart/form-data" method="POST" action="index.php?r=admin&c=imagens&a=<?=$tpl["dados"]["action"]?>">

		<?php if($tpl["dados"]["imagem_id"] == "") { ?>
		<div class="row">
			<div class="col-xs-3">
					<strong>Selecione uma imagem:</strong>
			</div>
			<div class="col-xs-9">
					<input type="file" name="arquivo" required />
					<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
			</div>
		</div>
		<?php } ?>

		<div class="row marginTop">
			<div class="col-xs-3">
					<strong>Legenda da imagem:</strong>
			</div>
			<div class="col-xs-9">
					<input type="text" name="imagem_subtitle" class="col-xs-12 form-control" value="<?=$tpl["dados"]["imagem_subtitle"]?>" autofocus />
			</div>
		</div>

        <input type="hidden" name="imagem_featured" value="1" />

		<div class="row marginTop">
			<div class="col-xs-2">
					<input type="submit" value="<?=$tpl["dados"]["labelbtnsubmit"]?>" class="btn btn-primary btn-large" />
			</div>
		</div>
        <br>
		<input type="hidden" value="<?=$tpl["dados"]["imagem_id"]?>" name="imagem_id" />
		<input type="hidden" value="<?=$tpl["dados"]["post_id"]?>" name="post_id" />
	</form>
</div>