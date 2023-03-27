<?php

$topic = $result["data"]['topicDetail'];
    
?>

<h1>Detail du topic</h1>


    <p><?=$topic->getTitle()?></p>
    <p>by <?=$topic->getUser()->getUsername()?></p>


  
