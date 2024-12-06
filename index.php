<?php

require('./Biblioteca.php');
session_start();

if (!isset($_SESSION['Libros'])) {

    $_SESSION['Libros'] = [];
}

$Libros = $_SESSION['Libros'];

//verficando si en el POST Creacionlibro para guardar datos
if (isset($_POST['CreacionLibro'])) {

    //Guardando un nuevo libro
    if (isset($_POST['Libro'], $_POST['Categoria'], $_POST['Descripcion'], $_POST['Dispo'], $_POST['ClienteName'], $_POST['Fecha'])) {

        $id = count($Libros) + 1;
        $libro = $_POST['Libro'];
        $categoria = $_POST['Categoria'];
        $descripcion = $_POST['Descripcion'];
        $dispo = $_POST['Dispo'];
        $nombreCliente = $_POST['ClienteName'];
        $fecha = $_POST['Fecha'];

        $libroNuevo = new Biblioteca($id, $libro, $descripcion, $categoria, $dispo, $nombreCliente, $fecha);
        $Libros[] = $libroNuevo;

        $_SESSION['Libros'] = $Libros;
    }
}

//Verificando si hay EdicionLibro en el POST
if (isset($_POST['EdicionLibro'])) {

    //Editando nuestros valores
    foreach ($Libros as $libroNuevo) {
        if ($libroNuevo->GetId() == $_POST['id']) {

            $libroNuevo->SetLibro($_POST['Libro']);
            $libroNuevo->SetCategoria($_POST['Categoria']);
            $libroNuevo->SetDescripcion($_POST['Descripcion']);
            $libroNuevo->SetDispo($_POST['Dispo']);
        }

        header('Location: /PHP/POO/Proyecto_Biblioteca/');
    }
}

//Eliminando nuestros valores
if (isset($_GET['Eliminar'])) {
    $id = $_GET['Eliminar'];

    foreach ($Libros as $key => $libro) {
        if ($libro->GetId() == $id) {
            unset($Libros[$key]);
            break;
        }
    }
    $_SESSION['Libros'] = $Libros;
    header('Location: /PHP/POO/Proyecto_Biblioteca/');
}


//Funcion para agregar un prestamo(Modificando los campos)
if (isset($_GET['AgregandoCliente'])) {
    $id = $_GET['AgregandoCliente'];

    foreach ($Libros as $libro) {
        if ($libro->GetId() == $id) {
            if (isset($_POST['ClienteName'], $_POST['Fecha'])) {
                $libro->SetNombreCliente($_POST['ClienteName']);
                $libro->SetFecha($_POST['Fecha']);
                break;
            }
        }
    }
    $_SESSION['Libros'] = $Libros;

}

//Funcion para eliminar el prestamo(Modificando a los valores predeterminados)
if (isset($_GET['EliminandoCliente'])) {
    $id = $_GET['EliminandoCliente'];

    foreach ($Libros as $libro) {
        if ($libro->GetId() == $id) {
            $libro->SetNombreCliente('-');
            $libro->SetFecha('-');
            break;
        }
    }

    $_SESSION['Libros'] = $Libros;

    header('Location: /PHP/POO/Proyecto_Biblioteca/');

}





//Funcion para obtener el id
function GetIDLibro($id, $Libros)
{
    foreach ($Libros as $libroNuevo) {
        if ($libroNuevo->GetId() == $id) {
            return $libroNuevo;
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <h1 class="titulo">Bienvenido a tu biblioteca virtual</h1>
    <img class="logo" src="./assets/libro.png" alt="Imagen de libro">


    <div class="contenedor">

        <?php
        if (isset($_GET['Editar'])) {
            $LibroEditable = GetIDLibro($_GET['Editar'], $Libros);
            // print_r($LibroEditable);

        ?>
            <!-- Formulario de Edicion -->
            <form action="" method="POST" class="Formulario">

                <input type="hidden" name="EdicionLibro" value="Editando Libro :)">

                <input type="hidden" name="id" value="<?php echo $LibroEditable->GetId() ?>">

                <label>Ingrese el nombre del libro: </label>
                <input type="text" name="Libro" value="<?php echo $LibroEditable->GetLibro() ?>">

                <label>Ingrese la categoria del libro:</label>
                <select name="Categoria">
                    <option value="Comedia" <?php echo (isset($LibroEditable) && $LibroEditable->GetCategoria() == "Comedia") ? "selected" : ""; ?>>Comedia</option>
                    <option value="Drama" <?php echo (isset($LibroEditable) && $LibroEditable->GetCategoria() == "Drama") ? "selected" : ""; ?>>Drama</option>
                    <option value="Ciencia Ficcion" <?php echo (isset($LibroEditable) && $LibroEditable->GetCategoria() == "Ciencia Ficcion") ? "selected" : ""; ?>>Ciencia Ficcion</option>
                </select>

                <label>Ingrese una breve descripcion: </label>
                <input type="text" name="Descripcion" value="<?php echo $LibroEditable->GetDescripcion() ?>">

                <label>Disponibilidad</label>
                <select name="Dispo">
                    <option value="Si" <?php echo ($LibroEditable->GetDispo() == "Si") ? "selected" : ""; ?>>Si</option>
                    <option value="No" <?php echo ($LibroEditable->GetDispo() == "No") ? "selected" : ""; ?>>No</option>
                </select>

                <button type="submit" class="btn btn-outline-secondary">Editar Libro</button>

            </form>
        <?php } else { ?>



            <!--Formulario de creacion-->
            <form action="" method="POST" class="Formulario">
                <input type="hidden" name="CreacionLibro" value="Creando Libro :)">

                <label>Ingrese el nombre del libro: </label>
                <input type="text" name="Libro">

                <label>Ingrese la categoria del libro:</label>
                <select name="Categoria">
                    <option value="Comedia">Comedia</option>
                    <option value="Drama">Drama</option>
                    <option value="Ciencia Ficcion">Ciencia Ficcion</option>
                </select>

                <label>Ingrese una breve descripcion: </label>
                <input type="text" name="Descripcion">

                <label>Disponibilidad</label>
                <select name="Dispo">
                    <option value="Si">Si</option>
                    <option value="No">No</option>
                </select>

                <!---Inputs escondidos-->
                <input type="hidden" name="ClienteName" value="-">
                <input type="hidden" name="Fecha" value="-">

                <button type="submit" class="btn btn-outline-secondary">Enviar</button>

            </form>
        <?php } ?>

        <main class="table ps-4">
            <table class="table table-striped">
                <thead>
                    <th>Id</th>
                    <th>Libro</th>
                    <th>Categoria</th>
                    <th>Descripcion</th>
                    <th>Disponibilidad</th>
                    <th>Acciones</th>
                </thead>

                <tbody>
                    <?php
                    foreach ($Libros as $libroNuevo): ?>
                        <tr>
                            <td><?php print "{$libroNuevo->GetId()}" ?></td>
                            <td><?php print "{$libroNuevo->GetLibro()}" ?></td>
                            <td><?php print "{$libroNuevo->GetCategoria()}" ?></td>
                            <td><?php print "{$libroNuevo->GetDescripcion()}" ?></td>
                            <td><?php print "{$libroNuevo->GetDispo()}" ?></td>
                            <td><a href="?Editar=<?php print "{$libroNuevo->GetId()}" ?>">Editar</a>
                                <a href="?Eliminar=<?php print "{$libroNuevo->GetId()}" ?>">Eliminar</a>
                            </td>

                        </tr>
                    <?php
                    endforeach   ?>
                </tbody>
            </table>
        </main>
    </div>

    <!--Contendor para prestamos y filtrar informacion-->
    <h1 class="titulo">Prestamo de libro</h1>
    <h2 class="Subtitulo">En este apartado podras reservar tu libro favorito</h2>

    <div class="contenedor">

    <?php if (isset($_GET['AgregandoCliente'])) {
    $LibroEditable = GetIDLibro($_GET['AgregandoCliente'], $Libros);

    if (!$LibroEditable) {
        echo "<p>Error: No se encontró un libro con el ID proporcionado.</p>";
    } else { ?>
        <form action="" class="Formulario col-7" method="POST">
            <label>Nombre del prestamista:</label>
            <input type="text" name="ClienteName" value="<?php echo $LibroEditable->GetNombreCliente(); ?>">

            <label>Fecha de préstamo:</label>
            <input type="date" name="Fecha" value="<?php echo $LibroEditable->GetFecha(); ?>">

            <input type="hidden" name="id" value="<?php echo $LibroEditable->GetId(); ?>">

            <button type="submit">Enviar información</button>
        </form>
    <?php }
} else {
    echo "<p>Por favor, selecciona un libro para agendar un préstamo.</p>";
}
?>


        <!---Apartado donde se filtrara la información-->
        <main class="table col-5">

            <form class="Formulario col-7" method="POST">

                <label>Filtrar Por categoria</label>
                <select name="Categoria">
                    <option value="Comedia">Comedia</option>
                    <option value="Drama">Drama</option>
                    <option value="Ciencia Ficcion">Ciencia Ficcion</option>
                </select>

                <button type="submit">Filtrar categoria</button>
            </form>

            <table class="table table-striped">
                <thead>
                    <th>Libro</th>
                    <th>Descripcion</th>
                    <th>Categoria</th>
                    <th>Cliente</th>
                    <th>Fecha de prestamo</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    <?php
                    $categoriaFiltro = $_POST['Categoria'] ?? null;
                    foreach ($Libros as $Libro):
                        if (($categoriaFiltro === null || $Libro->GetCategoria() == $categoriaFiltro) && $Libro->GetDispo() == "Si") {
                    ?>
                        <tr>
                            <td><?php echo $Libro->GetLibro() ?></td>
                            <td><?php echo $Libro->GetDescripcion() ?></td>
                            <td><?php echo $Libro->GetCategoria() ?></td>
                            <td><?php echo $Libro->GetNombreCliente() ?></td>
                            <td><?php echo $Libro->GetFecha() ?></td>
                            <td><a href="?AgregandoCliente=<?php print "{$Libro->GetId()}" ?>">Agregar</a>
                                <a href="?EliminandoCliente=<?php print "{$Libro->GetId()}" ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php
                    }endforeach ?>
                </tbody>
            </table>

        </main>


    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>