<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modele_donnees_indicateur extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Modele_donnees_indicateur_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'modele_donnees_indicateur/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'modele_donnees_indicateur/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'modele_donnees_indicateur/index.html';
            $config['first_url'] = base_url() . 'modele_donnees_indicateur/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Modele_donnees_indicateur_model->total_rows($q);
        $modele_donnees_indicateur = $this->Modele_donnees_indicateur_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'modele_donnees_indicateur_data' => $modele_donnees_indicateur,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('modele_donnees_indicateur_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Modele_donnees_indicateur_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Modele_Donnees_Indicateur' => $row->id_Modele_Donnees_Indicateur,
		'designation' => $row->designation,
		'valeur' => $row->valeur,
	    );
            $this->load->view('modele_donnees_indicateur_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('modele_donnees_indicateur'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('modele_donnees_indicateur/create_action'),
	    'id_Modele_Donnees_Indicateur' => set_value('id_Modele_Donnees_Indicateur'),
	    'designation' => set_value('designation'),
	    'valeur' => set_value('valeur'),
	);
        $this->load->view('modele_donnees_indicateur_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'designation' => $this->input->post('designation',TRUE),
		'valeur' => $this->input->post('valeur',TRUE),
	    );

            $this->Modele_donnees_indicateur_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('modele_donnees_indicateur'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Modele_donnees_indicateur_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('modele_donnees_indicateur/update_action'),
		'id_Modele_Donnees_Indicateur' => set_value('id_Modele_Donnees_Indicateur', $row->id_Modele_Donnees_Indicateur),
		'designation' => set_value('designation', $row->designation),
		'valeur' => set_value('valeur', $row->valeur),
	    );
            $this->load->view('modele_donnees_indicateur_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('modele_donnees_indicateur'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Modele_Donnees_Indicateur', TRUE));
        } else {
            $data = array(
		'designation' => $this->input->post('designation',TRUE),
		'valeur' => $this->input->post('valeur',TRUE),
	    );

            $this->Modele_donnees_indicateur_model->update($this->input->post('id_Modele_Donnees_Indicateur', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('modele_donnees_indicateur'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Modele_donnees_indicateur_model->get_by_id($id);

        if ($row) {
            $this->Modele_donnees_indicateur_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('modele_donnees_indicateur'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('modele_donnees_indicateur'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('designation', 'designation', 'trim|required');
	$this->form_validation->set_rules('valeur', 'valeur', 'trim|required|numeric');

	$this->form_validation->set_rules('id_Modele_Donnees_Indicateur', 'id_Modele_Donnees_Indicateur', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Modele_donnees_indicateur.php */
/* Location: ./application/controllers/Modele_donnees_indicateur.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-05-06 08:00:38 */
/* http://harviacode.com */