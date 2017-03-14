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
        <h2 style="margin-top:0px">Query <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Query <?php echo form_error('query') ?></label>
            <input type="text" class="form-control" name="query" id="query" placeholder="Query" value="<?php echo $query; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Ordre <?php echo form_error('ordre') ?></label>
            <input type="text" class="form-control" name="ordre" id="ordre" placeholder="Ordre" value="<?php echo $ordre; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Indicateur <?php echo form_error('id_Indicateur') ?></label>
            <input type="text" class="form-control" name="id_Indicateur" id="id_Indicateur" placeholder="Id Indicateur" value="<?php echo $id_Indicateur; ?>" />
        </div>
	    <input type="hidden" name="id_Query" value="<?php echo $id_Query; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('query') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>