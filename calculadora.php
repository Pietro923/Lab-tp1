<?php
// Permitir el acceso desde cualquier origen
header("Access-Control-Allow-Origin: *");

// Permitir los métodos que se van a utilizar
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");

// Permitir ciertos encabezados en las solicitudes
header("Access-Control-Allow-Headers: Content-Type");

// Establecer el tipo de contenido para las respuestas
header("Content-Type: application/json");

// Definir las funciones para cada método HTTP

function suma($num1, $num2) {
    return $num1 + $num2;
}

function resta($num1, $num2) {
    return $num1 - $num2;
}

function producto($num1, $num2) {
    return $num1 * $num2;
}

function cociente($num1, $num2) {
    if ($num2 == 0) {
        http_response_code(400);
        return json_encode(array("error" => "División por cero no permitida"));
    } else {
        return $num1 / $num2;
    }
}

function potencia($base, $exponente) {
    return pow($base, $exponente);
}

function cambioBase($numero) {
    if (!is_numeric($numero)) {
        http_response_code(400);
        return json_encode(array("error" => "La entrada no es un número válido"));
    } else {
        $binario = decbin($numero);
        $octal = decoct($numero);
        $hexadecimal = dechex($numero);
        return array(
            "binario" => $binario,
            "octal" => $octal,
            "hexadecimal" => $hexadecimal
        );
    }
}

function datosGrupales() {
    return array(
        "alurralde" => "Daniel Nicolas",
        "bonacossa" => "Juan",
        "abregu" => "Rodrigo",
        "Aybar" => "Gonzalo",
        "Devani" => "Lisandro"
    );
}

// Manejar la solicitud HTTP
$requestMethod = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

switch ($requestMethod) {
    case 'POST':
        if (isset($data['num1']) && isset($data['num2'])) {
            $resultado = suma($data['num1'], $data['num2']);
            echo json_encode(array("resultado" => $resultado));
        } else {
            http_response_code(400);
            echo json_encode(array("error" => "Se requieren los parámetros 'num1' y 'num2'"));
        }
        break;
    case 'PUT':
        if (isset($data['num1']) && isset($data['num2'])) {
            $resultado = resta($data['num1'], $data['num2']);
            echo json_encode(array("resultado" => $resultado));
        } else {
            http_response_code(400);
            echo json_encode(array("error" => "Se requieren los parámetros 'num1' y 'num2'"));
        }
        break;
    case 'PATCH':
        if (isset($data['num1']) && isset($data['num2'])) {
            $resultado = producto($data['num1'], $data['num2']);
            echo json_encode(array("resultado" => $resultado));
        } else {
            http_response_code(400);
            echo json_encode(array("error" => "Se requieren los parámetros 'num1' y 'num2'"));
        }
        break;
    case 'DELETE':
        // Usar parse_str solo si esperas datos en formato URL-encoded en el cuerpo
        // Si estás enviando JSON, utiliza $data directamente como en los otros métodos
        // parse_str(file_get_contents('php://input'), $data);
        if (isset($data['num1']) && isset($data['num2'])) {
            $resultado = cociente($data['num1'], $data['num2']);
            echo json_encode(array("resultado" => $resultado));
        } else {
            http_response_code(400);
            echo json_encode(array("error" => "Se requieren los parámetros 'num1' y 'num2'"));
        }
        break;
    case 'COPY':
        if (isset($data['num1']) && isset($data['num2'])) {
            $resultado = potencia($data['num1'], $data['num2']);
            echo json_encode(array("resultado" => $resultado));
        } else {
            http_response_code(400);
            echo json_encode(array("error" => "Se requieren los parámetros 'num1' y 'num2'"));
        }
        break;
    case 'OPTIONS':
        if (isset($data['num1'])) {
            $resultado = cambioBase($data['num1']);
            echo json_encode(array("resultado" => $resultado));
        } else {
            http_response_code(400);
            echo json_encode(array("error" => "Se requiere el parámetro 'num1'"));
        }
        break;
    case 'GET':
        $resultado = datosGrupales();
        echo json_encode(array("resultado" => $resultado));
        break;
    default:
        http_response_code(405);
        echo json_encode(array("error" => "Método HTTP no permitido"));
        break;
}
?>
