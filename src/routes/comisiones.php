<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    //Comisiones

    // [GET]
    
    //Obtener todas las Comisiones
    $app->get("/comisiones", function (Request $request, Response $response, array $args) {
        $respuesta = dbGet("SELECT * FROM comisiones ORDER BY nombre");
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($respuesta, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    });
?>