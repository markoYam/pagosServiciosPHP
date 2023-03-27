<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "pagosServicios";

$data = array();

$conexion = new mysqli($host, $user, $pass,$db);

if($conexion->connect_errno){
    $data["error"] = true;
    $data["status"] = 500;
    $data["message"] = "Error al conectar a la base de datos: " . $conexion->connect_error;
    echo json_encode($data);
}



// Acción de agregar un nuevo pago
if($_POST['accion'] == 'agregar'){
    $nombre = $_POST['nombre'];
    $servicio = $_POST['servicio'];
    $cuenta = $_POST['cuenta'];
    //echo $cuenta;
    $cantidad = $_POST['cantidad'];
    $comision = 20;
    $fecha = date("Y-m-d");
    $estatus = $_POST['estatus'];

    $sql = "INSERT INTO pagos (nombre, servicio, cantidad, comision, estatus, cuenta,fecha) VALUES ('$nombre', '$servicio', '$cantidad', '$comision', '$estatus','$cuenta','$fecha')";

    if($conexion->query($sql) === true){
        $data["error"] = false;
        $data["code"] = 200;
        $data["message"] = "Pago agregado correctamente";
        
        //echo "Pago agregado correctamente";
    }else{
        $data["error"] = true;
        $data["status"] = 400;
        $data["message"] = "Error al agregar el pago: " . $conexion->error;
        //echo "Error al agregar el pago: " . $conexion->error;
    }

    echo json_encode($data);
}

// Acción de obtener la información de un pago específico
if($_POST['accion'] == 'obtener'){
    $id = $_POST['id'];

    $sql = "SELECT * FROM pagos WHERE id = $id";
    $resultado = $conexion->query($sql);

    $pago = $resultado->fetch_assoc();

    echo json_encode($pago);
}

// Acción de actualizar la información de un pago
if($_POST['accion'] == 'actualizar'){
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $servicio = $_POST['servicio'];
    $cuenta = $_POST['cuenta'];
    $cantidad = $_POST['cantidad'];
    $estatus = $_POST['estatus'];
    $fecha = date("Ymd");
    $nombreArchivo = 'Comprobante'.$nombre.$cuenta.$fecha.'.jpg';

    //echo $nombreArchivo;

    if(isset($_FILES['comprobante'])) {
        //echo $_FILES['comprobante'];
        $rutaTemporal = $_FILES['comprobante']['tmp_name'];
        //echo $rutaTemporal;
        $rutaDestino = '/comprobantes/' . $nombreArchivo;
        move_uploaded_file($rutaTemporal, __DIR__ . $rutaDestino);
    }

    $sql = "UPDATE pagos SET nombre='$nombre', servicio='$servicio', cantidad='$cantidad', estatus='$estatus', cuenta='$cuenta' WHERE id=$id";
    //echo $sql;
    if($conexion->query($sql) === true){
        $data["error"] = false;
        $data["code"] = 200;
        $data["message"] = "Pago actualizado correctamente";
        //echo "Pago actualizado correctamente";
    }else{
        $data["error"] = true;
        $data["status"] = 400;
        $data["message"] = "Error al actualizar el pago: " . $conexion->error;
        //echo "Error al actualizar el pago: " . $conexion->error;
    }
    echo json_encode($data);
}

// Acción de eliminar un pago
if($_POST['accion'] == 'eliminar'){
    $id = $_POST['id'];

    $sql = "DELETE FROM pagos WHERE id = $id";

    if($conexion->query($sql) === true){
        $data["error"] = false;
        $data["code"] = 200;
        $data["message"] = "Pago eliminado correctamente";
       
    }else{
        $data["error"] = true;
        $data["status"] = 400;
        $data["message"] = "Error al eliminar el pago: " . $conexion->error;
    }
    echo json_encode($data);
}

// Acción de obtener todos los pagos
if($_POST['accion'] == 'obtener_todos'){
    $sql = "SELECT * FROM pagos order by id desc";
    $resultado = $conexion->query($sql);

    $pagos = array();

    while($fila = $resultado->fetch_assoc()){
        $pagos[] = $fila;
    }

    echo json_encode($pagos);
}

$conexion->close();
?>
