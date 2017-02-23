<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<div class="container marginTop">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?r=admin&c=categorias&a=insertCategoria" class="btn btn-primary btn-large">Cadastrar nova categoria</a>
			
			<?php if($tpl["dados"]["msg"] != "") { ?>
				<div class="alert alert-info alert-dismissible marginTop" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong><?=$tpl["dados"]["msg"]?></strong>
				</div>
			<?php } ?>
			
			<table class="table table-striped table-bordered table-hover marginTop">
				<thead>
					<tr>
						<th width="150">ID</th>
						<th width="650">Nome Categoria</th>
						<th colspan="2">Opções</th>
					</tr>
				</thead>
				
				<tbody>
					<?php foreach($tpl["dados"]["categorias"] as $categoria) { ?>
										
					<tr>
						<td><?=$categoria["categoria_id"]?></td>
						<td><?=$categoria["categoria_title"]?> <span class="badge"><?=$categoria["numeroposts"]?></span></td>
						<td>
							<a href="index.php?r=admin&c=categorias&a=updateCategoria&id=<?=$categoria["categoria_id"]?>" class="btn btn-primary">Alterar</a>
						</td>
						<td>
							<a href="index.php?r=admin&c=categorias&a=deleteCategoria&id=<?=$categoria["categoria_id"]?>" class="btn btn-danger" onclick="return confirm('Deseja realmente excluir o registro?')">Excluir</a>
						</td>
					</tr>
					
					<?php } ?>
				</tbody>
				
			</table>
		
		</div>
	</div>
</div>