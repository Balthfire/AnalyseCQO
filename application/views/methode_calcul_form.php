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
        <h2 style="margin-top:0px">Methode_calcul <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Libelle <?php echo form_error('libelle') ?></label>
            <input type="text" class="form-control" name="libelle" id="libelle" placeholder="Libelle" value="<?php echo $libelle; ?>" />
        </div>
	    <input type="hidden" name="id_Methode_Calcul" value="<?php echo $id_Methode_Calcul; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('methode_calcul') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>