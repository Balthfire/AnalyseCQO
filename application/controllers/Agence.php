<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agence extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Agence_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'agence/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'agence/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'agence/index.html';
            $config['first_url'] = base_url() . 'agence/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Agence_model->total_rows($q);
        $agence = $this->Agence_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'agence_data' => $agence,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('agence_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Agence_model->get_by_id($id);
        if ($row) {
            $data = array(
		'CCS' => $row->CCS,
		'nom' => $row->nom,
		'DUM' => $row->DUM,
		'SDUM' => $row->SDUM,
		'portefeuille' => $row->portefeuille,
	    );
            $this->load->view('agence_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('agence'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('agence/create_action'),
	    'CCS' => set_value('CCS'),
	    'nom' => set_value('nom'),
	    'DUM' => set_value('DUM'),
	    'SDUM' => set_value('SDUM'),
	    'portefeuille' => set_value('portefeuille'),
	);
        $this->load->view('agence_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'DUM' => $this->input->post('DUM',TRUE),
		'SDUM' => $this->input->post('SDUM',TRUE),
		'portefeuille' => $this->input->post('portefeuille',TRUE),
	    );

            $this->Agence_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('agence'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Agence_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('agence/update_action'),
		'CCS' => set_value('CCS', $row->CCS),
		'nom' => set_value('nom', $row->nom),
		'DUM' => set_value('DUM', $row->DUM),
		'SDUM' => set_value('SDUM', $row->SDUM),
		'portefeuille' => set_value('portefeuille', $row->portefeuille),
	    );
            $this->load->view('agence_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('agence'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('CCS', TRUE));
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'DUM' => $this->input->post('DUM',TRUE),
		'SDUM' => $this->input->post('SDUM',TRUE),
		'portefeuille' => $this->input->post('portefeuille',TRUE),
	    );

            $this->Agence_model->update($this->input->post('CCS', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('agence'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Agence_model->get_by_id($id);

        if ($row) {
            $this->Agence_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('agence'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('agence'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nom', 'nom', 'trim|required');
	$this->form_validation->set_rules('DUM', 'dum', 'trim|required');
	$this->form_validation->set_rules('SDUM', 'sdum', 'trim|required');
	$this->form_validation->set_rules('portefeuille', 'portefeuille', 'trim|required');

	$this->form_validation->set_rules('CCS', 'CCS', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Agence.php */
/* Location: ./application/controllers/Agence.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-12-16 08:18:19 */
/* http://harviacode.com */