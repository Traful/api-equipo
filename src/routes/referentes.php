<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    //Referentes

    // [GET]
    
    //Obtener todos los Referentes
    $app->get("/referentes", function (Request $request, Response $response, array $args) {
        $respuesta = dbGet("SELECT id, apellido, nombre FROM referentes ORDER BY nombre");
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($respuesta, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    });
?>