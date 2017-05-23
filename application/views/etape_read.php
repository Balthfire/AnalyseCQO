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
        <h2 style="margin-top:0px">Etape Read</h2>
        <table class="table">
	    <tr><td>Parameter</td><td><?php echo $Parameter; ?></td></tr>
	    <tr><td>Ordre</td><td><?php echo $ordre; ?></td></tr>
	    <tr><td>Id Operateur</td><td><?php echo $id_Operateur; ?></td></tr>
	    <tr><td>Id Structure</td><td><?php echo $id_Structure; ?></td></tr>
	    <tr><td>Id Type Indicateur</td><td><?php echo $id_Type_Indicateur; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('etape') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>