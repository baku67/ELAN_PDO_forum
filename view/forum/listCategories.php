<?php

$categories = $result["data"]['categories'];

$userConnectedRoleFromBdd = $result["data"]['userConnectedRoleFromBdd'];
    
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
// On check le role de l'user connecté depuis la BDD et non la SESSION (pour si changement de role en cours de session active)
if($userConnectedRoleFromBdd == "ROLE_ADMIN"){
?>
    <p>Ajouter une catégorie</p>
    <form action="index.php?ctrl=category&action=addCategory" method="post">
        <label for="categoryName"></label>
        <input id="categoryName" name="categoryName" type="text" maxlength="20">
        <input type="submit" value="ajouter">
    </form>
<?php
}
?>


  
