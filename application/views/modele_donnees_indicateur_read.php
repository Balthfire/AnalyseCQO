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
        <h2 style="margin-top:0px">Modele_donnees_indicateur Read</h2>
        <table class="table">
	    <tr><td>Designation</td><td><?php echo $designation; ?></td></tr>
	    <tr><td>Valeur</td><td><?php echo $valeur; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('modele_donnees_indicateur') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>