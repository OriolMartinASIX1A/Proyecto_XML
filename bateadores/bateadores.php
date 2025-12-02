<?php
header('Content-Type: text/html; charset=utf-8');

$xmlFile = 'top_bateadores.xml';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $turno    = $_POST['turno'] ?? '';
    $nombre   = $_POST['nombre'] ?? '';
    $equipo   = $_POST['equipo'] ?? '';
    $hits     = $_POST['hits'] ?? '';
    $dobles   = $_POST['dobles'] ?? '';
    $triples  = $_POST['triples'] ?? '';
    $hr       = $_POST['hr'] ?? '';
    $carreras = $_POST['carreras'] ?? '';
    $avg      = $_POST['avg'] ?? '';

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
    } else {
        $xml = new SimpleXMLElement('<top_bateadores></top_bateadores>');
    }

    $bateador = $xml->addChild('bateador');
    $bateador->addAttribute('turno', $turno);
    $bateador->addChild('nombre', $nombre);
    $bateador->addChild('equipo', $equipo);

    $estadBateo = $bateador->addChild('estadisticas_bateo');
    $estadBateo->addChild('hits', $hits);
    $estadBateo->addChild('dobles', $dobles);
    $estadBateo->addChild('triples', $triples);
    $estadBateo->addChild('hr', $hr);

    $estadCarrera = $bateador->addChild('estadisticas_carrera');
    $estadCarrera->addChild('carreras', $carreras);
    $estadCarrera->addChild('avg', $avg);

    $xml->asXML($xmlFile);
    $message = "Bateador agregado correctamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Bateador al XML</title>
</head>
<body>
    <h1>Agregar Bateador</h1>
    <?php if ($message) echo "<p style='color:green;'>$message</p>"; ?>

    <form method="post">
        <label>Turno: <input type="text" name="turno" required></label><br><br>
        <label>Nombre: <input type="text" name="nombre" required></label><br><br>
        <label>Equipo: <input type="text" name="equipo" required></label><br><br>
        <label>Hits: <input type="number" name="hits" required></label><br><br>
        <label>Dobles: <input type="number" name="dobles" required></label><br><br>
        <label>Triples: <input type="number" name="triples" required></label><br><br>
        <label>HR: <input type="number" name="hr" required></label><br><br>
        <label>Carreras: <input type="number" name="carreras" required></label><br><br>
        <label>AVG: <input type="text" name="avg" required></label><br><br>
        <button type="submit">Agregar Bateador</button>
    </form>

    <h2>Bateadores existentes</h2>
    <?php
    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Turno</th><th>Nombre</th><th>Equipo</th><th>Hits</th><th>Dobles</th><th>Triples</th><th>HR</th><th>Carreras</th><th>AVG</th></tr>";
        foreach ($xml->bateador as $b) {
            echo "<tr>";
            echo "<td>{$b['turno']}</td>";
            echo "<td>{$b->nombre}</td>";
            echo "<td>{$b->equipo}</td>";
            echo "<td>{$b->estadisticas_bateo->hits}</td>";
            echo "<td>{$b->estadisticas_bateo->dobles}</td>";
            echo "<td>{$b->estadisticas_bateo->triples}</td>";
            echo "<td>{$b->estadisticas_bateo->hr}</td>";
            echo "<td>{$b->estadisticas_carrera->carreras}</td>";
            echo "<td>{$b->estadisticas_carrera->avg}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>
</body>
</html>
