<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Utilisateur extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Utilisateur_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'utilisateur/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'utilisateur/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'utilisateur/index.html';
            $config['first_url'] = base_url() . 'utilisateur/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Utilisateur_model->total_rows($q);
        $utilisateur = $this->Utilisateur_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'utilisateur_data' => $utilisateur,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('utilisateur_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Utilisateur_model->get_by_id($id);
        if ($row) {
            $data = array(
		'NNI' => $row->NNI,
		'nom' => $row->nom,
		'prenom' => $row->prenom,
		'id_Type_Utilisateur' => $row->id_Type_Utilisateur,
		'CCS' => $row->CCS,
	    );
            $this->load->view('utilisateur_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('utilisateur'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('utilisateur/create_action'),
	    'NNI' => set_value('NNI'),
	    'nom' => set_value('nom'),
	    'prenom' => set_value('prenom'),
	    'id_Type_Utilisateur' => set_value('id_Type_Utilisateur'),
	    'CCS' => set_value('CCS'),
	);
        $this->load->view('utilisateur_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'prenom' => $this->input->post('prenom',TRUE),
		'id_Type_Utilisateur' => $this->input->post('id_Type_Utilisateur',TRUE),
		'CCS' => $this->input->post('CCS',TRUE),
	    );

            $this->Utilisateur_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('utilisateur'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Utilisateur_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('utilisateur/update_action'),
		'NNI' => set_value('NNI', $row->NNI),
		'nom' => set_value('nom', $row->nom),
		'prenom' => set_value('prenom', $row->prenom),
		'id_Type_Utilisateur' => set_value('id_Type_Utilisateur', $row->id_Type_Utilisateur),
		'CCS' => set_value('CCS', $row->CCS),
	    );
            $this->load->view('utilisateur_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('utilisateur'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('NNI', TRUE));
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'prenom' => $this->input->post('prenom',TRUE),
		'id_Type_Utilisateur' => $this->input->post('id_Type_Utilisateur',TRUE),
		'CCS' => $this->input->post('CCS',TRUE),
	    );

            $this->Utilisateur_model->update($this->input->post('NNI', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('utilisateur'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Utilisateur_model->get_by_id($id);

        if ($row) {
            $this->Utilisateur_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('utilisateur'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('utilisateur'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nom', 'nom', 'trim|required');
	$this->form_validation->set_rules('prenom', 'prenom', 'trim|required');
	$this->form_validation->set_rules('id_Type_Utilisateur', 'id type utilisateur', 'trim|required');
	$this->form_validation->set_rules('CCS', 'ccs', 'trim|required');

	$this->form_validation->set_rules('NNI', 'NNI', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Utilisateur.php */
/* Location: ./application/controllers/Utilisateur.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-28 15:16:09 */
/* http://harviacode.com */