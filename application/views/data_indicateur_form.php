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
        <h2 style="margin-top:0px">Data_indicateur <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Methode Calcul <?php echo form_error('methode_calcul') ?></label>
            <input type="text" class="form-control" name="methode_calcul" id="methode_calcul" placeholder="Methode Calcul" value="<?php echo $methode_calcul; ?>" />
        </div>
	    <div class="form-group">
            <label for="double">Resultat <?php echo form_error('resultat') ?></label>
            <input type="text" class="form-control" name="resultat" id="resultat" placeholder="Resultat" value="<?php echo $resultat; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Indicateur <?php echo form_error('id_Indicateur') ?></label>
            <input type="text" class="form-control" name="id_Indicateur" id="id_Indicateur" placeholder="Id Indicateur" value="<?php echo $id_Indicateur; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">CCS <?php echo form_error('CCS') ?></label>
            <input type="text" class="form-control" name="CCS" id="CCS" placeholder="CCS" value="<?php echo $CCS; ?>" />
        </div>
	    <input type="hidden" name="id_data_indicateur" value="<?php echo $id_data_indicateur; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('data_indicateur') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>