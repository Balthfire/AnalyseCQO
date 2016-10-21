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
        <h2 style="margin-top:0px">Colonne <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nom Colonne <?php echo form_error('nom_colonne') ?></label>
            <input type="text" class="form-control" name="nom_colonne" id="nom_colonne" placeholder="Nom Colonne" value="<?php echo $nom_colonne; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Lettre Excel <?php echo form_error('lettre_excel') ?></label>
            <input type="text" class="form-control" name="lettre_excel" id="lettre_excel" placeholder="Lettre Excel" value="<?php echo $lettre_excel; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Data Indicateur <?php echo form_error('id_data_indicateur') ?></label>
            <input type="text" class="form-control" name="id_data_indicateur" id="id_data_indicateur" placeholder="Id Data Indicateur" value="<?php echo $id_data_indicateur; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Type Colonne <?php echo form_error('id_type_colonne') ?></label>
            <input type="text" class="form-control" name="id_type_colonne" id="id_type_colonne" placeholder="Id Type Colonne" value="<?php echo $id_type_colonne; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Feuille <?php echo form_error('id_Feuille') ?></label>
            <input type="text" class="form-control" name="id_Feuille" id="id_Feuille" placeholder="Id Feuille" value="<?php echo $id_Feuille; ?>" />
        </div>
	    <input type="hidden" name="id_colonne" value="<?php echo $id_colonne; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('colonne') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>