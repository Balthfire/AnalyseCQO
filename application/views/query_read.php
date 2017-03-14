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
        <h2 style="margin-top:0px">Query Read</h2>
        <table class="table">
	    <tr><td>Query</td><td><?php echo $query; ?></td></tr>
	    <tr><td>Ordre</td><td><?php echo $ordre; ?></td></tr>
	    <tr><td>Id Indicateur</td><td><?php echo $id_Indicateur; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('query') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>