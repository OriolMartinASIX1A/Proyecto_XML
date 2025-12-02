<?php
header('Content-Type: text/html; charset=utf-8');

$xmlFile = 'top_infielders.xml';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $posicion         = $_POST['posicion'] ?? '';
    $nombre           = $_POST['nombre'] ?? '';
    $equipo           = $_POST['equipo'] ?? '';
    $max_exit_velocity = $_POST['max_exit_velocity'] ?? '';
    $avg_exit_velocity = $_POST['avg_exit_velocity'] ?? '';
    $distance         = $_POST['distance'] ?? '';
    $defensa_tipo     = $_POST['defensa_tipo'] ?? 'infielder';

    $oaa               = $_POST['oaa'] ?? null;
    $arm_strength      = $_POST['arm_strength'] ?? null;
    $double_play_pct   = $_POST['double_play_pct'] ?? null;
    $caught_stealing_pct = $_POST['caught_stealing_pct'] ?? null;
    $pop_time          = $_POST['pop_time'] ?? null;
    $framing_runs      = $_POST['framing_runs'] ?? null;

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
    } else {
        $xml = new SimpleXMLElement('<top_infielders></top_infielders>');
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
    $defensa->addAttribute('tipo', $defensa_tipo);

    if ($defensa_tipo == 'infielder') {
        if ($oaa !== null) $defensa->addChild('oaa', $oaa);
        if ($arm_strength !== null) $defensa->addChild('arm_strength', $arm_strength);
        if ($double_play_pct !== null) $defensa->addChild('double_play_pct', $double_play_pct);
    } elseif ($defensa_tipo == 'catcher') {
        if ($caught_stealing_pct !== null) $defensa->addChild('caught_stealing_pct', $caught_stealing_pct);
        if ($pop_time !== null) $defensa->addChild('pop_time', $pop_time);
        if ($framing_runs !== null) $defensa->addChild('framing_runs', $framing_runs);
    }

    $xml->asXML($xmlFile);
    $message = "Jugador agregado correctamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Infielder</title>
</head>
<body>
    <h1>Agregar Infielder / Catcher</h1>
    <?php if ($message) echo "<p style='color:green;'>$message</p>"; ?>

    <form method="post">
        <label>Posición: <input type="text" name="posicion" required></label><br><br>
        <label>Nombre: <input type="text" name="nombre" required></label><br><br>
        <label>Equipo: <input type="text" name="equipo" required></label><br><br>

        <h3>Estadísticas de bateo</h3>
        <label>Max Exit Velocity: <input type="number" step="0.1" name="max_exit_velocity" required></label><br><br>
        <label>Avg Exit Velocity: <input type="number" step="0.1" name="avg_exit_velocity" required></label><br><br>
        <label>Distance: <input type="number" name="distance" required></label><br><br>

        <h3>Defensa</h3>
        <label>Tipo: 
            <select name="defensa_tipo" id="defensa_tipo" onchange="cambioDefensaFields()">
                <option value="infielder">Infielder</option>
                <option value="catcher">Catcher</option>
            </select>
        </label><br><br>

        <div id="infielder_fields">
            <label>OAA: <input type="number" name="oaa"></label><br><br>
            <label>Arm Strength: <input type="number" name="arm_strength"></label><br><br>
            <label>Double Play %: <input type="number" name="double_play_pct"></label><br><br>
        </div>

        <div id="catcher_fields" style="display:none;">
            <label>Caught Stealing %: <input type="number" name="caught_stealing_pct"></label><br><br>
            <label>Pop Time: <input type="number" step="0.01" name="pop_time"></label><br><br>
            <label>Framing Runs: <input type="number" name="framing_runs"></label><br><br>
        </div>

        <button type="submit">Agregar Jugador</button>
    </form>

    <h2>Jugadores existentes</h2>
    <?php
    if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Posición</th><th>Nombre</th><th>Equipo</th><th>Max EV</th><th>Avg EV</th><th>Distance</th><th>OAA</th><th>Arm</th><th>DP %</th><th>CS %</th><th>Pop</th><th>Framing</th></tr>";
    foreach ($xml->jugador as $j) {
        $def = $j->defensa;
        echo "<tr>";
        echo "<td>{$j['posicion']}</td>";
        echo "<td>{$j->nombre}</td>";
        echo "<td>{$j->equipo}</td>";
        echo "<td>{$j->estadisticas_bateo->max_exit_velocity}</td>";
        echo "<td>{$j->estadisticas_bateo->avg_exit_velocity}</td>";
        echo "<td>{$j->estadisticas_bateo->distance}</td>";
        echo "<td>".($def->oaa ?? '')."</td>";
        echo "<td>".($def->arm_strength ?? '')."</td>";
        echo "<td>".($def->double_play_pct ?? '')."</td>";
        echo "<td>".($def->caught_stealing_pct ?? '')."</td>";
        echo "<td>".($def->pop_time ?? '')."</td>";
        echo "<td>".($def->framing_runs ?? '')."</td>";
        echo "</tr>";
    }
    echo "</table>";
}
    ?>

    <script>
        function cambioDefensaFields() {
            const tipo = document.getElementById('defensa_tipo').value;
            document.getElementById('infielder_fields').style.display = (tipo === 'infielder') ? 'block' : 'none';
            document.getElementById('catcher_fields').style.display = (tipo === 'catcher') ? 'block' : 'none';
        }
    </script>
</body>
</html>
