<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Type_colonne extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Type_colonne_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'type_colonne/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'type_colonne/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'type_colonne/index.html';
            $config['first_url'] = base_url() . 'type_colonne/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Type_colonne_model->total_rows($q);
        $type_colonne = $this->Type_colonne_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'type_colonne_data' => $type_colonne,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('type_colonne_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Type_colonne_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Type_Colonne' => $row->id_Type_Colonne,
		'nom' => $row->nom,
		'isIdentifiant' => $row->isIdentifiant,
	    );
            $this->load->view('type_colonne_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('type_colonne'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('type_colonne/create_action'),
	    'id_Type_Colonne' => set_value('id_Type_Colonne'),
	    'nom' => set_value('nom'),
	    'isIdentifiant' => set_value('isIdentifiant'),
	);
        $this->load->view('type_colonne_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'isIdentifiant' => $this->input->post('isIdentifiant',TRUE),
	    );

            $this->Type_colonne_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('type_colonne'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Type_colonne_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('type_colonne/update_action'),
		'id_Type_Colonne' => set_value('id_Type_Colonne', $row->id_Type_Colonne),
		'nom' => set_value('nom', $row->nom),
		'isIdentifiant' => set_value('isIdentifiant', $row->isIdentifiant),
	    );
            $this->load->view('type_colonne_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('type_colonne'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Type_Colonne', TRUE));
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'isIdentifiant' => $this->input->post('isIdentifiant',TRUE),
	    );

            $this->Type_colonne_model->update($this->input->post('id_Type_Colonne', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('type_colonne'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Type_colonne_model->get_by_id($id);

        if ($row) {
            $this->Type_colonne_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('type_colonne'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('type_colonne'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nom', 'nom', 'trim|required');
	$this->form_validation->set_rules('isIdentifiant', 'isidentifiant', 'trim|required');

	$this->form_validation->set_rules('id_Type_Colonne', 'id_Type_Colonne', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Type_colonne.php */
/* Location: ./application/controllers/Type_colonne.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-03-14 15:22:14 */
/* http://harviacode.com */