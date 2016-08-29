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
        <h2 style="margin-top:0px">Indicateur Read</h2>
        <table class="table">
	    <tr><td>Libelle</td><td><?php echo $libelle; ?></td></tr>
	    <tr><td>Valeur</td><td><?php echo $valeur; ?></td></tr>
	    <tr><td>Id Controle</td><td><?php echo $id_Controle; ?></td></tr>
	    <tr><td>Id Type Indicateur</td><td><?php echo $id_Type_Indicateur; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('indicateur') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>