<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Selecionar todos os usuários
$app->get('/api/usuario/select', function(Request $request, Response $response){
	$sql = "SELECT * FROM usuarios";

	try{
		//Instanciar o Objeto db (Database)
		$db = new db();
		//Conectar ao DB
		$db = $db->connection();

		$stmt = $db->query($sql);
		$usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($usuarios);

	}catch(PDOException $ex){
		echo '{"error":{"text": '.$ex->getMessage().'}';
	}
});

//Selecionar apenas um usuário
$app->get('/api/usuario/select/{id}', function(Request $request, Response $response){

	$id = $request->getAttribute('id');

	$sql = "SELECT * FROM usuarios WHERE id = $id";

	try{
		//Instanciar o Objeto db (Database)
		$db = new db();
		//Conectar ao DB
		$db = $db->connection();

		$stmt = $db->query($sql);
		$usuario = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($usuario);

	}catch(PDOException $ex){
		echo '{"error":{"text": '.$ex->getMessage().'}';
	}
});

//Adicionar usuário
$app->post('/api/usuario/add', function(Request $request, Response $response){

	$nome            = $request->getParam('nome');
	$email           = $request->getParam('email');
	$senha           = $request->getParam('senha');
	$id_tipo_usuario = $request->getParam('id_tipo_usuario');

	$sql = "INSERT INTO usuarios (nome, email, senha, id_tipo_usuario) VALUES (:nome,:email,:senha,:id_tipo_usuario)";

	try{
		//Instanciar o Objeto db (Database)
		$db = new db();
		//Conectar ao DB
		$db = $db->connection();

		$stmt = $db->prepare($sql);
		$stmt->bindParam(':nome',            $nome);
		$stmt->bindParam(':email',           $email);
		$stmt->bindParam(':senha',           $senha);
		$stmt->bindParam(':id_tipo_usuario', $id_tipo_usuario);

		$stmt->execute();

		echo '{"notice": {"text": "Usuário Cadastrado"}';

	}catch(PDOException $ex){

		echo '{"error":{"text": '.$ex->getMessage().'}';
	}
});

//Atualizar usuário
$app->put('/api/usuario/atualizar/{id}', function(Request $request, Response $response){
	$id              = $request->getAttribute('id');
	$nome            = $request->getParam('nome');
	$email           = $request->getParam('email');
	$senha           = $request->getParam('senha');
	$id_tipo_usuario = $request->getParam('id_tipo_usuario');

	$sql = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, id_tipo_usuario = :id_tipo_usuario WHERE id = $id";

	try{
		//Instanciar o Objeto db (Database)
		$db = new db();
		//Conectar ao DB
		$db = $db->connection();

		$stmt = $db->prepare($sql);

		$stmt->bindParam(':nome',            $nome);
		$stmt->bindParam(':email',           $email);
		$stmt->bindParam(':senha',           $senha);
		$stmt->bindParam(':id_tipo_usuario', $id_tipo_usuario);

		$stmt->execute();

		echo '{"notice": {"text": "Usuário Atualizado"}';

	}catch(PDOException $ex){

		echo '{"error":{"text": '.$ex->getMessage().'}';
	}
});

//Deletar usuário
$app->delete('/api/usuario/deletar/{id}', function(Request $request, Response $response){

	$id = $request->getAttribute('id');

	$sql = "DELETE FROM usuarios WHERE id = $id";

	try{
		//Instanciar o Objeto db (Database)
		$db = new db();
		//Conectar ao DB
		$db = $db->connection();

		$stmt = $db->prepare($sql);
		$stmt->execute();
		$db = null;

		echo '{"notice": {"text": "Usuário Deletado"}';

	}catch(PDOException $ex){
		echo '{"error":{"text": '.$ex->getMessage().'}';
	}
});

