<?php

$respAdresses = $pdo->query('SELECT * FROM adresses ORDER BY adress_id');
$adresses = $respAdresses->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="container" id="adresses">
    <div class=" row">
        <div class="col">
            <h2 class="text-center text-secondary-emphasis">Adresses</h2>
        </div>
    </div>
    <div class="row">
        <table class="table text-secondary-emphasis border border-light mt-5">
            <thead class="text-bg-light">
                <tr style="vertical-align:middle;">
                    <th scope="col">ID</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Code postal</th>
                    <th scope="col">Ville</th>
                    <th scope="col" class="d-flex justify-content-end"><button type="button" onclick="window.location.href = '/website/admin/adresses/create_modify_adresse.php';" class=" btn btn-primary mx-2">Ajouter</button></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($adresses as $adresse) {
                ?>
                    <tr style="vertical-align:middle;">
                        <th scope="row"><?php echo $adresse['adress_id']; ?></th>
                        <td><?php echo $adresse['adresse1']; ?></td>
                        <td><?php echo $adresse['adresse2']; ?></td>
                        <td><?php echo $adresse['code_postal']; ?></td>
                        <td><?php echo $adresse['ville']; ?></td>
                        <td class="d-flex justify-content-end">
                            <button type="button" onclick="window.location.href = '/website/admin/adresses/create_modify_adresse.php?modifier_id_adresse=<?php echo $adresse['adress_id'] ?>';" class=" btn btn-warning me-2">Modifier</button>
                            <button type="button" onclick="window.location.href = '/website/admin/index.php?supprimer_id_adresse=<?php echo $adresse['adress_id'] ?>';" class=" btn btn-danger">Supprimer</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>