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
        <h2 style="margin-top:0px">Fichier <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Libelle <?php echo form_error('libelle') ?></label>
            <input type="text" class="form-control" name="libelle" id="libelle" placeholder="Libelle" value="<?php echo $libelle; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Controle <?php echo form_error('id_Controle') ?></label>
            <input type="text" class="form-control" name="id_Controle" id="id_Controle" placeholder="Id Controle" value="<?php echo $id_Controle; ?>" />
        </div>
	    <input type="hidden" name="id_Fichier" value="<?php echo $id_Fichier; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('fichier') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>