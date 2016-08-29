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
        <h2 style="margin-top:0px">Cellule <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Pos X <?php echo form_error('pos_x') ?></label>
            <input type="text" class="form-control" name="pos_x" id="pos_x" placeholder="Pos X" value="<?php echo $pos_x; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Pos Y <?php echo form_error('pos_y') ?></label>
            <input type="text" class="form-control" name="pos_y" id="pos_y" placeholder="Pos Y" value="<?php echo $pos_y; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Valeur <?php echo form_error('valeur') ?></label>
            <input type="text" class="form-control" name="valeur" id="valeur" placeholder="Valeur" value="<?php echo $valeur; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Feuille <?php echo form_error('id_Feuille') ?></label>
            <input type="text" class="form-control" name="id_Feuille" id="id_Feuille" placeholder="Id Feuille" value="<?php echo $id_Feuille; ?>" />
        </div>
	    <input type="hidden" name="id_Cellule" value="<?php echo $id_Cellule; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('cellule') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>