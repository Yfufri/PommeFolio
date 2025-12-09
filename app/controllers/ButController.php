<?php

class ButController extends BaseController
{
    private Competence $competenceModel;
    private Annee $anneeModel;
    private Ac $acModel;
    private Illustration $illustrationModel;

    public function __construct()
    {
        $this->competenceModel   = new Competence();
        $this->anneeModel        = new Annee();
        $this->acModel           = new Ac();
        $this->illustrationModel = new Illustration();
    }

    // /but  → liste des années + compétences
    public function index()
    {
        $annees = $this->anneeModel->getAllWithCompetences();
        $this->render('but-list', [
            'annees' => $annees,
        ]);
    }

    // /but/annee?id=1  (facultatif, si tu veux une page par année)
    public function byYear()
    {
        $anneeId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $annee   = $this->anneeModel->findById($anneeId);

        if (!$annee) {
            (new ErrorController())->notFound();
            return;
        }

        $competences = $this->competenceModel->findByAnnee($anneeId);

        $this->render('but-year', [
            'annee'       => $annee,
            'competences' => $competences,
        ]);
    }

    // /but/competence?id=xx  → page détaillée (ce qu’on a appelé views/but.php)
    public function competence()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $competence = $this->competenceModel->findById($id);

        if (!$competence) {
            (new ErrorController())->notFound();
            return;
        }

        $annee = $this->anneeModel->findById((int) $competence['annee_id']);
        $acs   = $this->acModel->findByCompetence($id);

        $illustrationsGlobales = $this->illustrationModel->findGlobalByCompetence($id);
        $illustrationsParAc    = $this->illustrationModel->findGroupedByAcForCompetence($id);

        $this->render('but', [
            'annee'               => $annee,
            'competence'          => $competence,
            'acs'                 => $acs,
            'illustrationsGlobales' => $illustrationsGlobales,
            'illustrationsParAc'  => $illustrationsParAc,
        ]);
    }
}
