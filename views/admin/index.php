<h1 class="nombre-pagina">Panel de Administración</h1>
<?php  include_once __DIR__ . '/../templates/barra.php'; ?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form>
</div>

<?php 
 /**Cuento el array de citas y si no hay ninguna
  * mando un mensaje de notificación
  */
    if(count($citas) === 0){
        echo "<h2>No hay citas en esta fecha</h2>";
    }
?>

<div id="citas-admin">
    <ul class="citas">
    <?php 
        $idcita = 0;
        // itero el array con todas las citas
        foreach($citas as $key => $cita){

            if($idcita !== $cita->id){
                $total = 0;
    ?>
        <li>
            <p>Id: <span><?php echo $cita->id; ?></span></p>
            <p>Hora: <span><?php echo $cita->hora; ?></span></p>
            <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
            <p>Email: <span><?php echo $cita->email; ?></span></p>
            <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>
            <h3>Servicios</h3>
    <?php 
        $idcita = $cita->id;
        } // FIN DEL IF
            $total += $cita->precio;
        ?>
            <p class="servicio"><?php echo $cita->servicio . " ". $cita->precio ?></p>
    <?php 
        $actual = $cita->id; // retorna la posicion actual donde nos encontramos
        $proximo = $citas[$key + 1]->id ?? 0; // es el indice en el array de la DB        
        
        if(esUltimo($actual, $proximo)){ ?>
            <p class="total">Total a pagar: <span>$ <?php echo $total; ?></span></p>

            <form action="/api/eliminar" method="POST">
                <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                <input type="submit" class="boton-eliminar" value="Eliminar">
            </form>
        <?php
        }
     } // FIN FOREACH
        ?>    
    </ul>
</div>
<?php 
    $script = "<script src='build/js/buscador.js'></script>";
?>