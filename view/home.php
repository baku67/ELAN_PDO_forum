<h1>BIENVENUE SUR LE FORUM</h1>

<?php

if (isset($result["data"])) {

    var_dump($result["data"]["dbPass"]);
    echo "<br>";
    var_dump($result["data"]["hashPassword"]);
    echo "<br>";
    var_dump($result["data"]["user"]);

}

?>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>

<!-- <p>
    <a href="/security/login.html">Se connecter</a>
    <span>&nbsp;-&nbsp;</span>
    <a href="/security/register.html">S'inscrire</a>
</p> -->