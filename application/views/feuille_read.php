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
        <h2 style="margin-top:0px">Feuille Read</h2>
        <table class="table">
	    <tr><td>Nb Ligne</td><td><?php echo $nb_ligne; ?></td></tr>
	    <tr><td>Nb Colonne</td><td><?php echo $nb_colonne; ?></td></tr>
	    <tr><td>Num Page</td><td><?php echo $num_page; ?></td></tr>
	    <tr><td>Nom Page</td><td><?php echo $nom_page; ?></td></tr>
	    <tr><td>Id Colonne</td><td><?php echo $id_colonne; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('feuille') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>