<?php

include_once 'Libro.php';
session_start();


if(!isset($_SESSION['libros'])){
    $_SESSION['libros'] = [];
}

$libros = $_SESSION['libros'];

//Crear un libro
if(isset($_POST['createForm'])){
    if(isset($_POST['titulo'], $_POST['autor'], $_POST['editorial'], $_POST['fecha'], $_POST['genero'], $_POST['cantidad_libros'])){
    print_r($_POST);


    $id = rand(1, 1000);
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $editorial = $_POST['editorial'];
    $fecha = $_POST['fecha'];
    $genero = $_POST['genero'];
    $cantidad = $_POST['cantidad_libros'];

    $libro = new Libro($id, $titulo, $autor, $editorial, $fecha, $genero, $cantidad);

    array_push($libros, $libro);

    $_SESSION['libros'] = $libros;

    header('Location: /index.php');
    }
}
//print_r($libros);

//Editar un libro 
if(isset($_POST['updateForm'])){
    foreach($libros as $lib){
        if($lib->getIdLibro() == $_POST['id']){
           $lib->setTitulo($_POST['titulo']);
            $lib->setAutor($_POST['autor']);
            $lib->setGenero($_POST['genero']);
            $lib->setEditorial($_POST['editorial']);
            $lib->setFecha($_POST['fecha']);
            $lib->setCantidad($_POST['cantidad_libros']); 
        }
    }
    header('Location: /index.php');
}

//Eliminar un libro 
if(isset($_GET['delete'])){
    $id =$_GET['delete'];

    foreach($libros as $key => $lib){

        if($lib->getIdLibro() == $id){
            unset($libros[$key]);
        }
    }
    $_SESSION['libros'] = $libros;

    header('Location: /index.php');
}

function obtenerLibroPorId($arrayLibro, $id){
    foreach($arrayLibro as $libro){
        if($libro->getIdLibro() == $id){
            return $libro;
        }
    }
}

//Buscar un libro 
if(isset($_GET['buscar'])){
    $libros = array_filter($libros, function($libro) {
        $searchTerm = strtolower($_GET['buscar']);
        return strpos(strtolower($libro->getTitulo()), $searchTerm) !== false ||
               strpos(strtolower($libro->getAutor()), $searchTerm) !== false ||
               strpos(strtolower($libro->getGenero()), $searchTerm) !== false;
    });
}
?>

    <!-- Creacion de libros -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
</head>
<body>
    <h1>Bienvenidos a Biblioteca Kodigo</h1>

    <!-- Formulario para editar un libro -->
    <?php
        if(isset($_GET['editar'])){
            $libroEditable = obtenerLibroPorId($libros, $_GET['editar']);
            
    ?>
    
    <h2>Editar libro</h2>
    <form action="" method = "POST">
        <input type="hidden" name="updateForm" value="Soy el update">
        <input type="hidden" name="id" value="<?php echo $libroEditable->getIdLibro() ?>">

        <label>Título</label>
        <input type="text" name="titulo" id="titulo" placeholder="Escribe el título del libro" value="<?php echo $libroEditable->getTitulo()?>" required>

        <label>Autor</label>
        <input type="text" name="autor" id="autor" placeholder="Escribe el nombre del autor" value="<?php echo $libroEditable->getAutor()?>" required>
        
        <label>Genero</label>
        <input type="text" name="genero" id="genero" placeholder="Escribe el genero del libro" value="<?php echo $libroEditable->getGenero()?>" required>

        <label>Editorial</label>
        <input type="text" name="editorial" id="editorial" placeholder="Escribe el nombre del editorial" value="<?php echo $libroEditable->getEditorial()?>" required>

        <label>Año de publicación</label>
        <input type="text" name="fecha" id="fecha" placeholder="Escribe el año de publicación" value="<?php echo $libroEditable->getFecha()?>" required>

        <label>Cantidad de libros</label>
        <input type="text" name="cantidad_libros" id="cantidad_libros" placeholder="Escribe el numero de libros disponibles" value="<?php echo $libroEditable->getCantidad()?>" required>

        <button type="submit">Editar libro</button>
    </form>

        <?php
            } else {
        ?>
    <h2>Agregar libro</h2>
    <form action="" method = "POST">
        <input type="hidden" name="createForm" value="Soy el create">

        <label>Título</label>
        <input type="text" name="titulo" id="titulo" placeholder="Escribe el título del libro" required>

        <label>Autor</label>
        <input type="text" name="autor" id="autor" placeholder="Escribe el nombre del autor" required>
        
        <label>Genero</label>
        <input type="text" name="genero" id="genero" placeholder="Escribe el genero del libro" required>

        <label>Editorial</label>
        <input type="text" name="editorial" id="editorial" placeholder="Escribe el nombre del editorial" required>

        <label>Año de publicación</label>
        <input type="text" name="fecha" id="fecha" placeholder="Escribe el año de publicación" required>


        <label>Cantidad de libros</label>
        <input type="text" name="cantidad_libros" id="cantidad_libros" placeholder="Escribe el numero de libros disponibles" required>

        <button type="submit">Agregar libro</button>
    </form>

        <?php
            }
        ?>


            <form action="" method="GET" style="margin-top: 2rem;">
                <input type="text" name="buscar" id="buscar" placeholder="Buscar libro por titulo, autor o genero">
                <button type="submit">Buscar</button>
            </form>
    <!-- Representacion de los libros -->
    <main style="margin-top: 1rem;">
        <table border="1" cellpadding="10" cellspacing="0"> 
            <thead>
                <th>ID</th>
                <th>Titulo de libro</th>
                <th>Autor</th>
                <th>Genero</th>
                <th>Editorial</th>
                <th>Año de publicación</th>
                <th>Cantidad de libros</th>
                <th>Acciones</th>
            </thead>

            <tbody>
                <?php foreach($libros as $lib){
               echo " <tr>
                    <td>{$lib->getIdLibro()}</td>
                    <td>{$lib->getTitulo()}</td>
                    <td>{$lib->getAutor()}</td>
                    <td>{$lib->getGenero()}</td>
                    <td>{$lib->getEditorial()}</td>
                    <td>{$lib->getFecha()}</td>
                    <td>{$lib->getCantidad()}</td>
                    <td>
                        <a href='?editar={$lib->getIdLibro()}'>Editar</a>
                        <a href='?delete={$lib->getIdLibro()}'>Eliminar</a>
                    </td>
                </tr>";
                }?>
            </tbody>
        </table>
    </main>

</body>
</html>