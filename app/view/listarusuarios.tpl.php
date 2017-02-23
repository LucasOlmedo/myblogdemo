<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<div class="container marginTop">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?r=admin&c=usuarios&a=insertUsuario" class="btn btn-primary btn-large">Cadastrar novo usuário</a>
			
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
						<th>ID</th>
						<th>Usuários</th>
						<th>Nome</th>
						<th colspan="3">Opções</th>
					</tr>
				</thead>
				
				<tbody>
					<?php foreach($tpl["dados"]["usuarios"] as $usuario) { ?>
										
					<tr>
						<td width="150"><?=$usuario["usuario_id"]?></td>
						<td width="250"><?=$usuario["usuario_user"]?></td>
						<td width="350"><?=$usuario["usuario_name"]?></td>
                        <td>
							<a href="index.php?r=admin&c=usuarios&a=viewUsuario&id=<?=$usuario["usuario_id"]?>" class="btn btn-warning">Ver</a>
						</td>
						<td>
							<a href="index.php?r=admin&c=usuarios&a=updateUsuario&id=<?=$usuario["usuario_id"]?>" class="btn btn-primary">Alterar</a>
						</td>
						<td>
							<a href="index.php?r=admin&c=usuarios&a=deleteUsuario&id=<?=$usuario["usuario_id"]?>" class="btn btn-danger" onclick="return confirm('Deseja realmente excluir o registro?')">Excluir</a>
						</td>
					</tr>
					
					<?php } ?>
				</tbody>
				
			</table>
		
		</div>
	</div>
</div>