<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Indicateur_model extends CI_Model
{

    public $table = 'indicateur';
    public $id = 'id_Indicateur';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function get_last_id()
    {
        return $this->db->insert_id();
    }

    function execute_super_query($superquery)
    {
        $query = $this->db->query($superquery);
        $resultarray = $query->result_array();
        return $resultarray;
    }

    function testTransactions()
    {
        $this->db->trans_begin();
        $this->db->query("CREATE TEMPORARY TABLE TMP_data AS(Select * FROM data WHERE id_Structure IN(153,156,154,155))");
        $this->db->query("ALTER TABLE TMP_data ADD Nom_Type_Colonne varchar(25)");
        $this->db->query("CREATE TEMPORARY TABLE TMP_struct AS(SELECT TMP_data.id_Structure,id_Colonne FROM structure INNER JOIN TMP_data ON TMP_data.id_Structure = structure.id_Structure)");
        $this->db->query("CREATE TEMPORARY TABLE TMP_colonne AS(SELECT TMP_struct.id_Colonne,id_Type_Colonne FROM colonne INNER JOIN TMP_struct ON TMP_struct.id_Colonne = colonne.id_Colonne)");
        $this->db->query("CREATE TEMPORARY TABLE TMP_Type_Colonne AS(SELECT type_colonne.* FROM type_colonne INNER JOIN TMP_colonne ON TMP_colonne.id_Type_Colonne = type_colonne.id_Type_Colonne)");
        $this->db->query("UPDATE TMP_data SET Nom_Type_Colonne =(SELECT DISTINCT nom FROM TMP_Type_Colonne,TMP_Colonne,TMP_struct WHERE TMP_Type_Colonne.id_Type_Colonne = TMP_Colonne.id_Type_Colonne AND TMP_Colonne.id_Colonne = TMP_struct.id_Colonne AND id_structure = 153) WHERE id_Structure = 153");
        $this->db->query("UPDATE TMP_data SET Nom_Type_Colonne =(SELECT DISTINCT nom FROM TMP_Type_Colonne,TMP_Colonne,TMP_struct WHERE TMP_Type_Colonne.id_Type_Colonne = TMP_Colonne.id_Type_Colonne AND TMP_Colonne.id_Colonne = TMP_struct.id_Colonne AND id_structure = 154) WHERE id_Structure = 154");
        $this->db->query("UPDATE TMP_data SET Nom_Type_Colonne =(SELECT DISTINCT nom FROM TMP_Type_Colonne,TMP_Colonne,TMP_struct WHERE TMP_Type_Colonne.id_Type_Colonne = TMP_Colonne.id_Type_Colonne AND TMP_Colonne.id_Colonne = TMP_struct.id_Colonne AND id_structure = 155) WHERE id_Structure = 155");
        $this->db->query("UPDATE TMP_data SET Nom_Type_Colonne =(SELECT DISTINCT nom FROM TMP_Type_Colonne,TMP_Colonne,TMP_struct WHERE TMP_Type_Colonne.id_Type_Colonne = TMP_Colonne.id_Type_Colonne AND TMP_Colonne.id_Colonne = TMP_struct.id_Colonne AND id_structure = 156) WHERE id_Structure = 156");
        $this->db->query("CREATE TEMPORARY TABLE TMP_data_Identifiant AS (SELECT id_data as id_data_Identifiant,num_ligne_excel as num_ligne_excel_Identifiant,data as data_Identifiant FROM TMP_data WHERE Nom_Type_Colonne = 'Identifiant')");
        $this->db->query("CREATE TEMPORARY TABLE TMP_data_Anomalie AS (SELECT id_data as id_data_Anomalie,num_ligne_excel as num_ligne_excel_Anomalie,data as data_Anomalie FROM TMP_data WHERE Nom_Type_Colonne = 'Anomalie')");
        $this->db->query("CREATE TEMPORARY TABLE TMP_data_Montant AS (SELECT id_data as id_data_Montant,num_ligne_excel as num_ligne_excel_Montant,data as data_Montant FROM TMP_data WHERE Nom_Type_Colonne = 'Montant')");
        $this->db->query("CREATE TEMPORARY TABLE TMP_data_DMR AS (SELECT id_data as id_data_DMR,num_ligne_excel as num_ligne_excel_DMR,data as data_DMR FROM TMP_data WHERE Nom_Type_Colonne = 'DMR')");
        $this->db->query("CREATE TEMPORARY TABLE TMP_Sorted AS(SELECT * FROM TMP_data_Identifiant INNER JOIN TMP_data_Anomalie ON TMP_data_Identifiant.num_ligne_excel_Identifiant=TMP_data_Anomalie.num_ligne_excel_Anomalie INNER JOIN TMP_data_Montant ON TMP_data_Anomalie.num_ligne_excel_Anomalie=TMP_data_Montant.num_ligne_excel_Montant INNER JOIN TMP_data_DMR ON TMP_data_Montant.num_ligne_excel_montant=TMP_data_DMR.num_ligne_excel_DMR )");
        $this->db->query("CREATE TEMPORARY TABLE TMP_Sorted2 as (SELECT * FROM TMP_Sorted)");
        $this->db->query("CREATE TEMPORARY TABLE TMP_Sorted3 as (SELECT * FROM TMP_Sorted)");
        $selectquery = "SELECT nom,COUNT(DISTINCT(data_DMR)) as NbDMR,(SUM(ABS(data_Anomalie))) as Anomalie,ROUND((SUM(ABS(data_Montant))),2) as Montant,ROUND((SUM(ABS(data_Anomalie))/SUM(ABS(data_Montant)))*100,2) as 'A/M',ROUND(((SUM(ABS(data_Anomalie)))/(SELECT(SUM(ABS(data_Montant))) FROM TMP_Sorted2))*100 ,2) as 'A/MT',ROUND(((SUM(ABS(data_Montant)))/(SELECT(SUM(ABS(data_Montant))) FROM TMP_Sorted3))*100 ,2) as 'M/MT' FROM TMP_Sorted,agence WHERE TMP_Sorted.data_Identifiant=agence.CCS GROUP BY nom";
        $resultquery=$this->db->query($selectquery);
        $this->db->trans_complete();
        $resultarray = $resultquery->result_array();
        return($resultarray);
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_Indicateur', $q);
	$this->db->or_like('nom', $q);
	$this->db->or_like('id_Controle', $q);
	$this->db->or_like('id_Type_Indicateur', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_Indicateur', $q);
	$this->db->or_like('nom', $q);
	$this->db->or_like('id_Controle', $q);
	$this->db->or_like('id_Type_Indicateur', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Indicateur_model.php */
/* Location: ./application/models/Indicateur_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-03-14 15:22:21 */
/* http://harviacode.com */