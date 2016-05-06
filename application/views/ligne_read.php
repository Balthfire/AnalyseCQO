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
        <h2 style="margin-top:0px">Ligne Read</h2>
        <table class="table">
	    <tr><td>Id Donnee</td><td><?php echo $id_Donnee; ?></td></tr>
	    <tr><td>Id Modele Ligne</td><td><?php echo $id_Modele_Ligne; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('ligne') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>