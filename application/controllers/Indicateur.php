<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Indicateur extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Indicateur_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'indicateur/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'indicateur/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'indicateur/index.html';
            $config['first_url'] = base_url() . 'indicateur/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Indicateur_model->total_rows($q);
        $indicateur = $this->Indicateur_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'indicateur_data' => $indicateur,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('indicateur_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Indicateur_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Indicateur' => $row->id_Indicateur,
		'designation' => $row->designation,
		'description' => $row->description,
		'id_Type_Indicateur' => $row->id_Type_Indicateur,
		'id_Controle' => $row->id_Controle,
		'id_Modele_Indicateur' => $row->id_Modele_Indicateur,
	    );
            $this->load->view('indicateur_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('indicateur'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('indicateur/create_action'),
	    'id_Indicateur' => set_value('id_Indicateur'),
	    'designation' => set_value('designation'),
	    'description' => set_value('description'),
	    'id_Type_Indicateur' => set_value('id_Type_Indicateur'),
	    'id_Controle' => set_value('id_Controle'),
	    'id_Modele_Indicateur' => set_value('id_Modele_Indicateur'),
	);
        $this->load->view('indicateur_form', $data);
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
		'id_Type_Indicateur' => $this->input->post('id_Type_Indicateur',TRUE),
		'id_Controle' => $this->input->post('id_Controle',TRUE),
		'id_Modele_Indicateur' => $this->input->post('id_Modele_Indicateur',TRUE),
	    );

            $this->Indicateur_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('indicateur'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Indicateur_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('indicateur/update_action'),
		'id_Indicateur' => set_value('id_Indicateur', $row->id_Indicateur),
		'designation' => set_value('designation', $row->designation),
		'description' => set_value('description', $row->description),
		'id_Type_Indicateur' => set_value('id_Type_Indicateur', $row->id_Type_Indicateur),
		'id_Controle' => set_value('id_Controle', $row->id_Controle),
		'id_Modele_Indicateur' => set_value('id_Modele_Indicateur', $row->id_Modele_Indicateur),
	    );
            $this->load->view('indicateur_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('indicateur'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Indicateur', TRUE));
        } else {
            $data = array(
		'designation' => $this->input->post('designation',TRUE),
		'description' => $this->input->post('description',TRUE),
		'id_Type_Indicateur' => $this->input->post('id_Type_Indicateur',TRUE),
		'id_Controle' => $this->input->post('id_Controle',TRUE),
		'id_Modele_Indicateur' => $this->input->post('id_Modele_Indicateur',TRUE),
	    );

            $this->Indicateur_model->update($this->input->post('id_Indicateur', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('indicateur'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Indicateur_model->get_by_id($id);

        if ($row) {
            $this->Indicateur_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('indicateur'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('indicateur'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('designation', 'designation', 'trim|required');
	$this->form_validation->set_rules('description', 'description', 'trim|required');
	$this->form_validation->set_rules('id_Type_Indicateur', 'id type indicateur', 'trim|required');
	$this->form_validation->set_rules('id_Controle', 'id controle', 'trim|required');
	$this->form_validation->set_rules('id_Modele_Indicateur', 'id modele indicateur', 'trim|required');

	$this->form_validation->set_rules('id_Indicateur', 'id_Indicateur', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Indicateur.php */
/* Location: ./application/controllers/Indicateur.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-05-06 08:00:38 */
/* http://harviacode.com */