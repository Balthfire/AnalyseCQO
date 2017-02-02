<?php include 'headerbarrenav.php'; ?>
<link rel="stylesheet" href="<?php echo base_url('/assets/style/general.css') ?>"/>

<html>
<head>
    <script>
        function set_operateur(operateur)
        {
            switch(operateur) {
                case "+":
                    document.getElementById('formulevisible').innerHTML = document.getElementById('formulevisible').innerHTML + '+';
                    document.getElementById('formulesql').innerHTML = document.getElementById('formulesql').innerHTML + '+';
                    break;
                case "-":
                    document.getElementById('formulevisible').innerHTML = document.getElementById('formulevisible').innerHTML + '-';
                    document.getElementById('formulesql').innerHTML = document.getElementById('formulesql').innerHTML + '-';
                    break;
                case "*":
                    document.getElementById('formulevisible').innerHTML = document.getElementById('formulevisible').innerHTML + '*';
                    document.getElementById('formulesql').innerHTML = document.getElementById('formulesql').innerHTML + '*';
                    break;
                case "/":
                    document.getElementById('formulevisible').innerHTML = document.getElementById('formulevisible').innerHTML + '/';
                    document.getElementById('formulesql').innerHTML = document.getElementById('formulesql').innerHTML + '/';
                    break;
                case "%":
                    document.getElementById('formulevisible').innerHTML = document.getElementById('formulevisible').innerHTML + '%(';
                    document.getElementById('formulesql').innerHTML = document.getElementById('formulesql').innerHTML + '%(';
                    break;
                case "(":
                    document.getElementById('formulevisible').innerHTML = document.getElementById('formulevisible').innerHTML + '(';
                    document.getElementById('formulesql').innerHTML = document.getElementById('formulesql').innerHTML + '(';
                    break;
                case ")":
                    document.getElementById('formulevisible').innerHTML = document.getElementById('formulevisible').innerHTML + ')';
                    document.getElementById('formulesql').innerHTML = document.getElementById('formulesql').innerHTML + ')';
                    break;
                case "NBVAL":
                    document.getElementById('formulevisible').innerHTML = document.getElementById('formulevisible').innerHTML + 'NBVAL(';
                    document.getElementById('formulesql').innerHTML = document.getElementById('formulesql').innerHTML + 'COUNT(';
                    break;
                case "SOMME":
                    document.getElementById('formulevisible').innerHTML = document.getElementById('formulevisible').innerHTML + 'SOMME(';
                    document.getElementById('formulesql').innerHTML = document.getElementById('formulesql').innerHTML + 'SUM(';
                    break;
                case "ABS":
                    document.getElementById('formulevisible').innerHTML = document.getElementById('formulevisible').innerHTML + 'ABS(';
                    document.getElementById('formulesql').innerHTML = document.getElementById('formulesql').innerHTML + 'ABS(';
                    break;
                default:
                    document.getElementById('formulevisible').innerHTML = document.getElementById('formulevisible').innerHTML + '-';
                    document.getElementById('formulesql').innerHTML = document.getElementById('formulesql').innerHTML + 'ABS(';
                    break;
            }
        }

        function select_colonne(col)
        {
            document.getElementById('formulevisible').innerHTML = document.getElementById('formulevisible').innerHTML + col;
            document.getElementById('formulesql').innerHTML = document.getElementById('formulesql').innerHTML + col;
        }
    </script>

</head>
<body>
<div id="DivIndic_1"></div>
<div id="DivOp">
<input id="Op_+" type="button" value="+" onclick="set_operateur('+');" /><br>
<input id="Op_-" type="button" value="-" onclick="set_operateur('-');" /><br>
<input id="Op_-" type="button" value="*" onclick="set_operateur('*');" /><br>
<input id="Op_-" type="button" value="/" onclick="set_operateur('/');" /><br>
<input id="Op_-" type="button" value="%" onclick="set_operateur('%');" /><br>
<input id="Op_-" type="button" value="(" onclick="set_operateur('(');" /><br>
<input id="Op_-" type="button" value=") " onclick="set_operateur(')');" /><br>
<input id="Op_-" type="button" value="NbVal" onclick="set_operateur('NBVAL');" /><br>
<input id="Op_-" type="button" value="Somme" onclick="set_operateur('SOMME');" /><br>
<input id="Op_-" type="button" value="Absolu" onclick="set_operateur('ABS');" /><br>
</div>


<div id="DivCol">
    <input id="col_1" type="button" value="col 1" onclick="select_colonne('col_1');" /><br>
    <input id="col_2" type="button" value="col 4" onclick="select_colonne('col_1');" /><br>
    <input id="col_3" type="button" value="col 3" onclick="select_colonne('col_1');" /><br>
</div>



<div id="formula">
<input type="hidden" id="formulesql" value =""/>

<label id="formulevisible"> blabla </label>
</div>

</body>
</html>

CREATE TEMPORARY TABLE TMP_data AS(Select * FROM data WHERE id_Structure IN(1,2,3));

ALTER TABLE TMP_data
ADD Nom_Type_Colonne varchar(25);

CREATE TEMPORARY TABLE TMP_struct AS(SELECT TMP_data.id_Structure,id_Colonne FROM structure INNER JOIN TMP_data ON TMP_data.id_Structure = structure.id_Structure);

CREATE TEMPORARY TABLE TMP_colonne AS(SELECT TMP_struct.id_Colonne,id_Type_Colonne FROM colonne INNER JOIN TMP_struct ON TMP_struct.id_Colonne = colonne.id_Colonne);

CREATE TEMPORARY TABLE TMP_Type_Colonne AS(SELECT type_colonne.* FROM type_colonne INNER JOIN TMP_colonne ON TMP_colonne.id_Type_Colonne = type_colonne.id_Type_Colonne);

UPDATE TMP_data
SET Nom_Type_Colonne =(SELECT DISTINCT nom FROM TMP_Type_Colonne,TMP_Colonne,TMP_struct WHERE TMP_Type_Colonne.id_Type_Colonne = TMP_Colonne.id_Colonne AND TMP_Colonne.id_Colonne = TMP_struct.id_Colonne AND id_structure = 1)
WHERE id_Structure = 1;

UPDATE TMP_data
SET Nom_Type_Colonne = (SELECT DISTINCT nom FROM TMP_Type_Colonne,TMP_Colonne,TMP_struct WHERE TMP_Type_Colonne.id_Type_Colonne = TMP_Colonne.id_Colonne AND TMP_Colonne.id_Colonne = TMP_struct.id_Colonne AND id_structure = 2)
WHERE id_Structure = 2;

UPDATE TMP_data
SET Nom_Type_Colonne = (SELECT DISTINCT nom FROM TMP_Type_Colonne,TMP_Colonne,TMP_struct WHERE TMP_Type_Colonne.id_Type_Colonne = TMP_Colonne.id_Colonne AND TMP_Colonne.id_Colonne = TMP_struct.id_Colonne AND id_structure = 3)
WHERE id_Structure = 3;

CREATE TEMPORARY TABLE TMP_data_CCS AS (SELECT id_data as id_data_CCS,num_ligne_excel as num_ligne_excel_CCS,data as data_CCS FROM TMP_data WHERE Nom_Type_Colonne = "identifiant");
CREATE TEMPORARY TABLE TMP_data_Anomalie AS (SELECT id_data as id_data_Anomalie,num_ligne_excel as num_ligne_excel_Anomalie ,data as data_Anomalie FROM TMP_data WHERE Nom_Type_Colonne = "Champ KO");
CREATE TEMPORARY TABLE TMP_data_Montant AS (SELECT id_data as id_data_Montant,num_ligne_excel as num_ligne_excel_Montant,data as data_Montant FROM TMP_data WHERE Nom_Type_Colonne = "Montant");

CREATE TEMPORARY TABLE TMP_Sorted AS (SELECT * FROM TMP_data_CCS INNER JOIN TMP_data_Anomalie ON TMP_data_CCS.num_ligne_excel_CCS=TMP_data_Anomalie.num_ligne_excel_Anomalie INNER JOIN TMP_data_Montant ON TMP_data_Anomalie.num_ligne_excel_Anomalie=TMP_data_Montant.num_ligne_excel_Montant);

SELECT data_CCS,SUM(data_Montant),SUM(data_Anomalie) FROM TMP_Sorted GROUP BY data_CCS;






