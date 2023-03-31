<?php
    namespace Model\Entities;

    use App\Entity;

    final class Category extends Entity{

        private $id;
        private $name;
        // Champ "non mappé" (car pas présent en BDD)
        private $nbrTopics;


        public function __construct($data){         
            $this->hydrate($data);        
        }
 

        public function getId()
        {
                return $this->id;
        }

        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }


        public function getName()
        {
                return $this->name;
        }

        public function setName($name)
        {
                $this->name = $name;

                return $this;
        }


        public function getNbrTopics() {

                return $this->nbrTopics;
        }

        public function setNbrTopics($nbrTopics) {

                $this->nbrTopics = $nbrTopics;

                return $this;
        }


    }
