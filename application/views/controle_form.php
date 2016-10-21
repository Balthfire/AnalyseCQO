<?php include 'headerbarrenav.php';  var_dump($action)?>
<link rel="stylesheet" href="<?php echo base_url('/assets/bootstrap/css/bootstrap.css') ?>"/>
<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>

<!doctype html>
<html>
<head>
    <title>Création de Contrôle</title>
</head>
    <body>
        <h2 style="margin-top:0px">Création de Contrôle </h2>
        <form action=<?php echo $action; ?> method="post">
	    <div class="form-group">
            <label for="varchar">Designation <?php echo form_error('designation') ?></label>
            <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation" value="<?php echo $designation; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Description <?php echo form_error('description') ?></label>
            <input type="text" class="form-control" name="description" id="description" placeholder="Description" value="<?php echo $description; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Num Vague <?php echo form_error('num_vague') ?></label>
            <input type="text" class="form-control" name="num_vague" id="num_vague" placeholder="Num Vague" value="<?php echo $num_vague; ?>" />
        </div>
	    <div class="form-group">
            <label for="date">Date Debut <?php echo form_error('date_debut') ?></label>
            <input type="text" class="form-control" name="date_debut" id="date_debut" placeholder="Date Debut" value="<?php echo $date_debut; ?>" />

        </div>
	    <div class="form-group">
            <label for="date">Date Fin <?php echo form_error('date_fin') ?></label>
            <input type="text" class="form-control" name="date_fin" id="date_fin" placeholder="Date Fin" value="<?php echo $date_fin; ?>" />
        </div>
	    <div class="form-group">
            <label for="double">Note <?php echo form_error('note') ?></label>
            <input type="text" class="form-control" name="note" id="note" placeholder="Note" value="<?php echo $note; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Niveau Qualite <?php echo form_error('Niveau_Qualite') ?></label>
            <input type="text" class="form-control" name="Niveau_Qualite" id="Niveau_Qualite" placeholder="Niveau Qualite" value="<?php echo $Niveau_Qualite; ?>" />
        </div>

        <div class="form-group">
            <label for="int">Type Controle <?php echo form_error('id_Type_Controle') ?></label></br>
            <?php
            echo '<select class="selectpicker" name="Type_Controle" id="Type_Controle">',"n";
            $i=0;
            foreach($arrayTypeControle as $typeControle )
            {
                echo '<option value="'.$typeControle[1].'">'.$typeControle[0].'</option>';
                $i++;
            }
            echo '</select>',"\n";

            ?>
        </div>
	    <div class="form-group">
            <label for="char">NNI <?php echo form_error('NNI') ?></label>
            <input type="text" class="form-control" name="NNI" id="NNI" placeholder="NNI" value="<?php echo $NNI; ?>" />
        </div>

            <input type="hidden" name="id_Controle" value="<?php echo $id_Controle; ?>" />
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('index.php/controle') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>