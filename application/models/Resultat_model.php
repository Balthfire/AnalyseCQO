<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Resultat_model extends CI_Model
{

    public $table = 'resultat';
    public $id = 'id_Resultat';
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
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_Resultat', $q);
	$this->db->or_like('valeur', $q);
	$this->db->or_like('id_Indicateur', $q);
	$this->db->or_like('CCS', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_Resultat', $q);
	$this->db->or_like('valeur', $q);
	$this->db->or_like('id_Indicateur', $q);
	$this->db->or_like('CCS', $q);
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

/* End of file Resultat_model.php */
/* Location: ./application/models/Resultat_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-05-22 09:27:59 */
/* http://harviacode.com */