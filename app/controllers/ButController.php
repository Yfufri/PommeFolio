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

    // /but → page explorateur interactif
    public function index()
    {
        // années + compétences
        $annees = $this->anneeModel->getAllWithCompetences();

        // pour chaque compétence, récupérer les AC
        $acsParCompetence = [];
        foreach ($annees as $annee) {
            foreach ($annee['competences'] as $comp) {
                $acsParCompetence[$comp['id']] = $this->acModel->findByCompetence($comp['id']);
            }
        }

        $this->render('but-list', [
            'annees'           => $annees,
            'acsParCompetence' => $acsParCompetence,
        ]);
    }

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
