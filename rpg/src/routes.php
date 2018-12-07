<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
//Grupo de Raças

$app->group('/racas', function() use($app) {
    $app->get('', function(Request $request, Response $response) {
        $sql = "select * from racas;";
        $exec = $this->db->query($sql);
        $retorno = [];
        while($row = $exec->fetch(PDO::FETCH_OBJ)){	
            $retorno[] = $row;
        }
        return $this->renderer->render($response, 'racas/listar.phtml', [
            "dados" => $retorno
        ]);
    });
    $app->get('/cadastrar', function(Request $request, Response $response) {
        return $this->renderer->render($response,  'racas/cadastrar.phtml');

    });
    $app->post('/salvar', function(Request $request, Response $response) {
        $params = $request->getBody()->getContents();
        parse_str($params, $dados);
        $sql = "insert into racas (nome, descricao) values(:nome, :descricao)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nome", $dados['nome']);
        $stmt->bindParam(":descricao", $dados['descricao']);
        $stmt->execute();
        return $response->withRedirect("/racas");
    });
    $app->get('/editar/{id}', function(Request $request, Response $response) {
        $id = $request->getAttribute('id');
        $sql = "select * from racas where id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $raca = $stmt->fetch(PDO::FETCH_OBJ);

        return $this->renderer->render($response, 'racas/editar.phtml', [
            "raca" => $raca
        ]);
    });
    $app->post('/atualizar/{id}', function(Request $request, Response $response) {
        $params = $request->getBody()->getContents();
        parse_str($params, $dados);
        $id = $request->getAttribute('id');
        $sql = "update racas set nome=:nome, descricao=:descricao where id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $dados['nome']);
        $stmt->bindParam(":descricao", $dados['descricao']);
        $stmt->execute();
        return $response->withRedirect("/racas");
    });
    $app->get('/visualizar/{id}', function(Request $request , Response $response) {
        $id = $request->getAttribute('id');
        $sql = "select * from racas where id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $raca = $stmt->fetch(PDO::FETCH_OBJ); 

        return $this->renderer->render($response, 'racas/visualizar.phtml', [
            "raca" => $raca
        ]);
    });
    $app->get('/excluir/{id}', function(Request $request, Response $response) {
        $id = $request->getAttribute('id');
        $sql = "delete from racas where id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $response->withRedirect("/racas");
    });
});

//Grupo de Habilidades

$app->group('/habilidades', function() use($app) {
    $app->get('', function(Request $request, Response $response) {
        $sql = "select * from habilidades;";
        $exec = $this->db->query($sql);
        $retorno = [];
        while($row = $exec->fetch(PDO::FETCH_OBJ)) {
            $retorno[] = $row;
        }
        return $this->renderer->render($response, 'habilidades/listar.phtml', [
            "dados" => $retorno
        ]);
    });
    $app->get('/cadastrar', function(Request $request, Response $response) {
        return $this->renderer->render($response, 'habilidades/cadastrar.phtml');
    });
    $app->post('/salvar', function(Request $request, Response $response) {
        $params = $request->getBody()->getContents();
        parse_str($params, $dados);
        $sql = "insert into habilidades (nome, descricao) values(:nome, :descricao)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nome", $dados['nome']);
        $stmt->bindParam(":descricao", $dados['descricao']);
        $stmt->execute();
        return $response->withRedirect("/habilidades");
    });
    $app->get('/editar/{id}', function(Request $request, Response $response) {
        $id = $request->getAttribute('id');
        $sql = "select * from habilidades where id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $habilidades = $stmt->fetch(PDO::FETCH_OBJ);

        return $this->renderer->render($response, 'habilidades/editar.phtml', [
            "habilidades" => $habilidades
        ]);
    });
    $app->post('/atualizar/{id}', function(Request $request, Response $response) {
        $params = $request->getBody()->getContents();
        parse_str($params, $dados);
        $id = $request->getAttribute('id');
        $sql = "update habilidades set nome=:nome, descricao=:descricao where id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $dados['nome']);
        $stmt->bindParam(":descricao", $dados['descricao']);
        $stmt->execute();
        return $response->withRedirect("/habilidades");
    });
    $app->get('/visualizar/{id}', function(Request $request, Response $response) {
        $id = $request->getAttribute('id');
        $sql = "select * from habilidades where id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $habilidades = $stmt->fetch(PDO::FETCH_OBJ);

        return $this->renderer->render($response, 'habilidades/visualizar.phtml', [
            "habilidades" => $habilidades
        ]);
    });
    $app->get('/excluir/{id}', function(Request $request, Response $response) {
        $id = $request->getAttribute('id');
        $sql = "delete from habilidades where id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $response->withRedirect("/habilidades");
    });
});

//Grupo de personagens

$app->group('/personagens', function() use($app) {
    $app->get('', function(Request $request, Response $response) {
        $sql = "select p.id, p.nome, r.id as id_raca, r.nome as raca 
                from personagens p inner join racas r 
                on p.raca_id = r.id;";
        $exec = $this->db->query($sql);
        $retorno = [];
        $i = 0;
        while($row = $exec->fetch(PDO::FETCH_OBJ)) {
            $sql = "select h.nome
                    from personagens_habilidades ph inner join habilidades h   
                    on ph.habilidade_id = h.id
                    where ph.personagem_id = :id;";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $row->id);
            $stmt->execute();
            $habilidades = $stmt->fetchAll();
            $retorno[$i] = $row;
            $retorno[$i]->habilidades = (object)$habilidades;
            $i++;
        }
        return $this->renderer->render($response, 'personagens/listar.phtml', [
            "dados" => $retorno
        ]);
    });
    $app->get('/visualizar/{id}', function(Request $request, Response $response) {
        $id = $request->getAttribute('id');
        $sql = "select p.id, p.nome, p.peso, p.idade, r.id as id_raca, r.nome as raca 
                from personagens p inner join racas r 
                on p.raca_id = r.id
                where p.id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $personagem = $stmt->fetch(PDO::FETCH_OBJ);
        $sql = "select h.nome
                from personagens_habilidades ph inner join habilidades h   
                on ph.habilidade_id = h.id
                where ph.personagem_id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $habilidades = $stmt->fetchAll();
        
        return $this->renderer->render($response, 'personagens/visualizar.phtml', [
            "personagem" => $personagem,
            "habilidades" => $habilidades
        ]);
    });
    $app->get('/cadastrar', function(Request $request, Response $response) {
        $sql = "select id, nome from racas;";
        $exec = $this->db->query($sql);
        $racas = $exec->fetchAll();
        $sql = "select id, nome from habilidades;";
        $exec = $this->db->query($sql);
        $habilidades = $exec->fetchAll();

        return $this->renderer->render($response, 'personagens/cadastrar.phtml', [
            "racas" => $racas,
            "habilidades" => $habilidades
        ]);
    });
    $app->post('/salvar', function(Request $request, Response $response) {
        $params = $request->getBody()->getContents();
        parse_str($params, $post);
        
        $sql = "insert into personagens(nome, peso, idade, raca_id)
                values(:nome, :peso, :idade, :racas);";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nome", $post['nome']); 
        $stmt->bindParam(":peso", $post['peso']); 
        $stmt->bindParam(":idade", $post['idade']); 
        $stmt->bindParam(":racas", $post['racas']);
        $stmt->execute();
       
        $per_id = $this->db->lastInsertId(); 

        foreach($post['habilidades'] as $habi) {
            $sql = "insert into personagens_habilidades(personagem_id, habilidade_id)
                    values(:per_id, :habi_id);";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":per_id", $per_id);
            $stmt->bindParam(":habi_id", $habi);
            $stmt->execute();
        }
        return $response->withRedirect("/personagens");
    });
    $app->get('/excluir/{id}', function(Request $request, Response $response) {
        $id = $request->getAttribute('id');
        
        $sql = "delete from personagens where id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $sql = "delete from personagens_habilidades where personagem_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $response->withRedirect("/personagens");
    });
}); 