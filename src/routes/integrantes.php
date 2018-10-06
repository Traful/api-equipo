<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    //Integrantes (miembros de cada comisión)

    // [GET]
    
    //Obtener todos los Integrantes
    $app->get("/integrantes", function (Request $request, Response $response, array $args) {
        $respuesta = dbGet("SELECT * FROM integrantes ORDER BY nombre");
        return $response
            ->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($respuesta, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    });

    // [POST]
    
    //Nuevo Integrante
    $app->post("/integrante/nuevo", function (Request $request, Response $response, array $args) {
        $reglas = array(
            "apellido" => array(
                "min" => 3,
                "max" => 50,
                "tag" => "Apellido"
            ),
            "nombre" => array(
                "min" => 3,
                "max" => 50,
                "tag" => "Nombre"
            ),
            "dni" => array(
                "numeric" => true,
                "tag" => "Número de DNI"
            ),
            "domicilio" => array(
                "max" => 100,
                "tag" => "Domicilio"
            ),
            "caracteristica" => array(
                "max" => 5,
                "tag" => "Característica telefónica"
            ),
            "telefono" => array(
                "max" => 6,
                "tag" => "Número de celular"
            ),
            "mail" => array(
                "max" => 100,
                "tag" => "Email"
            ),
            "idcomision" => array(
                "numeric" => true,
                "mayorcero" => 0,
                "tag" => "Identificador de Comisión"
            ),
            "idreferente" => array(
                "numeric" => true,
                "mayorcero" => 0,
                "tag" => "Identificador de Referente"
            ),
            "notas" => array(
                "tag" => "Notas"
            ),
            "idtipo" => array(
                "numeric" => true,
                "mayorcero" => 0,
                "tag" => "Identificador de Tipo"
            ),
            "activo" => array(
                "numeric" => true,
                "tag" => "Identificador de Actividad"
            )
        );
        $validar = new Validate();
        $parsedBody = $request->getParsedBody();
        if($validar->validar($parsedBody, $reglas)) {
            //Verificar que el DNI sea único
            //Se quitó la verificación momentaneamente por los datos que hay que cargar
            /*
            $dni = dbGet("SELECT id FROM integrantes WHERE dni = '" . $parsedBody["dni"] . "'");
            if($dni->data["count"] > 0) {
                $resperr = new stdClass();
                $resperr->err = true;
                $resperr->errMsg = "El DNI " . $parsedBody["dni"] . " ya está registrado!";
                return $response
                    ->withStatus(409) //Conflicto
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode($resperr, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            } else {
            */
                $data = array(
                    "apellido" => $parsedBody["apellido"],
                    "nombre" => $parsedBody["nombre"],
                    "dni" => $parsedBody["dni"],
                    "domicilio" => $parsedBody["domicilio"],
                    "caracteristica" => $parsedBody["caracteristica"],
                    "telefono" => $parsedBody["telefono"],
                    "mail" => $parsedBody["mail"],
                    "idcomision" => $parsedBody["idcomision"],
                    "idreferente" => $parsedBody["idreferente"],
                    "notas" => $parsedBody["notas"],
                    "idtipo" => $parsedBody["idtipo"],
                    "activo" => $parsedBody["activo"]
                );
                $respuesta = dbPostWithData("integrantes", $data);
                return $response
                    ->withStatus(201) //Created
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode($respuesta, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            /*
            }
            */
        } else {
            $resperr = new stdClass();
            $resperr->err = true;
            $resperr->errMsg = "Hay errores en los datos suministrados";
            $resperr->errMsgs = $validar->errors();
            return $response
                ->withStatus(409) //Conflicto
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($resperr, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    });
?>