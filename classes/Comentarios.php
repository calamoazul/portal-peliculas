<?php

class Comentarios{

    public static function get(int $id){
        $db = new Database();

        $sql= "SELECT * from `comentarios` WHERE id_pelicula = " . $id;

        $comentarios = $db->query($sql);
        
        return $comentarios;
    }

    public static function show(int $id) {

        $comentarios = self::get($id);
        if(empty($comentarios)) {
            print('<p>Sin comentarios</p>');
        }
        foreach($comentarios as $comentario) { ?>

            <div class="container container-fluid d-flex flex-column align-items-center p-3 comentario mt-2 mb-2">
                <p class="text-center"><?= $comentario['autor'] ?> escribió: </p>
                <p class="text-center mt-2"><?= $comentario['comentario'] ?></p>
            </div>
       <?php }
        
    }

    public static function save(array $data, $id_movie) {
        $db = new Database();

        try {
            $conn = $db->connection();

            $sql = "INSERT INTO comentarios (id_pelicula, autor, comentario) 
            VALUES ('" . $id_movie  . "', '" . $data['autor']. "', '" . $data['comentario'] . "')";
            mysqli_query($conn, $sql);
            mysqli_close($conn);
        }
        catch(Exception $err) {
            printf('Error al guardar el comentario: %s', $err->getMessage());
        }
    }

    public static function form() { ?>

        <div class="container container-fluid p-5">
                <h3 class="text-light">Escribe tu comentario</h3>
                <form class="form-comentarios d-flex flex-column p-5" method="post">
                    <label class="mb-3 text-light" for="autor">Escribe tu nombre</label>
                    <input class="form-control mb-3" name="autor" type="text" required>
                    <textarea name="comentario" id="" cols="30" rows="10" placeholder="Escribe tu comentario" required></textarea>
                    <input type="submit" class="btn btn-primary" value="Enviar">
                </form>
            </div>
            
    <?php }
}