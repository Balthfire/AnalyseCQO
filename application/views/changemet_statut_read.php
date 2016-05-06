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
        <h2 style="margin-top:0px">Changemet_statut Read</h2>
        <table class="table">
	    <tr><td>Date Changement</td><td><?php echo $Date_changement; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('changemet_statut') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>