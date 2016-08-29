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
        <h2 style="margin-top:0px">Structure <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Annee Utilisation <?php echo form_error('annee_utilisation') ?></label>
            <input type="text" class="form-control" name="annee_utilisation" id="annee_utilisation" placeholder="Annee Utilisation" value="<?php echo $annee_utilisation; ?>" />
        </div>
	    <input type="hidden" name="id_Type_Controle" value="<?php echo $id_Type_Controle; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('structure') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>