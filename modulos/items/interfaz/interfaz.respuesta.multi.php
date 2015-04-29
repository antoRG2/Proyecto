<!--//***********************************************************************//   
//                                                                           //
//                                                                           //       
//                                                                           //  
//                                                                           //
//                                                                           //
//                                                                           //
//                                                                           //
//                                                                           //   
//                                                                           //
//************************************************************************//-->



<?php
/*
 * Este archivo recibe por parametros las variables del logeo y las procesa 
 * con ayuda de la clase clase.logeo.php
 *
 *
 * En esta parte se reciben las variables que vienen tanto como POST y como GET
 * y las convierte en variables propias.
 * Ejemplo
 * En lugar de tener que poner$_POST['nombre'] basta con simplemente poner 
 * $nombre para utilizar la variable.
 */

foreach ($_GET as $key => $value)
	$$key = $value;
foreach ($_POST as $key => $value)
	$$key = $value;
?>

<h2>Respuestas</h2>
<?php
if($clasificacion == 1){#Imagenes
?>
    <table>
        <thead>
            <tr>
	            <td>Respuesta</td>
	            <td>Acierto</td>
            </tr>
        </thead>
        <tbody id="tbRespuestas">
            <tr id='fila-base' style="display: none">
	            <td><input type="file" name="respuesta[]" id="respuesta" size="80"
                    /></td>
	            <td><input type="checkbox" name="checkbox[]" class="chk" id="chk"
                  /><input type="hidden" name="acierto[]" id="acierto" value="0"/></td>
            </tr>
            <?php for($i = 1; $i <= $cantR; $i++){?>
            <tr id='<?=$i?>'>
	            <td><input type="file" name="respuesta[]" id="respuesta<?=$i?>"
                     size="80"/></td>
	            <td><input type="checkbox" name="checkbox[]" class="chk" 
                    id="chk_<?=$i?>" /><input type="hidden" name="acierto[]" 
                        id="acierto<?=$i?>" value="0"/></td>
            </tr>
            <?php }?>
        </tbody>
    </table>
<?php }
if($clasificacion == 2){#Texto
?>
	<table>
		<thead>
		    <tr>
			    <td>Respuesta</td>
			    <td>Acierto</td>
		    </tr>
		</thead>
		<tbody id="tbRespuestas">
            <tr id='fila-base' style="display: none">
	            <td><input type="text" name="respuesta[]" id="respuesta"
                     size="80"/></td>
	            <td><input type="checkbox" name="checkbox[]" class="chk" 
                    id="chk"  /><input type="hidden" name="acierto[]" 
                        id="acierto" value="0"/></td>
            </tr>
            <?php for($i = 1; $i <= $cantR; $i++){?>
            <tr id='<?=$i?>'>
	            <td><input type="text" name="respuesta[]" id="respuesta<?=$i?>"
                     size="80"/></td>
	            <td><input type="checkbox" name="checkbox[]" class="chk" id="
                    chk_<?=$i?>" /><input type="hidden" name="acierto[]" id="
                        acierto<?=$i?>" value="0"/></td>
            </tr>
            <?php }?>
		</tbody>
	</table>
<?php
}
if($clasificacion == 3){#Audio
?>
	<table>
		<thead>
		<tr>
			<td>Respuesta</td>
			<td>Acierto</td>
		</tr>
		</thead>
		<tbody id="tbRespuestas">
		<tr id='fila-base' style="display: none">
			<td><input type="file" name="respuesta[]" id="respuesta" size="80"/>
			</td>
			<td><input type="checkbox" name="checkbox[]" class="chk" id="chk"
             /><input type="hidden" name="acierto[]" id="acierto" value="0"/>
			</td>
		</tr>
        <?php for($i = 1; $i <= $cantR; $i++){?>
		        <tr id='<?=$i?>'>
			        <td><input type="file" name="respuesta[]" id="respuesta<?=$i?>"
                         size="80"/></td>
			        <td><input type="checkbox" name="checkbox[]" class="chk" 
                    id="chk_<?=$i?>" /><input type="hidden" name="acierto[]" 
                        id="acierto<?=$i?>" value="0"/></td>
		        </tr>
        <?php }?>
		</tbody>
	</table>
<?php
}
?>

<!--//********************************************************************//-->