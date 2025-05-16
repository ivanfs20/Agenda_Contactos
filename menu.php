
<nav>
            <?php
				if (isset($_SESSION["tipo"])){
					if ($_SESSION["tipo"]=="Administrador"){
			
					
			?>
        <ul>
		<li><a href="inicio.php" class="menu">Inicio</a></li>

          <li><a href="tabAdmin.php" class="menu">ABC Personal</a></li>
          <li><a href="tabContactos.php" class="menu">ABC Contactos</a></li>
  		  <li><a href="logout.php" class="menu">Salir</a></li>
        </ul>
			<?php
				}else{
			?>

<ul>
<li><a href="inicio.php" class="menu">Inicio</a></li>

          <li><a href="visualizadorContactos.php" class="menu">Contactos</a></li>
  		  <li><a href="logout.php" class="menu">Salir</a></li>
        </ul>
			<?php
				}
			?>

			<?php
				} else {
			?>
			<ul id="listaNav">
				<li> <a href="#" class="menu">Opcion 1</a> </li>
				<li> <a href="#" class="menu">Opcion 2</a> </li>
				<li> <a href="#" class="menu">Opcion 3</a> </li>
			</ul>
			<?php
				}
			?>
        </nav>
