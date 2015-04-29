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

foreach ($_GET as $key => $value) {
    $$key = $value;
}
foreach ($_POST as $key => $value) {
    $$key = $value;
}

session_name('SS');
session_start();
$usuario = $_SESSION['user'];//Cédula del Usuario.
$pass = $_SESSION['pass'];
$usuario_id = $_SESSION['userID'];
$tipoUsuario = $_SESSION['tipoUsuario'];

require_once $_SERVER['DOCUMENT_ROOT'] . 
                        '/Sistema/modulos/login/modelo/clase.logeo.php';

$obj = new Logeo;
$obj->set_Cedula($usuario);
$obj->set_Clave($pass);
$obj->_CONSULTAR_USUARIO();
if ($obj->get_Contador() <= 0) {
    echo '<script language="javascript">';
    echo 'location.href = "http://' . $_SERVER['HTTP_HOST'] . '/index.php';
    echo '</script>';
}
?>


<!--//********************************************************************//-->