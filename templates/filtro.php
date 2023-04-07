<div class="container container-fluid my-4">
    <form action="/" method="post" class="container container-fluid d-flex align-items-center p-2">
        <label class="text-dark text-center" for="genero"><strong>Filtra películas por genero</strong></label>
        <select name="genero" id="genero">
            <option value="todas">Cualquiera</option>
            <option value="clasico">Clásico</option>
            <option value="historico">Histórico</option>
            <option value="romance">Romance</option>
            <option value="fantastico">Fantástico</option>
        </select>
        <input class="btn btn-primary p-3" type="submit" value="Buscar">
    </form>
</div>