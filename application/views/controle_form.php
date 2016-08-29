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
        <h2 style="margin-top:0px">Controle <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Designation <?php echo form_error('designation') ?></label>
            <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation" value="<?php echo $designation; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Description <?php echo form_error('description') ?></label>
            <input type="text" class="form-control" name="description" id="description" placeholder="Description" value="<?php echo $description; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Num Vague <?php echo form_error('num_vague') ?></label>
            <input type="text" class="form-control" name="num_vague" id="num_vague" placeholder="Num Vague" value="<?php echo $num_vague; ?>" />
        </div>
	    <div class="form-group">
            <label for="date">Date Debut <?php echo form_error('date_debut') ?></label>
            <input type="text" class="form-control" name="date_debut" id="date_debut" placeholder="Date Debut" value="<?php echo $date_debut; ?>" />
        </div>
	    <div class="form-group">
            <label for="date">Date Fin <?php echo form_error('date_fin') ?></label>
            <input type="text" class="form-control" name="date_fin" id="date_fin" placeholder="Date Fin" value="<?php echo $date_fin; ?>" />
        </div>
	    <div class="form-group">
            <label for="double">Note <?php echo form_error('note') ?></label>
            <input type="text" class="form-control" name="note" id="note" placeholder="Note" value="<?php echo $note; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Niveau Qualite <?php echo form_error('Niveau_Qualite') ?></label>
            <input type="text" class="form-control" name="Niveau_Qualite" id="Niveau_Qualite" placeholder="Niveau Qualite" value="<?php echo $Niveau_Qualite; ?>" />
        </div>
	    <div class="form-group">
            <label for="blob">Fichier Excell <?php echo form_error('fichier_excell') ?></label>
            <input type="text" class="form-control" name="fichier_excell" id="fichier_excell" placeholder="Fichier Excell" value="<?php echo $fichier_excell; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Extension Fichier <?php echo form_error('extension_fichier') ?></label>
            <input type="text" class="form-control" name="extension_fichier" id="extension_fichier" placeholder="Extension Fichier" value="<?php echo $extension_fichier; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Type Controle <?php echo form_error('id_Type_Controle') ?></label>
            <input type="text" class="form-control" name="id_Type_Controle" id="id_Type_Controle" placeholder="Id Type Controle" value="<?php echo $id_Type_Controle; ?>" />
        </div>
	    <div class="form-group">
            <label for="char">NNI <?php echo form_error('NNI') ?></label>
            <input type="text" class="form-control" name="NNI" id="NNI" placeholder="NNI" value="<?php echo $NNI; ?>" />
        </div>
	    <input type="hidden" name="id_Controle" value="<?php echo $id_Controle; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('controle') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>