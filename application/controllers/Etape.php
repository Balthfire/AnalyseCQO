<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Etape extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Etape_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'etape/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'etape/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'etape/index.html';
            $config['first_url'] = base_url() . 'etape/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Etape_model->total_rows($q);
        $etape = $this->Etape_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'etape_data' => $etape,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('etape_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Etape_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Etape' => $row->id_Etape,
		'AvecColonne' => $row->AvecColonne,
		'ordre' => $row->ordre,
		'id_Operateur' => $row->id_Operateur,
		'id_Structure' => $row->id_Structure,
		'id_Type_Indicateur' => $row->id_Type_Indicateur,
	    );
            $this->load->view('etape_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('etape'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('etape/create_action'),
	    'id_Etape' => set_value('id_Etape'),
	    'AvecColonne' => set_value('AvecColonne'),
	    'ordre' => set_value('ordre'),
	    'id_Operateur' => set_value('id_Operateur'),
	    'id_Structure' => set_value('id_Structure'),
	    'id_Type_Indicateur' => set_value('id_Type_Indicateur'),
	);
        $this->load->view('etape_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'AvecColonne' => $this->input->post('AvecColonne',TRUE),
		'ordre' => $this->input->post('ordre',TRUE),
		'id_Operateur' => $this->input->post('id_Operateur',TRUE),
		'id_Structure' => $this->input->post('id_Structure',TRUE),
		'id_Type_Indicateur' => $this->input->post('id_Type_Indicateur',TRUE),
	    );

            $this->Etape_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('etape'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Etape_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('etape/update_action'),
		'id_Etape' => set_value('id_Etape', $row->id_Etape),
		'AvecColonne' => set_value('AvecColonne', $row->AvecColonne),
		'ordre' => set_value('ordre', $row->ordre),
		'id_Operateur' => set_value('id_Operateur', $row->id_Operateur),
		'id_Structure' => set_value('id_Structure', $row->id_Structure),
		'id_Type_Indicateur' => set_value('id_Type_Indicateur', $row->id_Type_Indicateur),
	    );
            $this->load->view('etape_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('etape'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Etape', TRUE));
        } else {
            $data = array(
		'AvecColonne' => $this->input->post('AvecColonne',TRUE),
		'ordre' => $this->input->post('ordre',TRUE),
		'id_Operateur' => $this->input->post('id_Operateur',TRUE),
		'id_Structure' => $this->input->post('id_Structure',TRUE),
		'id_Type_Indicateur' => $this->input->post('id_Type_Indicateur',TRUE),
	    );

            $this->Etape_model->update($this->input->post('id_Etape', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('etape'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Etape_model->get_by_id($id);

        if ($row) {
            $this->Etape_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('etape'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('etape'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('AvecColonne', 'aveccolonne', 'trim|required');
	$this->form_validation->set_rules('ordre', 'ordre', 'trim|required');
	$this->form_validation->set_rules('id_Operateur', 'id operateur', 'trim|required');
	$this->form_validation->set_rules('id_Structure', 'id structure', 'trim|required');
	$this->form_validation->set_rules('id_Type_Indicateur', 'id type indicateur', 'trim|required');

	$this->form_validation->set_rules('id_Etape', 'id_Etape', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Etape.php */
/* Location: ./application/controllers/Etape.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-17 08:23:55 */
/* http://harviacode.com */