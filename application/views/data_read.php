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
        <h2 style="margin-top:0px">Data Read</h2>
        <table class="table">
	    <tr><td>Data</td><td><?php echo $data; ?></td></tr>
	    <tr><td>Num Ligne Excel</td><td><?php echo $num_ligne_excel; ?></td></tr>
	    <tr><td>Id Structure</td><td><?php echo $id_Structure; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('data') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>