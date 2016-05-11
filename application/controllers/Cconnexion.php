<?php

/**
 * Created by PhpStorm.
 * User: Menerith
 * Date: 11-Feb-16
 * Time: 11:09 AM
 */

class Cconnexion extends CI_Controller
{

    public function index()
    {
        $this->load->helper('url');
        $this->load->view('connexion');

    }

    public function login()
    {
        $this->load->model("Utilisateur_model");
        $NNI = $_POST['NNI'];
        $pwd = $_POST['pwd'];
        $utilisateur = new Utilisateur_model();
        $u = $utilisateur->get_by_id($NNI);

        if($u->NNI != "")
        {

            if($u->password == $pwd)
            {
                $message = "Vous êtes connecté en tant que " . $u->Nom . " "
                    . $u->Prenom . " (" . $u->NNI . ")";
                $params['message'] = $message;
                $params['user'] = $u;
                $this->load->view("accueil", $params);
            }
            else
            {
                $param['messagefail'] = "Mot de passe incorrect pour ce NNI";
                echo("Mot de passe incorrect pour ce NNI");
                $this->load->view("connexion", $param);
            }
        }
        else
        {
            $param['messagefail'] = "NNI incorrect";
            echo("NNI incorrect");
            $this->load->view("connexion", $param);
        }

    }
}