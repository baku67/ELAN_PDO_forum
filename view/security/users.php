<?php

    $listUsers = $result["data"]['users'];

?>

<p>Liste des utilisateurs</p>
    <table id="usersTable">

        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Date d'inscription</th>
            </tr>
        </thead>

        <tbody>
        
            <?php 
            foreach($listUsers as $user) {
                $roleText = "";
                if($user->getRole() == "ROLE_USER") {
                    $roleText = "Utilisateur";
                }
                else if ($user->getRole() == "ROLE_ADMIN") {
                    $roleText = "Administrateur";
                }

                $statusText = "";
                if($user->getStatus() == 1) {
                    $statusText = "Strandard";
                }
                else if ($user->getStatus() == 0) {
                    $statusText = "Banni";
                }

                // Chercher "carbon php time human reading" library
                // Formattage *Time*Temps*Date
                $date0 = str_replace("/", "-", $user->getSignInDate());
                $date1 = trim($date0, ",");
                $date2 = new DateTime($date1, new DateTimeZone("+0000"));
                
                $dateNow0 = date("Y-m-d H:i:s");
                $dateNow1 = new DateTime($dateNow0, new DateTimeZone("+0200"));

                $dateDiff0 = $date2->diff($dateNow1);
                $dateDiff1 = $dateDiff0->format("il y a %Ya %mm %dj, %Hh %im %ss");

            ?>
                <tr>
                    <td><?= $user->getId() ?></td>
                    <td><a href="index.php?ctrl=security&action=viewUserProfile&id=<?= $user->getId() ?>"><?= $user->getUsername() ?></a></td>
                    <td><?= $user->getEmail() ?></td>
                    <td><?= $roleText ?></td>
                    <td><?= $statusText ?></td>
                    <td><?php echo $dateDiff1 ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        
    </table>


    <script>
        let table = new DataTable('#usersTable');
    </script>
