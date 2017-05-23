<?php include 'headerbarrenav.php'; ?>
<link rel="stylesheet" href="<?php echo base_url('/assets/style/general.css') ?>"/>

<html>
<body>
    <table class="table table-bordered" style="margin-bottom: 10px">
        <tr>
            <th>Action</th>
            <th>Nom</th>
            <th>Annee</th>
            <th>Vague</th>
            <th>NNI</th>
        </tr>

<?php

$colonneModel = new Colonne_model();
$TypeColModel = new Type_colonne_model();
$IndicateurModel = new Indicateur_model();


foreach($ResultArray as $idIndic => $Agences)
{
    $indicateur = $IndicateurModel->get_by_id($idIndic);
    $nomIndic = $indicateur->nom;
    var_dump($nomIndic);
    var_dump(array_keys($Agences));
    var_dump(array_keys($Agences['total']));
}

?>
</body>
</html>