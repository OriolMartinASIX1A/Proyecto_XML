<?php
header('Content-Type: text/html; charset=utf-8');

$xmlFile = 'top_pitchers.xml';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rol       = $_POST['rol'] ?? '';
    $nombre    = $_POST['nombre'] ?? '';
    $equipo    = $_POST['equipo'] ?? '';
    $era       = $_POST['era'] ?? '';
    $strikeouts = $_POST['strikeouts'] ?? '';
    $bb         = $_POST['base_por_bolas'] ?? '';

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
    } else {
        $xml = new SimpleXMLElement('<top_lanzadores></top_lanzadores>');
    }

    $lanzador = $xml->addChild('lanzador');
    $lanzador->addAttribute('rol', $rol);
    $lanzador->addChild('nombre', $nombre);
    $lanzador->addChild('equipo', $equipo);
    $lanzador->addChild('era', $era);

    $estadisticas = $lanzador->addChild('estadisticas_tiro');
    $estadisticas->addChild('strikeouts', $strikeouts);
    $estadisticas->addChild('base_por_bolas', $bb);

    $xml->asXML($xmlFile);
    $message = "Lanzador agregado correctamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Lanzador al XML</title>
</head>
<body>
    <h1>Agregar Lanzador</h1>
    <?php if ($message) echo "<p style='color:green;'>$message</p>"; ?>

    <form method="post">
        <label>Rol: 
            <select name="rol" required>
                <option value="Starter">Starter</option>
                <option value="Reliever">Reliever</option>
                <option value="Closer">Closer</option>
            </select>
        </label><br><br>
        <label>Nombre: <input type="text" name="nombre" required></label><br><br>
        <label>Equipo: <input type="text" name="equipo" required></label><br><br>
        <label>ERA: <input type="number" step="0.01" name="era" required></label><br><br>
        <label>Strikeouts: <input type="number" name="strikeouts" required></label><br><br>
        <label>Base por bolas: <input type="number" name="base_por_bolas" required></label><br><br>
        <button type="submit">Agregar Lanzador</button>
    </form>

    <h2>Lanzadores existentes</h2>
    <?php
    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Rol</th><th>Nombre</th><th>Equipo</th><th>ERA</th><th>Strikeouts</th><th>BB</th></tr>";
        foreach ($xml->lanzador as $l) {
            echo "<tr>";
            echo "<td>{$l['rol']}</td>";
            echo "<td>{$l->nombre}</td>";
            echo "<td>{$l->equipo}</td>";
            echo "<td>{$l->era}</td>";
            echo "<td>{$l->estadisticas_tiro->strikeouts}</td>";
            echo "<td>{$l->estadisticas_tiro->base_por_bolas}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>
</body>
</html>
