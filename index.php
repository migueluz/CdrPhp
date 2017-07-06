<?php 

include 'fw/Router.php';
include 'fw/Model.php';
include 'fw/Dispatch.php';
include 'fw/DB.php';
include 'fw/Controller.php';
include 'fw/Result.php';
include 'src/controllers/Configuration.php';
include 'src/controllers/Reporter.php';
include 'src/model/Registers.php';
include 'src/model/Configurations.php';

set_time_limit (120);

new Dispatch(new Router(
array(
		'/generarReporte'=>'Reporter:reportGenerator',
		'/registrarLlamada'=>'Reporter:registrarLlamada'
	)
),array(
	'host'=>'127.0.0.1',
	'user'=>'root',
	'password'=>'',
	'dataBase'=>'cdr',
	'appName'=>'cdr'	
));

?>