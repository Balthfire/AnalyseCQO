<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Query extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Query_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'query/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'query/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'query/index.html';
            $config['first_url'] = base_url() . 'query/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Query_model->total_rows($q);
        $query = $this->Query_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'query_data' => $query,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('query_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Query_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Query' => $row->id_Query,
		'query' => $row->query,
		'ordre' => $row->ordre,
		'id_Indicateur' => $row->id_Indicateur,
	    );
            $this->load->view('query_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('query'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('query/create_action'),
	    'id_Query' => set_value('id_Query'),
	    'query' => set_value('query'),
	    'ordre' => set_value('ordre'),
	    'id_Indicateur' => set_value('id_Indicateur'),
	);
        $this->load->view('query_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'query' => $this->input->post('query',TRUE),
		'ordre' => $this->input->post('ordre',TRUE),
		'id_Indicateur' => $this->input->post('id_Indicateur',TRUE),
	    );

            $this->Query_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('query'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Query_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('query/update_action'),
		'id_Query' => set_value('id_Query', $row->id_Query),
		'query' => set_value('query', $row->query),
		'ordre' => set_value('ordre', $row->ordre),
		'id_Indicateur' => set_value('id_Indicateur', $row->id_Indicateur),
	    );
            $this->load->view('query_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('query'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Query', TRUE));
        } else {
            $data = array(
		'query' => $this->input->post('query',TRUE),
		'ordre' => $this->input->post('ordre',TRUE),
		'id_Indicateur' => $this->input->post('id_Indicateur',TRUE),
	    );

            $this->Query_model->update($this->input->post('id_Query', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('query'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Query_model->get_by_id($id);

        if ($row) {
            $this->Query_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('query'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('query'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('query', 'query', 'trim|required');
	$this->form_validation->set_rules('ordre', 'ordre', 'trim|required');
	$this->form_validation->set_rules('id_Indicateur', 'id indicateur', 'trim|required');

	$this->form_validation->set_rules('id_Query', 'id_Query', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Query.php */
/* Location: ./application/controllers/Query.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-03-14 14:10:27 */
/* http://harviacode.com */