CREATE TEMPORARY TABLE TMP_data AS(Select * FROM data WHERE id_Structure IN(153,156,154,155));
 ALTER TABLE TMP_data ADD Nom_Type_Colonne varchar(25);
 CREATE TEMPORARY TABLE TMP_struct AS(SELECT TMP_data.id_Structure,id_Colonne FROM structure INNER JOIN TMP_data ON TMP_data.id_Structure = structure.id_Structure);
 CREATE TEMPORARY TABLE TMP_colonne AS(SELECT TMP_struct.id_Colonne,id_Type_Colonne FROM colonne INNER JOIN TMP_struct ON TMP_struct.id_Colonne = colonne.id_Colonne);
 CREATE TEMPORARY TABLE TMP_Type_Colonne AS(SELECT type_colonne.* FROM type_colonne INNER JOIN TMP_colonne ON TMP_colonne.id_Type_Colonne = type_colonne.id_Type_Colonne);
 UPDATE TMP_data SET Nom_Type_Colonne =(SELECT DISTINCT nom FROM TMP_Type_Colonne,TMP_Colonne,TMP_struct WHERE TMP_Type_Colonne.id_Type_Colonne = TMP_Colonne.id_Type_Colonne AND TMP_Colonne.id_Colonne = TMP_struct.id_Colonne AND id_structure = 153) WHERE id_Structure = 153;
UPDATE TMP_data SET Nom_Type_Colonne =(SELECT DISTINCT nom FROM TMP_Type_Colonne,TMP_Colonne,TMP_struct WHERE TMP_Type_Colonne.id_Type_Colonne = TMP_Colonne.id_Type_Colonne AND TMP_Colonne.id_Colonne = TMP_struct.id_Colonne AND id_structure = 154) WHERE id_Structure = 154;
UPDATE TMP_data SET Nom_Type_Colonne =(SELECT DISTINCT nom FROM TMP_Type_Colonne,TMP_Colonne,TMP_struct WHERE TMP_Type_Colonne.id_Type_Colonne = TMP_Colonne.id_Type_Colonne AND TMP_Colonne.id_Colonne = TMP_struct.id_Colonne AND id_structure = 155) WHERE id_Structure = 155;
UPDATE TMP_data SET Nom_Type_Colonne =(SELECT DISTINCT nom FROM TMP_Type_Colonne,TMP_Colonne,TMP_struct WHERE TMP_Type_Colonne.id_Type_Colonne = TMP_Colonne.id_Type_Colonne AND TMP_Colonne.id_Colonne = TMP_struct.id_Colonne AND id_structure = 156) WHERE id_Structure = 156;
CREATE TEMPORARY TABLE TMP_data_Identifiant AS (SELECT id_data as id_data_Identifiant,num_ligne_excel as num_ligne_excel_Identifiant,data as data_Identifiant FROM TMP_data WHERE Nom_Type_Colonne = 'Identifiant');
CREATE TEMPORARY TABLE TMP_data_Anomalie AS (SELECT id_data as id_data_Anomalie,num_ligne_excel as num_ligne_excel_Anomalie,data as data_Anomalie FROM TMP_data WHERE Nom_Type_Colonne = 'Anomalie');
CREATE TEMPORARY TABLE TMP_data_Montant AS (SELECT id_data as id_data_Montant,num_ligne_excel as num_ligne_excel_Montant,data as data_Montant FROM TMP_data WHERE Nom_Type_Colonne = 'Montant');
CREATE TEMPORARY TABLE TMP_data_DMR AS (SELECT id_data as id_data_DMR,num_ligne_excel as num_ligne_excel_DMR,data as data_DMR FROM TMP_data WHERE Nom_Type_Colonne = 'DMR');
CREATE TEMPORARY TABLE TMP_Sorted AS(SELECT * FROM TMP_data_Identifiant INNER JOIN TMP_data_Anomalie ON TMP_data_Identifiant.num_ligne_excel_Identifiant=TMP_data_Anomalie.num_ligne_excel_Anomalie INNER JOIN TMP_data_Montant ON TMP_data_Anomalie.num_ligne_excel_Anomalie=TMP_data_Montant.num_ligne_excel_Montant INNER JOIN TMP_data_DMR ON TMP_data_Montant.num_ligne_excel_montant=TMP_data_DMR.num_ligne_excel_DMR );
SELECT nom,data_DMR,SUM(ABS(data_Anomalie)),SUM(ABS(data_Montant)),(SUM(ABS(data_Anomalie))/SUM(ABS(data_Montant)))*100 as PrctAgence FROM TMP_Sorted,Agence WHERE TMP_Sorted.data_Identifiant=agence.CCS GROUP BY nom,data_DMR;

CREATE TEMPORARY TABLE TMP_Sorted2 as (SELECT * FROM TMP_Sorted);
CREATE TEMPORARY TABLE TMP_Sorted3 as (SELECT * FROM TMP_Sorted);

SELECT nom,COUNT(DISTINCT(data_DMR)) as NbDMR,(SUM(ABS(data_Anomalie))) as Anomalie,ROUND((SUM(ABS(data_Montant))),2) as Montant,ROUND((SUM(ABS(data_Anomalie))/SUM(ABS(data_Montant)))*100,2) as 'A/M',ROUND(((SUM(ABS(data_Anomalie)))/(SELECT(SUM(ABS(data_Montant))) FROM TMP_Sorted2))*100 ,2) as 'A/MT',ROUND(((SUM(ABS(data_Montant)))/(SELECT(SUM(ABS(data_Montant))) FROM TMP_Sorted3))*100 ,2) as 'M/MT' FROM TMP_Sorted,agence WHERE TMP_Sorted.data_Identifiant=agence.CCS GROUP BY nom;


SUM - ABS - COUNT - DISTINCT - 2x Requete Imbriquée - 3x Même table temporaire 
