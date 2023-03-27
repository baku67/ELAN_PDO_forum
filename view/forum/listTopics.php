<?php

$topics = $result["data"]['topics'];
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
    <br>
    <?php
}


  
