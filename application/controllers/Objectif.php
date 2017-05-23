<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Objectif extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Objectif_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'objectif/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'objectif/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'objectif/index.html';
            $config['first_url'] = base_url() . 'objectif/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Objectif_model->total_rows($q);
        $objectif = $this->Objectif_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'objectif_data' => $objectif,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('objectif_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Objectif_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Objectif' => $row->id_Objectif,
		'seuil_OK' => $row->seuil_OK,
		'seuil_OKKO' => $row->seuil_OKKO,
		'seuil_KO' => $row->seuil_KO,
	    );
            $this->load->view('objectif_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('objectif'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('objectif/create_action'),
	    'id_Objectif' => set_value('id_Objectif'),
	    'seuil_OK' => set_value('seuil_OK'),
	    'seuil_OKKO' => set_value('seuil_OKKO'),
	    'seuil_KO' => set_value('seuil_KO'),
	);
        $this->load->view('objectif_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'seuil_OK' => $this->input->post('seuil_OK',TRUE),
		'seuil_OKKO' => $this->input->post('seuil_OKKO',TRUE),
		'seuil_KO' => $this->input->post('seuil_KO',TRUE),
	    );

            $this->Objectif_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('objectif'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Objectif_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('objectif/update_action'),
		'id_Objectif' => set_value('id_Objectif', $row->id_Objectif),
		'seuil_OK' => set_value('seuil_OK', $row->seuil_OK),
		'seuil_OKKO' => set_value('seuil_OKKO', $row->seuil_OKKO),
		'seuil_KO' => set_value('seuil_KO', $row->seuil_KO),
	    );
            $this->load->view('objectif_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('objectif'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Objectif', TRUE));
        } else {
            $data = array(
		'seuil_OK' => $this->input->post('seuil_OK',TRUE),
		'seuil_OKKO' => $this->input->post('seuil_OKKO',TRUE),
		'seuil_KO' => $this->input->post('seuil_KO',TRUE),
	    );

            $this->Objectif_model->update($this->input->post('id_Objectif', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('objectif'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Objectif_model->get_by_id($id);

        if ($row) {
            $this->Objectif_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('objectif'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('objectif'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('seuil_OK', 'seuil ok', 'trim|required');
	$this->form_validation->set_rules('seuil_OKKO', 'seuil okko', 'trim|required');
	$this->form_validation->set_rules('seuil_KO', 'seuil ko', 'trim|required');

	$this->form_validation->set_rules('id_Objectif', 'id_Objectif', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Objectif.php */
/* Location: ./application/controllers/Objectif.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-05-22 09:27:46 */
/* http://harviacode.com */