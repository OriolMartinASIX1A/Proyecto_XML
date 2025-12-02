<?php
header('Content-Type: text/html; charset=utf-8');

$xmlFile = 'top_outfielders.xml';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $posicion          = $_POST['posicion'] ?? '';
    $nombre            = $_POST['nombre'] ?? '';
    $equipo            = $_POST['equipo'] ?? '';
    $max_exit_velocity = $_POST['max_exit_velocity'] ?? '';
    $avg_exit_velocity = $_POST['avg_exit_velocity'] ?? '';
    $distance          = $_POST['distance'] ?? '';
    $oaa               = $_POST['oaa'] ?? '';
    $outfield_jump     = $_POST['outfield_jump'] ?? '';
    $arm_strength      = $_POST['arm_strength'] ?? '';

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
    } else {
        $xml = new SimpleXMLElement('<top_outfielders></top_outfielders>');
    }

    $jugador = $xml->addChild('jugador');
    $jugador->addAttribute('posicion', $posicion);
    $jugador->addChild('nombre', $nombre);
    $jugador->addChild('equipo', $equipo);

    $estadBateo = $jugador->addChild('estadisticas_bateo');
    $estadBateo->addChild('max_exit_velocity', $max_exit_velocity);
    $estadBateo->addChild('avg_exit_velocity', $avg_exit_velocity);
    $estadBateo->addChild('distance', $distance);

    $defensa = $jugador->addChild('defensa');
    $defensa->addChild('oaa', $oaa);
    $defensa->addChild('outfield_jump', $outfield_jump);
    $defensa->addChild('arm_strength', $arm_strength);

    $xml->asXML($xmlFile);
    $message = "Jugador agregado correctamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Outfielder</title>
</head>
<body>
    <h1>Agregar Outfielder</h1>
    <?php if ($message) echo "<p style='color:green;'>$message</p>"; ?>

    <form method="post">
        <label>Posición: <input type="text" name="posicion" required></label><br><br>
        <label>Nombre: <input type="text" name="nombre" required></label><br><br>
        <label>Equipo: <input type="text" name="equipo" required></label><br><br>

        <h3>Estadísticas de bateo</h3>
        <label>Max Exit Velocity: <input type="number" step="0.1" name="max_exit_velocity" required></label><br><br>
        <label>Avg Exit Velocity: <input type="number" step="0.1" name="avg_exit_velocity" required></label><br><br>
        <label>Distance: <input type="number" name="distance" required></label><br><br>

        <h3>Estadísticas de defensa</h3>
        <label>OAA: <input type="number" name="oaa" required></label><br><br>
        <label>Outfield Jump: <input type="number" step="0.1" name="outfield_jump" required></label><br><br>
        <label>Arm Strength: <input type="number" name="arm_strength" required></label><br><br>

        <button type="submit">Agregar Jugador</button>
    </form>

    <h2>Jugadores existentes</h2>
    <?php
    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Posición</th><th>Nombre</th><th>Equipo</th><th>Max EV</th><th>Avg EV</th><th>Distance</th><th>OAA</th><th>Outfield Jump</th><th>Arm Strength</th></tr>";
        foreach ($xml->jugador as $j) {
            echo "<tr>";
            echo "<td>{$j['posicion']}</td>";
            echo "<td>{$j->nombre}</td>";
            echo "<td>{$j->equipo}</td>";
            echo "<td>{$j->estadisticas_bateo->max_exit_velocity}</td>";
            echo "<td>{$j->estadisticas_bateo->avg_exit_velocity}</td>";
            echo "<td>{$j->estadisticas_bateo->distance}</td>";
            echo "<td>{$j->defensa->oaa}</td>";
            echo "<td>{$j->defensa->outfield_jump}</td>";
            echo "<td>{$j->defensa->arm_strength}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>
</body>
</html>
