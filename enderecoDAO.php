<?php

class EnderecoDAO {

    private $pdo;

    function EnderecoDAO($conn){
        $this->$pdo = $conn;
    }

    function add($endereco){

        $sql = 'INSERT INTO tab_endereco (tab_cliente_id, endereco, bairro, cep, cidade ,estado)
        VALUES(:tab_cliente_id, :endereco, :bairro, :cep, :cidade ,:estado)';
			
            $stm = $this->$pdo->prepare($sql);
			$stm->bindValue(':tab_cliente_id', $endereco->clienteId);
			$stm->bindValue(':endereco', $endereco->endereco);
			$stm->bindValue(':bairro', $endereco->bairro);
			$stm->bindValue(':cep', $endereco->cep);
			$stm->bindValue(':cidade', $endereco->cidade);
			$stm->bindValue(':estado', $endereco->estado);
			try{
                $retorno = $stm->execute();
            }catch(PDOException $e){
                echo $e->getMessage();
            }
			
    return $retorno;
    }

    function edit($endereco){

        $sql = 'UPDATE tab_endereco SET  endereco= :endereco, bairro= :bairro, cep= :cep, cidade= :cidade, estado= :estado ';
        $sql .= 'WHERE id = :id';
    
        $stm = $this->$pdo->prepare($sql);
       $stm->bindValue(':endereco', $endereco->endereco);
        $stm->bindValue(':bairro', $endereco->bairro);
        $stm->bindValue(':cep', $endereco->cep);
        $stm->bindValue(':cidade', $endereco->cidade);
        $stm->bindValue(':estado', $endereco->estado);
        $stm->bindValue(':id', $endereco->id);
        try{
            $retorno = $stm->execute();
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    return $retorno;        
    }

    function delete($id){

        $sql = 'DELETE FROM tab_endereco WHERE id = :id';
		$stm = $this->$pdo->prepare($sql);
		$stm->bindValue(':id', $id);
		$retorno = $stm->execute();

    }

}



?>