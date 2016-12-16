<?php include 'headerbarrenav.php'; ?>
<link rel="stylesheet" href="<?php echo base_url('/assets/style/general.css') ?>"/>

<html>
<head>
    <title>Upload Form</title>
    <script>
        function create_champ(i) {
            var i2 = i + 1;
            document.getElementById('nb_champ').setAttribute('value',i);

            document.getElementById('leschamps_'+i).innerHTML = '<select class="selectpicker" name="nom_champ_'+i+'" id="nom_champ_'+i+'">' +
                '<option value="CCS">CCS</option>' +
                '<option value="Service">Service</option>' +
                '<option value="Service2">Service2</option>' +
                '<option value="Agence">Agence</option></select>' +
                ' <input type="input" class="form-control" name="value_'+i+'" id="value_'+i+'"</span>';

            document.getElementById('leschamps_'+i).innerHTML += (i <=40 ) ? '<br /><span id="leschamps_'+i2+'"><a href="javascript:create_champ('+i2+')">Ajouter un champ</a></span>' : '';
        }
    </script>
</head>

<body>
<div class="container">
    <div class="center-block">

        <?php echo form_open_multipart('index.php/controle/ProcessCCS');
        echo '<label>Sélectionner une feuille</label> : <select class="selectpicker" name="nom_feuille" id="nom_feuille">',"n";

        foreach($arrayNomFeuille as $nomFeuille )
        {
            echo '<option value="'.$nomFeuille.'">'.$nomFeuille.'</option>';
        }
        echo '</select>',"\n";
        ?>
        <br><label>Ligne de départ</label> : <input type="input" class="form-control" name="datastart" id="datastart" />
        <br><label>Nombre d'échantillon</label> : <input type="input" class="form-control" name="nbechant" id="nbechant" />

        <fieldset><legend>Formulaire de saisie</legend>
            <select class="selectpicker" name="nom_champ_1" id="nom_champ_1">
                <option value="CCS">CCS</option>
                <option value="Service">Service</option>
                <option value="Service2">Service2</option>
                <option value="Agence">Agence</option>
            </select> <input type="input" class="form-control" name="value_1" id="value_1" />
            <br />
            <span id="leschamps_2"><a href="javascript:create_champ(2)">Ajouter un champ</a>
        </fieldset>
        <br/>

        <input type="hidden" name="nb_champ" id="nb_champ" value="1"/>
        <input type="hidden" name="lastinsert" id="lastinsert" value="<?php echo $lastinsert ?>"/>


        <br /><br />
        <input type="submit" value="submit" class="btn btn-primary" />
        </form>
    </div>
</div>
</body>
</html>