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
        <h2 style="margin-top:0px">Utilisateur <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nom <?php echo form_error('nom') ?></label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" value="<?php echo $nom; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Prenom <?php echo form_error('prenom') ?></label>
            <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prenom" value="<?php echo $prenom; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Type Utilisateur <?php echo form_error('id_Type_Utilisateur') ?></label>
            <input type="text" class="form-control" name="id_Type_Utilisateur" id="id_Type_Utilisateur" placeholder="Id Type Utilisateur" value="<?php echo $id_Type_Utilisateur; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">CCS <?php echo form_error('CCS') ?></label>
            <input type="text" class="form-control" name="CCS" id="CCS" placeholder="CCS" value="<?php echo $CCS; ?>" />
        </div>
	    <input type="hidden" name="NNI" value="<?php echo $NNI; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('utilisateur') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>