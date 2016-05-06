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
        <h2 style="margin-top:0px">Modele_indicateur <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Designation <?php echo form_error('Designation') ?></label>
            <input type="text" class="form-control" name="Designation" id="Designation" placeholder="Designation" value="<?php echo $Designation; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Decription <?php echo form_error('decription') ?></label>
            <input type="text" class="form-control" name="decription" id="decription" placeholder="Decription" value="<?php echo $decription; ?>" />
        </div>
	    <input type="hidden" name="id_Modele_Indicateur" value="<?php echo $id_Modele_Indicateur; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('modele_indicateur') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>