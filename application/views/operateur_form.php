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
        <h2 style="margin-top:0px">Operateur <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Valeur <?php echo form_error('valeur') ?></label>
            <input type="text" class="form-control" name="valeur" id="valeur" placeholder="Valeur" value="<?php echo $valeur; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Valeursql <?php echo form_error('valeursql') ?></label>
            <input type="text" class="form-control" name="valeursql" id="valeursql" placeholder="Valeursql" value="<?php echo $valeursql; ?>" />
        </div>
	    <input type="hidden" name="id_Operateur" value="<?php echo $id_Operateur; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('operateur') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>