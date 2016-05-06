<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modele_champ extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Modele_champ_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'modele_champ/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'modele_champ/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'modele_champ/index.html';
            $config['first_url'] = base_url() . 'modele_champ/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Modele_champ_model->total_rows($q);
        $modele_champ = $this->Modele_champ_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'modele_champ_data' => $modele_champ,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('modele_champ_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Modele_champ_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Champ_Modele' => $row->id_Champ_Modele,
		'nom' => $row->nom,
		'estNumerique' => $row->estNumerique,
		'Description' => $row->Description,
	    );
            $this->load->view('modele_champ_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('modele_champ'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('modele_champ/create_action'),
	    'id_Champ_Modele' => set_value('id_Champ_Modele'),
	    'nom' => set_value('nom'),
	    'estNumerique' => set_value('estNumerique'),
	    'Description' => set_value('Description'),
	);
        $this->load->view('modele_champ_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'estNumerique' => $this->input->post('estNumerique',TRUE),
		'Description' => $this->input->post('Description',TRUE),
	    );

            $this->Modele_champ_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('modele_champ'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Modele_champ_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('modele_champ/update_action'),
		'id_Champ_Modele' => set_value('id_Champ_Modele', $row->id_Champ_Modele),
		'nom' => set_value('nom', $row->nom),
		'estNumerique' => set_value('estNumerique', $row->estNumerique),
		'Description' => set_value('Description', $row->Description),
	    );
            $this->load->view('modele_champ_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('modele_champ'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Champ_Modele', TRUE));
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'estNumerique' => $this->input->post('estNumerique',TRUE),
		'Description' => $this->input->post('Description',TRUE),
	    );

            $this->Modele_champ_model->update($this->input->post('id_Champ_Modele', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('modele_champ'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Modele_champ_model->get_by_id($id);

        if ($row) {
            $this->Modele_champ_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('modele_champ'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('modele_champ'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nom', 'nom', 'trim|required');
	$this->form_validation->set_rules('estNumerique', 'estnumerique', 'trim|required');
	$this->form_validation->set_rules('Description', 'description', 'trim|required');

	$this->form_validation->set_rules('id_Champ_Modele', 'id_Champ_Modele', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Modele_champ.php */
/* Location: ./application/controllers/Modele_champ.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-05-06 08:00:38 */
/* http://harviacode.com */