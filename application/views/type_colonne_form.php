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
        <h2 style="margin-top:0px">Type_colonne <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nom <?php echo form_error('nom') ?></label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" value="<?php echo $nom; ?>" />
        </div>
	    <div class="form-group">
            <label for="tinyint">IsIdentifiant <?php echo form_error('isIdentifiant') ?></label>
            <input type="text" class="form-control" name="isIdentifiant" id="isIdentifiant" placeholder="IsIdentifiant" value="<?php echo $isIdentifiant; ?>" />
        </div>
	    <input type="hidden" name="id_Type_Colonne" value="<?php echo $id_Type_Colonne; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('type_colonne') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>