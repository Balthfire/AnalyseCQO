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
        <h2 style="margin-top:0px">Utilisateur Read</h2>
        <table class="table">
	    <tr><td>Nom</td><td><?php echo $Nom; ?></td></tr>
	    <tr><td>Prenom</td><td><?php echo $Prenom; ?></td></tr>
	    <tr><td>Password</td><td><?php echo $password; ?></td></tr>
	    <tr><td>Id Type User</td><td><?php echo $id_Type_User; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('utilisateur') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>