<?php

class ClienteDAO {

    private $pdo;

    function ClienteDAO($conn){
        $this->$pdo = $conn;
    }

    function add($cliente){

        $sql = 'INSERT INTO tab_clientes (nome, email, cpf, data_nascimento, telefone, celular, status, foto)
							   VALUES(:nome, :email, :cpf, :data_nascimento, :telefone, :celular, :status, :foto)';

			$stm =$this->$pdo->prepare($sql);
			$stm->bindValue(':nome', $cliente->nome);
			$stm->bindValue(':email', $cliente->email);
			$stm->bindValue(':cpf', $cliente->cpf);
			$stm->bindValue(':data_nascimento', $cliente->data_ansi);
			$stm->bindValue(':telefone', $cliente->telefone);
			$stm->bindValue(':celular', $cliente->celular);
			$stm->bindValue(':status', $cliente->status);
			$stm->bindValue(':foto', $cliente->nome_foto);
			$retorno = $stm->execute();
    return $retorno;
    }

    function edit($cliente){

        $sql = 'UPDATE tab_clientes SET nome=:nome, email=:email, cpf=:cpf, data_nascimento=:data_nascimento, telefone=:telefone, celular=:celular, status=:status, foto=:foto ';
			$sql .= 'WHERE id = :id';

			$stm = $this->$pdo->prepare($sql);
			$stm->bindValue(':nome', $cliente->nome);
			$stm->bindValue(':email', $cliente->email);
			$stm->bindValue(':cpf', $cliente->cpf);
			$stm->bindValue(':data_nascimento', $cliente->data_ansi);
			$stm->bindValue(':telefone', $cliente->telefone);
			$stm->bindValue(':celular', $cliente->celular);
			$stm->bindValue(':status', $cliente->status);
			$stm->bindValue(':foto', $cliente->nome_foto);
			$stm->bindValue(':id', $cliente->id);
			$retorno = $stm->execute();
    return $retorno;        
    }

    function delete($id){
		$sql = 'DELETE FROM tab_endereco WHERE tab_cliente_id = :tab_cliente_id';
		$stm = $this->$pdo->prepare($sql);
		$stm->bindValue(':tab_cliente_id', $id);
		$retorno =  $stm->execute();
        
		if ($retorno):
			$sql = 'DELETE FROM tab_clientes WHERE id = :id';
			$stm = $this->$pdo->prepare($sql);
			$stm->bindValue(':id', $id);
			$retorno = $stm->execute();
		endif;
	return $retorno;
    }

	function deleteFoto($id){

		$sql = "SELECT foto FROM tab_clientes WHERE id = :id AND foto <> 'padrao.jpg'";
		$stm = $this->$pdo->prepare($sql);
		$stm->bindValue(':id', $id);
		$stm->execute();
		$cliente = $stm->fetch(PDO::FETCH_OBJ);
     	if (!empty($cliente) && file_exists('fotos/'.$cliente->foto)):
			unlink("fotos/" . $cliente->foto);
		endif;

    }

}



?>