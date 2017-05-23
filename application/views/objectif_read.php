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
        <h2 style="margin-top:0px">Objectif Read</h2>
        <table class="table">
	    <tr><td>Seuil OK</td><td><?php echo $seuil_OK; ?></td></tr>
	    <tr><td>Seuil OKKO</td><td><?php echo $seuil_OKKO; ?></td></tr>
	    <tr><td>Seuil KO</td><td><?php echo $seuil_KO; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('objectif') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>