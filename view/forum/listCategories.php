<?php

$categories = $result["data"]['categories'];
    
?>

<h1>liste catégories</h1>

<?php
foreach($categories as $category ){

    ?>
    <a href="index.php?ctrl=forum&action=listTopicByCat&id=<?= $category->getId() ?>&catName=<?= $category->getName() ?>"><?=$category->getName()?></a><br>
    <?php
}


  
