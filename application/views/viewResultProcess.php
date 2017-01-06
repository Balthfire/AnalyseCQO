<?php include 'headerbarrenav.php'; ?>
<link rel="stylesheet" href="<?php echo base_url('/assets/style/general.css') ?>"/>

<html>
<head>
    <title>Tableau résultat</title>
</head>
<body>
<div class="container">
    <div class="center-block">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Agence</th>
                <th>Nombre</th>
                <th>Montant </th>
                <th>Anomalie</th>
                <th>% Montant</th>
                <th>% Anomalie</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $ArrayMultipleCCS = array();
            $ArrayStorage = array();
            $MontantTotal = $MT;
            $AnomalieTotal = $AT;
            $TotalEchant = 0;
            foreach ($CCSparName as $Name => $ArrayCCS)
            {
                $sommeMontant = 0;
                $sommeAnomalie = 0;
                $nbligne=0;

                if(count($ArrayCCS)>1)
                 {
                     foreach($ArrayCCS as $id => $CCS)
                     {
                         if(array_key_exists($CCS,$MontantParCCS))
                         {
                             $sommeMontant = $sommeMontant + $MontantParCCS[$CCS];
                         }
                         if(array_key_exists($CCS,$KOParCCS))
                         {
                             $sommeAnomalie = $sommeAnomalie + $KOParCCS[$CCS];
                         }
                         if(array_key_exists($CCS,$NbLigneParCCS))
                         {
                             $nbligne = $nbligne + $NbLigneParCCS[$CCS];
                         }
                     }
                     $ArrayStorage['nbligne'] = $nbligne;
                     $ArrayStorage['Montant'] = $sommeMontant;
                     $ArrayStorage['Anomalie'] = $sommeAnomalie;
                     $ArrayMultipleCCS[$Name] = $ArrayStorage;
                 }
            }

            foreach ($CCSparName as $Name => $ArrayCCS)
            {
                $CollapseId = 0;
                if(array_key_exists($Name,$ArrayMultipleCCS))
                {
                    $ArrayStorage = $ArrayMultipleCCS[$Name];
                    if(!array_key_exists('Used',$ArrayStorage))
                    {
                        $montant = $ArrayStorage['Montant'];
                        $anomalie = $ArrayStorage['Anomalie'];
                        $ligne = $ArrayStorage['nbligne'];
                        $TotalEchant = $TotalEchant + $ligne;
                        $PourcentMontant = round((($montant * 100)/$MontantTotal),2);
                        $PourcentAnomalie = round((($anomalie * 100)/$AnomalieTotal),2);
                        echo("<tr><td>".$Name."</td>");
                        echo("<td>".$ligne."</td>");
                        echo("<td>".$montant."</td>");
                        echo("<td>".$anomalie."</td>");
                        echo("<td>$PourcentMontant</td>");
                        echo("<td>$PourcentAnomalie</td></tr>");
                        $ArrayMultipleCCS[$Name]['Used'] = 1;
                    }
                }
                else
                {
                    foreach($ArrayCCS as $id => $CCS)
                    {
                        $nombreligne=0;
                        if(array_key_exists($CCS,$MontantParCCS))
                        {
                            $montantCCS = $MontantParCCS[$CCS];
                            $PourcentMontant = round((($montantCCS * 100)/$MontantTotal),2);
                        }
                        if(array_key_exists($CCS,$KOParCCS))
                        {
                            $anomalieCCS = $KOParCCS[$CCS];
                            $PourcentAnomalie = round($anomalieCCS/$montantCCS);
                        }
                        if(array_key_exists($CCS,$NbLigneParCCS))
                        {
                            $nombreligne = $nombreligne + $NbLigneParCCS[$CCS];
                            $TotalEchant = $TotalEchant + $nombreligne;

                        }
                        echo("<tr><td>$Name</td>");
                        echo("<td>$nombreligne</td>");
                        echo("<td>$montantCCS</td>");
                        echo("<td>$anomalieCCS</td>");
                        echo("<td>$PourcentMontant</td>");
                        echo("<td>$PourcentAnomalie</td></tr>");
                    }
                }
            }
            echo("<tr><td>Total</td>");
            echo("<td>$TotalEchant</td>");
            echo("<td>$MontantTotal</td>");
            echo("<td>$AnomalieTotal</td></tr>");
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>