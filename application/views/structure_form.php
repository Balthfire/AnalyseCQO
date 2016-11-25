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
            <label for="int">Id Fichier <?php echo form_error('id_Fichier') ?></label>
            <input type="text" class="form-control" name="id_Fichier" id="id_Fichier" placeholder="Id Fichier" value="<?php echo $id_Fichier; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Colonne <?php echo form_error('id_Colonne') ?></label>
            <input type="text" class="form-control" name="id_Colonne" id="id_Colonne" placeholder="Id Colonne" value="<?php echo $id_Colonne; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Feuille <?php echo form_error('id_Feuille') ?></label>
            <input type="text" class="form-control" name="id_Feuille" id="id_Feuille" placeholder="Id Feuille" value="<?php echo $id_Feuille; ?>" />
        </div>
	    <input type="hidden" name="id_Structure" value="<?php echo $id_Structure; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('structure') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>