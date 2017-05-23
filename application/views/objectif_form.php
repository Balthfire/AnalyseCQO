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
        <h2 style="margin-top:0px">Objectif <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Seuil OK <?php echo form_error('seuil_OK') ?></label>
            <input type="text" class="form-control" name="seuil_OK" id="seuil_OK" placeholder="Seuil OK" value="<?php echo $seuil_OK; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Seuil OKKO <?php echo form_error('seuil_OKKO') ?></label>
            <input type="text" class="form-control" name="seuil_OKKO" id="seuil_OKKO" placeholder="Seuil OKKO" value="<?php echo $seuil_OKKO; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Seuil KO <?php echo form_error('seuil_KO') ?></label>
            <input type="text" class="form-control" name="seuil_KO" id="seuil_KO" placeholder="Seuil KO" value="<?php echo $seuil_KO; ?>" />
        </div>
	    <input type="hidden" name="id_Objectif" value="<?php echo $id_Objectif; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('objectif') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>