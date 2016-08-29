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
        <h2 style="margin-top:0px">Type_indicateur <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Libelle <?php echo form_error('libelle') ?></label>
            <input type="text" class="form-control" name="libelle" id="libelle" placeholder="Libelle" value="<?php echo $libelle; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Methode Calcul <?php echo form_error('methode_calcul') ?></label>
            <input type="text" class="form-control" name="methode_calcul" id="methode_calcul" placeholder="Methode Calcul" value="<?php echo $methode_calcul; ?>" />
        </div>
	    <input type="hidden" name="id_Type_Indicateur" value="<?php echo $id_Type_Indicateur; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('type_indicateur') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>