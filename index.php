<?php

require_once 'config.php'; 
$peliculas = new Peliculas;
get_template('header');

$paths = explode('/', $_SERVER['REQUEST_URI']);
?>



    <div class="container container-fluid d-flex flex-column justify-content-center">
        <?php if($_SERVER['REQUEST_URI'] === '/') { ?>
            <h1 class="text-center text-light">Portal de películas</h1>
            <?php
            get_template('filtro');
            if(isset($_POST) && array_key_exists('genero', $_POST)) {
                $genero = $_POST['genero'];
                $peliculas::filtrar($genero);
            }
            else {
                $peliculas::show_all();
            } ?>
        <?php }
        else {
            $peliculas::show_one();
            if(isset($_POST) && array_key_exists('autor', $_POST)) {

                //La validacion de datos es muy sencilla por falta de tiempo
                $data = [
                    'autor' => $_POST['autor'],
                    'comentario' => $_POST['comentario']
                ];

                Comentarios::save($data, end($paths));
            }
        }
         ?>
    </div>
    <footer class="container container-fluid"></footer>
</body>
</html>