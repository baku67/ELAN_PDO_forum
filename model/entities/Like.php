<?php
    namespace Model\Entities;

    use App\Entity;

    final class Like extends Entity{

        private $id;
        private $user;
        private $post;


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


        public function getUser()
        {
                return $this->user;
        }

        public function setUser($user)
        {
                $this->user = $user;

                return $this;
        }


        public function getPost()
        {
                return $this->post;
        }

        public function setPost($post)
        {
                $this->post = $post;

                return $this;
        }

    }