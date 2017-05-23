<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Resultat extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Resultat_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'resultat/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'resultat/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'resultat/index.html';
            $config['first_url'] = base_url() . 'resultat/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Resultat_model->total_rows($q);
        $resultat = $this->Resultat_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'resultat_data' => $resultat,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('resultat_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Resultat_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Resultat' => $row->id_Resultat,
		'valeur' => $row->valeur,
		'id_Indicateur' => $row->id_Indicateur,
		'CCS' => $row->CCS,
	    );
            $this->load->view('resultat_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('resultat'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('resultat/create_action'),
	    'id_Resultat' => set_value('id_Resultat'),
	    'valeur' => set_value('valeur'),
	    'id_Indicateur' => set_value('id_Indicateur'),
	    'CCS' => set_value('CCS'),
	);
        $this->load->view('resultat_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'valeur' => $this->input->post('valeur',TRUE),
		'id_Indicateur' => $this->input->post('id_Indicateur',TRUE),
		'CCS' => $this->input->post('CCS',TRUE),
	    );

            $this->Resultat_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('resultat'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Resultat_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('resultat/update_action'),
		'id_Resultat' => set_value('id_Resultat', $row->id_Resultat),
		'valeur' => set_value('valeur', $row->valeur),
		'id_Indicateur' => set_value('id_Indicateur', $row->id_Indicateur),
		'CCS' => set_value('CCS', $row->CCS),
	    );
            $this->load->view('resultat_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('resultat'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Resultat', TRUE));
        } else {
            $data = array(
		'valeur' => $this->input->post('valeur',TRUE),
		'id_Indicateur' => $this->input->post('id_Indicateur',TRUE),
		'CCS' => $this->input->post('CCS',TRUE),
	    );

            $this->Resultat_model->update($this->input->post('id_Resultat', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('resultat'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Resultat_model->get_by_id($id);

        if ($row) {
            $this->Resultat_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('resultat'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('resultat'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('valeur', 'valeur', 'trim|required');
	$this->form_validation->set_rules('id_Indicateur', 'id indicateur', 'trim|required');
	$this->form_validation->set_rules('CCS', 'ccs', 'trim|required');

	$this->form_validation->set_rules('id_Resultat', 'id_Resultat', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Resultat.php */
/* Location: ./application/controllers/Resultat.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-05-22 09:27:59 */
/* http://harviacode.com */