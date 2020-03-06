<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app = new \Slim\App;

// Get all data clients

$app->get('/api/clients', function(Request $request, Response $response){

    $query = "SELECT * FROM clients";
    try
    {

        $db = new Connection();
        $db = $db->Connect();
        $result = $db->query($query);

        if($result->rowCount() > 0)
        {
            $clients = $result->fetchAll(PDO::FETCH_OBJ);

            echo json_encode($clients);
        }else
        {

            echo json_encode("No existen clientes en la DB");

        }

        $result = null;
        $db = null;

    }
    catch(PDOException $e)
    {

        echo '{"error": { "text":'.$e->getMessage().'}';

    }
    
});

// Get data client by ID
$app->get('/api/clients/{id}', function(Request $request, Response $response){
    
    $id_client= $request->getAttribute('id');
    
    $query = "SELECT * FROM clients WHERE id = $id_client";

    try
    {

        $db = new Connection();
        $db = $db->Connect();
        $result = $db->query($query);

        if($result->rowCount() > 0)
        {
            $clients = $result->fetchAll(PDO::FETCH_OBJ);

            echo json_encode($clients);
        }else
        {

            echo json_encode("No existen clientes en la DB");

        }

        $result = null;
        $db = null;

    }
    catch(PDOException $e)
    {

        echo '{"error": { "text":'.$e->getMessage().'}';

    }

});

// POST Create new client

$app->post('/api/clients/new', function(Request $request, Response $response){

    
    $name = $request->getParam('name');
    $lastname = $request->getParam('lastname');
    $email = $request->getParam('email');
    $city = $request->getParam('city');



    $query = "SELECT * FROM clients WHERE name = :name AND lastname = :lastname";
    $query1 = "INSERT INTO clients(name,lastname,email,city) VALUES (:name,:lastname, :email, :city)";
    
    try
    {

        $db = new Connection();
        $db = $db->Connect();
        $result = $db->prepare($query);
        $result->bindParam(':name', $name);
        $result->bindParam(':lastname', $lastname);
        

        $result->execute();
        if($result->rowCount() > 0)
        {
            return json_encode("El cliente ya existe.");
        }else {

            $result1 = $db->prepare($query1);
            $result1->bindParam(':name', $name);
            $result1->bindParam(':lastname', $lastname);
            $result1->bindParam(':email', $email);
            $result1->bindParam(':city', $city);
            if($result1->execute())
            {
    
                echo json_encode("Nuevo cliente guardado.");
    
            }else
            {
    
                echo json_encode("No se ha podido guardar en la DB");
    
            }
    
        }



        $result = null;
        $result1 = null;

        $db = null;

    }
    catch(PDOException $e)
    {

        echo '{"error": { "text":'.$e->getMessage().'}';

    }

});

// PUT Modify client

$app->put('/api/clients/edit/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');
    $name = $request->getParam('name');
    $lastname = $request->getParam('lastname');
    $email = $request->getParam('email');
    $city = $request->getParam('city');


    $query = "UPDATE clients SET name = :name, lastname = :lastname, email = :email, city = :city WHERE id = :id";
    
    try
    {

        $db = new Connection();
        $db = $db->Connect();
        $result = $db->prepare($query);

        $result->bindParam(':id', $id);
        $result->bindParam(':name', $name);
        $result->bindParam(':lastname', $lastname);
        $result->bindParam(':email', $email);
        $result->bindParam(':city', $city);

        $result->execute();

        if($result->rowCount() > 0)
        {

            echo json_encode("Cliente editado.");

        }else
        {

            echo json_encode("No se ha podido editar el cliente");

        }

        $result = null;
        $db = null;

    }
    catch(PDOException $e)
    {

        echo '{"error": { "text":'.$e->getMessage().'}';

    }

});

// DELETE client

$app->delete('/api/clients/delete/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');
    


    $query = "DELETE FROM clients WHERE id = :id";
    
    try
    {

        $db = new Connection();
        $db = $db->Connect();
        $result = $db->prepare($query);

        $result->bindParam(':id', $id);
        $result->execute();
        if($result->rowCount() > 0)
        {

            echo json_encode("Cliente borrado exitosamente.");

        }else
        {

            echo json_encode("No existe cliente con este ID");

        }

        $result = null;
        $db = null;

    }
    catch(PDOException $e)
    {

        echo '{"error": { "text":'.$e->getMessage().'}';

    }

});