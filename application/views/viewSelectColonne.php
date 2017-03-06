<?php include 'headerbarrenav.php'; ?>
<link rel="stylesheet" href="<?php echo base_url('/assets/style/general.css') ?>"/>

<html>
<head>
    <title>Selection Colonne</title>
<script>
    function CreateSelectNomFeuille() {
        var jsArrayNomfeuille = <?php echo json_encode($arrayNomFeuille); ?> ;
        var options ="";

        for(i=0;i<jsArrayNomfeuille.length;++i)
        {
            var nomfeuille = jsArrayNomfeuille[i];
            options = options + '<option value="'+nomfeuille+'">'+nomfeuille+'</option>';
        }
        options = options + '</select>';
        return(options);
    }

    function CreateSelectTypeColonne() {
        var jsArrayNomfeuille = <?php echo json_encode($arrayNomFeuille); ?> ;
        var options ="";

        for(i=0;i<jsArrayNomfeuille.length;++i)
        {
            var nomfeuille = jsArrayNomfeuille[i];
            options = options + '<option value="'+nomfeuille+'">'+nomfeuille+'</option>';
        }
        options = options + '</select>';
        return(options);
    }

    var Options = CreateSelectNomFeuille();

    function CreateIndicateur(i)
    {
        document.getElementById('nb_indic').setAttribute('value',i);
        var i2 = i + 1;

        var parent = document.getElementById('btn_indic_'+i).parentNode;
        parent.removeChild(document.getElementById('btn_indic_'+i));

        var newnode = document.createElement("div");
        newnode.className = "col-md-3";
        newnode.innerHTML = '<div class="well-indicateur">' +
            '<input type="text" class="form-control" name="indicateur_'+i+'" id="indicateur_'+i+'" placeholder="Indicateur" /><br>' +
            '<select class="form-control" name="nom_feuille_'+i+'" id="nom_feuille_'+i+'">'+
            '<option value="none" disabled selected>Feuille de calcul</option>'+
            Options +
            '<button type="button" id="btn_ajout_feuille_'+i+'_1" class="btn btn-primary-end" onclick="CreateFeuille('+i+',0)">Ajout Feuille</button>'+
            '<input type="hidden" name="nb_feuille_'+i+'" id="nb_feuille_'+i+'" value="1"/>'+
            '<div id="div_feuilles_'+i+'"></div></div>'+
            '</div><div class="col-md-3"><button type="button" id="btn_indic_'+i2+'" class="btn btn-primary" onclick="CreateIndicateur('+i2+')">Ajout Indicateur</button></div>';

        document.getElementById('row_indicateur').appendChild(newnode);
    }

    function CreateFeuille(idIndic,i)
    {
        var i2 = i + 1;
        if(i===0)
            i=1;

        var selector = document.getElementById('nom_feuille_'+idIndic);
        var selectedvalue = selector.options[selector.selectedIndex].value;

        if(selectedvalue !== "none")
        {
            document.getElementById('nb_feuille_'+idIndic).setAttribute('value',i2);
            var newnode = document.createElement("div");
            newnode.id = "div_feuille_"+idIndic+"_"+i2;
            newnode.className = "div_feuille";
            newnode.innerHTML = '<label class="label-feuille">'+selectedvalue+'</label></br>'+
                '<input type="hidden" name="txt_nom_feuille_'+idIndic+'_'+i2+'" id="txt_nom_feuille_'+idIndic+'_'+i2+'" value="'+selectedvalue+'"/>'+
                '<input type="text" class="champ_ligne" name="datastart_'+idIndic+'_'+i2+'" id="datastart_'+idIndic+'_'+i2+'" placeholder="1ère ligne" />'+
                '<input type="text" class="champ_ligne" name="dataend_'+idIndic+'_'+i2+'" id="dataend_'+idIndic+'_'+i2+'" placeholder="Dern. ligne" /></br></br>'+
                '<div id=div_colonnes_'+idIndic+'_'+i2+'>'+
                '<div id=div_colonne_'+idIndic+'_'+i2+'_1>'+
                '<select class="form-control" name="type_colonne_'+idIndic+'_'+i2+'_1" id="type_colonne_'+idIndic+'_'+i2+'_1">'+
                '</br></br><option value="" disabled selected>Type de colonne</option>'+
                '<option value="CCS">CCS</option>'+
                '<option value="Montant">Montant</option>'+
                '<option value="Champ KO">Champ KO</option></select>' +
                '<input type="text" class="form-control" name="value_'+idIndic+'_'+i2+'_1" id="value_'+idIndic+'_'+i2+'_1" placeholder="Lettre colonne" onkeyup="this.value=this.value.toUpperCase()" /></br>'+
                '<input type="hidden" name="nb_colonne_'+idIndic+'_'+i2+'" id="nb_colonne_'+idIndic+'_'+i2+'" value="1">'+
                '<button type="button" id="btn_ajout_colonne_'+idIndic+'_'+i2+'_1" class="btn btn-primary-end" onclick="CreateColonne('+idIndic+','+i2+',1)">Ajout Colonne</button></div></div>';

            document.getElementById('div_feuilles_'+idIndic).appendChild(newnode);
            var parent = document.getElementById('btn_ajout_feuille_'+idIndic+'_'+i).parentNode;
            parent.removeChild(document.getElementById('btn_ajout_feuille_'+idIndic+'_'+i));
            parent.removeChild(document.getElementById('nom_feuille_'+idIndic));

            newnode = document.createElement("div")
            newnode.innerHTML='</br><select class="form-control" name="nom_feuille_'+idIndic+'" id="nom_feuille_'+idIndic+'">' +
                '<option value="none" disabled selected>Feuille de calcul</option>'+
                Options +
                '<button type="button" id="btn_ajout_feuille_'+idIndic+'_'+i2+'" class="btn btn-primary-end" onclick="CreateFeuille('+idIndic+','+i2+')">Ajout Feuille</button>';
            document.getElementById('div_feuilles_'+idIndic).appendChild(newnode);
        }
        else
            alert('Veuillez sélectionner une feuille');

    }

    function CreateColonne(idIndic,idFeuille,i)
    {
        var i2 = i + 1;
        document.getElementById('nb_colonne_'+idIndic+'_'+idFeuille).setAttribute('value',i2);

        var newnode = document.createElement('div');
        newnode.id = 'div_colonne_'+idIndic+'_'+idFeuille+'_'+i2;
        newnode.innerHTML = '<select class="form-control" name="type_colonne_'+idIndic+'_'+idFeuille+'_'+i2+'" id="type_colonne_'+idIndic+'_'+idFeuille+'_'+i2+'">' +
            '<option value="" disabled selected>Type de colonne</option>'+
            '<option value="CCS">CCS</option>' +
            '<option value="Montant">Montant</option>' +
            '<option value="Champ KO">Champ KO</option>' +
            '<input type="text" class="form-control" name="value_'+idIndic+'_'+idFeuille+'_'+i2+'" id="value_'+idIndic+'_'+idFeuille+'_'+i2+'" placeholder="Lettre colonne" onkeyup="this.value=this.value.toUpperCase()"/><br>'+
            '<button type="button" id="btn_ajout_colonne_'+idIndic+'_'+idFeuille+'_'+i2+'" class="btn btn-primary-end" onclick="CreateColonne('+idIndic+','+idFeuille+','+i2+')">Ajout Colonne</button></div>';

        document.getElementById('div_colonnes_'+idIndic+'_'+idFeuille).appendChild(newnode);
        var parent = document.getElementById('btn_ajout_colonne_'+idIndic+'_'+idFeuille+'_'+i).parentNode;
        parent.removeChild(document.getElementById('btn_ajout_colonne_'+idIndic+'_'+idFeuille+'_'+i));
    }
</script>
</head>

<body>
<div class="container" id="wrapper">
    <?php echo form_open_multipart('index.php/controle/ProcessExcel2'); ?>
    <div class="row" id="row_indicateur">
        <div class="col-md-3">
            <div class="well-indicateur">
                <input type="text" class="form-control" name="indicateur_1" id="indicateur_1" placeholder="Indicateur" />
                <br/>
                <select class="form-control" name="nom_feuille_1" id="nom_feuille_1">
                    <option value="none" disabled selected>Feuille de calcul</option>
                <?php
                foreach($arrayNomFeuille as $nomFeuille)
                {
                    echo '<option value="'.$nomFeuille.'">'.$nomFeuille.'</option>';
                }
                ?>
                </select>
                <button type="button" id="btn_ajout_feuille_1_1" class="btn btn-primary-end" onclick="CreateFeuille(1,0)">Ajout Feuille</button>
                <div id="div_feuilles_1">
                </div>
                <input type="hidden" name="nb_feuille_1" id="nb_feuille_1" value="1"/>
                <input type="hidden" name="lastinsert" id="lastinsert" value="<?php echo $lastinsert ?>"/>
            </div>
        </div>
        <button type="button" id="btn_indic_2" class="btn btn-primary" onclick="CreateIndicateur(2)">Ajouter Indicateur</button>
    </div>
    <div class="row" id="rowbutton">
        <div class ="col-md-12">
            <input type="submit" value="Accepter" class="btn btn-primary-end" />
            <input type="hidden" name="nb_indic" id="nb_indic" value="1"/>
            <input type="hidden" name="idControle" id="idControle" value="<?php echo $idControle ?>"/>
        </div>
    </div>
<?php form_close(); ?>
</div>
</body>
</html>