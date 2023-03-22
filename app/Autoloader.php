<?php
	namespace App;
	
	class Autoloader{

		public static function register(){
			spl_autoload_register(array(__CLASS__, 'autoload'));
		}

		public static function autoload($class){

			//$class = Model\Managers\VehiculeManager (FullyQualifiedClassName)
			//namespace = Model\Managers, nom de la classe = VehiculeManager

			// on explose notre variable $class par \
			$parts = preg_split('#\\\#', $class);
			//$parts = ['Model', 'Managers', 'VehiculeManager']

			// on extrait le dernier element 
			$className = array_pop($parts);
			//$className = VehiculeManager

			// on créé le chemin vers la classe
			// on utilise DS car plus propre et meilleure portabilité entre les différents systèmes (windows/linux) 

			$path = strtolower(implode(DS, $parts));
			//$path = 'model/manager'
			$file = $className.'.php';
			//$file = VehiculeManager.php

			$filepath = BASE_DIR.$path.DS.$file;
			//$filepath = model/managers/VehiculeManager.php
			if(file_exists($filepath)){
              
				require $filepath;
			}
			
		}
	}
