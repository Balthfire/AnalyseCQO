<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Data_model extends CI_Model
{

    public $table = 'data';
    public $id = 'id_Data';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function get_by_structure_id($struct_id)
    {
        $query = $this->db->query('SELECT * FROM data WHERE id_Structure ='.$struct_id);
        return $query->result_array();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function get_lignes($numligne,$idFeuille,$idFichier)
    {
        $query = $this->db->query('SELECT * FROM data WHERE num_ligne_excel='.$numligne.' AND id_Structure IN(SELECT id_Structure FROM structure WHERE id_Feuille ='.$idFeuille.' AND id_Fichier ='.$idFichier.')');
        $resultarray = $query->result_array();

        return $resultarray;
    }

    /*function testSQL()
    {
        $query = $this->db->query('CREATE TEMPORARY TABLE TMP_data AS(Select * FROM data WHERE id_Structure IN(1,2,3));

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
 SELECT *');
        $resultarray = $query->result_array();

    }*/

    function get_specific_data($numligne,$idFeuille,$idFichier,$idColonne)
    {
        $query = $this->db->query('SELECT * FROM data WHERE num_ligne_excel='.$numligne.' AND id_Structure IN(SELECT id_Structure FROM structure WHERE id_Feuille ='.$idFeuille.' AND id_Fichier ='.$idFichier.' AND id_Colonne ='.$idColonne.')');
        $resultarray = $query->result_array();
        return $resultarray;
    }


    function get_colonne($idFichier,$idFeuille,$idColonne)
    {
        $query = $this->db->query('SELECT * FROM data WHERE id_Structure IN(SELECT id_Structure FROM structure WHERE id_Feuille ='.$idFeuille.' AND id_Fichier ='.$idFichier.' AND id_Colonne ='.$idColonne.')');
        $resultarray = $query->result_array();
        return $resultarray;
    }

    function count_nb_ligne($idstruct)
    {
        $query = $this->db->query('SELECT COUNT(*) as nbligne FROM data WHERE id_Structure='.$idstruct);
        return $query->row();
    }

    function count_nb_colonne($idFichier,$idFeuille)
    {
        $req = "SELECT COUNT(*) as nbcol FROM structure WHERE id_Feuille= $idFeuille AND id_Fichier = $idFichier";
        $query = $this->db->query($req);
        return $query->row();
    }

    function count_nb_colonne2($idFeuille,$idFichier)
    {
        return $this->db->select('id_Structure')
            ->from('structure')
            ->where('id_Feuille',$idFeuille)
            ->where('id_Fichier',$idFichier)
            ->count_all_results();
    }


    function get_last_id()
    {
        return $this->db->insert_id();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_Data', $q);
        $this->db->or_like('data', $q);
        $this->db->or_like('num_ligne_excel', $q);
        $this->db->or_like('id_Structure', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_Data', $q);
	$this->db->or_like('data', $q);
	$this->db->or_like('num_ligne_excel', $q);
	$this->db->or_like('id_Structure', $q);
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

/* End of file Data_model.php */
/* Location: ./application/models/Data_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-28 15:16:08 */
/* http://harviacode.com */