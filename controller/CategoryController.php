<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\CategoryManager;

    
    class CategoryController extends AbstractController implements ControllerInterface{

        public function index(){
          

           $categoryManager = new CategoryManager();

            return [
                "view" => VIEW_DIR."forum/listCategories.php",
                "data" => [
                    "categories" => $categoryManager->findAll(["name", "DESC"])
                ]
            ];
        
        }


        

    }
