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
        <h2 style="margin-top:0px">Structure_indicateur_calcul <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Id Structure <?php echo form_error('id_Structure') ?></label>
            <input type="text" class="form-control" name="id_Structure" id="id_Structure" placeholder="Id Structure" value="<?php echo $id_Structure; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Indicateur <?php echo form_error('id_Indicateur') ?></label>
            <input type="text" class="form-control" name="id_Indicateur" id="id_Indicateur" placeholder="Id Indicateur" value="<?php echo $id_Indicateur; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Methode Calcul <?php echo form_error('id_Methode_Calcul') ?></label>
            <input type="text" class="form-control" name="id_Methode_Calcul" id="id_Methode_Calcul" placeholder="Id Methode Calcul" value="<?php echo $id_Methode_Calcul; ?>" />
        </div>
	    <input type="hidden" name="id_SIC" value="<?php echo $id_SIC; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('structure_indicateur_calcul') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>