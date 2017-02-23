<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<div class="container marginTop">
	<div class="row">
		<div class="col-xs-12">
			<div class="well well-small">
				<h4><?=$tpl["dados"]["tituloform"]?></h4>
			</div>
		</div>
	</div>
		<div class="row">
			<div class="col-xs-2">
				<strong>Usuário:</strong>
			</div>
			<div class="col-xs-10">
				<?=$tpl["dados"]["usuario_user"]?>
			</div>
		</div>
		<div class="row marginTop">
			<div class="col-xs-2">
				<strong>Nome:</strong>
			</div>
			<div class="col-xs-10">
				<?=$tpl["dados"]["usuario_name"]?>
			</div>
		</div>
    <div class="row marginTop">
			<div class="col-xs-5">
				<strong>Postagens escritas:</strong>
			</div>
			<div class="col-lg-12">
				<table class="table table-striped table-bordered table-hover marginTop">
				<thead>
					<tr>
						<th>Título do post</th>
						<th width="200">Categoria</th>
						<th>Data de criação</th>
						<th>Opções</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($tpl["dados"]["posts"] as $post) { ?>

					<tr>
						<td width="350"><?=$post["post_title"]?></td>
						<td width="150"><?=$post["categoria_title"]?></td>
						<td width="300"><?=$post["post_creation"]?></td>
                        <td>
							<a href="index.php?r=post&url=<?=$post["post_url"]?>" class="btn btn-success">Ir ao post</a>
						</td>
					</tr>

					<?php } ?>
				</tbody>

			</table>

			</div>
    </div>
		<div class="row marginTop">
			<div class="col-xs-2">
					<a href="index.php?r=admin&c=usuarios"><input type="button" value="Voltar" class="btn btn-primary btn-large"/></a>
			</div>
		</div>
        <br>
</div>