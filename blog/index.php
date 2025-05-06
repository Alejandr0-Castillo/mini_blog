<?php
include 'db.php';

// Eliminar publicación si se hizo clic en el botón
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conexion->query("DELETE FROM posts WHERE id = $id");
    header("Location: index.php"); // Redireccionar para limpiar la URL
    exit;
}

// Obtener publicaciones
$resultado = $conexion->query("SELECT * FROM posts ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mini Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header style="display:flex; justify-content:space-between; align-items:center;">
    <a href="#"><img src="img1.png"></a>
    <button id="btnCrearPost">Crear post</button>
</header>

<div id="seccionPosts">
    <h1>Publicaciones</h1>
    <div id="posts">
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <div class="post-card">
                <h2><?php echo htmlspecialchars($fila['titulo']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($fila['contenido'])); ?></p>
                <a href="index.php?eliminar=<?php echo $fila['id']; ?>" 
                    onclick="return confirm('¿Seguro que deseas eliminar esta publicación?');"
                    class="delete-button">
                    Borrar publicación
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<div id="seccionCrear" style="display:none;">
    <h2>Agregar nueva publicación</h2>
    <form id="newPostForm">
        <input type="text" id="titulo" name="titulo" placeholder="Título" required><br><br>
        <textarea id="contenido" name="contenido" placeholder="Contenido" required></textarea><br><br>
        <div class="form-buttons">
            <button type="submit">Publicar</button>
            <button type="button" id="btnCancelar">Cancelar</button>
        </div>
    </form>
</div>

<script src="script.js"></script>
</body>
</html>
