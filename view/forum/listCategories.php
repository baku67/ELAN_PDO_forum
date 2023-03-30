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
?>

<?php
if(App\Session::isAdmin()){
?>
    <p>Ajouter une catégorie</p>
    <form action="index.php?ctrl=security&action=addCategory" method="post">
        <label for="categoryName"></label>
        <input id="categoryName" name="categoryName" type="text" maxlength="20">
        <input type="submit" value="ajouter">
    </form>
<?php
}
?>


  
