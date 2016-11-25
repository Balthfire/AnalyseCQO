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
        $row = $this->Controle_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Controle' => $row->id_Controle,
		'nom' => $row->nom,
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
        $data = array(
            'button' => 'Create',
            'action' => site_url('index.php/controle/create_action'),
	    'id_Controle' => set_value('id_Controle'),
	    'nom' => set_value('nom'),
	    'NNI' => set_value('NNI'),
	);
        $this->load->view('controle_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'NNI' => $this->input->post('NNI',TRUE),
	    );

            $this->Controle_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('index.php/controle'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Controle_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('index.php/controle/update_action'),
                'id_Controle' => set_value('id_Controle', $row->id_Controle),
                'nom' => set_value('nom', $row->nom),
                'NNI' => set_value('NNI', $row->NNI),
	        );
            $this->load->view('controle_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('controle'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Controle', TRUE));
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'NNI' => $this->input->post('NNI',TRUE),
	    );

            $this->Controle_model->update($this->input->post('id_Controle', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('controle'));
        }
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
	$this->form_validation->set_rules('nom', 'nom', 'trim|required');
	$this->form_validation->set_rules('NNI', 'nni', 'trim|required');

	$this->form_validation->set_rules('id_Controle', 'id_Controle', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function viewUploadExcel()
    {
        $this->load->view('ajoutExcel');
    }

    public function viewProcessExcel(Fichier_model $fichier)
    {
        $this->load->model('Fichier_model');
        $data = array(
            "lastinsert" => $fichier->get_last_id(),
            'arrayNomFeuille' => $this->getNomFeuilleExcel($fichier->get_last_id())
        );
        var_dump($data);
        $this->load->view('processExcel',$data);
    }

    public function storeExcel()
    {
        $this->load->library('excel');
        $this->load->model("Fichier_model");
        $fichier = new Fichier_model();

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
            $name = $_FILES['fichier_xl']['name'];
            $date = date('Y-n');
            $insert_data = array(
                "nom"=>$name,
                "extension"=>$config['allowed_types'],
                "upload_path"=>$uploadpath,
                "annee"=>$date,
            );
            $fichier->insert($insert_data);

            $this->session->set_flashdata('message', 'le fichier excel a bien été uploadé');
            $this->viewProcessExcel($fichier);

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

    public function createStructure($arrayGeneral)
    {
        $this->load->library('excel');
        $this->load->model("Fichier_model");
        $this->load->model("Feuille_model");
        $this->load->model("Colonne_model");
        $this->load->model("Structure_model");
        $this->load->model("Data_model");

        $struct = new Structure_model();
        $feuille = new Feuille_model();
        $col = new Colonne_model();
        $datamodel = new Data_model();
        $previousColonne = "";
        $DataIdArray = array();
        foreach($arrayGeneral as $idfichier => $arrayFeuille)
        {
            foreach($arrayFeuille as $nomfeuille => $arrayColonne)
            {
                $insert_data = array(
                    "nom"=>$nomfeuille,
                );
                $feuille->insert($insert_data);
                $idFeuille = $feuille->get_last_id();

                foreach($arrayColonne as $lettreColonne => $arrayLigne)
                {
                    foreach($arrayLigne as $numligne => $arrayData)
                    {
                        foreach($arrayData as $header => $valeur)
                        {
                            if($previousColonne != $lettreColonne)
                            {
                                var_dump("ok");
                                var_dump($header);
                                $insert_data = array(
                                    "header"=>$header,
                                    "lettre_excel"=>$lettreColonne,
                                );
                                $col->insert($insert_data);
                                $idCol = $col->get_last_id();

                                $insert_data = array(
                                    "id_Fichier"=>$idfichier,
                                    "id_Feuille"=>$idFeuille,
                                    "id_Colonne"=>$idCol
                                );
                                $struct->insert($insert_data);
                                $idStruct = $struct->get_last_id();
                            }
                            $espace = " ";
                            var_dump($espace);


                            $insert_data = array(
                                "data" => $valeur,
                                "num_ligne_excel" => $numligne,
                                "id_Structure" => $idStruct
                            );
                            $datamodel->insert($insert_data);
                            $idData = $datamodel->get_last_id();

                            $previousColonne = $lettreColonne;
                            $DataIdArray[] = $idData;
                        }
                    }
                }
            }
        }
        //var_dump($DataIdArray);
    }

    public function getNomFeuilleExcel($idfichier)
    {
        $this->load->library('excel');
        $this->load->model("Fichier_model");

        $fichier = new Fichier_model();
        $fichier = $fichier->get_by_id($idfichier);

        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($fichier->upload_path);

        $name = $objPHPExcel->getSheetNames();
        return $name;
    }

    public function ProcessExcel()
    {
        $dataColonne = $this->getDataProcess($this->input->post('lastinsert'));
        $arrayIdentifiant = array();

        foreach($dataColonne as $data)
        {
            if (!in_array($data['CCS'],$arrayIdentifiant))
            {
                $arrayIdentifiant[] = $data['CCS'];
            }
        }
        $nbElements = count($dataColonne[0]);
        $indice = 0;
        foreach($arrayIdentifiant as $id)
        {
            foreach($dataColonne as $data)
            {
                //var_dump($data[1]);
            }
        }

    }


    public function getDataProcess($lastid)
    {
        $this->load->library('excel');
        $this->load->model("Fichier_model");
        $fichier = new Fichier_model;
        $fichier = $fichier->get_by_id($lastid);

        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($fichier->upload_path);
        $arraynomfeuille = $objPHPExcel->getSheetNames();

        //Nombre de champs ajoutés via le script js
        $nbtotalchamp = $this->input->post('nb_champ',TRUE);
        $inputnomfeuille = $this->input->post('nom_feuille',TRUE);

        $generalArray = array();
        $arrayFeuille = array();
        foreach ($arraynomfeuille as $nomfeuille) {
            //TODO : Amélioration du système pour gérer plusieurs feuilles automatiquement
            if($nomfeuille == $inputnomfeuille)
            {
                $objPHPExcel->setActiveSheetIndexByName($nomfeuille);
                $objWorksheet = $objPHPExcel->getActiveSheet();
                $datastart = $this->input->post('datastart',TRUE);
                $nbechant = $this->input->post('nbechant',TRUE)-1; //Plus pratique

                $arrayColonne= array();
                for($i=1;$i<=$nbtotalchamp;$i++)
                {
                    $header = $this->input->post('nom_champ_'.$i,TRUE);
                    $colonnelettre = $this->input->post('value_'.$i,TRUE);
                    $arrayLigne = array();
                    for($z=0;$z <= $nbechant;$z++)
                    {
                        $arrayData = array();
                        $numligne = $z + $datastart;
                        var_dump($header);
                        $arrayData[$header] =  $objWorksheet->getCell($colonnelettre . $numligne)->getCalculatedValue();
                        $arrayLigne[$numligne] = $arrayData;
                    }
                    $arrayColonne[$colonnelettre] = $arrayLigne;
                }
                $arrayFeuille[$nomfeuille] = $arrayColonne;
            }
        }
        $generalArray[$lastid] = $arrayFeuille;
        return $this->createStructure($generalArray);
    }

    /**
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
            }
            var_dump($data['full_path']);

            redirect('index.php/controle/viewAjoutExcel');
        }
    }*/
}

/* End of file Controle.php */
/* Location: ./application/controllers/Controle.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-28 15:16:08 */
/* http://harviacode.com */