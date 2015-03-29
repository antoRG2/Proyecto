<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once $_SERVER['DOCUMENT_ROOT'].'/Sistema/modulos/login/modelo/sesion.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Sistema/modulos/configuraciones/modelo/clase.configuracion.ejecutar.php';


/*
 * Si la variable $continue existe quiere decir que el estudiante está ejecutando la prueba
 * por lo que se guarda el resultado del item actual y se carga el nuevo.
 */
if(isset($continue))
{
    if($continue == 1)//Seleccion única
    {
        require_once $_SERVER['DOCUMENT_ROOT'].'/Sistema/modulos/pruebas/modelo/clase.guardarprueba.php';
        $obG = new Guardar;
        $resultado = 1;
        for($i = 0; $i < count($respuestaSel); $i++)
        {
            if($respuestaSel[$i] != $aciertoRM[$i])
            {
                $resultado = 0;
                break;
            }      
        }
        /*
         * El id de la prueba en relacion al estudiante y al profesor
         * el id del item que se acaba de responder, y si acerto o no la respuesta.
         */
        if($obG -> GuardarResultados($id,$itemID,$resultado))
        {
            $pos = $pos + 1;
        }
        else 
        {
            die("Error Al guardar");
        }
        isset($obG);
    }
}//FIN del IF CONTINUE
else
{
    /*
     * Al ser la primera vez que se carga la página se valida si la prueba ya fue iniciada
     * y de ser ese el caso, entonces se eliminan los datos anteriores y se procese a escribir de 
     * nuevo los resultados.
     */
     require_once $_SERVER['DOCUMENT_ROOT'].'/Sistema/modulos/pruebas/modelo/clase.guardarprueba.php';
     $obG = new Guardar;
     
     $obG -> EliminarAnterior($id);
     isset($obG);
}

/*
 * La posición del Item que se va a ejecutar.
 * Cuando supera la posicion, se terminó la prueba.
 */
if(!isset($_POST['pos']))
    $pos = 0;

$obE = new Ejecucion;
$obE -> SET_CONFIGURACIONID($test);
$obE -> SET_POSICION($pos);
$obE -> _QUERY_ITEMS();
$obE -> _QUERY_RESPUESTAS();

/*
 * Se hace la validación de si hay mas Items en la configuración
 * si no hay , entonces se termina la prueba
 */
if(!$obE ->GET_ITEMID() == '')
{

    if($obE ->GET_ITEMTIPO() == 1) //Seleccion única
    {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Sistema</title>    
        <script  src="../../js/jquery.js"></script>
        <script>
            jQuery(function($) {
                $(".chk").click(function(){
                    var id = $(this).attr("id").split("_")[1];
                    if($(this).prop("checked") == 1)
                      $("#respuestaSel_"+id).val(1);
                    else
                        $("#respuestaSel_"+id).val(0);
                });

            });
        </script>
    </head>
    <body>
        <form name="prueba" id="prueba" action="" method="post">
            <input type="hidden" id="pos" name="pos" value="<?=$pos?>" />
            <input type="hidden" id="test" name="test" value="<?=$test?>" />
            <input type="hidden" id="continue" name="continue" value="1" />
            <input type="hidden" id="itemID" name="itemID" value="<?=$obE ->GET_ITEMID()?>" />
            <input type="hidden" id="id" name="id" value="<?=$id?>" />
        <!--En esta primera parte se carga el tipo de Enunciado que posee el item -->
        <div class="backgroundTransparent">
        <?php
            if($obE ->GET_ITEMTIPOENUNCIADO() == 1) //IMAGEN
            {
        ?>        
            <img id="img" style="width: 150px; height: 150px;" src="../../../Files/<?=$obE ->GET_ITEMID()?>/IMG/<?=$obE ->GET_ITEMENUNCIADO()?>"/>  
        <?php
            }//FIN DE IMAGEN
             if($obE ->GET_ITEMTIPOENUNCIADO() == 2) //TEXTO
             {
        ?>
            <h2><?=$obE ->GET_ITEMENUNCIADO("HTML")?></h2>
        <?php
            }//FIN DE TEXTO
            if($obE ->GET_ITEMTIPOENUNCIADO() == 3) //AUDIO
            {
        ?>
            <audio id='audio' controls title="<?=$objItems -> get_Enunciado(0)?>">
                <source src="../../../Files/<?=$obE ->GET_ITEMID()?>/AUDIO/<?=$obE ->GET_ITEMENUNCIADO()?>" type="audio/mpeg">
                <embed id="audiow" height="50" width="100" src="../../../Files/<?=$obE ->GET_ITEMID()?>/AUDIO/<?=$obE ->GET_ITEMENUNCIADO()?>">
             </audio>&nbsp;&nbsp;
        <?php    
            }//FIN DE AUDIO
        ?>
             <br />

       <?php
    if($obE ->GET_RESPUESTATIPO(0) == 1 ){#Imagenes
    ?>
    <table>

                    <tbody id="tbRespuestas">
    <?php for($i = 0; $i < $obE ->GET_RESPUESTACONT(); $i++){?>
                    <tr id='<?=$i?>'>
                        <td><img style="width: 400px; height: 400px;" src="../../../Files/<?=$obE ->GET_ITEMID()?>/IMG/<?=$obE ->GET_RESPUESTADESC($i)?>"/>
                            </td>
                            <td><input type="checkbox" name="checkbox[]" class="chk" id="chk_<?=$i?>" />
                                <input type="hidden" name="respuestaSel[]" id="respuestaSel_<?=$i?>" value="0" />
                            <input type="hidden" name="aciertoRM[]" id="acierto<?=$i?>" value="<?=$obE ->GET_RESPUESTAACIERTO($i)?>"/></td>
                    </tr>
    <?php }?>
                    </tbody>
            </table>
    <?php }
    if($obE -> GET_RESPUESTATIPO(0) == 2){#Texto

    ?>
            <table>

                    <tbody id="tbRespuestas">
    <?php for($i = 0; $i < $obE ->GET_RESPUESTACONT(); $i++){?>
                    <tr id='<?=$i?>'>
                            <td><?=$obE ->GET_RESPUESTADESC($i)?></td>
                            <td><input type="checkbox" name="checkbox[]" class="chk" id="chk_<?=$i?>"/>
                                <input type="hidden" name="respuestaSel[]" id="respuestaSel_<?=$i?>" value="0"/>
                             <input type="hidden" name="aciertoRM[]" id="acierto<?=$i?>" value="<?=$obE ->GET_RESPUESTAACIERTO($i)?>"/></td>
                    </tr>
    <?php }?>
                    </tbody>
            </table>
    <?php
    }
    if($obE -> GET_RESPUESTATIPO(0) == 3){#Audio
    ?>
            <table>
                    <tbody id="tbRespuestas">
    <?php for($i = 0; $i < $obE ->GET_RESPUESTACONT(); $i++){?>
                    <tr id='<?=$i?>'>
                            <td><audio controls title="<?=$obE ->GET_RESPUESTADESC($i)?>">
                                      <source src="../../../Files/<?=$obE ->GET_ITEMID()?>/AUDIO/<?=$obE ->GET_RESPUESTADESC($i)?>" type="audio/mpeg">
                                      <embed id="audio_<?=$i?>" height="50" width="100" src="../../../Files/<?=$itemID?>/AUDIO/<?=$obE ->GET_RESPUESTADESC($i)?>">
                                    </audio>&nbsp;&nbsp;<input type="button" class="eliminarR" id="EliminarR_<?=$obE ->GET_ITEMID()?>" value="Eliminar"/>
                                    <input type="hidden" id="descripcion_<?=$obE -> GET_RESPUESTAID($i)?>" name="descripcionRM[]" value="<?=$obE ->GET_RESPUESTADESC($i)?>" />
                            </td>
                            <td><input type="checkbox" name="checkbox[]" class="chk" id="chk_<?=$i?>"   />
                                <input type="hidden" name="respuestaSel[]" id="respuestaSel_<?=$i?>" value="0"/>
                            <input type="hidden" name="aciertoRM[]" id="acierto<?=$i?>" value="<?=$obE ->GET_RESPUESTAACIERTO($i)?>"/></td>
                    </tr>
    <?php }?>
                    </tbody>
            </table>
    <?php
    }
    ?>
             <br />
             <input type="submit" name="guardarRespuestas" id="guardarRespuestas" value="Enviar" />
        </div>
        </form>
    </body>
    </html>
    <?php 
        }//Fin del if si la prueba es Seleccion Unica
        else{ // Drag and Drop
    ?>
    <html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Sistema</title>    
        <script  src="/js/jquery.js"></script>
    </head>
    <body>
        <!--En esta primera parte se carga el tipo de Enunciado que posee el item -->
        <div class="backgroundTransparent">
        <?php
            if($obE ->GET_ITEMTIPOENUNCIADO() == 1) //IMAGEN
            {
        ?>        
            <img id="img" style="width: 150px; height: 150px;" src="../../../Files/<?=$obE ->GET_ITEMID()?>/IMG/<?=$obE ->GET_ITEMENUNCIADO()?>"/>  
        <?php
            }//FIN DE IMAGEN
             if($obE ->GET_ITEMTIPOENUNCIADO() == 2) //TEXTO
             {
        ?>
            <h2><?=$obE ->GET_ITEMENUNCIADO("HTML")?></h2>
        <?php
            }//FIN DE TEXTO
            if($obE ->GET_ITEMTIPOENUNCIADO() == 3) //AUDIO
            {
        ?>
            <audio id='audio' controls title="<?=$objItems -> get_Enunciado(0)?>">
                <source src="../../../Files/<?=$obE ->GET_ITEMID()?>/AUDIO/<?=$obE ->GET_ITEMENUNCIADO()?>" type="audio/mpeg">
                <embed id="audiow" height="50" width="100" src="../../../Files/<?=$obE ->GET_ITEMID()?>/AUDIO/<?=$obE ->GET_ITEMENUNCIADO()?>">
             </audio>&nbsp;&nbsp;
        <?php    
            }//FIN DE AUDIO
        ?>       
        </div>
    </body>
    </html>
<?php
    }//FIn del else si la pruena es de tipo drag and drop
}//Fin del IF si la prueba terminó
else{
    /*
     * Al terminar las pruebas se actualiza la tabla de pruebas por estudiante y se coloca la prueba como 
     * finalizada. 
     */
     require_once $_SERVER['DOCUMENT_ROOT'].'/Sistema/modulos/pruebas/modelo/clase.guardarprueba.php';
     $obG = new Guardar;
     
     $obG -> MarcarFinalizada($id);
     isset($obG);
     
?>
     <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Sistema</title>
    </head>
    <body>
        <br />
        <h2>Prueba finalizada</h2>
        <br />
        <br />
        <a href="/Sistema/modulos/interfaz.inicio.estudiante.php">Regresar</a>
    </body>
    </html>
<?php } ?>
