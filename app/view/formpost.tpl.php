<script src="tinymce/js/tinymce/tinymce.min.js"></script>
<script language="javascript" type="text/javascript">
        tinymce.init({
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern jbimages"
            ],
            toolbar1: "jbimages insertfile undo redo bold italic alignleft aligncenter alignright alignjustify bullist numlist outdent indent link media forecolor backcolor emoticons",
            relative_urls: false
        });
</script>
<div class="container marginTop">
	<div class="row">
		<div class="col-xs-12">
			<div class="well well-small">
				<h4><?=$tpl["dados"]["tituloform"]?></h4>
			</div>
		</div>
	</div>

	<?php if($tpl["dados"]["post_creation"] != ""){ ?>
		<div class="row">
			<div class="col-xs-12">
				<div class="alert alert-info">
					Post criado em <?=$tpl["dados"]["post_creation"]?> por <?=$tpl["dados"]["usuario_name"]?>.
				</div>
			</div>
		</div>
	<?php } ?>

	<form  enctype="multipart/form-data" method="POST" action="index.php?r=admin&c=posts&a=<?=$tpl["dados"]["action"]?>">
		<div class="row">
			<div class="col-xs-2">
					<strong>Título do post:</strong>
			</div>
			<div class="col-xs-10">
					<input type="text" name="post_title" class="col-xs-12 form-control" value="<?=$tpl["dados"]["post_title"]?>" autofocus required />
			</div>
		</div>

		<div class="row marginTop">
			<div class="col-xs-2">
					<strong>Data da postagem:</strong>
			</div>
			<div class="col-xs-10">
					<input type="text" name="post_date" class="col-xs-12 form-control" value="<?=$tpl["dados"]["post_date"]?>" placeholder="<?=$tpl["dados"]["auxPostData"]?>" required />
			</div>
		</div>

        <div class="row marginTop">
			<div class="col-xs-2">
					<strong>Texto:</strong>
			</div>
			<div class="col-xs-10">
				<textarea cols="126" rows="20" id="post_text" name="post_text">
                    <?=$tpl["dados"]["post_text"]?>
                </textarea>
            </div>
		</div>

		<div class="row marginTop">
			<div class="col-xs-2">
					<strong>Bloqueado?</strong>
			</div>
			<div class="col-xs-10">
				<label>
					<input type="radio" name="post_blocked" value="1" <?php if($tpl["dados"]["post_blocked"] == 1) echo "checked"; ?>> Sim
				</label>
				<label>
					<input type="radio" name="post_blocked" value="0" <?php if($tpl["dados"]["post_blocked"] == 0) echo "checked"; ?>> Não
				</label>
			</div>
		</div>

		<div class="row marginTop">
			<div class="col-xs-2">
					<strong>Categoria:</strong>
			</div>
			<div class="col-xs-10">
				<select name="post_categoria_id" class="form-control" title="post_categoria_id">
					<?php foreach($tpl["dados"]["categorias"] as $cat){?>
						<option value="<?=$cat["categoria_id"]?>" <?php if($cat["categoria_id"] == $tpl["dados"]["post_categoria_id"]) echo ' selected="selected" '; ?>><?=$cat["categoria_title"]?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="row marginTop">
			<div class="col-xs-2">
					<input type="submit" value="<?=$tpl["dados"]["labelbtnsubmit"]?>" class="btn btn-primary btn-large" />
			</div>
		</div>
        <br>
		<input type="hidden" value="<?=$tpl["dados"]["post_id"]?>" name="post_id" />
	</form>
</div>