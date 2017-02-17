<?php include 'headerbarrenav.php'; ?>
<link rel="stylesheet" href="<?php echo base_url('/assets/style/general.css') ?>"/>

<html>
<head>
    <script type="text/javascript">
        function CreatePage()
        {
            var ArrayLinkedDatas = <?php echo json_encode($ArrayLinkedDatas); ?> ;
            dump(ArrayLinkedDatas);
            for(i=0;i<$ArrayLinkedDatas.length;++i)
            {
                alert(ArrayLinkedDatas);
            }
        }
/*
        function SetFormula(idSelect,idIndic)
        {
            idSelect++;
            alert(idIndic);

            var parent =  document.getElementById('select_colonne_'+idIndic+'_'+idSelect).parentNode;
            parent.removeChild(document.getElementById('select_colonne_'+idIndic+'_'+idSelect));
        }
*/
        var ArrayFormula = [];

        function SetFormula(idOperateur,idIndic)
        {
            /*
            if("key" in ArrayFormula[idIndic])
            {
                //ArrayFormula[idIndic][idColonne][] = idOperateur;
            }*/
            alert(idIndic);
            alert(idOperateur);
            var labelFormula =  document.getElementById('formula_'+idIndic);
            //var selectColonne = document.getElementById('formula_'+idIndic);
            labelFormula.innerHTML = "chips" ;
        }

        function dump(obj) {
            var out = '';
            for (var i in obj) {
                out += i + ": " + obj[i] + "\n";
            }
            alert(out);
        }


    </script>
    <title>Créer un nouveau calcul</title>
</head>
<body>
<div class="container" id="wrapper">
    <div class="row">
        <?php
        echo form_open_multipart();
        $Indic=0;
        $c=0;
        $varhtml = "";

        foreach ($ArrayLinkedDatas as $nomIndicateur => $ArrayFeuille)
        {
            $varIndic="";
            $varColonne="";
            $Indic++;
            $varhtml = $varhtml."<div class='col-md-4'>";
            $varIndic = $varIndic."<div class='well-indicateur' id='indicateur_'".$Indic.">";
            $varIndic = $varIndic."<label>".$nomIndicateur."</label><br/>";
            $varIndic = $varIndic."<select class='form-control' id='select_colonne_".$Indic."_".$c."'>";
            $varColonne = $varColonne."<option value='' disabled selected>Selection colonne</option>";
            foreach($ArrayFeuille as $nomFeuille => $ArrayColonne)
            {
                foreach($ArrayColonne['colonnes'] as $typeColonne => $idstruct)
                {
                    $c++;
                    $varColonne =$varColonne."<option value='".$idstruct."'>".$nomFeuille." - ".$typeColonne."</option>";
                }
            }
            $varIndic = $varIndic.$varColonne."</select></br>";
            $varIndic = $varIndic."<div class='row'>";
            for($i=0;$i<=count($ArrayOperateurs)-1;$i++)
            {
                $val=$ArrayOperateurs[$i]['valeur'];
                $idop=$ArrayOperateurs[$i]['id_Operateur'];
                $varIndic = $varIndic."<div class='col-md-4'><button class='btn btn-primary-end' type='button' onclick='SetFormula(".$idop.",".$Indic.")'>".$val."</button></div>";
            }
            $varIndic = $varIndic."</div></br><label id='formula_".$Indic."'>Chips</label>";
            $varIndic = $varIndic."<button class='btn btn-primary-end' type='button'>Appliquer Formule</button></div></div>";
            $varhtml = $varhtml.$varIndic;
        }
        echo $varhtml;
        echo form_close();
        ?>
    </div>
</div>
</body>

