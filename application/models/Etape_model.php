<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Etape_model extends CI_Model
{

    public $table = 'etape';
    public $id = 'id_Etape';
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
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_Etape', $q);
	$this->db->or_like('Parameter', $q);
	$this->db->or_like('ordre', $q);
	$this->db->or_like('id_Operateur', $q);
	$this->db->or_like('id_Structure', $q);
	$this->db->or_like('id_Type_Indicateur', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_Etape', $q);
	$this->db->or_like('Parameter', $q);
	$this->db->or_like('ordre', $q);
	$this->db->or_like('id_Operateur', $q);
	$this->db->or_like('id_Structure', $q);
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

/* End of file Etape_model.php */
/* Location: ./application/models/Etape_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-05-22 09:28:26 */
/* http://harviacode.com */