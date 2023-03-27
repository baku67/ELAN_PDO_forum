<?php

$topics = $result["data"]['topics'];
    
?>

<h1>liste topics</h1>

<?php
foreach($topics as $topic ){

    ?>
    <a href="index.php?ctrl=forum&action=topicDetail&id=<?= $topic->getId() ?>"><?=$topic->getTitle()?></a><br>
    <?php
}


  
