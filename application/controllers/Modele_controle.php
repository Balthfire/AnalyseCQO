<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modele_controle extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Modele_controle_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'modele_controle/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'modele_controle/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'modele_controle/index.html';
            $config['first_url'] = base_url() . 'modele_controle/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Modele_controle_model->total_rows($q);
        $modele_controle = $this->Modele_controle_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'modele_controle_data' => $modele_controle,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('modele_controle_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Modele_controle_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Modele_Controle' => $row->id_Modele_Controle,
		'designation' => $row->designation,
		'description' => $row->description,
		'Coefficient_Importance' => $row->Coefficient_Importance,
	    );
            $this->load->view('modele_controle_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('modele_controle'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('modele_controle/create_action'),
	    'id_Modele_Controle' => set_value('id_Modele_Controle'),
	    'designation' => set_value('designation'),
	    'description' => set_value('description'),
	    'Coefficient_Importance' => set_value('Coefficient_Importance'),
	);
        $this->load->view('modele_controle_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'designation' => $this->input->post('designation',TRUE),
		'description' => $this->input->post('description',TRUE),
		'Coefficient_Importance' => $this->input->post('Coefficient_Importance',TRUE),
	    );

            $this->Modele_controle_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('modele_controle'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Modele_controle_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('modele_controle/update_action'),
		'id_Modele_Controle' => set_value('id_Modele_Controle', $row->id_Modele_Controle),
		'designation' => set_value('designation', $row->designation),
		'description' => set_value('description', $row->description),
		'Coefficient_Importance' => set_value('Coefficient_Importance', $row->Coefficient_Importance),
	    );
            $this->load->view('modele_controle_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('modele_controle'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Modele_Controle', TRUE));
        } else {
            $data = array(
		'designation' => $this->input->post('designation',TRUE),
		'description' => $this->input->post('description',TRUE),
		'Coefficient_Importance' => $this->input->post('Coefficient_Importance',TRUE),
	    );

            $this->Modele_controle_model->update($this->input->post('id_Modele_Controle', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('modele_controle'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Modele_controle_model->get_by_id($id);

        if ($row) {
            $this->Modele_controle_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('modele_controle'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('modele_controle'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('designation', 'designation', 'trim|required');
	$this->form_validation->set_rules('description', 'description', 'trim|required');
	$this->form_validation->set_rules('Coefficient_Importance', 'coefficient importance', 'trim|required|numeric');

	$this->form_validation->set_rules('id_Modele_Controle', 'id_Modele_Controle', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Modele_controle.php */
/* Location: ./application/controllers/Modele_controle.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-05-06 08:00:38 */
/* http://harviacode.com */