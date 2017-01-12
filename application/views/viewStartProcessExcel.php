<?php include 'headerbarrenav.php'; ?>
<link rel="stylesheet" href="<?php echo base_url('/assets/style/general.css') ?>"/>

<html>
<head>
    <title>Upload Form</title>
    <script>
        function CreateSelectNomFeuille() {
            var jsArrayNomfeuille = <?php echo json_encode($arrayNomFeuille); ?> ;
            var options ="";

            for(i=0;i<jsArrayNomfeuille.length;++i)
            {
                var nomfeuille = jsArrayNomfeuille[i];
                options = options + '<option value="'+nomfeuille+'">'+nomfeuille+'</option>';
            }
            options = options + '</select><br>';
            return(options);
        }

        var Options = CreateSelectNomFeuille();

        function CreateIndicateur(i)
        {
            document.getElementById('nb_indic').setAttribute('value',i);
            var i2 = i + 1;

            document.getElementById('indicateur_'+i).innerHTML = '<div class="well-indicateur"><br/>' +
                '<label class="label-test">Indicateur</label> : <input type="input" class="form-control" name="indicateur_'+i+'" id="indicateur_'+i+'" /><br>' +
                '<label>Sélectionner une feuille</label> : <select class="form-control" name="nom_feuille_'+i+'" id="nom_feuille_'+i+'">' +
                Options +
                '<label>Ligne de départ</label> : <input type="input" class="form-control" name="datastart_'+i+'" id="datastart_'+i+'" />' +
                '<label>Ligne de fin</label> : <input type="input" class="form-control" name="dataend_'+i+'" id="dataend_'+i+'" />' +
                '<fieldset><legend>Formulaire de saisie</legend>' +
                '<select class="form-control" name="nom_champ_'+i+'_1" id="nom_champ_'+i+'_1">'+
                    '<option value="CCS">CCS</option>'+
                    '<option value="Montant">Montant</option>'+
                    '<option value="Champ KO">Champ KO</option></select>' +
                '<input type="input" class="form-control" name="value_'+i+'_1" id="value_'+i+'_1" /><br>'+
                '<div id="leschamps_'+i+'_2"><button type="button" class="btn btn-primary" onclick="CreateChamp('+i+',2)">Ajouter un champ</button></div></fieldset><br/>'+
                '<input type="hidden" name="nb_champ_'+i+'" id="nb_champ_'+i+'" value="1"/></div>'+
                '<div id="indicateur_'+i2+'"><button type="button" class="btn btn-primary" onclick="CreateIndicateur('+i2+')">Ajouter un indicateur</button></div>';
        }

        function CreateChamp(idIndic,i)
        {
            var i2 = i + 1;
            document.getElementById('nb_champ_'+idIndic).setAttribute('value',i);
            document.getElementById('leschamps_'+idIndic+'_'+i).innerHTML = '<select class="form-control" name="nom_champ_'+idIndic+'_'+i+'" id="nom_champ_'+idIndic+'_'+i+'">' +
                '<option value="CCS">CCS</option>' +
                '<option value="Montant">Montant</option>' +
                '<option value="Champ KO">Champ KO</option>' +
                '<input type="input" class="form-control" name="value_'+idIndic+'_'+i+'" id="value_'+idIndic+'_'+i+'"/><br>'+
                '<div id="leschamps_'+idIndic+'_'+i2+'"><button type="button" class="btn btn-primary" onclick="CreateChamp('+idIndic+','+i2+')">Ajouter un champ</button></div><br>';

            }
    </script>
</head>

<body>
<div class="container" id="wrapper">
    <div class="container" id="cloneDiv">
        <div class="well-indicateur"><br/>
                <label class="label-test">Indicateur</label> : <input type="input" class="form-control" name="indicateur" id="indicateur" />
                <br>
            <?php echo form_open_multipart('index.php/controle/ProcessExcel');
            echo '<label>Sélectionner une feuille</label> : <select class="form-control" name="nom_feuille_1" id="nom_feuille_1">',"n";

            foreach($arrayNomFeuille as $nomFeuille )
            {
                echo '<option value="'.$nomFeuille.'">'.$nomFeuille.'</option>';
            }
            echo '</select><br>',"\n";
            ?>
            <label>Ligne de départ</label> : <input type="input" class="form-control" name="datastart_1" id="datastart_1" />
            <label>Ligne de fin</label> : <input type="input" class="form-control" name="dataend_1" id="dataend_1" />

                <fieldset><legend>Formulaire de saisie</legend>
                    <select class="form-control" name="nom_champ_1_1" id="nom_champ_1_1">
                        <option value="CCS">CCS</option>
                        <option value="Montant">Montant</option>
                        <option value="Champ KO">Champ KO</option>
                    </select>
                    <input type="input" class="form-control" name="value_1_1" id="value_1_1" />
                    <br />
                    <div id="leschamps_1_2"><button type="button" class="btn btn-primary" onclick="CreateChamp(1,2)">Ajouter un champ</button></div>
                </fieldset>
                <br/>
                <input type="hidden" name="nb_champ_1" id="nb_champ_1" value="1"/>
                <input type="hidden" name="lastinsert" id="lastinsert" value="<?php echo $lastinsert ?>"/>
        </div>
        <div id="indicateur_2"><button type="button" class="btn btn-primary" onclick="CreateIndicateur(2)">Ajouter un indicateur</button></div>
        <input type="submit" value="Accepter" class="btn btn-primary" />
        <input type="hidden" name="nb_indic" id="nb_indic" value="1"/>

        <?php form_close(); ?>
        </div>
    </div>
</body>
</html>