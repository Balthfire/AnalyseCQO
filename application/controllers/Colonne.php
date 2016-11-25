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
		'id_Colonne' => $row->id_Colonne,
		'header' => $row->header,
		'lettre_excel' => $row->lettre_excel,
		'id_Type_Colonne' => $row->id_Type_Colonne,
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
	    'id_Colonne' => set_value('id_Colonne'),
	    'header' => set_value('header'),
	    'lettre_excel' => set_value('lettre_excel'),
	    'id_Type_Colonne' => set_value('id_Type_Colonne'),
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
		'header' => $this->input->post('header',TRUE),
		'lettre_excel' => $this->input->post('lettre_excel',TRUE),
		'id_Type_Colonne' => $this->input->post('id_Type_Colonne',TRUE),
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
		'id_Colonne' => set_value('id_Colonne', $row->id_Colonne),
		'header' => set_value('header', $row->header),
		'lettre_excel' => set_value('lettre_excel', $row->lettre_excel),
		'id_Type_Colonne' => set_value('id_Type_Colonne', $row->id_Type_Colonne),
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
            $this->update($this->input->post('id_Colonne', TRUE));
        } else {
            $data = array(
		'header' => $this->input->post('header',TRUE),
		'lettre_excel' => $this->input->post('lettre_excel',TRUE),
		'id_Type_Colonne' => $this->input->post('id_Type_Colonne',TRUE),
	    );

            $this->Colonne_model->update($this->input->post('id_Colonne', TRUE), $data);
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
	$this->form_validation->set_rules('header', 'header', 'trim|required');
	$this->form_validation->set_rules('lettre_excel', 'lettre excel', 'trim|required');
	$this->form_validation->set_rules('id_Type_Colonne', 'id type colonne', 'trim|required');

	$this->form_validation->set_rules('id_Colonne', 'id_Colonne', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Colonne.php */
/* Location: ./application/controllers/Colonne.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-28 15:16:08 */
/* http://harviacode.com */