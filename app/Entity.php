<?php
    namespace App;

    abstract class Entity{

        protected function hydrate($data){

            foreach($data as $field => $value){

                //field = marque_id
                //fieldarray = ['marque','id']
                $fieldArray = explode("_", $field);

                if(isset($fieldArray[1]) && $fieldArray[1] == "id"){
                    $manName = ucfirst($fieldArray[0])."Manager";
                    $FQCName = "Model\Managers".DS.$manName;
                    
                    $man = new $FQCName();
                    $value = $man->findOneById($value);
                }
                //fabrication du nom du setter à appeler (ex: setMarque)
                $method = "set".ucfirst($fieldArray[0]);
               
                if(method_exists($this, $method)){
                    $this->$method($value);
                }

            }
        }

        public function getClass(){
            return get_class($this);
        }
    }