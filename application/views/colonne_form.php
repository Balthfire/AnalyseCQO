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
            <label for="varchar">Header <?php echo form_error('header') ?></label>
            <input type="text" class="form-control" name="header" id="header" placeholder="Header" value="<?php echo $header; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Lettre Excel <?php echo form_error('lettre_excel') ?></label>
            <input type="text" class="form-control" name="lettre_excel" id="lettre_excel" placeholder="Lettre Excel" value="<?php echo $lettre_excel; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Type Colonne <?php echo form_error('id_Type_Colonne') ?></label>
            <input type="text" class="form-control" name="id_Type_Colonne" id="id_Type_Colonne" placeholder="Id Type Colonne" value="<?php echo $id_Type_Colonne; ?>" />
        </div>
	    <input type="hidden" name="id_Colonne" value="<?php echo $id_Colonne; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('colonne') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>