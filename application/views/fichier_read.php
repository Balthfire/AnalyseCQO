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
        <h2 style="margin-top:0px">Fichier Read</h2>
        <table class="table">
	    <tr><td>Nom</td><td><?php echo $nom; ?></td></tr>
	    <tr><td>Extension</td><td><?php echo $extension; ?></td></tr>
	    <tr><td>Conteneur</td><td><?php echo $conteneur; ?></td></tr>
	    <tr><td>Upload Path</td><td><?php echo $upload_path; ?></td></tr>
	    <tr><td>Annee</td><td><?php echo $annee; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('fichier') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>