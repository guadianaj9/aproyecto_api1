<?php
require "config/Conexion.php";

  //print_r($_SERVER['REQUEST_METHOD']);
  switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $correo = isset($_GET['correo']) ? $_GET['correo'] : null;

        if (!empty($correo)) {
            $sql = "SELECT id_alugmno, correo, edad, telefono, foto FROM base_fued WHERE correo = '$correo'";
        } else {
            $sql = "SELECT id_alugmno, correo, edad, telefono, foto FROM base_fued";
        }

        $query = $conexion->query($sql);

        if ($query->num_rows > 0) {
            $data = array();
            while ($row = $query->fetch_assoc()) {
                $data[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            echo "No se encontraron registros" . (!empty($correo) ? " para el correo '$correo'." : ".");
        }

        $conexion->close();
        break;

    case 'POST':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['correo'];
            $edad = $_POST['edad'];
            $telefono = $_POST['telefono'];
            $foto = $_POST['foto'];

            $sql = "INSERT INTO base_fued (correo, edad, telefono, foto ) VALUES ('$correo', '$edad','$telefono', '$foto')";

            if ($conexion->query($sql) === TRUE) {
                echo "Datos insertados con éxito.";
            } else {
                echo "Error al insertar datos: " . $conexion->error;
            }
        } else {
            echo "Esta API solo admite solicitudes POST.";
        }

        $conexion->close();
        break;

        case 'PATCH':
            // Obtener los datos del cuerpo de la solicitud JSON
            $input = json_decode(file_get_contents("php://input"), true);
    
            // Obtener el ID del base_fued desde la URL o el cuerpo de la solicitud
            $id_base_fued = isset($_GET['id_alugmno']) ? $_GET['id_alugmno'] : (isset($input['id_alugmno']) ? $input['id_alugmno'] : null);
            echo $id_base_fued;
            // Obtener otros datos del cuerpo de la solicitud
            $correo = isset($input['correo']) ? $input['correo'] : null;
            $edad = isset($input['edad']) ? $input['edad'] : null;
            $foto = isset($input['foto']) ? $input['foto'] : null;
            $telefono = isset($input['telefono']) ? $input['telefono'] : null;
    
            // Realizar la lógica para manejar las solicitudes PUT aquí...
            if (!empty($id_base_fued)) {
                $actualizaciones = array();
                if (!empty($correo)) {
                    $actualizaciones[] = "correo = '$correo'";
                }
                if (!empty($edad)) {
                    $actualizaciones[] = "edad = '$edad'";
                }
                if (!empty($foto)) {
                    $actualizaciones[] = "foto = '$foto'";
                }
                if (!empty($telefono)) {
                    $actualizaciones[] = "telefono = '$telefono'";
                }
    
                $actualizaciones_str = implode(', ', $actualizaciones);
                $sql = "UPDATE base_fued SET $actualizaciones_str WHERE id_alugmno = $id_base_fued";
    
                if ($conexion->query($sql) === TRUE) {
                    echo "Registro actualizado con éxito.";
                } else {
                    echo "Error al actualizar registro: " . $conexion->error;
                }
            } else {
                echo "Faltan datos obligatorios en la solicitud.";
            }
    
            $conexion->close();
            break;

        case 'PUT':
            // Obtener los datos del cuerpo de la solicitud JSON
            $input = json_decode(file_get_contents("php://input"), true);
    
            // Obtener el ID del base_fued desde la URL o el cuerpo de la solicitud
            $id_base_fued = isset($_GET['id_alugmno']) ? $_GET['id_alugmno'] : (isset($input['id_alugmno']) ? $input['id_alugmno'] : null);
            echo $id_base_fued;
            // Obtener otros datos del cuerpo de la solicitud
            $correo = isset($input['correo']) ? $input['correo'] : null;
            $edad = isset($input['edad']) ? $input['edad'] : null;
            $foto = isset($input['foto']) ? $input['foto'] : null;
            $telefono = isset($input['telefono']) ? $input['telefono'] : null;
    
            // Realizar la lógica para manejar las solicitudes PUT aquí...
            if (!empty($id_base_fued)) {
                $actualizaciones = array();
                if (!empty($correo)) {
                    $actualizaciones[] = "correo = '$correo'";
                }
                if (!empty($edad)) {
                    $actualizaciones[] = "edad = '$edad'";
                }
                if (!empty($foto)) {
                    $actualizaciones[] = "foto = '$foto'";
                }
                if (!empty($telefono)) {
                    $actualizaciones[] = "telefono = '$telefono'";
                }
    
                $actualizaciones_str = implode(', ', $actualizaciones);
                $sql = "UPDATE base_fued SET $actualizaciones_str WHERE id_alugmno = $id_base_fued";
    
                if ($conexion->query($sql) === TRUE) {
                    echo "Registro actualizado con éxito.";
                } else {
                    echo "Error al actualizar registro: " . $conexion->error;
                }
            } else {
                echo "Faltan datos obligatorios en la solicitud.";
            }
    
            $conexion->close();
            break;

    case 'DELETE':
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            if (isset($data['id_base_fued'])) {
                $id_base_fued = $data['id_base_fued'];
                $sql = "DELETE FROM base_fued WHERE id_alugmno = $id_base_fued";

                if ($conexion->query($sql) === TRUE) {
                    echo "Registro eliminado con éxito.";
                } else {
                    echo "Error al eliminar registro: " . $conexion->error;
                }
            } else {
                echo "El parámetro id_base_fued no se proporcionó en el JSON.";
            }
        } else {
            echo "Método de solicitud no válido.";
        }

        $conexion->close();
        break;

    default:
        echo 'undefined request type!';
}
?>