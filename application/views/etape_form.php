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
        <h2 style="margin-top:0px">Etape <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Parameter <?php echo form_error('Parameter') ?></label>
            <input type="text" class="form-control" name="Parameter" id="Parameter" placeholder="Parameter" value="<?php echo $Parameter; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Ordre <?php echo form_error('ordre') ?></label>
            <input type="text" class="form-control" name="ordre" id="ordre" placeholder="Ordre" value="<?php echo $ordre; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Operateur <?php echo form_error('id_Operateur') ?></label>
            <input type="text" class="form-control" name="id_Operateur" id="id_Operateur" placeholder="Id Operateur" value="<?php echo $id_Operateur; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Structure <?php echo form_error('id_Structure') ?></label>
            <input type="text" class="form-control" name="id_Structure" id="id_Structure" placeholder="Id Structure" value="<?php echo $id_Structure; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Type Indicateur <?php echo form_error('id_Type_Indicateur') ?></label>
            <input type="text" class="form-control" name="id_Type_Indicateur" id="id_Type_Indicateur" placeholder="Id Type Indicateur" value="<?php echo $id_Type_Indicateur; ?>" />
        </div>
	    <input type="hidden" name="id_Etape" value="<?php echo $id_Etape; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('etape') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>