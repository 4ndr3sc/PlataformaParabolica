<?php
// Verificar foto de perfil en SQLite
$db = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
$result = $db->query("SELECT id, name, email, profile_photo FROM users LIMIT 5");
$users = $result->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Usuarios y Fotos de Perfil</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Foto de Perfil</th></tr>";

foreach ($users as $user) {
    echo "<tr>";
    echo "<td>" . $user['id'] . "</td>";
    echo "<td>" . $user['name'] . "</td>";
    echo "<td>" . $user['email'] . "</td>";
    echo "<td>" . ($user['profile_photo'] ? $user['profile_photo'] : '<em>SIN FOTO</em>') . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br><br><h2>Verificación de Archivos</h2>";

$user = $users[0] ?? null;
if ($user && $user['profile_photo']) {
    $path = $user['profile_photo'];
    $fullPath = __DIR__ . '/storage/app/public/' . $path;
    $publicPath = __DIR__ . '/public/storage/' . $path;
    
    echo "<p><strong>Usuario:</strong> " . $user['name'] . "</p>";
    echo "<p><strong>Foto guardada en BD:</strong> " . $path . "</p>";
    echo "<p><strong>Ruta completa storage:</strong> " . $fullPath . "</p>";
    echo "<p><strong>¿Existe en storage?</strong> " . (file_exists($fullPath) ? '<span style="color:green">SÍ</span>' : '<span style="color:red">NO</span>') . "</p>";
    echo "<p><strong>¿Accesible desde public?</strong> " . (file_exists($publicPath) ? '<span style="color:green">SÍ</span>' : '<span style="color:red">NO</span>') . "</p>";
    
    if (file_exists($fullPath)) {
        echo "<p><strong>Tamaño:</strong> " . filesize($fullPath) . " bytes</p>";
        echo "<p><strong>URL pública:</strong> <a href='" . str_replace('\\', '/', str_replace(__DIR__, '', $publicPath)) . "' target='_blank'>" . str_replace('\\', '/', str_replace(__DIR__, '', $publicPath)) . "</a></p>";
    }
}
?>
