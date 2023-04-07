<?php

class Peliculas {

    public static function get():array {
        $db = new Database();

        $sql= "SELECT * from `peliculas`";

        $peliculas = $db->query($sql);
        
        return $peliculas;
    }

    public static function show_all() {

        $peliculas = self::get();
        print('<div class="container-fluid container-peliculas row">');
        foreach($peliculas as $pelicula) {
            self::template($pelicula);
         }
        print('</div>');
    }

    public static function show_one() {
        $paths = explode('/', $_SERVER['REQUEST_URI']);
        $id_movie = end($paths);

        $peliculas = self::get();
        $ids = [];
        foreach($peliculas as $pelicula) {
            array_push($ids, $pelicula['id']);
        }
        if(!in_array($id_movie, $ids)) {
            http_response_code(404);
            print('<h1 class="text-center">Esta página no existe</h1>');
            return false;
        }
        else {
            self::ficha($id_movie);
        }

    }

    public static function filtrar($value) {
        $peliculas = self::get();
        match($value) {
            'historico' => $genero = 'Histórico',
            'romance' => $genero = 'Romance',
            'clasico' => $genero = 'Clásicos',
            'fantastico' => $genero = 'Fantástico',
            'todas' => $genero = 'todas',
            default => $genero = 'todas'
        };  
         print('<div class="container-fluid container-peliculas row">');
            if($genero === 'todas'){
                self::show_all();
            }
            else {
                
            $resultado = [];
            foreach($peliculas as $pelicula) {
                
                if($pelicula['genero'] === $genero ) {
                    array_push($resultado, $pelicula);
                }
            }
            if(!empty($resultado)) {
                printf('<h2 class="text-center">Películas de Género: %s</h2>', $genero);
                foreach($resultado as $pelicula) {
                    
                    self::template($pelicula);
                }
            }
            else {
                print('<h2 class="text-center my-3 mx-auto">No hay resultados que coincidan con tu criterio de búsqueda</h2>');
            }
            }
            print('</div>');
    }


    private static function template(array $pelicula) {?>
        <?php $url = strtolower(str_replace(' ', '-', $pelicula['titulo'])) . '/' . $pelicula['id']; ?>
        <div class="col-lg-4 col-md-6 col-sm-12 p3 mt-3 mb-3 d-flex flex-column justify-content-center ficha-pelicula">
                <div class="cartel-pelicula">
                    <img src="<?= $pelicula['portada'] ?>" alt="portada de película" class="img-fluid">
                </div>
                <h2 class="text-light text-center my-3"><?= $pelicula["titulo"]; ?></h2>
                <a href="<?= $url; ?>" class="button text-center">Ver ficha</a>
        </div>
   <?php }

   private static function ficha(int| string $id_movie) {
        $db = new Database();
        $comentarios = new Comentarios();

        $sql = "SELECT * FROM peliculas WHERE id = " . $id_movie;
        $pelicula = $db->query($sql); ?>
            <div class="container container-fluid d-flex-flex-column">
                <h1 class="text-light mt-5 text-center mb-5"><?= $pelicula[0]['titulo']; ?></h1>
                <div class="container-fluid cartel-pelicula d-flex flex-column justify-content-center">
                    <img width="500" src="/<?= $pelicula[0]['portada']; ?>" alt="Cartel Pelicula" class="m-auto">
                </div>
                <p class="text-light text-center mt-5"><?= $pelicula[0]['descripcion']; ?></p>
            </div>
            <div class="container container-fluid p-5 d-flex flex-column mt-2">
                <h2 class="mb-3">Comentarios</h2>
                <?php $comentarios::show($id_movie); ?>
            </div><?php $comentarios::form();
            if(isset($_POST) && array_key_exists('autor', $_POST)) {
                print('<p class="text-light">Comentario mandado</p>
                <script type="text/javascript">
                alert("Comentario guardado");
                window.location = window.location.origin;
                </script>"');
            }
   }
}