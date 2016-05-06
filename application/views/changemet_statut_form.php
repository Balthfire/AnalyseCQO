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
        <h2 style="margin-top:0px">Changemet_statut <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="date">Date Changement <?php echo form_error('Date_changement') ?></label>
            <input type="text" class="form-control" name="Date_changement" id="Date_changement" placeholder="Date Changement" value="<?php echo $Date_changement; ?>" />
        </div>
	    <input type="hidden" name="id_Statut" value="<?php echo $id_Statut; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('changemet_statut') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>