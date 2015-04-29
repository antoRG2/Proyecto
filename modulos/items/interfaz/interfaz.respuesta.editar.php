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

require_once '../modelo/clase.respuesta.php';
$objR = new Respuesta;
$objR -> set_ItemID($itemID);
$objR -> _QUERY();
?>
<h2>Respuestas</h2>
<?php
if($objR -> get_Tipo(0) == 1 ){#Imagenes
?>
    <table>
	    <thead>
	        <tr>
		        <td>Marca</td>
		        <td>Acierto</td>
	        </tr>
	    </thead>
	    <tbody id="tbRespuestas">
            <tr id='fila-base' style="display: none">
	            <td><input type="file" name="respuesta[]" id="respuesta" size="80"/>
	            </td>
	            <td><input type="checkbox" name="checkbox[]" class="chk" id="chk"/>
                    <input type="hidden" name="acierto[]" id="acierto" value="0"/></td>
            </tr>
            <?php for($i = 0; $i < $objR -> get_Contador(); $i++){?>
            <tr id='<?=$i?>'>
	            <td><img style="width: 400px; height: 400px;" 
                    src="../../../Files/<?=$itemID?>/IMG/<?=$objR -> 
                    get_Descripcion($i)?>"/>&nbsp;&nbsp;<input type="button" 
                        class="eliminarR" id="EliminarR_<?=$objR -> 
                        get_ID($i)?>" value="Eliminar"/>
		            <input type="hidden" id="descripcion_<?=$objR ->
                    get_ID($i)?>" name="descripcionRM[]" value="<?=$objR ->
                    get_Descripcion($i)?>" />
	            </td>
	            <td><input type="checkbox" name="checkbox[]" class="chk" 
                    id="chk_<?=$i?>"  <?php if($objR -> get_Acierto($i) == 1) 
                    echo "checked";?> /><input type="hidden" name="aciertoRM[]"
                    id="acierto<?=$i?>" value="<?=$objR -> get_Acierto($i)?>"/></td>
            </tr>
            <?php }?>
	    </tbody>
    </table>
<?php }
if($objR -> get_Tipo(0) == 2){#Texto	
?>
    <table>
	    <thead>
	        <tr>
		        <td>Marca</td>
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
            <?php for($i = 0; $i < $objR -> get_Contador(); $i++){?>
            <tr id='<?=$i?>'>
	            <td><input type="text" name="respuesta[]" id="respuesta<?=$i?>"
                 value="<?=$objR -> get_Descripcion($i,"INPUT")?>" size="80"/></td>
	            <td><input type="checkbox" name="checkbox[]" class="chk" 
                    id="chk_<?=$i?>" <?php if($objR -> get_Acierto($i) == 1) 
                    echo "checked";?>/><input type="hidden" name="acierto[]" 
                    id="acierto<?=$i?>" value="<?=$objR -> get_Acierto($i)?>"/>
	            </td>
            </tr>
        <?php }?>
	    </tbody>
    </table>
    <?php
}
if($objR -> get_Tipo(0) == 3){#Audio
?>
	<table>
		<thead>
		<tr>
			<td>Marca</td>
			<td>Acierto</td>
		</tr>
		</thead>
		<tbody id="tbRespuestas">
            <tr id='fila-base' style="display: none">
	            <td><input type="file" name="respuesta[]" id="respuesta" 
                    size="80"/></td>
	            <td><input type="checkbox" name="checkbox[]" class="chk" id="chk"
              /><input type="hidden" name="acierto[]" id="acierto" value="0"/></td>
            </tr>
            <?php for($i = 0; $i < $objR -> get_Contador(); $i++){?>
            <tr id='<?=$i?>'>
	            <td><audio controls title="<?=$objR -> get_Descripcion($i)?>">
			            <source src="../../../Files/<?=$itemID?>/AUDIO/<?=$objR ->
                        get_Descripcion($i)?>" type="audio/mpeg">
			            <embed id="audio_<?=$i?>" height="50" width="100" 
                        src="../../../Files/<?=$itemID?>/AUDIO/<?=$objR ->
                        get_Descripcion($i)?>">
		            </audio>&nbsp;&nbsp;<input type="button" class="eliminarR" 
                    id="EliminarR_<?=$objR -> get_ID($i)?>" value="Eliminar"/>
		            <input type="hidden" id="descripcion_<?=$objR -> get_ID($i)?>" 
                    name="descripcionRM[]" value="<?=$objR ->
                    get_Descripcion($i)?>" />
	            </td>
	            <td><input type="checkbox" name="checkbox[]" class="chk" 
                    id="chk_<?=$i?>"  <?php if($objR -> get_Acierto($i) == 1) 
                    echo "checked";?> /><input type="hidden" name="aciertoRM[]" 
                    id="acierto<?=$i?>" value="<?=$objR -> get_Acierto($i)?>"/></td>
            </tr>
            <?php }?>
		</tbody>
	</table>
<?php
}
?>


<!--//********************************************************************//-->