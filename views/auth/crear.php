<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el formulario para crear una cuenta</p>
<!-- las alertas vienen en un array,
        itero el array y muestro cada una -->
<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>
<form class="formulario" method="POST" action="/crear">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="Escribe tu nombre" value="<?php echo s($usuario->nombre);?>">
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" placeholder="Escribe tu apellido" value="<?php echo s($usuario->apellido);?>">
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Tu telefono" value="<?php echo s($usuario->telefono);?>">
    </div>
    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Tu email" value="<?php echo s($usuario->email);?>">
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu password">
    </div>

    <input type="submit" class="boton" value="Crear Cuenta">
</form>

<div class="acciones">
    <a href="/">¿Tienes una cuenta? Inicia Sesión</a>
    <a href="/olvide">Olvide mi Contraseña</a>
</div>