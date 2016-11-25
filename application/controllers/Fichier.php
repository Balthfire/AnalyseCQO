<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fichier extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Fichier_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'fichier/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'fichier/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'fichier/index.html';
            $config['first_url'] = base_url() . 'fichier/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Fichier_model->total_rows($q);
        $fichier = $this->Fichier_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'fichier_data' => $fichier,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('fichier_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Fichier_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Fichier' => $row->id_Fichier,
		'nom' => $row->nom,
		'extension' => $row->extension,
		'conteneur' => $row->conteneur,
		'upload_path' => $row->upload_path,
		'annee' => $row->annee,
	    );
            $this->load->view('fichier_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('fichier'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('fichier/create_action'),
	    'id_Fichier' => set_value('id_Fichier'),
	    'nom' => set_value('nom'),
	    'extension' => set_value('extension'),
	    'conteneur' => set_value('conteneur'),
	    'upload_path' => set_value('upload_path'),
	    'annee' => set_value('annee'),
	);
        $this->load->view('fichier_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'extension' => $this->input->post('extension',TRUE),
		'conteneur' => $this->input->post('conteneur',TRUE),
		'upload_path' => $this->input->post('upload_path',TRUE),
		'annee' => $this->input->post('annee',TRUE),
	    );

            $this->Fichier_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('fichier'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Fichier_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('fichier/update_action'),
		'id_Fichier' => set_value('id_Fichier', $row->id_Fichier),
		'nom' => set_value('nom', $row->nom),
		'extension' => set_value('extension', $row->extension),
		'conteneur' => set_value('conteneur', $row->conteneur),
		'upload_path' => set_value('upload_path', $row->upload_path),
		'annee' => set_value('annee', $row->annee),
	    );
            $this->load->view('fichier_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('fichier'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Fichier', TRUE));
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'extension' => $this->input->post('extension',TRUE),
		'conteneur' => $this->input->post('conteneur',TRUE),
		'upload_path' => $this->input->post('upload_path',TRUE),
		'annee' => $this->input->post('annee',TRUE),
	    );

            $this->Fichier_model->update($this->input->post('id_Fichier', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('fichier'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Fichier_model->get_by_id($id);

        if ($row) {
            $this->Fichier_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('fichier'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('fichier'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nom', 'nom', 'trim|required');
	$this->form_validation->set_rules('extension', 'extension', 'trim|required');
	$this->form_validation->set_rules('conteneur', 'conteneur', 'trim|required');
	$this->form_validation->set_rules('upload_path', 'upload path', 'trim|required');
	$this->form_validation->set_rules('annee', 'annee', 'trim|required');

	$this->form_validation->set_rules('id_Fichier', 'id_Fichier', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Fichier.php */
/* Location: ./application/controllers/Fichier.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-28 15:16:08 */
/* http://harviacode.com */