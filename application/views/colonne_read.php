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
        <h2 style="margin-top:0px">Colonne Read</h2>
        <table class="table">
	    <tr><td>Nom Colonne</td><td><?php echo $nom_colonne; ?></td></tr>
	    <tr><td>Lettre Excel</td><td><?php echo $lettre_excel; ?></td></tr>
	    <tr><td>Id Data Indicateur</td><td><?php echo $id_data_indicateur; ?></td></tr>
	    <tr><td>Id Type Colonne</td><td><?php echo $id_type_colonne; ?></td></tr>
	    <tr><td>Id Feuille</td><td><?php echo $id_Feuille; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('colonne') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>