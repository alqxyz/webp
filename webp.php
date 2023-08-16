<?php
error_reporting(E_ALL);
ini_set('display_errors', 'ON');

function convertirAWebP($origen, $destino, $calidad = 80) {
    $extension = pathinfo($origen, PATHINFO_EXTENSION);
    if ($extension === 'jpeg' || $extension === 'jpg') {
        $imagen = imagecreatefromjpeg($origen);
    } elseif ($extension === 'gif') {
        $imagen = imagecreatefromgif($origen);
    } elseif ($extension === 'png') {
        $imagen = imagecreatefrompng($origen);
    } else {
        return false; // Formato de imagen no soportado
    }

    $imagenWebP = imagecreatetruecolor(imagesx($imagen), imagesy($imagen));
    imagecopy($imagenWebP, $imagen, 0, 0, 0, 0, imagesx($imagen), imagesy($imagen));

    $resultado = imagewebp($imagenWebP, $destino, $calidad);

    imagedestroy($imagen);
    imagedestroy($imagenWebP);

    return $resultado;
}

$nombreImagen = 'miniatura-wordpress.png';
$rutaImagenOriginal = __DIR__ . '/' . $nombreImagen;
$rutaImagenWebP = __DIR__ . '/' . pathinfo($nombreImagen, PATHINFO_FILENAME) . '.webp';

if (convertirAWebP($rutaImagenOriginal, $rutaImagenWebP, 70)) {
    $nombreImagenWebP = basename($rutaImagenWebP);
} else {
    $nombreImagenWebP = ''; // No se pudo convertir
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imagen WebP</title>
</head>
<body>
    <?php if ($nombreImagenWebP !== '') : ?>
        <img src="<?= $nombreImagenWebP ?>" alt="Imagen WebP">
    <?php else : ?>
        <p>No se pudo convertir la imagen a formato WebP.</p>
    <?php endif; ?>
</body>
</html>
