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
        <h2 style="margin-top:0px">Structure Read</h2>
        <table class="table">
	    <tr><td>Id Fichier</td><td><?php echo $id_Fichier; ?></td></tr>
	    <tr><td>Id Colonne</td><td><?php echo $id_Colonne; ?></td></tr>
	    <tr><td>Id Feuille</td><td><?php echo $id_Feuille; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('structure') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>