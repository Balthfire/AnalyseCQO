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
        <h2 style="margin-top:0px">Champ Read</h2>
        <table class="table">
	    <tr><td>Nom</td><td><?php echo $nom; ?></td></tr>
	    <tr><td>TxtChamp</td><td><?php echo $txtChamp; ?></td></tr>
	    <tr><td>NumChamp</td><td><?php echo $numChamp; ?></td></tr>
	    <tr><td>EstNumerique</td><td><?php echo $estNumerique; ?></td></tr>
	    <tr><td>Id Ligne</td><td><?php echo $id_Ligne; ?></td></tr>
	    <tr><td>Id Champ Modele</td><td><?php echo $id_Champ_Modele; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('champ') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>