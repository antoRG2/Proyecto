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
require_once $_SERVER['DOCUMENT_ROOT'].'/Sistema/modulos/login/modelo/sesion.php';

require_once '../modelo/clase.item.php';
$objItems = new Item;
$objItems -> set_ID($itemID);
$objItems -> _QUERY();

require_once '../modelo/clase.respuesta.php';
$objR = new Respuesta;
$objR -> set_ItemID($itemID);
$objR -> _QUERY();
	
require_once '../../areaConocimiento/modelo/clase.areaC.php';
$objArea = new AreaC;
$objArea -> _QUERY();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Sistema</title>
        <link rel="stylesheet" type="text/css" href="../../../CSS/menu.css">
        <link rel="stylesheet" type="text/css" href="../../../CSS/site.css">
        <link rel="stylesheet" type="text/css" 
            href="../../../CSS/Elementos de Prueba/modificarItem.css">
        <link rel="stylesheet" type="text/css" href="../../../CSS/jquery.ui.css">
    
    
        <script  src="../../../js/jquery.js"></script>
        <script  src="../../../js/jquery.ui.js"></script>
        <script  src="../../../js/menu.js"></script>
        <script  src="../../../js/modificarItems.js"></script>
    </head>
    <body>
        <?php require_once '../../interfaz.menu.php';?>
        <br />
	    <div class="transBack">
		    <div class="displayData">
			    <div class="title">
				    <h2>Modificar Items</h2>
			    </div>	
		
			    <br />
			    <form name="FRMItems" id="FRMItems" method="post" 
                    action="../modelo/control.item.php">
				    <input type="hidden" name="editar" value="1" />
				    <input type="hidden" name="itemID" id="itemID" 
                        value="<?=$itemID?>" />
				    <table>
					    <tr>
						    <td><label for="nombre">Nombre:</label></td>
						    <td><input type="text" name="nombre" id="nombre" 
                                value="<?=$objItems->get_Nombre(0,'INPUT')?>"/></td>
					    </tr>
					    <tr>
						    <td><label for="dificultad">Dificultad:</label></td>
						    <td><select name="dificultad" id="dificultad">
							    <option value="0">...</option>
							    <option value="1" <?php if($objItems -> 
                                get_Dificultad(0) == 1) echo "selected" ?>>
                                    F&aacute;cil</option>
							    <option value="2" <?php if($objItems -> 
                                get_Dificultad(0) == 2) echo "selected" ?>
                                    >Medio</option>
							    <option value="3" <?php if($objItems ->
                                get_Dificultad(0) == 3) echo "selected" ?>
                                    >Dificil</option>
						    </select></td>
					    </tr>
					    <tr>
						    <td><label for="tipo">Tipo:</label></td>
						    <td><select name="tipo" id="tipo" 
                                class="scheck" disabled>
							    <option value="0" >...</option>
							    <option value="1" <?php 
                                if($objItems -> get_Tipo(0) == 1) echo 
                                 "selected" ?>>Seleci&oacute;n &Uacute;nica</option>
							    <option value="2" <?php 
                                if($objItems -> get_Tipo(0) == 2) echo
                                    "selected" ?>>Drag / Drop</option>
						        </select><input type="hidden" name="tipo" id="tipo" 
                                value="<?=$objItems -> get_Tipo(0)?>"/></td>
					    </tr>
					    <tr>
						    <td><label for="clasificacion">Clasificaci&oacute;n:
						        </label></td>
						    <td><select name="clasificacion" id="clasificacion" 
                                class="scheck" disabled>
							    <option value="0" >...</option>
							    <option value="1" <?php if($objItems ->
                                  get_Clasificacion(0) == 1) echo "selected" 
                                ?>>Imagenes</option>
							    <option value="2" <?php if($objItems -> 
                                get_Clasificacion(0) == 2) echo "selected" ?>>Texto</option>
							    <option value="3" <?php if($objItems -> get_Clasificacion(0)
                                    == 3) echo "selected" ?>>Audio</option>
						     </select><input type="hidden" name="clasificacion" 
                                id="clasificacion" value="<?=$objItems ->
                                get_Clasificacion(0)?>"/></td>
					    </tr>
					    <tr>
						    <td><label for="tEnunciado">Tipo Enunciado:</label>
						    </td>
						    <td><select name="tEnunciado" id="tEnunciado" disabled>
							    <option value="0" selected>...</option>
							    <option value="1" <?php if($objItems -> 
                                 get_Tipoenunciado(0) == 1) echo "selected" ?>>
                                    Imagenes</option>
							    <option value="2" <?php if($objItems -> 
                                get_Tipoenunciado(0) == 2) echo "selected" ?>>
                                    Texto</option>
							    <option value="3" <?php if($objItems -> 
                                get_Tipoenunciado(0) == 3) echo "selected" ?>>
                                    Audio</option>
						    </select><input type="hidden" name="tEnunciado"
                                 id="tEnunciado" value="<?=$objItems -> 
                                 get_Tipoenunciado(0)?>"/></td>
					    </tr>
					    <tr>
                            <td><label>Enunciado:</label></td>
                            <td id='tdEnunciado1' <?php if($objItems -> 
                                        get_Tipoenunciado(0) != 1) echo 
                                        "style='display: none'";?>>
	                            <?php if($objItems -> get_Tipoenunciado(0) == 1){?>
		                            <img id="img" style="width: 150px; 
                                    height: 150px;" src="../../../Files/<?=$itemID?>/IMG/<?=$objItems -> 
                                        get_Enunciado(0)?>"/>&nbsp;&nbsp;
		                            <input type="hidden" id="enunciadoImgT" 
                                        name="enunciadoImgT" value="<?=$objItems -> 
                                        get_Enunciado(0)?>" />
		                            <input type="button"  id="EliminarI" value="Eliminar"/>
	                            <?php }?>
	                            <input style="display: none" type="file" 
                                    name='enunciadoImg' id='enunciadoImg'/>
                            </td>
                            <td id='tdEnunciado2' <?php if($objItems -> 
                                    get_Tipoenunciado(0) != 2) echo "style='display: none'";?>>
                                <input type="text" value="<?=$objItems -> get_Enunciado(0,'INPUT')?>" name='enunciadoTxt' id='enunciadoTxt'/></td>
                            <td id='tdEnunciado3' <?php if($objItems -> get_Tipoenunciado(0) != 3) echo "style='display: none'";?>>
	                            <?php if($objItems -> get_Tipoenunciado(0) == 3){?>
	                            <audio id='audio' controls title="<?=$objItems -> get_Enunciado(0)?>">
		                            <source src="../../../Files/<?=$itemID?>/AUDIO/<?=$objItems -> get_Enunciado(0)?>" type="audio/mpeg">
		                            <embed id="audiow" height="50" width="100" src="../../../Files/<?=$itemID?>/AUDIO/<?=$objItems -> get_Enunciado(0)?>">
	                            </audio>&nbsp;&nbsp;
	                            <input type="hidden" id="enunciadoAudioT" name="enunciadoAudioT" value="<?=$objItems -> get_Enunciado(0)?>" />
	                            <input type="button"  id="EliminarA" value="Eliminar"/>
	                            <?php }?>
	                            <input style="display: none" type="file" name='enunciadoAudio' id='enunciadoAudio'/>
                            </td>
				    </tr>
					    <tr>
						    <td><label for="descripcion">Descripci&oacute;n:</label></td>
						    <td><textarea id="descripcion" name="descripcion" style="width: 658px;height: 66px;">
                            <?=$objItems -> get_Descripcion(0,'HTML')?></textarea></td>
					    </tr>
					    <tr>
						    <td><label for='areaC'>&Aacute;rea de Conocimiento:</label></td>
						    <td><?=$objArea -> _HTML_SELECT($objItems -> get_AreaConocimiento_ID(0))?></td>
					    </tr>
					    <tr>
						    <td><label for="nRespuestas">Cantidad de Respuestas:</label></td>
						    <td><input type='text' readonly size='2' value="<?=$objR -> get_Contador()?>"  
                                style="width:20px" id='nRespuestas' name="nRespuestas"/></td>
					    </tr>
				    </table>
				    <br />
				    <div id="areaRespuestas"></div>
				    <script language="JavaScript">
					    $('#areaRespuestas').load('interfaz.respuesta.editar.php?itemID=<?=$itemID?>');
					    contRespuestas = <?=$objR -> get_Contador()?>;
					    INITTYPE = <?=$objItems -> get_Clasificacion(0)?>;
					    INITTYPEEN = <?=$objItems -> get_Tipoenunciado(0)?>;
				    </script>
				    <br />
			    <center>
				    <div id="controlbuttonsDiv">
					    <div class="controlbuttons"><input type="button" 
                            name="btnCancelar" id="btnCancelar"
                             value='Cancelar'/></div>
					    <div class="controlbuttons"><input type="button"
                             name="btnGuardar"  id="btnGuardar"
                             value='Guardar'/></div>					
				    </div>
			    </center>
			    </form>
		    </div>
	    </div>
    </body>
</html>



<!--//********************************************************************//-->