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
        <h2 style="margin-top:0px">Feuille <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nom <?php echo form_error('nom') ?></label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" value="<?php echo $nom; ?>" />
        </div>
	    <input type="hidden" name="id_Feuille" value="<?php echo $id_Feuille; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('feuille') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>