<?php include 'headerbarrenav.php'; ?>
<link rel="stylesheet" href="<?php echo base_url('/assets/style/general.css') ?>"/>

<html>
<head>
    <title>Upload Form</title>
    <script>
        function create_champ(i,idDiv) {
            var i2 = i + 1;
            document.getElementById('nb_champ').setAttribute('value',i);

            document.getElementById('leschamps_'+i).innerHTML = '<select class="form-control" name="nom_champ_'+i+'" id="nom_champ_'+i+'">' +
                '<option value="CCS">CCS</option>' +
                '<option value="Montant">Montant</option>' +
                '<option value="Champ KO">Champ KO</option>' +
                '<option value="Nombre d\'échantillon">Nombre d\'échantillon</option></select>' +
                '<input type="input" class="form-control" name="value_'+i+'" id="value_'+i+'"</span>';

            document.getElementById('leschamps_'+i).innerHTML += (i <=40 ) ? '<br /><span id="leschamps_'+i2+'"><a href="javascript:create_champ('+i2+')">Ajouter un champ</a></span>' : '';
        }

        function create_indicateur(i) {
            var i2 = i + 1;
            var id = "cloneDiv"; // ID de ton div a cloner
            var elem = document.getElementById(id);
            var clone = elem.cloneNode(true);
            elem.parentNode.appendChild(clone);
            // document.getElementById('lesindic_'+i).innerHTML = elem
        }

        function create_indicateurTest(i) {
            var i2 = i + 1;
            var id = "cloneDiv"; // ID de ton div a cloner
            var elem = document.getElementById(id);
            var clone = elem.cloneNode(true);
            elem.parentNode.appendChild(clone);
            // document.getElementById('lesindic_'+i).innerHTML = elem

            document.getElementById('lesindics_'+i).innerHTML =


        }
    </script>
</head>

<body>
<div class="container" id="wrapper">
    <div class="container" id="cloneDiv">
        <div class="well-indicateur"><br/>
            <div id="DivChampForm">
            <label class="label-test">Indicateur</label> : <input type="input" class="form-control" name="indicateur" id="indicateur" />
            <br>
                <?php echo form_open_multipart('index.php/controle/ProcessExcel');
                echo '<label>Sélectionner une feuille</label> : <select class="form-control" name="nom_feuille" id="nom_feuille">',"n";

                foreach($arrayNomFeuille as $nomFeuille )
                {
                    echo '<option value="'.$nomFeuille.'">'.$nomFeuille.'</option>';
                }
                echo '</select><br>',"\n";
                ?>
                    <label>Ligne de départ</label> : <input type="input" class="form-control" name="datastart" id="datastart" />
                    <label>Ligne de fin</label> : <input type="input" class="form-control" name="dataend" id="dataend" />
            </div>
            <div id="DivFormSaisie_1">
                    <fieldset><legend>Formulaire de saisie</legend>
                        <select class="form-control" name="nom_champ_1" id="nom_champ_1">
                            <option value="CCS">CCS</option>
                            <option value="Montant">Montant</option>
                            <option value="Champ KO">Champ KO</option>
                            <option value="Nombre d'échantillon">Nombre d'échantillon</option>
                        </select>
                        <input type="input" class="form-control" name="value_1" id="value_1" />
                        <br />
                    <span id="leschamps_2"><a href="javascript:create_champ(2)">Ajouter un champ</a>
            </fieldset>
            <br/>
            <input type="hidden" name="nb_champ" id="nb_champ" value="1"/>
            <input type="hidden" name="nb_indic" id="nb_indic" value="1"/>
            <input type="hidden" name="lastinsert" id="lastinsert" value="<?php echo $lastinsert ?>"/>
            <br /><br />
            </div>
        <span id="lesindic_2"><a href="javascript:create_indicateur(2)">Ajouter un indicateur</a>

        <input type="submit" value="Accepter" class="btn btn-primary" />
        <?php form_close(); ?>

            </div>
        </div>
    </div>
    </div>
</body>
</html>