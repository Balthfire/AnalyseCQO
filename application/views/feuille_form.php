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
            <label for="int">Nb Ligne <?php echo form_error('nb_ligne') ?></label>
            <input type="text" class="form-control" name="nb_ligne" id="nb_ligne" placeholder="Nb Ligne" value="<?php echo $nb_ligne; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Nb Colonne <?php echo form_error('nb_colonne') ?></label>
            <input type="text" class="form-control" name="nb_colonne" id="nb_colonne" placeholder="Nb Colonne" value="<?php echo $nb_colonne; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Num Page <?php echo form_error('num_page') ?></label>
            <input type="text" class="form-control" name="num_page" id="num_page" placeholder="Num Page" value="<?php echo $num_page; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nom Page <?php echo form_error('nom_page') ?></label>
            <input type="text" class="form-control" name="nom_page" id="nom_page" placeholder="Nom Page" value="<?php echo $nom_page; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Colonne <?php echo form_error('id_colonne') ?></label>
            <input type="text" class="form-control" name="id_colonne" id="id_colonne" placeholder="Id Colonne" value="<?php echo $id_colonne; ?>" />
        </div>
	    <input type="hidden" name="id_Feuille" value="<?php echo $id_Feuille; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('feuille') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>