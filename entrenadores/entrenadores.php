<?php
header('Content-Type: text/html; charset=utf-8');

$xmlFile = 'top_entrenadores.xml';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre       = $_POST['nombre'] ?? '';
    $equipo       = $_POST['equipo'] ?? '';
    $activo       = $_POST['activo'] ?? 'si'; // Valor por defecto "si"
    $experiencia  = $_POST['experiencia'] ?? '';
    $victorias    = $_POST['victorias'] ?? '';
    $derrotas     = $_POST['derrotas'] ?? '';

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
    } else {
        $xml = new SimpleXMLElement('<top_entrenadores></top_entrenadores>');
    }

    $entrenador = $xml->addChild('entrenador');
    $entrenador->addChild('nombre', $nombre);
    
    $equipoNode = $entrenador->addChild('equipo', $equipo);
    $equipoNode->addAttribute('activo', $activo);

    $entrenador->addChild('experiencia', $experiencia);
    $entrenador->addChild('victorias', $victorias);
    $entrenador->addChild('derrotas', $derrotas);

    $xml->asXML($xmlFile);
    $message = "Entrenador agregado correctamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Entrenador</title>
</head>
<body>
    <h1>Agregar Entrenador</h1>
    <?php if ($message) echo "<p style='color:green;'>$message</p>"; ?>

    <form method="post">
        <label>Nombre: <input type="text" name="nombre" required></label><br><br>
        <label>Equipo: <input type="text" name="equipo"></label>
        <label>Activo:
            <select name="activo">
                <option value="si">Sí</option>
                <option value="no">No</option>
            </select>
        </label><br><br>
        <label>Experiencia (años): <input type="number" name="experiencia" required></label><br><br>
        <label>Victorias: <input type="number" name="victorias" required></label><br><br>
        <label>Derrotas: <input type="number" name="derrotas" required></label><br><br>
        <button type="submit">Agregar Entrenador</button>
    </form>

    <h2>Entrenadores existentes</h2>
    <?php
    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Nombre</th><th>Equipo</th><th>Activo</th><th>Experiencia</th><th>Victorias</th><th>Derrotas</th></tr>";
        foreach ($xml->entrenador as $e) {
            echo "<tr>";
            echo "<td>{$e->nombre}</td>";
            echo "<td>{$e->equipo}</td>";
            echo "<td>{$e->equipo['activo']}</td>";
            echo "<td>{$e->experiencia}</td>";
            echo "<td>{$e->victorias}</td>";
            echo "<td>{$e->derrotas}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>
</body>
</html>
