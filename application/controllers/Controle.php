<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Controle extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Controle_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'controle/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'controle/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'controle/index.html';
            $config['first_url'] = base_url() . 'controle/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Controle_model->total_rows($q);
        $controle = $this->Controle_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'controle_data' => $controle,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('controle_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Controle_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Controle' => $row->id_Controle,
		'designation' => $row->designation,
		'description' => $row->description,
		'num_vague' => $row->num_vague,
		'date_debut' => $row->date_debut,
		'date_fin' => $row->date_fin,
		'note' => $row->note,
		'Niveau_Qualite' => $row->Niveau_Qualite,
		'id_Type_Controle' => $row->id_Type_Controle,
		'NNI' => $row->NNI,
		'id_Modele_Controle' => $row->id_Modele_Controle,
	    );
            $this->load->view('controle_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('controle'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('controle/create_action'),
	    'id_Controle' => set_value('id_Controle'),
	    'designation' => set_value('designation'),
	    'description' => set_value('description'),
	    'num_vague' => set_value('num_vague'),
	    'date_debut' => set_value('date_debut'),
	    'date_fin' => set_value('date_fin'),
	    'note' => set_value('note'),
	    'Niveau_Qualite' => set_value('Niveau_Qualite'),
	    'id_Type_Controle' => set_value('id_Type_Controle'),
	    'NNI' => set_value('NNI'),
	    'id_Modele_Controle' => set_value('id_Modele_Controle'),
	);
        $this->load->view('controle_form', $data);
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
		'num_vague' => $this->input->post('num_vague',TRUE),
		'date_debut' => $this->input->post('date_debut',TRUE),
		'date_fin' => $this->input->post('date_fin',TRUE),
		'note' => $this->input->post('note',TRUE),
		'Niveau_Qualite' => $this->input->post('Niveau_Qualite',TRUE),
		'id_Type_Controle' => $this->input->post('id_Type_Controle',TRUE),
		'NNI' => $this->input->post('NNI',TRUE),
		'id_Modele_Controle' => $this->input->post('id_Modele_Controle',TRUE),
	    );

            $this->Controle_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('controle'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Controle_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('controle/update_action'),
		'id_Controle' => set_value('id_Controle', $row->id_Controle),
		'designation' => set_value('designation', $row->designation),
		'description' => set_value('description', $row->description),
		'num_vague' => set_value('num_vague', $row->num_vague),
		'date_debut' => set_value('date_debut', $row->date_debut),
		'date_fin' => set_value('date_fin', $row->date_fin),
		'note' => set_value('note', $row->note),
		'Niveau_Qualite' => set_value('Niveau_Qualite', $row->Niveau_Qualite),
		'id_Type_Controle' => set_value('id_Type_Controle', $row->id_Type_Controle),
		'NNI' => set_value('NNI', $row->NNI),
		'id_Modele_Controle' => set_value('id_Modele_Controle', $row->id_Modele_Controle),
	    );
            $this->load->view('controle_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('controle'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Controle', TRUE));
        } else {
            $data = array(
		'designation' => $this->input->post('designation',TRUE),
		'description' => $this->input->post('description',TRUE),
		'num_vague' => $this->input->post('num_vague',TRUE),
		'date_debut' => $this->input->post('date_debut',TRUE),
		'date_fin' => $this->input->post('date_fin',TRUE),
		'note' => $this->input->post('note',TRUE),
		'Niveau_Qualite' => $this->input->post('Niveau_Qualite',TRUE),
		'id_Type_Controle' => $this->input->post('id_Type_Controle',TRUE),
		'NNI' => $this->input->post('NNI',TRUE),
		'id_Modele_Controle' => $this->input->post('id_Modele_Controle',TRUE),
	    );

            $this->Controle_model->update($this->input->post('id_Controle', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('controle'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Controle_model->get_by_id($id);

        if ($row) {
            $this->Controle_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('controle'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('controle'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('designation', 'designation', 'trim|required');
	$this->form_validation->set_rules('description', 'description', 'trim|required');
	$this->form_validation->set_rules('num_vague', 'num vague', 'trim|required');
	$this->form_validation->set_rules('date_debut', 'date debut', 'trim|required');
	$this->form_validation->set_rules('date_fin', 'date fin', 'trim|required');
	$this->form_validation->set_rules('note', 'note', 'trim|required|numeric');
	$this->form_validation->set_rules('Niveau_Qualite', 'niveau qualite', 'trim|required');
	$this->form_validation->set_rules('id_Type_Controle', 'id type controle', 'trim|required');
	$this->form_validation->set_rules('NNI', 'nni', 'trim|required');
	$this->form_validation->set_rules('id_Modele_Controle', 'id modele controle', 'trim|required');

	$this->form_validation->set_rules('id_Controle', 'id_Controle', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Controle.php */
/* Location: ./application/controllers/Controle.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-05-06 08:00:38 */
/* http://harviacode.com */