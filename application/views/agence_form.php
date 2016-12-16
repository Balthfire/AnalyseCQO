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
        <h2 style="margin-top:0px">Agence <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nom <?php echo form_error('nom') ?></label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" value="<?php echo $nom; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">DUM <?php echo form_error('DUM') ?></label>
            <input type="text" class="form-control" name="DUM" id="DUM" placeholder="DUM" value="<?php echo $DUM; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">SDUM <?php echo form_error('SDUM') ?></label>
            <input type="text" class="form-control" name="SDUM" id="SDUM" placeholder="SDUM" value="<?php echo $SDUM; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Portefeuille <?php echo form_error('portefeuille') ?></label>
            <input type="text" class="form-control" name="portefeuille" id="portefeuille" placeholder="Portefeuille" value="<?php echo $portefeuille; ?>" />
        </div>
	    <input type="hidden" name="CCS" value="<?php echo $CCS; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('agence') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>