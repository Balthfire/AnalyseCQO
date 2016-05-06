<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Champ extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Champ_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'champ/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'champ/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'champ/index.html';
            $config['first_url'] = base_url() . 'champ/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Champ_model->total_rows($q);
        $champ = $this->Champ_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'champ_data' => $champ,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('champ_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Champ_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Champ' => $row->id_Champ,
		'nom' => $row->nom,
		'txtChamp' => $row->txtChamp,
		'numChamp' => $row->numChamp,
		'estNumerique' => $row->estNumerique,
		'id_Ligne' => $row->id_Ligne,
		'id_Champ_Modele' => $row->id_Champ_Modele,
	    );
            $this->load->view('champ_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('champ'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('champ/create_action'),
	    'id_Champ' => set_value('id_Champ'),
	    'nom' => set_value('nom'),
	    'txtChamp' => set_value('txtChamp'),
	    'numChamp' => set_value('numChamp'),
	    'estNumerique' => set_value('estNumerique'),
	    'id_Ligne' => set_value('id_Ligne'),
	    'id_Champ_Modele' => set_value('id_Champ_Modele'),
	);
        $this->load->view('champ_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'txtChamp' => $this->input->post('txtChamp',TRUE),
		'numChamp' => $this->input->post('numChamp',TRUE),
		'estNumerique' => $this->input->post('estNumerique',TRUE),
		'id_Ligne' => $this->input->post('id_Ligne',TRUE),
		'id_Champ_Modele' => $this->input->post('id_Champ_Modele',TRUE),
	    );

            $this->Champ_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('champ'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Champ_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('champ/update_action'),
		'id_Champ' => set_value('id_Champ', $row->id_Champ),
		'nom' => set_value('nom', $row->nom),
		'txtChamp' => set_value('txtChamp', $row->txtChamp),
		'numChamp' => set_value('numChamp', $row->numChamp),
		'estNumerique' => set_value('estNumerique', $row->estNumerique),
		'id_Ligne' => set_value('id_Ligne', $row->id_Ligne),
		'id_Champ_Modele' => set_value('id_Champ_Modele', $row->id_Champ_Modele),
	    );
            $this->load->view('champ_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('champ'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Champ', TRUE));
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'txtChamp' => $this->input->post('txtChamp',TRUE),
		'numChamp' => $this->input->post('numChamp',TRUE),
		'estNumerique' => $this->input->post('estNumerique',TRUE),
		'id_Ligne' => $this->input->post('id_Ligne',TRUE),
		'id_Champ_Modele' => $this->input->post('id_Champ_Modele',TRUE),
	    );

            $this->Champ_model->update($this->input->post('id_Champ', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('champ'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Champ_model->get_by_id($id);

        if ($row) {
            $this->Champ_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('champ'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('champ'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nom', 'nom', 'trim|required');
	$this->form_validation->set_rules('txtChamp', 'txtchamp', 'trim|required');
	$this->form_validation->set_rules('numChamp', 'numchamp', 'trim|required|numeric');
	$this->form_validation->set_rules('estNumerique', 'estnumerique', 'trim|required');
	$this->form_validation->set_rules('id_Ligne', 'id ligne', 'trim|required');
	$this->form_validation->set_rules('id_Champ_Modele', 'id champ modele', 'trim|required');

	$this->form_validation->set_rules('id_Champ', 'id_Champ', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Champ.php */
/* Location: ./application/controllers/Champ.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-05-06 08:00:37 */
/* http://harviacode.com */