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

                // $dateSignInBdd = $user->getSignInDate();
                // $dateTemp1 = str_replace("/", "-", $dateSignInBdd);
                // $dateTemp2 = trim($dateTemp1, ",");
                // $dateSignInFormatted = strtotime($dateTemp2);

                // $date1 = new DateTime();
                // $date1->setTimestamp($dateSignInFormatted);
                // $finalDateLast = $date1->format("Y-m-d H:i:s");
                // $finalDate = date("m-d-Y H:m:s",$dateSignInFormatted);


                // $dateSignInBdd = "2023-03-28 14:06:54";
                // $dateSignInFormatted = strtotime($dateSignInBdd);
                // $finalDate = date("m-d-Y H:m:s",$dateSignInFormatted);

                // $dateNow = date("Y-m-d H:i:s");
                // $dateDiffSignIn = $finalDateLast->diff($dateNow);

                // Fix le timezone offset (bien présent mais calcul pas bon)
                $date0 = str_replace("/", "-", $user->getSignInDate());
                $date1 = trim($date0, ",");
                $date2 = new DateTime($date1, new DateTimeZone("+0200"));
                
                $dateNow0 = date("Y-m-d H:i:s");
                $dateNow1 = new DateTime($dateNow0, new DateTimeZone("+0200"));

                $dateDiff0 = $date2->diff($dateNow1);
                $dateDiff1 = $dateDiff0->format("il y a %Yy %mm %dd");

            ?>
                <tr>
                    <td><?= $user->getId() ?></td>
                    <td><?= $user->getUsername() ?></td>
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
