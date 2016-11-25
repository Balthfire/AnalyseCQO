<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Data extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Data_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'data/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'data/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'data/index.html';
            $config['first_url'] = base_url() . 'data/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Data_model->total_rows($q);
        $data = $this->Data_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'data_data' => $data,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('data_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Data_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Data' => $row->id_Data,
		'data' => $row->data,
		'num_ligne_excel' => $row->num_ligne_excel,
		'id_Structure' => $row->id_Structure,
	    );
            $this->load->view('data_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('data/create_action'),
	    'id_Data' => set_value('id_Data'),
	    'data' => set_value('data'),
	    'num_ligne_excel' => set_value('num_ligne_excel'),
	    'id_Structure' => set_value('id_Structure'),
	);
        $this->load->view('data_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'data' => $this->input->post('data',TRUE),
		'num_ligne_excel' => $this->input->post('num_ligne_excel',TRUE),
		'id_Structure' => $this->input->post('id_Structure',TRUE),
	    );

            $this->Data_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('data'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Data_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('data/update_action'),
		'id_Data' => set_value('id_Data', $row->id_Data),
		'data' => set_value('data', $row->data),
		'num_ligne_excel' => set_value('num_ligne_excel', $row->num_ligne_excel),
		'id_Structure' => set_value('id_Structure', $row->id_Structure),
	    );
            $this->load->view('data_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Data', TRUE));
        } else {
            $data = array(
		'data' => $this->input->post('data',TRUE),
		'num_ligne_excel' => $this->input->post('num_ligne_excel',TRUE),
		'id_Structure' => $this->input->post('id_Structure',TRUE),
	    );

            $this->Data_model->update($this->input->post('id_Data', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('data'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Data_model->get_by_id($id);

        if ($row) {
            $this->Data_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('data'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('data', 'data', 'trim|required');
	$this->form_validation->set_rules('num_ligne_excel', 'num ligne excel', 'trim|required');
	$this->form_validation->set_rules('id_Structure', 'id structure', 'trim|required');

	$this->form_validation->set_rules('id_Data', 'id_Data', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Data.php */
/* Location: ./application/controllers/Data.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-28 15:16:08 */
/* http://harviacode.com */