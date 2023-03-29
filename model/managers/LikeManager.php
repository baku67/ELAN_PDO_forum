<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\LikeManager;

    class LikeManager extends Manager{

        protected $className = "Model\Entities\Like";
        protected $tableName = "liking_post";


        public function __construct(){
            parent::connect();
        }

        

    }