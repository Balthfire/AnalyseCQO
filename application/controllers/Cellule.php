<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cellule extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Cellule_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'cellule/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'cellule/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'cellule/index.html';
            $config['first_url'] = base_url() . 'cellule/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Cellule_model->total_rows($q);
        $cellule = $this->Cellule_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'cellule_data' => $cellule,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('cellule_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Cellule_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Cellule' => $row->id_Cellule,
		'pos_x' => $row->pos_x,
		'pos_y' => $row->pos_y,
		'valeur' => $row->valeur,
		'id_Feuille' => $row->id_Feuille,
	    );
            $this->load->view('cellule_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cellule'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('cellule/create_action'),
	    'id_Cellule' => set_value('id_Cellule'),
	    'pos_x' => set_value('pos_x'),
	    'pos_y' => set_value('pos_y'),
	    'valeur' => set_value('valeur'),
	    'id_Feuille' => set_value('id_Feuille'),
	);
        $this->load->view('cellule_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'pos_x' => $this->input->post('pos_x',TRUE),
		'pos_y' => $this->input->post('pos_y',TRUE),
		'valeur' => $this->input->post('valeur',TRUE),
		'id_Feuille' => $this->input->post('id_Feuille',TRUE),
	    );

            $this->Cellule_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('cellule'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Cellule_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('cellule/update_action'),
		'id_Cellule' => set_value('id_Cellule', $row->id_Cellule),
		'pos_x' => set_value('pos_x', $row->pos_x),
		'pos_y' => set_value('pos_y', $row->pos_y),
		'valeur' => set_value('valeur', $row->valeur),
		'id_Feuille' => set_value('id_Feuille', $row->id_Feuille),
	    );
            $this->load->view('cellule_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cellule'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Cellule', TRUE));
        } else {
            $data = array(
		'pos_x' => $this->input->post('pos_x',TRUE),
		'pos_y' => $this->input->post('pos_y',TRUE),
		'valeur' => $this->input->post('valeur',TRUE),
		'id_Feuille' => $this->input->post('id_Feuille',TRUE),
	    );

            $this->Cellule_model->update($this->input->post('id_Cellule', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('cellule'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Cellule_model->get_by_id($id);

        if ($row) {
            $this->Cellule_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('cellule'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cellule'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('pos_x', 'pos x', 'trim|required');
	$this->form_validation->set_rules('pos_y', 'pos y', 'trim|required');
	$this->form_validation->set_rules('valeur', 'valeur', 'trim|required');
	$this->form_validation->set_rules('id_Feuille', 'id feuille', 'trim|required');

	$this->form_validation->set_rules('id_Cellule', 'id_Cellule', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Cellule.php */
/* Location: ./application/controllers/Cellule.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-09-08 07:54:42 */
/* http://harviacode.com */