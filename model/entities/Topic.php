<?php
    namespace Model\Entities;

    use App\Entity;

    final class Topic extends Entity{

        private $id;
        private $title;
        private $user;
        private $creationdate;
        private $closed;

        public function __construct($data){         
            $this->hydrate($data);        
        }
 
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of title
         */ 
        public function getTitle()
        {
                return $this->title;
        }

        /**
         * Set the value of title
         *
         * @return  self
         */ 
        public function setTitle($title)
        {
                $this->title = $title;

                return $this;
        }

        /**
         * Get the value of user
         */ 
        public function getUser()
        {
                return $this->user;
        }

        /**
         * Set the value of user
         *
         * @return  self
         */ 
        public function setUser($user)
        {
                $this->user = $user;

                return $this;
        }

        public function getCreationdate(){
            $formattedDate = $this->creationdate->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setCreationdate($date){
            $this->creationdate = new \DateTime($date);
            return $this;
        }

        /**
         * Get the value of closed
         */ 
        public function getClosed()
        {
                return $this->closed;
        }

        /**
         * Set the value of closed
         *
         * @return  self
         */ 
        public function setClosed($closed)
        {
                $this->closed = $closed;

                return $this;
        }
    }
