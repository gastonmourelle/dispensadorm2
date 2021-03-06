<?php
session_start();
include 'db.php';
include 'uid.php';
include 'tiempo.php';
include 'situacion.php';
include "config.php";

$tiempoActualUnix = time() - 10800;
$tiempoActual = gmdate('Y-m-d H:i:s', $tiempoActualUnix);
$diaActual = gmdate('Y-m-d', $tiempoActualUnix);

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

$pdo = Base::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM perros WHERE id = '$UIDresultado'";
$q = $pdo->prepare($sql);
$q->execute();
$datos = $q->fetch(PDO::FETCH_ASSOC);
$sql2 = "SELECT COUNT(*)+1 AS total FROM logs WHERE rfid = '$UIDresultado' AND horaSalida BETWEEN '$diaActual 00:00:01' AND '$diaActual 23:59:59'";
$result = $conex->query($sql2);
$logs =  $result->fetch_assoc();

$nombre = ($datos['nombre']);
$identificador = ($datos['identificador']);
$id = ($datos['id']);
$racion = ($datos['racion']);
$turnos = ($datos['turnos']);
$unaRacion = ($racion / $turnos) | 0;
$cooldown = ($datos['cooldown']);
$veces = ($logs['total']);
$ultimaSalidaUnix = strtotime(($datos['ultimaSalida'])) + 7200;
$ultimaEntrada = gmdate('Y-m-d H:i:s', (strtotime(($datos['ultimaEntrada'])) + 7200));
$entro = ($datos['entro']);
$diferenciaTiempoUnix = $tiempoActualUnix - $ultimaSalidaUnix;
$cooldownUnix = ($datos['cooldown'] * 10); /* <--- cambiarlo por $cooldown*3600 */

if ($entro == 0 and $situacion == "entrada" and $turnos >= $veces and $diferenciaTiempoUnix >= $cooldownUnix) {
    // Entro a comer (dispensar comida)
    echo "&" . $unaRacion;

    $query1 = "UPDATE perros SET ultimaEntrada = NOW() WHERE id = '$UIDresultado'";
    mysqli_query($conex, $query1);

    $query2 = "UPDATE perros SET entro = 1 WHERE id = '$UIDresultado'";
    mysqli_query($conex, $query2);
} else if ($entro == 1 and $situacion == "salida") {
    // Termino de comer
    echo "&1";

    $query1 = "UPDATE perros SET ultimaSalida = NOW() WHERE id = '$UIDresultado'";
    mysqli_query($conex, $query1);

    $query2 = "INSERT INTO logs (nombre, rfid, horaEntrada, horaSalida) values ('$nombre', '$id', '$ultimaEntrada', NOW())";
    mysqli_query($conex, $query2);

    $query3 = "UPDATE perros SET veces = '$veces' WHERE id = '$UIDresultado'";
    mysqli_query($conex, $query3);

    $query4 = "UPDATE perros SET entro = 0 WHERE id = '$UIDresultado'";
    mysqli_query($conex, $query4);

    /* if ($ULTRAresultado != "") {
        $query5 = "UPDATE almacenamiento SET distancia = '$ULTRAresultado'";
        mysqli_query($conex, $query5);
    } */
} else if ($turnos < $veces) {
    // Ya uso todos sus turnos
    echo "&2";
} else if ($diferenciaTiempoUnix < $cooldownUnix) {
    // Cooldown activo
    echo "&3";
} else {
    echo "&0";
}

Base::disconnect();

?>