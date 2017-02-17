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
        <h2 style="margin-top:0px">Indicateur <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nom <?php echo form_error('nom') ?></label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" value="<?php echo $nom; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Calcul Query <?php echo form_error('calcul_query') ?></label>
            <input type="text" class="form-control" name="calcul_query" id="calcul_query" placeholder="Calcul Query" value="<?php echo $calcul_query; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Controle <?php echo form_error('id_Controle') ?></label>
            <input type="text" class="form-control" name="id_Controle" id="id_Controle" placeholder="Id Controle" value="<?php echo $id_Controle; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Type Indicateur <?php echo form_error('id_Type_Indicateur') ?></label>
            <input type="text" class="form-control" name="id_Type_Indicateur" id="id_Type_Indicateur" placeholder="Id Type Indicateur" value="<?php echo $id_Type_Indicateur; ?>" />
        </div>
	    <input type="hidden" name="id_Indicateur" value="<?php echo $id_Indicateur; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('indicateur') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>