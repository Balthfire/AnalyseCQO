<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feuille extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Feuille_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'feuille/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'feuille/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'feuille/index.html';
            $config['first_url'] = base_url() . 'feuille/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Feuille_model->total_rows($q);
        $feuille = $this->Feuille_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'feuille_data' => $feuille,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('feuille_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Feuille_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Feuille' => $row->id_Feuille,
		'nb_ligne' => $row->nb_ligne,
		'nb_colonne' => $row->nb_colonne,
		'num_page' => $row->num_page,
		'id_Controle' => $row->id_Controle,
	    );
            $this->load->view('feuille_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('feuille'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('feuille/create_action'),
	    'id_Feuille' => set_value('id_Feuille'),
	    'nb_ligne' => set_value('nb_ligne'),
	    'nb_colonne' => set_value('nb_colonne'),
	    'num_page' => set_value('num_page'),
	    'id_Controle' => set_value('id_Controle'),
	);
        $this->load->view('feuille_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nb_ligne' => $this->input->post('nb_ligne',TRUE),
		'nb_colonne' => $this->input->post('nb_colonne',TRUE),
		'num_page' => $this->input->post('num_page',TRUE),
		'id_Controle' => $this->input->post('id_Controle',TRUE),
	    );

            $this->Feuille_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('feuille'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Feuille_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('feuille/update_action'),
		'id_Feuille' => set_value('id_Feuille', $row->id_Feuille),
		'nb_ligne' => set_value('nb_ligne', $row->nb_ligne),
		'nb_colonne' => set_value('nb_colonne', $row->nb_colonne),
		'num_page' => set_value('num_page', $row->num_page),
		'id_Controle' => set_value('id_Controle', $row->id_Controle),
	    );
            $this->load->view('feuille_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('feuille'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Feuille', TRUE));
        } else {
            $data = array(
		'nb_ligne' => $this->input->post('nb_ligne',TRUE),
		'nb_colonne' => $this->input->post('nb_colonne',TRUE),
		'num_page' => $this->input->post('num_page',TRUE),
		'id_Controle' => $this->input->post('id_Controle',TRUE),
	    );

            $this->Feuille_model->update($this->input->post('id_Feuille', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('feuille'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Feuille_model->get_by_id($id);

        if ($row) {
            $this->Feuille_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('feuille'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('feuille'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nb_ligne', 'nb ligne', 'trim|required');
	$this->form_validation->set_rules('nb_colonne', 'nb colonne', 'trim|required');
	$this->form_validation->set_rules('num_page', 'num page', 'trim|required');
	$this->form_validation->set_rules('id_Controle', 'id controle', 'trim|required');

	$this->form_validation->set_rules('id_Feuille', 'id_Feuille', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Feuille.php */
/* Location: ./application/controllers/Feuille.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-06-03 09:09:44 */
/* http://harviacode.com */