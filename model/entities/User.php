<?php
    namespace Model\Entities;

    use App\Entity;

    final class User extends Entity{

        private $id;
        private $username;
        private $password;
        private $email;
        private $role;
        private $signInDate;
        private $status;
        // Champ "non mappé" (car pas présent en BDD)
        private $likesCount;


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


        public function getUsername()
        {
                return $this->username;
        }

        public function setUsername($username)
        {
                $this->username = $username;

                return $this;
        }

        public function getPassword()
        {
                return $this->password;
        }

        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        public function getEmail()
        {
                return $this->email;
        }

        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }


        
        public function getRole()
        {
                return $this->role;
        }

        public function setRole($role)
        {
                $this->role = $role;

                return $this;
        }


        public function getStatus()
        {
                return $this->status;
        }

        public function setStatus($status)
        {
                $this->status = $status;

                return $this;
        }


        public function getSignInDate(){
            $formattedDate = $this->signInDate->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setSignInDate($date){
            $this->signInDate = new \DateTime($date);
            return $this;
        }


        // Champ "non mappé" (car pas présent en BDD)
        public function getLikesCount() {

                return $this->likesCount;

        }
        public function setLikesCount($likesCount) {

                $this->likesCount = $likesCount;
                return $this;
                
        }

    }
