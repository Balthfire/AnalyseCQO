<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Controle extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Controle_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'controle/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'controle/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'controle/index.html';
            $config['first_url'] = base_url() . 'controle/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Controle_model->total_rows($q);
        $controle = $this->Controle_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'controle_data' => $controle,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('controle_list', $data);
    }

    public function read($id) 
    {
        $this->load->model("Type_controle_model");
        $row = $this->Controle_model->get_by_id($id);
        if ($row) {
            $idType = $row->id_Type_Controle ;
            $type_controle = new Type_controle_model();
            $type = $type_controle->get_by_id($idType);
            $nomtype = $type->libelle;
            $data = array(

		'id_Controle' => $row->id_Controle,
		'designation' => $row->designation,
		'description' => $row->description,
		'num_vague' => $row->num_vague,
		'date_debut' => $row->date_debut,
		'date_fin' => $row->date_fin,
		'note' => $row->note,
		'Niveau_Qualite' => $row->Niveau_Qualite,
		'fichier_excel' => $row->fichier_excel,
		'id_Type_Controle' => $nomtype,
		'NNI' => $row->NNI,
	    );
            $this->load->view('controle_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('controle'));
        }
    }

    public function create() 
    {
        $this->load->model("Type_controle_model");
        $type_controle = new Type_controle_model();
        $data = array(
            'button' => 'Create',
            'action' => 'http://localhost/controle_optimisateur3/index.php/controle/create_action',
            'id_Controle' => set_value('id_Controle'),
            'designation' => set_value('designation'),
            'description' => set_value('description'),
            'num_vague' => set_value('num_vague'),
            'date_debut' => set_value('date_debut'),
            'date_fin' => set_value('date_fin'),
            'note' => set_value('note'),
            'Niveau_Qualite' => set_value('Niveau_Qualite'),
            'id_Type_Controle' => set_value('id_Type_Controle'),
            'NNI' => set_value('NNI'),
            'arrayTypeControle' => $type_controle->get_all(),

	);
        $this->load->view('controle_form', $data);
    }
    
    public function create_action() 
    {

            $data = array(
		'designation' => $this->input->post('designation',TRUE),
		'description' => $this->input->post('description',TRUE),
		'num_vague' => $this->input->post('num_vague',TRUE),
		'date_debut' => $this->input->post('date_debut',TRUE),
		'date_fin' => $this->input->post('date_fin',TRUE),
		'note' => $this->input->post('note',TRUE),
		'Niveau_Qualite' => $this->input->post('Niveau_Qualite',TRUE),
		'id_Type_Controle' => $this->input->post('Type_Controle',TRUE),
		'NNI' => $this->input->post('NNI',TRUE),
	    );

            $this->Controle_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('index.php/controle'));

    }
    
    public function update($id) 
    {
        $this->load->model("Type_controle_model");
        $row = $this->Controle_model->get_by_id($id);
        $type_controle = new Type_controle_model();
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => 'http://localhost/controle_optimisateur3/index.php/controle/update_action',
                'id_Controle' => set_value('id_Controle', $row->id_Controle),
                'designation' => set_value('designation', $row->designation),
                'description' => set_value('description', $row->description),
                'num_vague' => set_value('num_vague', $row->num_vague),
                'date_debut' => set_value('date_debut', $row->date_debut),
                'date_fin' => set_value('date_fin', $row->date_fin),
                'note' => set_value('note', $row->note),
                'Niveau_Qualite' => set_value('Niveau_Qualite', $row->Niveau_Qualite),
                'id_Type_Controle' => set_value('Type_Controle', $row->id_Type_Controle),
                'NNI' => set_value('NNI', $row->NNI),
                'arrayTypeControle' => $type_controle->get_all(),
            );
            $this->load->view('controle_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('controle'));
        }
    }
    
    public function update_action() 
    {
            $data = array(
		'designation' => $this->input->post('designation',TRUE),
		'description' => $this->input->post('description',TRUE),
		'num_vague' => $this->input->post('num_vague',TRUE),
		'date_debut' => $this->input->post('date_debut',TRUE),
		'date_fin' => $this->input->post('date_fin',TRUE),
		'note' => $this->input->post('note',TRUE),
		'Niveau_Qualite' => $this->input->post('Niveau_Qualite',TRUE),
		'id_Type_Controle' => $this->input->post('Type_Controle',TRUE),
		'NNI' => $this->input->post('NNI',TRUE),
	    );

            $this->Controle_model->update($this->input->post('id_Controle', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('index.php/controle'));

    }
    
    public function delete($id) 
    {
        $row = $this->Controle_model->get_by_id($id);

        if ($row) {
            $this->Controle_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('controle'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('controle'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('designation', 'designation', 'trim|required');
	$this->form_validation->set_rules('description', 'description', 'trim|required');
	$this->form_validation->set_rules('num_vague', 'num vague', 'trim|required');
	$this->form_validation->set_rules('date_debut', 'date debut', 'trim|required');
	$this->form_validation->set_rules('date_fin', 'date fin', 'trim|required');
	$this->form_validation->set_rules('note', 'note', 'trim|required|numeric');
	$this->form_validation->set_rules('Niveau_Qualite', 'niveau qualite', 'trim|required');
	$this->form_validation->set_rules('fichier_excel', 'fichier excel', 'trim|required');
	$this->form_validation->set_rules('id_Type_Controle', 'id type controle', 'trim|required');
	$this->form_validation->set_rules('NNI', 'nni', 'trim|required');

	$this->form_validation->set_rules('id_Controle', 'id_Controle', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function viewAjoutExcel()
    {
        $this->load->view('ajoutExcel');
    }
    public function viewGrapheTest()
    {
        $this->load->view('grapheTest');
    }
    public function viewIframeTest()
    {
        $this->load->view('iframetest');
    }

    public function viewvisueltest()
    {
        $this->load->view('testvisuel');
    }

    public function viewProcessExcel()
    {
        $data = array
        (
            'arrayNomFeuille' => $this->getNomFeuilleExcel($_GET['idctrl']),
        );
        $this->load->view('processExcel',$data);
    }

    public function storeExcel()
    {
        $this->load->library('excel');
        $this->load->model("Controle_model");

        var_dump($_FILES);
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = '40000000';
        $config['encrypt_name'] = false;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('fichier_xl')) {
            $this->session->set_flashdata('status', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
            $this->session->set_flashdata('message', 'Nope');

            redirect(site_url('index.php/controle'));
        } else {
            $data = $this->upload->data();
            $uploadpath = $data['full_path'];
            $controle = new Controle_model();
            $controle = $controle->get_by_id($this->input->post('id_Controle',TRUE));
            $name = $_FILES['fichier_xl']['name'];
            var_dump($_FILES);
            $data = array(
                "fichier_excel"=>$uploadpath
            );
            $this->Controle_model->update($this->input->post('id_Controle',TRUE),$data);

            $this->session->set_flashdata('message',"Le fichier ".$name." a été lié au contrôle ". $controle->designation);
            redirect('index.php/controle');

            return $uploadpath;
            // Transforme un excel en html
            /*
            $inputFileType = 'Excel2007';
            $inputFileName = $uploadpath;
            $outputFileType = 'HTML';
            $outputFileName = './uploads/test.html';
            $objPHPExcelReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objPHPExcelReader->load($inputFileName);
            $objPHPExcelWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,$outputFileType);
            $objPHPExcel = $objPHPExcelWriter->save($outputFileName);*/
        }
    }

    public function getNomFeuilleExcel($idctrl)
    {
        $this->load->library('excel');
        $this->load->model("Controle_model");

        $controle = new Controle_model();
        $controle = $controle->get_by_id($idctrl);

        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($controle->fichier_excel);

        $name = $objPHPExcel->getSheetNames();

        return $name;
    }

    public function ProcessExcel()
    {
        $arraydata = $this->getDataProcess();
        var_dump($arraydata);




        //Faire un array avec chaque CCS différent
        //Faire la somme des montant pour chaque CCS
        //Compter le nombre d'apparition de chaque CCS
        //Checker les calculs pour chaque indicateurs - résultats
        //

        // $nbApparationCCS;
        //$somme

    }

    public function getDataProcess()
    {
        $this->load->library('excel');
        $this->load->model("Controle_model");

        $controle = new Controle_model();
        $controle = $controle->get_by_id($this->input->post('id_Controle',TRUE));

        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($controle->fichier_excel);

        $nbtotalchamp = $this->input->post('nb_champ',TRUE);
        $arraydata = array();

        for($i=1;$i<=$nbtotalchamp;$i++)
        {
            $champ = $this->input->post('nom_champ_'.$i,TRUE);
            $cellule = $this->input->post('value_'.$i,TRUE);
            $arraydata[$champ] = $cellule;
        }

        $nomfeuille = $this->input->post('nom_feuille',TRUE);
        $objPHPExcel->setActiveSheetIndexByName($nomfeuille);
        $objWorksheet = $objPHPExcel->getActiveSheet();

        $datastart = $this->input->post('datastart',TRUE);
        $nbechant = $this->input->post('nbechant',TRUE)-1; //Plus pratique
        $arrayfulldataexcel = array();

        for($z=0;$z <= $nbechant;$z++) {
            $arraydataColonne = array();
            foreach ($arraydata as $champ => $valeur) {
                $nbligne = $z + $datastart;
                $cellvalue = $objWorksheet->getCell($valeur . $nbligne)->getCalculatedValue();
                $arraydataColonne[$champ] = $cellvalue;
            }
            $arrayfulldataexcel[$z]= $arraydataColonne;
        }
        return $arrayfulldataexcel;
    }

    public function ajoutExcel()
    {
        $this->load->model("Controle_model");
        $controle = new Controle_model();
        $c = $controle->get_by_id('id_Controle');
        $config['upload_path'] = './temp/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = '400000000000000000';
        $config['encrypt_name'] = false;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('fichier_xl')) {
            $this->session->set_flashdata('status', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
            redirect('index.php/Cconnexion/index');
        } else {
            $this->load->library('excel');
            $objReader = PHPExcel_IOFactory::createReader("Excel2007");
            $objReader->setReadDataOnly(true);
            $data = $this->upload->data();
            $objPHPExcel = $objReader->load($data['full_path']);

            // TODO : Modifier le intval -> internet
            $this->load->model("Fichier_model");
            $this->load->model("Feuille_model");
            $this->load->model("Cellule_model");

            $fichier = new Fichier_model();
            $datafichier = array(
                'libelle' => "lib1",
                'id_Controle' => $this->input->post('id_Controle',TRUE)
            );
            $idfichier = $fichier->insertReturn($datafichier);

            $name = $objPHPExcel->getSheetNames();
            $nombrefeuille = count($name);

            /**
            for ($nbF = 0; $nbF < $nombrefeuille; $nbF++) {
            $objWorksheet = $objPHPExcel->getSheet($nbF);
            $row = intval($objWorksheet->getHighestDataRow());
            $stringCol = $objWorksheet->getHighestDataColumn();
            $indexCol = PHPExcel_Cell::columnIndexFromString($stringCol);
            $feuille = new Feuille_model();
            // TODO : gérer le numpage et l'id_controle dynamiquement
            // TODO : gérer le htaccess (danscache)
            $datafeuille = array(
            'nb_ligne' => $row,
            'nb_colonne' => $indexCol,
            'num_page' => $nbF,
            'id_Fichier' => $idfichier
            );
            $idFeuille = $feuille->insertReturn($datafeuille);
            $cellule = new Cellule_model();

            // x = colonne  y = ligne
            for ($x = 0; $x < $indexCol; $x++) {
            for ($y = 0; $y < $row; $y++) {
            $colString = PHPExcel_Cell::stringFromColumnIndex($x);
            //TODO : Fonction getCalculatedValue : bug lors de sélection de colonne complète (D:D) pour calcul

            //$cellvalue = $objPHPExcel->setActiveSheetIndex($nbF)->getCell($colString . $y)->getCalculatedValue();

            // Gestion de l'erreur cité ci-dessus
            $indiceCheck = 0;
            foreach ($name as $nomfeuille) {
            $cellValueFinal = "";
            $cellValueOrigin = $objPHPExcel->setActiveSheetIndex($nbF)->getCell($colString . $y)->getValue();
            $nbSpaceFeuille = substr_count($nomfeuille," ");

            if ($nbSpaceFeuille > 0)
            $strSearch = "'" . $nomfeuille . "'!";
            else
            $strSearch = $nomfeuille . "!";

            $nbOccurence = substr_count($cellValueOrigin, $strSearch);
            if ($nbOccurence > 0) {
            $lenStrSearch = strlen($strSearch);
            $lenOriginal = strlen($cellValueOrigin);
            $chrSearch = ":";
            $posChrSearch = strpos($cellValueOrigin, $chrSearch);
            $lastPosChrSearch = strrpos($cellValueOrigin, $chrSearch);

            $posStart = 0;
            $var = "";


            $posOccurence = 1;
            for ($z = 0; $z <= $nbOccurence; $z++) {

            $searchChr = ":";
            $posSearch = strpos($cellValueOrigin, $searchChr, $posOccurence);
            $posNomFeuille = strpos($cellValueOrigin, $nomfeuille, $posOccurence);

            if ($indiceCheck >= 1) {
            for ($num = 1; $num < $indiceCheck; $num++) {
            $posOccurence = $posSearch + 1;
            $posSearch = strpos($cellValueOrigin, $searchChr, $posOccurence);
            }
            }
            $posSearch = strpos($cellValueOrigin, $searchChr, $posOccurence);

            $chrAvant = substr($cellValueOrigin, $posSearch - 1, 1);
            $chrApres = substr($cellValueOrigin, $posSearch + 1, 1);

            if ($chrApres == $chrAvant AND $chrApres != " ") {
            $strPosToEnd = substr($cellValueOrigin, $posSearch + 2);
            $lengthStrAfterPos = strlen($strPosToEnd);
            $originalLength = strlen($cellValueOrigin);
            $lengthStrBefPos = $originalLength - $lengthStrAfterPos - 4;
            $strStartToPos = substr($cellValueOrigin, 0, $lengthStrBefPos);

            $objWorksheet = $objPHPExcel->getSheetByName($nomfeuille);
            $nbLigneFeuilleMin = 1;
            $nbLigneFeuilleMax = intval($objWorksheet->getHighestDataRow());

            $cellValueFinal = $strStartToPos . "!" . $chrAvant . $nbLigneFeuilleMin . $searchChr . $chrApres . $nbLigneFeuilleMax . $strPosToEnd;
            $indiceCheck++;
            $chips = array($colString . $y => $cellValueFinal);

            var_dump($chips);

            }
            $posOccurence = $posSearch + 1;
            $objPHPExcel->setActiveSheetIndex($nbF)->getCell($colString . $y)->setValue($cellValueFinal);
            }
            }
            }

            $cellvalue = $objPHPExcel->setActiveSheetIndex($nbF)->getCell($colString . $y)->getCalculatedValue();

            if ($cellvalue != NULL) {
            $datacellule = array(
            'pos_x' => $x,
            'pos_y' => $y,
            'valeur' => $cellvalue,
            'id_Feuille' => $idFeuille,

            );
            $cellule->insert($datacellule);
            }
            }
            }
            }*/
            var_dump($data['full_path']);

            redirect('index.php/controle/viewAjoutExcel');
        }
    }


}

/* End of file Controle.php */
/* Location: ./application/controllers/Controle.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-21 12:59:51 */
/* http://harviacode.com */