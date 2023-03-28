<?php

$topics = $result["data"]['topics'];
// $posts = $result["data"]['posts'];

$categories = $result["data"]['categories'];

if (isset($result["data"]["catName"])) {
    $catName = "(".$result["data"]["catName"].")";
}
else {
    $catName = "";
}
    
?>

<h1>liste topics <?= $catName ?> </h1>

<?php
foreach($topics as $topic ){

    ?>
    <p><span class="categoryLabel"><?=$topic->getCategory()->getName()?></span><a href="index.php?ctrl=forum&action=topicDetail&id=<?= $topic->getId() ?>"><?=$topic->getTitle()?></a></p>
    <p>...<?php echo var_dump($topic->getLastMsg()) ?></p>
    <br>
    <?php
}
?>



<p>Créer un topic:</p>
<form action="index.php?ctrl=forum&action=createTopic" method="post">
    <label>Titre</label>
    <input id="title" type="text" name="title" placeholder="Titre">
    <label>1er message</label>
    <textarea name="firstMsg" placeholder="blabla..." rows="5"></textarea>
    <label>Catégorie</label>
    <select id="category" name="category">
        <?php 
        foreach ($categories as $category) { 
        ?>
            <option value="<?= $category->getId() ?>"><?= $category->getName() ?></option>
        <?php 
        }
        ?>
    </select>
    <input id="submit" type="submit" value="Créer">
</form>


  
