<?php include 'headerbarrenav.php'; ?>
<!doctype html>
<html>
    <head>
        <title>Nouveau Contrôle</title>
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
            <label for="varchar">Nom <?php echo form_error('nom') ?></label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" value="<?php echo $nom; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Annee <?php echo form_error('annee') ?></label>
            <input type="text" class="form-control" name="annee" id="annee" placeholder="Annee" value="<?php echo $annee; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Vague <?php echo form_error('vague') ?></label>
            <input type="text" class="form-control" name="vague" id="vague" placeholder="Vague" value="<?php echo $vague; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">NNI <?php echo form_error('NNI') ?></label>
            <input type="text" class="form-control" name="NNI" id="NNI" placeholder="NNI" value="<?php echo $NNI; ?>" />
        </div>
	    <input type="hidden" name="id_Controle" value="<?php echo $id_Controle; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('controle') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>