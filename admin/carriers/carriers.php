<?php

$respTransporteurs = $pdo->query('SELECT * FROM transporteurs ORDER BY transp_id');
$transporteurs = $respTransporteurs->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="container" id="transporteurs">
    <div class="row">
        <div class="col">
            <h2 class="text-center text-secondary-emphasis">Transporteurs</h2>
        </div>
    </div>
    <div class="row">
        <table class="table text-secondary-emphasis border border-light mt-5">
            <thead class="text-bg-light">
                <tr style="vertical-align:middle;">
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Delai</th>
                    <th scope="col">Pays</th>
                    <th scope="col">Zone</th>
                    <th scope="col" class="d-flex justify-content-end"><button type="button" onclick="window.location.href = '/website/admin/carriers/create_modify_transp.php';" class=" btn btn-primary mx-2">Ajouter</button></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($transporteurs as $transporteur) {
                ?>
                    <tr style="vertical-align:middle;">
                        <th scope="row"><?php echo $transporteur['transp_id']; ?></th>
                        <td><?php echo $transporteur['nom']; ?></td>
                        <td><?php echo $transporteur['delay']; ?></td>
                        <td><?php echo $transporteur['country']; ?></td>
                        <td><?php echo $transporteur['zone']; ?></td>
                        <td class="d-flex justify-content-end">
                            <button type="button" onclick="window.location.href = '/website/admin/carriers/create_modify_transp.php?modifier_id_transp=<?php echo $transporteur['transp_id'] ?>';" class=" btn btn-warning me-2">Modifier</button>
                            <button type="button" onclick="window.location.href = '/website/admin/index.php?supprimer_id_transp=<?php echo $transporteur['transp_id'] ?>';" class=" btn btn-danger">Supprimer</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>