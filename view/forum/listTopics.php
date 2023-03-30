<?php

$topics = $result["data"]['topics'];
// $posts = $result["data"]['posts'];

$categories = $result["data"]['categories'];

$totalCountTopics = $result["data"]['totalCountTopics'];

if (isset($result["data"]["catName"])) {
    $catName = "(".$result["data"]["catName"].")";
}
else {
    $catName = "";
}
    
?>

<h1>liste topics (<?= $totalCountTopics["count"] ?>) <?= $catName ?> </h1>

<?php
foreach($topics as $topic ){
    if($topic->getStatus() == 1) {
        $statusText = "Ouvert";
    }
    else {
        $statusText = "Fermé";
    }

    // Chercher "carbon php time human reading" library
    // Formattage *Time*Temps*Date
    $date0 = str_replace("/", "-", $topic->getCreationdate());
    $date1 = trim($date0, ",");
    $date2 = new DateTime($date1, new DateTimeZone("+0000"));
    
    $dateNow0 = date("Y-m-d H:i:s");
    $dateNow1 = new DateTime($dateNow0, new DateTimeZone("+0200"));

    $dateDiff0 = $date2->diff($dateNow1);
    $dateDiff1 = $dateDiff0->format("il y a %Ya %mm %dj, %Hh %im %ss");

?>
    <a href="index.php?ctrl=forum&action=topicDetail&id=<?= $topic->getId() ?>">
    <div class="topicCard">
        <p><span class="categoryLabel"><?=$topic->getCategory()->getName()?></span><?=$topic->getTitle()?><span> &nbsp;(<?= $statusText ?>)</span></p>
        <p><?= $topic->getLastPostMsg() ?></p>
        <p><?= $dateDiff1 ?>, par <a class="userLink" href="index.php?ctrl=security&action=viewUserProfile&id=<?= $topic->getUser()->getId() ?>"><?= $topic->getUser()->getUsername() ?></a></p>
    </div>
    </a>
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


  
