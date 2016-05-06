<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Structure_indicateur_donnee extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Structure_indicateur_donnee_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'structure_indicateur_donnee/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'structure_indicateur_donnee/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'structure_indicateur_donnee/index.html';
            $config['first_url'] = base_url() . 'structure_indicateur_donnee/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Structure_indicateur_donnee_model->total_rows($q);
        $structure_indicateur_donnee = $this->Structure_indicateur_donnee_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'structure_indicateur_donnee_data' => $structure_indicateur_donnee,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('structure_indicateur_donnee_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Structure_indicateur_donnee_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Modele_Indicateur' => $row->id_Modele_Indicateur,
		'id_Modele_Donnees_Indicateur' => $row->id_Modele_Donnees_Indicateur,
	    );
            $this->load->view('structure_indicateur_donnee_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('structure_indicateur_donnee'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('structure_indicateur_donnee/create_action'),
	    'id_Modele_Indicateur' => set_value('id_Modele_Indicateur'),
	    'id_Modele_Donnees_Indicateur' => set_value('id_Modele_Donnees_Indicateur'),
	);
        $this->load->view('structure_indicateur_donnee_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
	    );

            $this->Structure_indicateur_donnee_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('structure_indicateur_donnee'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Structure_indicateur_donnee_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('structure_indicateur_donnee/update_action'),
		'id_Modele_Indicateur' => set_value('id_Modele_Indicateur', $row->id_Modele_Indicateur),
		'id_Modele_Donnees_Indicateur' => set_value('id_Modele_Donnees_Indicateur', $row->id_Modele_Donnees_Indicateur),
	    );
            $this->load->view('structure_indicateur_donnee_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('structure_indicateur_donnee'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Modele_Indicateur', TRUE));
        } else {
            $data = array(
	    );

            $this->Structure_indicateur_donnee_model->update($this->input->post('id_Modele_Indicateur', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('structure_indicateur_donnee'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Structure_indicateur_donnee_model->get_by_id($id);

        if ($row) {
            $this->Structure_indicateur_donnee_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('structure_indicateur_donnee'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('structure_indicateur_donnee'));
        }
    }

    public function _rules() 
    {

	$this->form_validation->set_rules('id_Modele_Indicateur', 'id_Modele_Indicateur', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Structure_indicateur_donnee.php */
/* Location: ./application/controllers/Structure_indicateur_donnee.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-05-06 08:00:38 */
/* http://harviacode.com */