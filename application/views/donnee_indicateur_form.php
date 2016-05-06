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
        <h2 style="margin-top:0px">Donnee_indicateur <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Libelle <?php echo form_error('libelle') ?></label>
            <input type="text" class="form-control" name="libelle" id="libelle" placeholder="Libelle" value="<?php echo $libelle; ?>" />
        </div>
	    <div class="form-group">
            <label for="double">Valeur <?php echo form_error('valeur') ?></label>
            <input type="text" class="form-control" name="valeur" id="valeur" placeholder="Valeur" value="<?php echo $valeur; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Requete Calcul <?php echo form_error('Requete_Calcul') ?></label>
            <input type="text" class="form-control" name="Requete_Calcul" id="Requete_Calcul" placeholder="Requete Calcul" value="<?php echo $Requete_Calcul; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Indicateur <?php echo form_error('id_Indicateur') ?></label>
            <input type="text" class="form-control" name="id_Indicateur" id="id_Indicateur" placeholder="Id Indicateur" value="<?php echo $id_Indicateur; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Modele Donnees Indicateur <?php echo form_error('id_Modele_Donnees_Indicateur') ?></label>
            <input type="text" class="form-control" name="id_Modele_Donnees_Indicateur" id="id_Modele_Donnees_Indicateur" placeholder="Id Modele Donnees Indicateur" value="<?php echo $id_Modele_Donnees_Indicateur; ?>" />
        </div>
	    <input type="hidden" name="id_Donnee" value="<?php echo $id_Donnee; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('donnee_indicateur') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>