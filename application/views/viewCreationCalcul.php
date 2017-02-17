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

        function SetFormula(idSelect,idIndic)
        {
            idSelect++;
            alert(idIndic);

            var parent =  document.getElementById('select_colonne_'+idIndic+'_'+idSelect).parentNode;
            parent.removeChild(document.getElementById('select_colonne_'+idIndic+'_'+idSelect));
        }

        function SetArrayFormula(idSelect,idIndic,ArrayFormula)
        {
            idSelect++;
            alert(idIndic);
            var labelFormula =  document.getElementById('formula_'+idIndic);
            var selectColonne = document.getElementById('formula_'+idIndic);
            labelFormula.innerHTML = ;
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
        $i=0;
        $c=0;
        $varhtml = "";

        foreach ($ArrayLinkedDatas as $nomIndicateur => $ArrayFeuille)
        {
            $varIndic="";
            $varColonne="";
            $i++;
            $varhtml = $varhtml."<div class='col-md-4'>";
            $varIndic = $varIndic."<div class='well-indicateur' id='indicateur_'".$i.">";
            $varIndic = $varIndic."<label>".$nomIndicateur."</label><br/>";
            $varIndic = $varIndic."<select class='form-control' id='select_colonne_".$i."_".$c."'>";
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
            $varIndic = $varIndic."<label id='formula_".$i."'></label>";
            $varIndic = $varIndic."<button class='btn btn-primary-end' type='button' onclick='SetFormula(0,".$i.")'>Appliquer Formule</button></div></div>";
            $varhtml = $varhtml.$varIndic;
        }
        echo $varhtml;
        ?>
    </div>
</div>
</body>

