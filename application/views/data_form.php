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
        <h2 style="margin-top:0px">Data <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Data <?php echo form_error('data') ?></label>
            <input type="text" class="form-control" name="data" id="data" placeholder="Data" value="<?php echo $data; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Num Ligne Excel <?php echo form_error('num_ligne_excel') ?></label>
            <input type="text" class="form-control" name="num_ligne_excel" id="num_ligne_excel" placeholder="Num Ligne Excel" value="<?php echo $num_ligne_excel; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Structure <?php echo form_error('id_Structure') ?></label>
            <input type="text" class="form-control" name="id_Structure" id="id_Structure" placeholder="Id Structure" value="<?php echo $id_Structure; ?>" />
        </div>
	    <input type="hidden" name="id_Data" value="<?php echo $id_Data; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('data') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>