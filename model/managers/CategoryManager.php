<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\CategoryManager;

    class CategoryManager extends Manager{

        protected $className = "Model\Entities\Category";
        protected $tableName = "category";


        public function __construct(){
            parent::connect();
        }


        public function findAllAndCount() {
            // name ASC

            $sql="
                SELECT c.id_category, c.name, COUNT(t.id_topic) AS nbrTopics
                FROM topic t
                RIGHT JOIN category c ON t.category_id = c.id_category
                GROUP BY c.id_category
                ORDER BY c.name ASC
            ";

            return $this->getMultipleResults(
                DAO::select($sql),
                $this->className
            );

        }


        

    }