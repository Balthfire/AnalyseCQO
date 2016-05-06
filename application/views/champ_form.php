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
        <h2 style="margin-top:0px">Champ <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nom <?php echo form_error('nom') ?></label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" value="<?php echo $nom; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">TxtChamp <?php echo form_error('txtChamp') ?></label>
            <input type="text" class="form-control" name="txtChamp" id="txtChamp" placeholder="TxtChamp" value="<?php echo $txtChamp; ?>" />
        </div>
	    <div class="form-group">
            <label for="double">NumChamp <?php echo form_error('numChamp') ?></label>
            <input type="text" class="form-control" name="numChamp" id="numChamp" placeholder="NumChamp" value="<?php echo $numChamp; ?>" />
        </div>
	    <div class="form-group">
            <label for="tinyint">EstNumerique <?php echo form_error('estNumerique') ?></label>
            <input type="text" class="form-control" name="estNumerique" id="estNumerique" placeholder="EstNumerique" value="<?php echo $estNumerique; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Ligne <?php echo form_error('id_Ligne') ?></label>
            <input type="text" class="form-control" name="id_Ligne" id="id_Ligne" placeholder="Id Ligne" value="<?php echo $id_Ligne; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Champ Modele <?php echo form_error('id_Champ_Modele') ?></label>
            <input type="text" class="form-control" name="id_Champ_Modele" id="id_Champ_Modele" placeholder="Id Champ Modele" value="<?php echo $id_Champ_Modele; ?>" />
        </div>
	    <input type="hidden" name="id_Champ" value="<?php echo $id_Champ; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('champ') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>