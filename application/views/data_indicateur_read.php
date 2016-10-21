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
        <h2 style="margin-top:0px">Data_indicateur Read</h2>
        <table class="table">
	    <tr><td>Methode Calcul</td><td><?php echo $methode_calcul; ?></td></tr>
	    <tr><td>Resultat</td><td><?php echo $resultat; ?></td></tr>
	    <tr><td>Id Indicateur</td><td><?php echo $id_Indicateur; ?></td></tr>
	    <tr><td>CCS</td><td><?php echo $CCS; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('data_indicateur') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>