<?php
	
	$db = new PDO("mysql:host=localhost;dbname=miage", "miage", "jimiage2021");
	$q = "SELECT * FROM etudiants ORDER BY date_register DESC";
	$q1 = "SELECT * FROM etudiants WHERE niveau='LICENCE 1'";
	$q3 = "SELECT * FROM etudiants WHERE niveau='LICENCE 3'";
	$query = $db->prepare($q);
	$query1 = $db->prepare($q1);
	$query3 = $db->prepare($q3);
    $query->execute();
    $query1->execute();
    $query3->execute();
	$row = $query->fetchAll(PDO::FETCH_ASSOC);
	$row1 = $query1->fetchAll(PDO::FETCH_ASSOC);
	$row3 = $query3->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">

</head>

<body>
    <div class="container mt-5 mb-5">
        <h3 style="text-align:center">LISTE DES INSCRITS</h3>
        <p>total L1 : <?= count($row1) ?> </p>
        <p>total L3 : <?= count($row3) ?></p>
        <p>total: <?= count($row) ?> </p>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>

                <tr>
                    <th>#</th>
                    <th>Noms</th>
                    <th>Niveau</th>
                    <th>photo</th>

                </tr>

            </thead>
            <tbody>
                <?php
                foreach ($row as $key => $value) {

                ?>
                    <tr>
                        <td><?=$key?></td>
                        <td><?=$value['nom']." ".$value['prenom']?></td>
                        <td><?=$value['niveau']?></td>
                        <td><a href="<?=$value['lien_photo']?>" target="_target"><img src="<?=$value['lien_photo']?>"  height="80" alt=""></a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Noms</th>
                    <th>Niveau</th>
                    <th>photo</th>
                </tr>

            </tfoot>
        </table>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>

</html>