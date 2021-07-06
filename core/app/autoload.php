<?php
// autoload.php
// [created] 10 octubre del 2014
// [rebuilded] 4 enero del 2019
// esta funcion elimina el hecho de estar agregando los modelos manualmente
// by eabanto2

function edg_autoload($modelname){
	if(Model::exists($modelname)){
		include Model::getFullPath($modelname);
	} 
}

spl_autoload_register('edg_autoload');

?>