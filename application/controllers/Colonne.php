<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Colonne extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Colonne_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'colonne/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'colonne/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'colonne/index.html';
            $config['first_url'] = base_url() . 'colonne/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Colonne_model->total_rows($q);
        $colonne = $this->Colonne_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'colonne_data' => $colonne,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('colonne_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Colonne_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_colonne' => $row->id_colonne,
		'nom_colonne' => $row->nom_colonne,
		'lettre_excel' => $row->lettre_excel,
		'id_data_indicateur' => $row->id_data_indicateur,
		'id_type_colonne' => $row->id_type_colonne,
		'id_Feuille' => $row->id_Feuille,
	    );
            $this->load->view('colonne_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('colonne'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('colonne/create_action'),
	    'id_colonne' => set_value('id_colonne'),
	    'nom_colonne' => set_value('nom_colonne'),
	    'lettre_excel' => set_value('lettre_excel'),
	    'id_data_indicateur' => set_value('id_data_indicateur'),
	    'id_type_colonne' => set_value('id_type_colonne'),
	    'id_Feuille' => set_value('id_Feuille'),
	);
        $this->load->view('colonne_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nom_colonne' => $this->input->post('nom_colonne',TRUE),
		'lettre_excel' => $this->input->post('lettre_excel',TRUE),
		'id_data_indicateur' => $this->input->post('id_data_indicateur',TRUE),
		'id_type_colonne' => $this->input->post('id_type_colonne',TRUE),
		'id_Feuille' => $this->input->post('id_Feuille',TRUE),
	    );

            $this->Colonne_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('colonne'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Colonne_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('colonne/update_action'),
		'id_colonne' => set_value('id_colonne', $row->id_colonne),
		'nom_colonne' => set_value('nom_colonne', $row->nom_colonne),
		'lettre_excel' => set_value('lettre_excel', $row->lettre_excel),
		'id_data_indicateur' => set_value('id_data_indicateur', $row->id_data_indicateur),
		'id_type_colonne' => set_value('id_type_colonne', $row->id_type_colonne),
		'id_Feuille' => set_value('id_Feuille', $row->id_Feuille),
	    );
            $this->load->view('colonne_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('colonne'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_colonne', TRUE));
        } else {
            $data = array(
		'nom_colonne' => $this->input->post('nom_colonne',TRUE),
		'lettre_excel' => $this->input->post('lettre_excel',TRUE),
		'id_data_indicateur' => $this->input->post('id_data_indicateur',TRUE),
		'id_type_colonne' => $this->input->post('id_type_colonne',TRUE),
		'id_Feuille' => $this->input->post('id_Feuille',TRUE),
	    );

            $this->Colonne_model->update($this->input->post('id_colonne', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('colonne'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Colonne_model->get_by_id($id);

        if ($row) {
            $this->Colonne_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('colonne'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('colonne'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nom_colonne', 'nom colonne', 'trim|required');
	$this->form_validation->set_rules('lettre_excel', 'lettre excel', 'trim|required');
	$this->form_validation->set_rules('id_data_indicateur', 'id data indicateur', 'trim|required');
	$this->form_validation->set_rules('id_type_colonne', 'id type colonne', 'trim|required');
	$this->form_validation->set_rules('id_Feuille', 'id feuille', 'trim|required');

	$this->form_validation->set_rules('id_colonne', 'id_colonne', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Colonne.php */
/* Location: ./application/controllers/Colonne.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-21 12:59:51 */
/* http://harviacode.com */