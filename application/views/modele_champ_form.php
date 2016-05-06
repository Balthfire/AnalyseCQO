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
        <h2 style="margin-top:0px">Modele_champ <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nom <?php echo form_error('nom') ?></label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" value="<?php echo $nom; ?>" />
        </div>
	    <div class="form-group">
            <label for="tinyint">EstNumerique <?php echo form_error('estNumerique') ?></label>
            <input type="text" class="form-control" name="estNumerique" id="estNumerique" placeholder="EstNumerique" value="<?php echo $estNumerique; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Description <?php echo form_error('Description') ?></label>
            <input type="text" class="form-control" name="Description" id="Description" placeholder="Description" value="<?php echo $Description; ?>" />
        </div>
	    <input type="hidden" name="id_Champ_Modele" value="<?php echo $id_Champ_Modele; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('modele_champ') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>