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
		'Nom' => $row->Nom,
		'Prenom' => $row->Prenom,
		'password' => $row->password,
		'id_Type_User' => $row->id_Type_User,
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
	    'Nom' => set_value('Nom'),
	    'Prenom' => set_value('Prenom'),
	    'password' => set_value('password'),
	    'id_Type_User' => set_value('id_Type_User'),
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
		'Nom' => $this->input->post('Nom',TRUE),
		'Prenom' => $this->input->post('Prenom',TRUE),
		'password' => $this->input->post('password',TRUE),
		'id_Type_User' => $this->input->post('id_Type_User',TRUE),
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
		'Nom' => set_value('Nom', $row->Nom),
		'Prenom' => set_value('Prenom', $row->Prenom),
		'password' => set_value('password', $row->password),
		'id_Type_User' => set_value('id_Type_User', $row->id_Type_User),
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
		'Nom' => $this->input->post('Nom',TRUE),
		'Prenom' => $this->input->post('Prenom',TRUE),
		'password' => $this->input->post('password',TRUE),
		'id_Type_User' => $this->input->post('id_Type_User',TRUE),
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
	$this->form_validation->set_rules('Nom', 'nom', 'trim|required');
	$this->form_validation->set_rules('Prenom', 'prenom', 'trim|required');
	$this->form_validation->set_rules('password', 'password', 'trim|required');
	$this->form_validation->set_rules('id_Type_User', 'id type user', 'trim|required');

	$this->form_validation->set_rules('NNI', 'NNI', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Utilisateur.php */
/* Location: ./application/controllers/Utilisateur.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-06-03 09:09:44 */
/* http://harviacode.com */