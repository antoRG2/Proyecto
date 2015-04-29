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
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once $_SERVER['DOCUMENT_ROOT'].
    '/Sistema/modulos/login/modelo/sesion.php';
require_once $_SERVER['DOCUMENT_ROOT'].
    '/Sistema/modulos/configuraciones/modelo/clase.configuracion.php';

$objConf = new Configuracion;
//$usuario es la variable de sesion que representa la cédual de la persona que esta logeada.
$objConf -> set_Cedula($usuario); 
$objConf -> set_profesorC($_GET['profesor']);
$objConf ->set_Finalizada(0);
$objConf -> _Query_Estudiante_Profesor();

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Sistema</title>
        <link rel="stylesheet" type="text/css" href="/CSS/menu.css">
    
        <script  src="/js/jquery.js"></script>
    </head>
    <body>
        <div class="backgroundTransparent">
                <h2>Configuraciones</h2>
            
                <ul>
                <?php
                    for($i = 0; $i < $objConf ->get_Contador(); $i++)
                    {?>
                    <li>
                        <a href="ejecutar.pruebas.php?id=<?=$objConf ->
                        get_EstudianteConfID($i)?>&test=<?=$objConf ->
                        get_ID($i)?>"><?=$objConf ->get_Nombre($i,"HTML")?></a>
                    </li>
                <?php }?>
                </ul>
                <br />
                <br />
                <a href="/Sistema/modulos/interfaz.inicio.estudiante.php">
                    Regresar</a>
	    </div>
    </body>
</html>


<!--//********************************************************************//-->