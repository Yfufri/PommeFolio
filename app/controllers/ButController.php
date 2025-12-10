<?php
// app/controllers/ButController.php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Annee.php';
require_once __DIR__ . '/../models/Competence.php';
require_once __DIR__ . '/../models/Ac.php';
require_once __DIR__ . '/../models/Illustration.php';

class ButController extends BaseController
{
    private $competenceModel;
    private $anneeModel;
    private $acModel;
    private $illustrationModel;

    public function __construct()
    {
        $this->competenceModel   = new Competence();
        $this->anneeModel        = new Annee();
        $this->acModel           = new Ac();
        $this->illustrationModel = new Illustration();
    }

    /**
     * /but
     * Page explorateur interactif BUT (VueJS) :
     *  - liste des années
     *  - compétences par année
     *  - AC par compétence
     */
    public function index()
    {
        // années + compétences
        $annees = $this->anneeModel->getAllWithCompetences();

        // AC groupées par compétence
        $acsParCompetence = array();
        foreach ($annees as $annee) {
            if (!empty($annee['competences'])) {
                foreach ($annee['competences'] as $comp) {
                    $acsParCompetence[$comp['id']] = $this->acModel->findByCompetence($comp['id']);
                }
            }
        }

        $this->render('but-list', array(
            'annees'           => $annees,
            'acsParCompetence' => $acsParCompetence,
        ));
    }

    /**
     * /but/competence?id=XX
     * Page détaillée d’une compétence :
     *  - infos compétence
     *  - AC
     *  - illustrations globales et par AC
     */
    public function competence()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($id <= 0) {
            $error = new ErrorController();
            $error->notFound();
            return;
        }

        $competence = $this->competenceModel->findById($id);
        if (!$competence) {
            $error = new ErrorController();
            $error->notFound();
            return;
        }

        $annee = $this->anneeModel->findById((int) $competence['annee_id']);
        $acs   = $this->acModel->findByCompetence($id);

        $illustrationsGlobales = $this->illustrationModel->findGlobalByCompetence($id);
        $illustrationsParAc    = $this->illustrationModel->findGroupedByAcForCompetence($id);

        $this->render('but', array(
            'annee'                 => $annee,
            'competence'            => $competence,
            'acs'                   => $acs,
            'illustrationsGlobales' => $illustrationsGlobales,
            'illustrationsParAc'    => $illustrationsParAc,
        ));
    }
}
