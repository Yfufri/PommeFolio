<?php

class AdminController extends BaseController
{
    private Annee $anneeModel;
    private Competence $competenceModel;
    private Ac $acModel;
    private Illustration $illustrationModel;
    private Culture $cultureModel;

    public function __construct()
    {
        $this->anneeModel        = new Annee();
        $this->competenceModel   = new Competence();
        $this->acModel           = new Ac();
        $this->illustrationModel = new Illustration();
        $this->cultureModel      = new Culture();
    }

    /* -------- Dashboard -------- */

    public function index(): void
    {
        $this->requireLogin();

        $stats = [
            'competences' => $this->competenceModel->countAll(),
            'acs'         => $this->acModel->countAll(),
            'illustrations' => $this->illustrationModel->countAll(),
        ];

        $this->render('admin/dashboard', [
            'stats' => $stats,
        ]);
    }



    /* -------- Compétences -------- */

    public function competencesList(): void
    {
        $this->requireLogin();

        $competences = $this->competenceModel->getAllWithAnnee();
        $this->render('admin/competences-list', [
            'competences' => $competences,
        ]);
    }

    public function competencesCreateForm(): void
    {
        $this->requireLogin();

        $annees = $this->anneeModel->findAll();

        $this->render('admin/competences-form', [
            'mode'       => 'create',
            'annees'     => $annees,
            'competence' => [],
        ]);
    }

    public function competencesStore(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/competences');
        }

        $data = [
            'annee_id'   => (int) ($_POST['annee_id'] ?? 0),
            'code'       => trim($_POST['code'] ?? ''),
            'titre'      => trim($_POST['titre'] ?? ''),
            'description'=> trim($_POST['description'] ?? ''),
        ];

        $this->competenceModel->create($data);

        $this->redirect('/admin/competences');
    }

    public function competencesEditForm(): void
    {
        $this->requireLogin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $competence = $this->competenceModel->findById($id);

        if (!$competence) {
            (new ErrorController())->notFound();
            return;
        }

        $annees = $this->anneeModel->findAll();

        $this->render('admin/competences-form', [
            'mode'       => 'edit',
            'annees'     => $annees,
            'competence' => $competence,
        ]);
    }

    public function competencesUpdate(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/competences');
        }

        $id = (int) ($_POST['id'] ?? 0);

        $data = [
            'annee_id'   => (int) ($_POST['annee_id'] ?? 0),
            'code'       => trim($_POST['code'] ?? ''),
            'titre'      => trim($_POST['titre'] ?? ''),
            'description'=> trim($_POST['description'] ?? ''),
        ];

        $this->competenceModel->update($id, $data);

        $this->redirect('/admin/competences');
    }

    public function competencesDelete(): void
    {
        $this->requireLogin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($id > 0) {
            $this->competenceModel->delete($id);
        }

        $this->redirect('/admin/competences');
    }

    // Gérer une compétence (AC + illustrations)
    public function competencesManage(): void
    {
        $this->requireLogin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $competence = $this->competenceModel->findById($id);

        if (!$competence) {
            (new ErrorController())->notFound();
            return;
        }

        $acs = $this->acModel->findByCompetence($id);

        $this->render('admin/acs-list', [
            'competence' => $competence,
            'acs'        => $acs,
        ]);
    }

    /* -------- AC -------- */

    public function acCreateForm(): void
    {
        $this->requireLogin();

        $competenceId = isset($_GET['competence_id']) ? (int) $_GET['competence_id'] : 0;
        $competence   = $this->competenceModel->findById($competenceId);

        if (!$competence) {
            (new ErrorController())->notFound();
            return;
        }

        $this->render('admin/acs-form', [
            'mode'       => 'create',
            'competence' => $competence,
            'ac'         => [],
        ]);
    }

    public function acStore(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/competences');
        }

        $data = [
            'competence_id' => (int) ($_POST['competence_id'] ?? 0),
            'code'          => trim($_POST['code'] ?? ''),
            'titre'         => trim($_POST['titre'] ?? ''),
            'description'   => trim($_POST['description'] ?? ''),
        ];

        $this->acModel->create($data);

        $this->redirect('/admin/competences/manage?id=' . $data['competence_id']);
    }

    public function acEditForm(): void
    {
        $this->requireLogin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $ac = $this->acModel->findById($id);

        if (!$ac) {
            (new ErrorController())->notFound();
            return;
        }

        $competence = $this->competenceModel->findById((int) $ac['competence_id']);

        $this->render('admin/acs-form', [
            'mode'       => 'edit',
            'competence' => $competence,
            'ac'         => $ac,
        ]);
    }

    public function acUpdate(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/competences');
        }

        $id = (int) ($_POST['id'] ?? 0);

        $data = [
            'code'        => trim($_POST['code'] ?? ''),
            'titre'       => trim($_POST['titre'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
        ];

        $ac = $this->acModel->findById($id);
        if ($ac) {
            $this->acModel->update($id, $data);
            $this->redirect('/admin/competences/manage?id=' . (int) $ac['competence_id']);
        }

        $this->redirect('/admin/competences');
    }

    public function acDelete(): void
    {
        $this->requireLogin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $ac = $this->acModel->findById($id);

        if ($ac) {
            $competenceId = (int) $ac['competence_id'];
            $this->acModel->delete($id);
            $this->redirect('/admin/competences/manage?id=' . $competenceId);
        }

        $this->redirect('/admin/competences');
    }

    /* -------- Illustrations -------- */

    public function illustrationsManage(): void
    {
        $this->requireLogin();

        $competenceId = isset($_GET['competence_id']) ? (int) $_GET['competence_id'] : 0;
        $acId         = isset($_GET['ac_id']) ? (int) $_GET['ac_id'] : 0;

        $competence = $this->competenceModel->findById($competenceId);
        if (!$competence) {
            (new ErrorController())->notFound();
            return;
        }

        $ac = null;
        if ($acId > 0) {
            $ac = $this->acModel->findById($acId);
        }

        $acsDeLaCompetence = $this->acModel->findByCompetence($competenceId);
        $illustrations     = $this->illustrationModel->findByCompetenceWithAc($competenceId);

        $this->render('admin/illustrations-form', [
            'competence'        => $competence,
            'ac'                => $ac,
            'acsDeLaCompetence' => $acsDeLaCompetence,
            'illustrations'     => $illustrations,
        ]);
    }

    public function illustrationsStore(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin');
        }

        $competenceId = (int) ($_POST['competence_id'] ?? 0);
        $scope        = $_POST['scope'] ?? 'global';
        $acId         = null;

        if ($scope === 'ac') {
            $acId = !empty($_POST['ac_id']) ? (int) $_POST['ac_id'] : null;
        }

        $type  = $_POST['type'] ?? 'image';
        $titre = trim($_POST['titre'] ?? '');

        // Détermine le path depuis upload ou URL
        $path = '';
        if (!empty($_FILES['file_upload']['name'])) {
            $filename = basename($_FILES['file_upload']['name']);
            $target   = 'assets/uploads/' . $filename;
            // A compléter avec les vérifs/moves réels
            move_uploaded_file($_FILES['file_upload']['tmp_name'], __DIR__ . '/../../public/' . $target);
            $path = $target;
        } elseif (!empty($_POST['url'])) {
            $path = trim($_POST['url']);
        }

        if ($path === '') {
            $this->redirect('/admin/illustrations?competence_id=' . $competenceId);
        }

        $this->illustrationModel->create([
            'competence_id' => $competenceId,
            'ac_id'         => $acId,
            'type'          => $type,
            'path'          => $path,
            'titre'         => $titre,
        ]);

        $this->redirect('/admin/illustrations?competence_id=' . $competenceId);
    }

    public function illustrationsDelete(): void
    {
        $this->requireLogin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $illu = $this->illustrationModel->findById($id);

        if ($illu) {
            $competenceId = (int) $illu['competence_id'];
            $this->illustrationModel->delete($id);
            $this->redirect('/admin/illustrations?competence_id=' . $competenceId);
        }

        $this->redirect('/admin');
    }
}
