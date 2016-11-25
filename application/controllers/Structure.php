<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Structure extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Structure_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'structure/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'structure/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'structure/index.html';
            $config['first_url'] = base_url() . 'structure/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Structure_model->total_rows($q);
        $structure = $this->Structure_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'structure_data' => $structure,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('structure_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Structure_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Structure' => $row->id_Structure,
		'id_Fichier' => $row->id_Fichier,
		'id_Colonne' => $row->id_Colonne,
		'id_Feuille' => $row->id_Feuille,
	    );
            $this->load->view('structure_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('structure'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('structure/create_action'),
	    'id_Structure' => set_value('id_Structure'),
	    'id_Fichier' => set_value('id_Fichier'),
	    'id_Colonne' => set_value('id_Colonne'),
	    'id_Feuille' => set_value('id_Feuille'),
	);
        $this->load->view('structure_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_Fichier' => $this->input->post('id_Fichier',TRUE),
		'id_Colonne' => $this->input->post('id_Colonne',TRUE),
		'id_Feuille' => $this->input->post('id_Feuille',TRUE),
	    );

            $this->Structure_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('structure'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Structure_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('structure/update_action'),
		'id_Structure' => set_value('id_Structure', $row->id_Structure),
		'id_Fichier' => set_value('id_Fichier', $row->id_Fichier),
		'id_Colonne' => set_value('id_Colonne', $row->id_Colonne),
		'id_Feuille' => set_value('id_Feuille', $row->id_Feuille),
	    );
            $this->load->view('structure_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('structure'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Structure', TRUE));
        } else {
            $data = array(
		'id_Fichier' => $this->input->post('id_Fichier',TRUE),
		'id_Colonne' => $this->input->post('id_Colonne',TRUE),
		'id_Feuille' => $this->input->post('id_Feuille',TRUE),
	    );

            $this->Structure_model->update($this->input->post('id_Structure', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('structure'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Structure_model->get_by_id($id);

        if ($row) {
            $this->Structure_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('structure'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('structure'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_Fichier', 'id fichier', 'trim|required');
	$this->form_validation->set_rules('id_Colonne', 'id colonne', 'trim|required');
	$this->form_validation->set_rules('id_Feuille', 'id feuille', 'trim|required');

	$this->form_validation->set_rules('id_Structure', 'id_Structure', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Structure.php */
/* Location: ./application/controllers/Structure.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-28 15:16:09 */
/* http://harviacode.com */