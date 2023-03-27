<?php

$topics = $result["data"]['topics'];
    
?>

<h1>liste topics</h1>

<?php
foreach($topics as $topic ){

    ?>
    <p><span class="categoryLabel"><?=$topic->getCategory()->getName()?></span><a href="index.php?ctrl=forum&action=topicDetail&id=<?= $topic->getId() ?>"><?=$topic->getTitle()?></a></p>
    <br>
    <?php
}


  
