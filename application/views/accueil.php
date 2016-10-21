<?php include 'headerbarrenav.php';

?>
$chrBB = substr($cellValueOrigin,$posChrSearch-2,1);
$chrB = substr($cellValueOrigin,$posChrSearch-1,1);
$chrA = substr($cellValueOrigin,$posChrSearch+1,1);
$chrAA = substr($cellValueOrigin,$posChrSearch+2,1);

if($chrBB == $chrA AND $chrB == $chrAA)
{
$chrBeforeChrSearch = $chrBB . $chrB;
$chrAfterChrSearch = $chrA . $chrAA;
$double = TRUE;
}
else
{
$chrBeforeChrSearch = $chrB;
$chrAfterChrSearch = $chrA;
$double = False;
}

/**
* while($posChrSearch != $lastPosChrSearch)
* {
* $chrBB = substr($cellValueOrigin,$posChrSearch-2,1);
* $chrB = substr($cellValueOrigin,$posChrSearch-1,1);
* $chrA = substr($cellValueOrigin,$posChrSearch+1,1);
* $chrAA = substr($cellValueOrigin,$posChrSearch+2,1);
*
* if($chrBB == $chrA AND $chrB == $chrAA)
* {
* $chrBeforeChrSearch = $chrBB . $chrB;
* $chrAfterChrSearch = $chrA . $chrAA;
* $double = TRUE;
* }
* else
* {
* $chrBeforeChrSearch = $chrB;
* $chrAfterChrSearch = $chrA;
* $double = False;
* }
*
* $lenChrBefore = strlen($chrBeforeChrSearch);
* $lenChrAfter = strlen($chrAfterChrSearch);
*
* if($double)
* $strPosToEnd = substr($cellValueOrigin,$posChrSearch+3);
* else
* $strPosToEnd = substr($cellValueOrigin,$posChrSearch+2);
* $lengthStrAfterPos = strlen($strPosToEnd);
* $originalLength = strlen($cellValueOrigin);
* if($double)
* $lengthStrBefPos = $originalLength - $lengthStrAfterPos -6;
* else
* $lengthStrBefPos = $originalLength - $lengthStrAfterPos -4;
* $strStartToPos = substr($cellValueOrigin,$posStart,$lengthStrBefPos);
*
* $objWorksheet = $objPHPExcel->getSheetByName($nomfeuille);
* $nbLigneFeuilleMin = 1;
* $nbLigneFeuilleMax = intval($objWorksheet->getHighestDataRow());
* $strFinalBefPos = $chrBeforeChrSearch . $nbLigneFeuilleMin;
* $strFinalAftPos = $chrAfterChrSearch . $nbLigneFeuilleMax;
*
* $addLen = strlen($strFinalAftPos);
*
* $posStart = $posChrSearch + $addLen;
*
* $var = $var . $strStartToPos . $strFinalBefPos .$strSearch. $chrSearch . $strFinalAftPos ;
* var_dump(($var));
*
* $posChrSearch = strpos($cellValueOrigin,$chrSearch,$posChrSearch + 1);
* }
**/