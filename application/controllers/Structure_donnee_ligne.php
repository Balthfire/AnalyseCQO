<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Structure_donnee_ligne extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Structure_donnee_ligne_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'structure_donnee_ligne/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'structure_donnee_ligne/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'structure_donnee_ligne/index.html';
            $config['first_url'] = base_url() . 'structure_donnee_ligne/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Structure_donnee_ligne_model->total_rows($q);
        $structure_donnee_ligne = $this->Structure_donnee_ligne_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'structure_donnee_ligne_data' => $structure_donnee_ligne,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('structure_donnee_ligne_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Structure_donnee_ligne_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Modele_Donnees_Indicateur' => $row->id_Modele_Donnees_Indicateur,
		'id_Modele_Ligne' => $row->id_Modele_Ligne,
	    );
            $this->load->view('structure_donnee_ligne_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('structure_donnee_ligne'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('structure_donnee_ligne/create_action'),
	    'id_Modele_Donnees_Indicateur' => set_value('id_Modele_Donnees_Indicateur'),
	    'id_Modele_Ligne' => set_value('id_Modele_Ligne'),
	);
        $this->load->view('structure_donnee_ligne_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
	    );

            $this->Structure_donnee_ligne_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('structure_donnee_ligne'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Structure_donnee_ligne_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('structure_donnee_ligne/update_action'),
		'id_Modele_Donnees_Indicateur' => set_value('id_Modele_Donnees_Indicateur', $row->id_Modele_Donnees_Indicateur),
		'id_Modele_Ligne' => set_value('id_Modele_Ligne', $row->id_Modele_Ligne),
	    );
            $this->load->view('structure_donnee_ligne_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('structure_donnee_ligne'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Modele_Donnees_Indicateur', TRUE));
        } else {
            $data = array(
	    );

            $this->Structure_donnee_ligne_model->update($this->input->post('id_Modele_Donnees_Indicateur', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('structure_donnee_ligne'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Structure_donnee_ligne_model->get_by_id($id);

        if ($row) {
            $this->Structure_donnee_ligne_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('structure_donnee_ligne'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('structure_donnee_ligne'));
        }
    }

    public function _rules() 
    {

	$this->form_validation->set_rules('id_Modele_Donnees_Indicateur', 'id_Modele_Donnees_Indicateur', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Structure_donnee_ligne.php */
/* Location: ./application/controllers/Structure_donnee_ligne.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-05-06 08:00:38 */
/* http://harviacode.com */