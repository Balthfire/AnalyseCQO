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
        <h2 style="margin-top:0px">Modele_controle <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Designation <?php echo form_error('designation') ?></label>
            <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation" value="<?php echo $designation; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Description <?php echo form_error('description') ?></label>
            <input type="text" class="form-control" name="description" id="description" placeholder="Description" value="<?php echo $description; ?>" />
        </div>
	    <div class="form-group">
            <label for="double">Coefficient Importance <?php echo form_error('Coefficient_Importance') ?></label>
            <input type="text" class="form-control" name="Coefficient_Importance" id="Coefficient_Importance" placeholder="Coefficient Importance" value="<?php echo $Coefficient_Importance; ?>" />
        </div>
	    <input type="hidden" name="id_Modele_Controle" value="<?php echo $id_Modele_Controle; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('modele_controle') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>