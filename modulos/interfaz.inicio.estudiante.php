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
require_once $_SERVER['DOCUMENT_ROOT'].'/Sistema/modulos/login/modelo/sesion.php';
require_once $_SERVER['DOCUMENT_ROOT'].
    '/Sistema/modulos/estudiantes/modelo/clase.estudiantes.php';

require_once $_SERVER['DOCUMENT_ROOT'].
    '/Sistema/modulos/profesores/modelo/clase.profesores.php';

//La variable Usuario es a cédula del Estudiante.

#Carga la información del Estudiante
$objE = new Estudiante;
$objE ->set_Cedula($usuario);
$objE ->_Query();

#Carga la información del Profesor
$objP = new Profesor;
$objP -> set_Estudiante_id($usuario);
$objP ->_Query_Estudiantes();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Sistema</title>
        <link rel="stylesheet" type="text/css" href="../CSS/menu.css">
    
        <script  src="../js/jquery.js"></script>
        <script  src="../js/menu.js"></script>
    </head>
    <body>
	    <div class="backgroundTransparent">
		    <h1>
                        ¡Bienvenido<?=$objE ->get_Nombre(0, "HTML")?>!
		    </h1>
                <br />
            
                <h2>Profesores</h2>
            
                <ul>
                <?php
                    for($i = 0; $i < $objP ->get_Contador(); $i++)
                    {?>
                    <li>
                        <a href="pruebas/lista.pruebas.php?profesor=<?=$objP
                        ->get_Cedula(0)?>"><?=$objP -> get_Nombre($i, "HTML")?></a>
                    </li>
                <?php }?>
                </ul>
	    </div>
    </body>
</html>



<!--//********************************************************************//-->