<?php
require 'conexao.php';
require 'endereco.php';
require 'enderecoDAO.php';

// Recebe o id do cliente do cliente via GET
$id_cliente = (isset($_GET['id'])) ? $_GET['id'] : '';
$id_endid = (isset($_GET['endid'])) ? $_GET['endid'] : '';

// Valida se existe um id e se ele é numérico
if (!empty($id_cliente) && is_numeric($id_cliente)):

	// Captura os dados do cliente solicitado
	$conexao = conexao::getInstance();
	$sql = 'SELECT id, nome, email, cpf, data_nascimento, telefone, celular, status, foto FROM tab_clientes WHERE id = :id';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(':id', $id_cliente);
	$stm->execute();
	$cliente = $stm->fetch(PDO::FETCH_OBJ);

	if(!empty($cliente)):

		// Formata a data no formato nacional
		$array_data     = explode('-', $cliente->data_nascimento);
		$data_formatada = $array_data[2] . '/' . $array_data[1] . '/' . $array_data[0];
		
		if (!empty($id_endid) ): 
			// Exclui o registro do banco de dados
			$enderecoDAO = new EnderecoDAO($conexao);
			$enderecoDAO->delete($id_endid);
			
			//echo  "Codigo:" .$id_endid;
			//$sql = 'DELETE FROM tab_endereco WHERE id = :id';
			//$stm = $conexao->prepare($sql);
			//$stm->bindValue(':id', $id_endid);
			//$retorno = $stm->execute();
		endif;

		$sql = 'SELECT id, endereco,bairro,cep,cidade,estado FROM tab_endereco WHERE tab_cliente_id = :id';
		$stm = $conexao->prepare($sql);
		$stm->bindValue(':id', $id_cliente);
		$stm->execute();
		$enderecos = $stm->fetchAll(PDO::FETCH_OBJ);
	    
		$row = 1 ;

	endif;

endif;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Edição de Cliente</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
	<div class='container'>
		<fieldset>
			<legend><h1>Formulário - Edição de Cliente</h1></legend>
			
			<?php if(empty($cliente)):?>
				<h3 class="text-center text-danger">Cliente não encontrado!</h3>
			<?php else: ?>
				<form action="action_cliente.php" method="post" id='form-contato' enctype='multipart/form-data'>
					<div class="row">
						<label for="nome">Alterar Foto</label>
				      	<div class="col-md-2">
						    <a href="#" class="thumbnail">
						      <img src="fotos/<?=$cliente->foto?>" height="190" width="150" id="foto-cliente">
						    </a>
					  	</div>
					  	<input type="file" name="foto" id="foto" value="foto" >
				  	</div>

				    <div class="form-group">
				      <label for="nome">Nome</label>
				      <input type="text" class="form-control" id="nome" name="nome" value="<?=$cliente->nome?>" placeholder="Infome o Nome">
				      <span class='msg-erro msg-nome'></span>
				    </div>

				    <div class="form-group">
				      <label for="email">E-mail</label>
				      <input type="email" class="form-control" id="email" name="email" value="<?=$cliente->email?>" placeholder="Informe o E-mail">
				      <span class='msg-erro msg-email'></span>
				    </div>

				    <div class="form-group">
				      <label for="cpf">CPF</label>
				      <input type="cpf" class="form-control" id="cpf" maxlength="14" name="cpf" value="<?=$cliente->cpf?>" placeholder="Informe o CPF">
				      <span class='msg-erro msg-cpf'></span>
				    </div>
				    <div class="form-group">
				      <label for="data_nascimento">Data de Nascimento</label>
				      <input type="data_nascimento" class="form-control" id="data_nascimento" maxlength="10" value="<?=$data_formatada?>" name="data_nascimento">
				      <span class='msg-erro msg-data'></span>
				    </div>
				    <div class="form-group">
				      <label for="telefone">Telefone</label>
				      <input type="telefone" class="form-control" id="telefone" maxlength="12" name="telefone" value="<?=$cliente->telefone?>" placeholder="Informe o Telefone">
				      <span class='msg-erro msg-telefone'></span>
				    </div>
				    <div class="form-group">
				      <label for="celular">Celular</label>
				      <input type="celular" class="form-control" id="celular" maxlength="13" name="celular" value="<?=$cliente->celular?>" placeholder="Informe o Celular">
				      <span class='msg-erro msg-celular'></span>
				    </div>
				    <div class="form-group">
				      <label for="status">Status</label>
				      <select class="form-control" name="status" id="status">
					    <option value="<?=$cliente->status?>"><?=$cliente->status?></option>
					    <option value="Ativo">Ativo</option>
					    <option value="Inativo">Inativo</option>
					  </select>
					  <span class='msg-erro msg-status'></span>
				    </div>
					<!--Endereco -->
					<input type="button" name="acao" value="+ Endereço"  class="btn btn-primary" onclick= "addTableRow()">
					<div class="table-responsive">
							<table class="table table-bordered" id= "tbl_endereco">
							<thead>
								<tr>
								<th>#</th>
								<th>Endereço</th>
								<th>Bairro</th>
								<th>CEP</th>
								<th>Cidade</th>
								<th>Estado</th>
								<th>Ações</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($enderecos as $endereco):?>
								<tr>
									<td><?=$row++?>
									<input type="hidden" name="end_id___<?=$row?>" id= "end_id___<?=$row?>" value="<?=$endereco->id?>">
									</td>		    
									<td><input type="text" class="form-control" id="endereco___<?=$row?>" name="endereco___<?=$row?>" value="<?=$endereco->endereco?>"> </td>
									<td><input type="text" class="form-control" id="bairro___<?=$row?>" name="bairro___<?=$row?>"    value="<?=$endereco->bairro?>"> </td>	    
									<td><input type="text" class="form-control" id="cep___<?=$row?>" name="cep___<?=$row?>"          value="<?=$endereco->cep?>">  </td>	    
									<td><input type="text" class="form-control" id="cidade___<?=$row?>" name="cidade___<?=$row?>"    value="<?=$endereco->cidade?>"> </td>
									<td>
										<input type="text" class="form-control" id="estado___<?=$row?>" name="estado___<?=$row?>"   value="<?=$endereco->estado?>"> 
										
									 </td>		    
									<td>
									<button onclick="RemoveTableRow(this)" type="button" end-id= "<?=$endereco->id?>"  class="btn btn-danger" >Remover</button>	    
									</td>
								 <tr>	
							<?php endforeach;?>
							</tbody>
							</table>
					</div>		

					
				    <input type="hidden" name="acao" value="editar">
				    <input type="hidden" name="id" value="<?=$cliente->id?>">
				    <input type="hidden" name="foto_atual" value="<?=$cliente->foto?>">
				    <button type="submit" class="btn btn-primary" id='botao'> 
				      Gravar
				    </button>
				    <a href='index.php' class="btn btn-danger">Cancelar</a>
				</form>
			<?php endif; ?>
		</fieldset>

	</div>
	<script type="text/javascript" src="js/custom.js"></script>
</body>
</html>