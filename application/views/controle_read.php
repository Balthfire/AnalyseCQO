<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Controle Read</h2>
        <table class="table">
	    <tr><td>Designation</td><td><?php echo $designation; ?></td></tr>
	    <tr><td>Description</td><td><?php echo $description; ?></td></tr>
	    <tr><td>Num Vague</td><td><?php echo $num_vague; ?></td></tr>
	    <tr><td>Date Debut</td><td><?php echo $date_debut; ?></td></tr>
	    <tr><td>Date Fin</td><td><?php echo $date_fin; ?></td></tr>
	    <tr><td>Note</td><td><?php echo $note; ?></td></tr>
	    <tr><td>Niveau Qualite</td><td><?php echo $Niveau_Qualite; ?></td></tr>
	    <tr><td>Id Type Controle</td><td><?php echo $id_Type_Controle; ?></td></tr>
	    <tr><td>NNI</td><td><?php echo $NNI; ?></td></tr>
	    <tr><td>Id Modele Controle</td><td><?php echo $id_Modele_Controle; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('controle') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>