<?php
$host = "";
$user = "";
$pass = "";
$db = "";


$conexion = new mysqli($host, $user, $pass,$db);

if($conexion->connect_errno){
    echo "Error al conectar a la base de datos: " . $conexion->connect_error;
}

// Acción de agregar un nuevo pago
if($_POST['accion'] == 'agregar'){
    $nombre = $_POST['nombre'];
    $servicio = $_POST['servicio'];
    $cuenta = $_POST['cuenta'];
    echo $cuenta;
    $cantidad = $_POST['cantidad'];
    $comision = 20;
    $fecha = date("Y-m-d");
    $estatus = $_POST['estatus'];

    $sql = "INSERT INTO pagos (nombre, servicio, cantidad, comision, estatus, cuenta,fecha) VALUES ('$nombre', '$servicio', '$cantidad', '$comision', '$estatus','$cuenta','$fecha')";

    if($conexion->query($sql) === true){
        echo "Pago agregado correctamente";
    }else{
        echo "Error al agregar el pago: " . $conexion->error;
    }
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

    echo $nombreArchivo;

    if(isset($_FILES['comprobante'])) {
        echo $_FILES['comprobante'];
        $rutaTemporal = $_FILES['comprobante']['tmp_name'];
        echo $rutaTemporal;
        $rutaDestino = '/comprobantes/' . $nombreArchivo;
        move_uploaded_file($rutaTemporal, __DIR__ . $rutaDestino);
    }

    $sql = "UPDATE pagos SET nombre='$nombre', servicio='$servicio', cantidad='$cantidad', estatus='$estatus', cuenta='$cuenta' WHERE id=$id";
echo $sql;
    if($conexion->query($sql) === true){
        echo "Pago actualizado correctamente";
    }else{
        echo "Error al actualizar el pago: " . $conexion->error;
    }
}

// Acción de eliminar un pago
if($_POST['accion'] == 'eliminar'){
    $id = $_POST['id'];

    $sql = "DELETE FROM pagos WHERE id = $id";

    if($conexion->query($sql) === true){
        echo "Pago eliminado correctamente";
    }else{
        echo "Error al eliminar el pago: " . $conexion->error;
    }
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
