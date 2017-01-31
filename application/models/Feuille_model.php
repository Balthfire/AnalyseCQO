<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feuille_model extends CI_Model
{

    public $table = 'feuille';
    public $id = 'id_Feuille';
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

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function get_last_id()
    {
        return $this->db->insert_id();
    }

    function getAllidFeuilleByName($name)
    {
        $query = $this->db->query('SELECT id_Feuille FROM feuille WHERE nom ='.$name);
        $resultarray = $query->result_array();

        return $resultarray;
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_Feuille', $q);
	$this->db->or_like('nom', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_Feuille', $q);
	$this->db->or_like('nom', $q);
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

/* End of file Feuille_model.php */
/* Location: ./application/models/Feuille_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-28 15:16:08 */
/* http://harviacode.com */