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
        <h2 style="margin-top:0px">Ligne <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Id Donnee <?php echo form_error('id_Donnee') ?></label>
            <input type="text" class="form-control" name="id_Donnee" id="id_Donnee" placeholder="Id Donnee" value="<?php echo $id_Donnee; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Modele Ligne <?php echo form_error('id_Modele_Ligne') ?></label>
            <input type="text" class="form-control" name="id_Modele_Ligne" id="id_Modele_Ligne" placeholder="Id Modele Ligne" value="<?php echo $id_Modele_Ligne; ?>" />
        </div>
	    <input type="hidden" name="id_Ligne" value="<?php echo $id_Ligne; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('ligne') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>