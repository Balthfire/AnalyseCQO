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
            <label for="varchar">Nom <?php echo form_error('nom') ?></label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" value="<?php echo $nom; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Extension <?php echo form_error('extension') ?></label>
            <input type="text" class="form-control" name="extension" id="extension" placeholder="Extension" value="<?php echo $extension; ?>" />
        </div>
	    <div class="form-group">
            <label for="blob">Conteneur <?php echo form_error('conteneur') ?></label>
            <input type="text" class="form-control" name="conteneur" id="conteneur" placeholder="Conteneur" value="<?php echo $conteneur; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Upload Path <?php echo form_error('upload_path') ?></label>
            <input type="text" class="form-control" name="upload_path" id="upload_path" placeholder="Upload Path" value="<?php echo $upload_path; ?>" />
        </div>
	    <div class="form-group">
            <label for="date">Annee <?php echo form_error('annee') ?></label>
            <input type="text" class="form-control" name="annee" id="annee" placeholder="Annee" value="<?php echo $annee; ?>" />
        </div>
	    <input type="hidden" name="id_Fichier" value="<?php echo $id_Fichier; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('fichier') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>