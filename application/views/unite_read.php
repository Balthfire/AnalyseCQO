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
        <h2 style="margin-top:0px">Unite Read</h2>
        <table class="table">
	    <tr><td>Libelle</td><td><?php echo $libelle; ?></td></tr>
	    <tr><td>SDUM</td><td><?php echo $SDUM; ?></td></tr>
	    <tr><td>Valeur</td><td><?php echo $Valeur; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('unite') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>