<?php
include_once("cabecera.html");
include_once("aside.html");
?>
        <section id="sectionIndex">
			<form id="frm" method="post" action="login.php">
			<div>
			Clave <br>  
				<input type="text" name="txtCve" required="true"/>
			</div>
			<div>
			Contrase&ntilde;a <br>
				<input type="password" name="txtPwd" required="true"/>
			</div>
            <div style="display:flex; justify-content:center">
            <input id="enviar" type="submit" value="Enviar"/>
            </div>
        </form>
		</section>


<?php
include_once("pie.html");
?>
