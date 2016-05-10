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
    <?php include 'headerbarrenav.php'; ?>
    <body>
        <h2 style="margin-top:0px">Controle <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="varchar">Designation <?php echo form_error('designation') ?></label>
                        <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation" value="<?php echo $designation; ?>" />
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="int">N°de vague <?php echo form_error('num_vague') ?></label>
                        <input type="text" class="form-control" name="num_vague" id="num_vague" placeholder="N° de vague" value="<?php echo $num_vague; ?>" />
                    </div>
                </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="date">Date Debut <?php echo form_error('date_debut') ?></label>
                    <input type="text" class="form-control" name="date_debut" id="date_debut" placeholder="Date Debut" value="<?php echo $date_debut; ?>" />
                </div>
            </div>
            <div class="col-lg-2">
                <label for="date">Date Fin <?php echo form_error('date_fin') ?></label>
                <input type="text" class="form-control" name="date_fin" id="date_fin" placeholder="Date Fin" value="<?php echo $date_fin; ?>" />
            </div>
                <div class="col-lg-1">
                    <div class="form-group">
                        <label for="double">Note <?php echo form_error('note') ?></label>
                        <input type="text" class="form-control" name="note" id="note" placeholder="Note" value="<?php echo $note; ?>" />
                    </div>
                </div>
                <div class="form-group">
                <label for="int">Niveau Qualite <?php echo form_error('Niveau_Qualite') ?></label>
                <input type="text" class="form-control" name="Niveau_Qualite" id="Niveau_Qualite" placeholder="Niveau Qualite" value="<?php echo $Niveau_Qualite; ?>" />
            </div>
            <div class="form-group">
                <label for="int">Id Type Controle <?php echo form_error('id_Type_Controle') ?></label>
                <input type="text" class="form-control" name="id_Type_Controle" id="id_Type_Controle" placeholder="Id Type Controle" value="<?php echo $id_Type_Controle; ?>" />
            </div>
            <div class="form-group">
                <label for="char">NNI <?php echo form_error('NNI') ?></label>
                <input type="text" class="form-control" name="NNI" id="NNI" placeholder="NNI" value="<?php echo $NNI; ?>" />
            </div>
            <div class="form-group">
                <label for="int">Id Modele Controle <?php echo form_error('id_Modele_Controle') ?></label>
                <input type="text" class="form-control" name="id_Modele_Controle" id="id_Modele_Controle" placeholder="Id Modele Controle" value="<?php echo $id_Modele_Controle; ?>" />
            </div>
            <input type="hidden" name="id_Controle" value="<?php echo $id_Controle; ?>" />
            <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
            <a href="<?php echo site_url('controle') ?>" class="btn btn-default">Cancel</a>
                </div>
        </div>
	</form>
    </body>
</html>