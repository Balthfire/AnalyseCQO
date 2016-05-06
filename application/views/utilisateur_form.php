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
        <h2 style="margin-top:0px">Utilisateur <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nom <?php echo form_error('Nom') ?></label>
            <input type="text" class="form-control" name="Nom" id="Nom" placeholder="Nom" value="<?php echo $Nom; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Prenom <?php echo form_error('Prenom') ?></label>
            <input type="text" class="form-control" name="Prenom" id="Prenom" placeholder="Prenom" value="<?php echo $Prenom; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Password <?php echo form_error('password') ?></label>
            <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Type User <?php echo form_error('id_Type_User') ?></label>
            <input type="text" class="form-control" name="id_Type_User" id="id_Type_User" placeholder="Id Type User" value="<?php echo $id_Type_User; ?>" />
        </div>
	    <input type="hidden" name="NNI" value="<?php echo $NNI; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('utilisateur') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>