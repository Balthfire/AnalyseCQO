<?php include 'headerbarrenav.php'; ?>
<link rel="stylesheet" href="<?php echo base_url('/assets/style/general.css') ?>"/>

<html>
<head>
    <script type="text/javascript">
        var ArrayFormula = {};
        var ArrayDenominateur = {};
        var ArrayNumerateur = {};
        var TempArrayNum = {};
        var TempArrayDeno = {};

        function SetFormula(idOperateur,idIndic,numerateur)
        {
            var labelFormula,columnId,divToAdd,nbCol,child,selectValue,textnumerateur;
            var nomIndic = document.getElementById('value_nom_indicateur_'+idIndic).value;
            ArrayNumerateur[nomIndic] = {}; //massacrer Xavier, sa maison et tout ce qui va avec
            ArrayDenominateur[nomIndic] = {}; //remassacrer Xavier, sa maison et tout ce qui va avec
            if(numerateur == 1) {
                textnumerateur = "numerateur";
            }
            else {
                textnumerateur = "denominateur";
            }
            nbCol = document.getElementById('nb_Colonne_'+textnumerateur+'_'+idIndic).value;
            columnId = document.getElementById('select_colonne_'+textnumerateur+'_'+idIndic+'_'+nbCol);
            selectValue = columnId.value;
            ArrayNumerateur[nomIndic][selectValue] = {};
            ArrayDenominateur[nomIndic][selectValue] = {};
            if(selectValue != "none")
            {
                if(idOperateur == 1) {
                    document.getElementById('nb_Colonne_' + textnumerateur + '_' + idIndic).value += 1;
                    nbCol = document.getElementById('nb_Colonne_' + textnumerateur + '_' + idIndic).value;
                    child = document.createElement("div");
                    child.id = "div_select_colonne_'+textnumerateur+'_'+idIndic+'_'+nbCol+'";
                    child.innerHTML = '+ <br/><select class="form-control" id="select_colonne_' + textnumerateur + '_' + idIndic + '_' + nbCol + '">' + OptionsColonne(nomIndic);

                    divToAdd = columnId.parentNode;
                    divToAdd.appendChild(child);
                    if (numerateur == 1) {
                        ArrayNumerateur[nomIndic]=(idOperateur);
                    }
                    else{
                        ArrayDenominateur[nomIndic]=(idOperateur);
                    }
                }
                else {
                    if (numerateur == 1) {
                        ArrayNumerateur[nomIndic][selectValue]=(idOperateur);
                    }
                    else {
                        ArrayDenominateur[nomIndic][selectValue]=(idOperateur);
                    }
                }
                labelFormula = document.getElementById('formula_'+textnumerateur+'_'+idIndic);
                columnId.disabled = true;
                ArrayFormula[nomIndic] = {};
                ArrayFormula[nomIndic][textnumerateur] = {};
                if (numerateur == 1) {
                    ArrayFormula[nomIndic][textnumerateur]=(ArrayNumerateur[nomIndic]);
                    alert(ArrayFormula[nomIndic][textnumerateur]);
                }
                else{
                    ArrayFormula[nomIndic][textnumerateur]=(ArrayDenominateur[nomIndic]);
                    alert(ArrayFormula[nomIndic][textnumerateur]);
                }

            }
            else{
                alert('Veuillez sélectionner une colonne');
            }
        }

        function writeLabelFormula(Array,textnumerateur,idIndic,nomIndic)
        {
            //TODO : faire cette fonction :)
        }
/*
        function ArrayKeyExist(Array,key)
        {
            if(key in Array){
                return true;
            }
            else {
                return false;
            }
        }

        function checkArrayColumnExist(Array,nomIndic,ColValue)
        {
            if (ArrayKeyExist(Array,nomIndic)){
                if(ArrayKeyExist(Array[nomIndic],ColValue)
                {
                    return true;
                }
                else
                {
                    return "needColumn";
                }
            }
            else {
                return "needIndic";
            }
        }
*/
        function createArrayFormula()
        {
            var jsonstring = JSON.stringify(ArrayFormula);
            document.getElementById('HiddenFormula').value = jsonstring;
            //alert(JSON.stringify(ArrayFormula));
            //alert(document.getElementById('HiddenFormula').value);
           // document.getElementById('form_calcul').submit();
        }

        function OptionsColonne(nomIndic)
        {
            var jsArrayNomFeuille,jsArrayNomColonne,jsArrayTypeColonne;
            var jsArrayLinkedDatas = <?php echo(json_encode($ArrayLinkedDatas)); ?> ;
            var options ="<option selected disabled value='none'> Selectionnez colonne </option>";

            jsArrayNomFeuille = jsArrayLinkedDatas[nomIndic];
            for(var nomFeuille in jsArrayNomFeuille)
            {
                jsArrayNomColonne = jsArrayNomFeuille[nomFeuille];
                jsArrayTypeColonne = jsArrayNomColonne['colonnes'];
                for (var TypeColonne in jsArrayTypeColonne)
                {
                    options += '<option value="'+jsArrayTypeColonne[TypeColonne]+'">'+nomFeuille+' - '+TypeColonne+'</option>';
                }
            }
            options += '</select>';
            return(options);
        }
    </script>
    <title>Créer un nouveau calcul</title>
</head>
<body>
<div class="container" id="wrapper">
    <div class="row">
        <?php
        echo form_open_multipart('index.php/controle/StoreFormula','id="form_calcul"');
        $Indic=0;
        $varhtml = "";
        foreach ($ArrayLinkedDatas as $nomIndicateur => $ArrayFeuille)
        {
            $numerateur = true;
            $txtnumerateur ="numerateur";
            $varIndic="";
            $Indic++;
            $varhtml = $varhtml."<div class='col-md-4'>";
            $varhtml = $varhtml . "<div class='well-indicateur' id='indicateur_" . $Indic . "'>";
            $varhtml = $varhtml . "<label id='nom_indicateur_" . $Indic . "'>" . $nomIndicateur . "</label><br/>";
            $varhtml = $varhtml . "<input type='hidden' name='value_nom_indicateur_" . $Indic . "' id='value_nom_indicateur_" . $Indic . "' value='" . $nomIndicateur . "'>";

            for($t=0;$t<=1;$t++)
            {
                $varIndic="";

                if($numerateur){
                    $txtnumerateur = "numerateur";
                }
                else{
                    $txtnumerateur = "denominateur";
                }

                $varIndic = $varIndic . "<div class ='row'>";
                $varIndic = $varIndic . "<div class ='col-md-12' id='div_" . $txtnumerateur . "_" . $Indic . "'>";
                $varIndic = $varIndic . "<div  id='div_selects_" . $txtnumerateur . "_" . $Indic . "'>";
                $varIndic = $varIndic . SelectColonne($ArrayFeuille,$Indic,$txtnumerateur);
                $varIndic = $varIndic . OptionsOperateurs($ArrayOperateurs, $Indic,$numerateur);
                $varIndic = $varIndic . "</div></br><label id='formula_". $txtnumerateur ."_" . $Indic . "'>Formule ". $txtnumerateur ."</label>";
                $varIndic = $varIndic . "<input type='hidden' value=1 name='nb_Colonne_". $txtnumerateur ."_" . $Indic . "' id='nb_Colonne_". $txtnumerateur ."_" . $Indic . "'>";
                $varIndic = $varIndic . "</div></br> ";
                $varIndic = $varIndic . "</div> ";
                if($numerateur) {
                    $numerateur = false;
                    $varIndic = $varIndic . "<hr class='hr-test'>";
                }
                $varhtml = $varhtml . $varIndic;
            }
            $varhtml = $varhtml."</div></div>";
        }
        $varhtml = $varhtml . "<input type=\"submit\" onclick=\"createArrayFormula()\">";
        $varhtml = $varhtml . "<input type=\"hidden\" name=\"HiddenFormula\" id=\"HiddenFormula\" value=\"chips\">";

        echo $varhtml;
        echo form_close();

        function SelectColonne($ArrayFeuille,$Indic,$txtnumerateur)
        {
            $varColonne = "";
            $varColonne = $varColonne . "<div id='div_select_colonne_". $txtnumerateur ."_" . $Indic . "_1'>";
            $varColonne = $varColonne . "<select class='form-control' id='select_colonne_". $txtnumerateur ."_" . $Indic . "_1'>";
            $varColonne = $varColonne . "<option selected disabled value='none'> Selectionnez colonne </option>";

            foreach ($ArrayFeuille as $nomFeuille => $ArrayColonne) {
                foreach ($ArrayColonne['colonnes'] as $typeColonne => $idstruct) {
                    $varColonne = $varColonne . "<option value='" . $idstruct . "'>" . $nomFeuille . " - " . $typeColonne . "</option>";
                }
            }
            $varColonne =$varColonne . "</select></div></br>";
            return($varColonne);
        }

        function OptionsOperateurs($ArrayOperateurs,$Indic,$numerateur)
        {
            if($numerateur){
                $BoolNumerateur = 1;
                $txtnumerateur = "numerateur";
            }
            else{
                $BoolNumerateur = 0;
                $txtnumerateur = "denominateur";
            }
            $returnvar = "<div class='btn-toolbar'>";
            $varButton="";
            for($i=0;$i<=count($ArrayOperateurs)-1;$i++)
            {
                $val=$ArrayOperateurs[$i]['valeur'];
                $idop=$ArrayOperateurs[$i]['id_Operateur'];
                $varButton = $varButton . "<div class='btn-group'><button class='btn btn-primary-end' type='button' onclick='SetFormula(".$idop.",".$Indic.",".$BoolNumerateur.")'>".$val."</button></div>";
            }
            $returnvar = $returnvar . $varButton . "</div>";
            return($returnvar);
        }

        ?>
    </div>
</div>
</body>
</html>