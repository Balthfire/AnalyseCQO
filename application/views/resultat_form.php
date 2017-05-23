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
        <h2 style="margin-top:0px">Resultat <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Valeur <?php echo form_error('valeur') ?></label>
            <input type="text" class="form-control" name="valeur" id="valeur" placeholder="Valeur" value="<?php echo $valeur; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Indicateur <?php echo form_error('id_Indicateur') ?></label>
            <input type="text" class="form-control" name="id_Indicateur" id="id_Indicateur" placeholder="Id Indicateur" value="<?php echo $id_Indicateur; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">CCS <?php echo form_error('CCS') ?></label>
            <input type="text" class="form-control" name="CCS" id="CCS" placeholder="CCS" value="<?php echo $CCS; ?>" />
        </div>
	    <input type="hidden" name="id_Resultat" value="<?php echo $id_Resultat; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('resultat') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>