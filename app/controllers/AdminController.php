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
            $this->redirect('../competences');
        }

        $data = [
            'annee_id'   => (int) ($_POST['annee_id'] ?? 0),
            'code'       => trim($_POST['code'] ?? ''),
            'titre'      => trim($_POST['titre'] ?? ''),
            'description'=> trim($_POST['description'] ?? ''),
        ];

        $this->competenceModel->create($data);

        $this->redirect('../competences');
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
            $this->redirect('../competences');
        }

        $id = (int) ($_POST['id'] ?? 0);

        $data = [
            'annee_id'   => (int) ($_POST['annee_id'] ?? 0),
            'code'       => trim($_POST['code'] ?? ''),
            'titre'      => trim($_POST['titre'] ?? ''),
            'description'=> trim($_POST['description'] ?? ''),
        ];

        $this->competenceModel->update($id, $data);

        $this->redirect('../competences');
    }

    public function competencesDelete(): void
    {
        $this->requireLogin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($id > 0) {
            $this->competenceModel->delete($id);
        }

        $this->redirect('../competences');
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
            $this->redirect('competences');
        }

        $data = [
            'competence_id' => (int) ($_POST['competence_id'] ?? 0),
            'code'          => trim($_POST['code'] ?? ''),
            'titre'         => trim($_POST['titre'] ?? ''),
            'description'   => trim($_POST['description'] ?? ''),
        ];

        $this->acModel->create($data);

        $this->redirect('../competences/manage?id=' . $data['competence_id']);
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
            $this->redirect('../admin/competences');
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
            $this->redirect('../admin/competences/manage?id=' . (int) $ac['competence_id']);
        }

        $this->redirect('../admin/competences');
    }

    public function acDelete(): void
    {
        $this->requireLogin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $ac = $this->acModel->findById($id);

        if ($ac) {
            $competenceId = (int) $ac['competence_id'];
            $this->acModel->delete($id);
            $this->redirect('../competences/manage?id=' . $competenceId);
        }

        $this->redirect('../competences');
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
        $acId         = ($scope === 'ac' && !empty($_POST['ac_id'])) ? (int) $_POST['ac_id'] : null;
        $type         = $_POST['type'] ?? 'image';
        $titre        = trim($_POST['titre'] ?? '');

        $path = '';

        // Gestion de l'upload
        if (!empty($_FILES['file_upload']['name']) && $_FILES['file_upload']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/assets/uploads/';

            // Créer le dossier s'il n'existe pas
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Sécuriser le nom du fichier (timestamp + nom d'origine nettoyé)
            $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES['file_upload']['name']));
            $targetPath = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $targetPath)) {
                $path = 'assets/uploads/' . $filename;
            }
        }
        // Si pas d'upload, on regarde si une URL est fournie
        elseif (!empty($_POST['url'])) {
            $path = trim($_POST['url']);
        }

        if ($path === '') {
            $this->redirect('../illustrations?competence_id=' . $competenceId);
            return;
        }

        $this->illustrationModel->create([
            'competence_id' => $competenceId,
            'ac_id'         => $acId,
            'type'          => $type,
            'path'          => $path,
            'titre'         => $titre,
        ]);

        $this->redirect('../illustrations?competence_id=' . $competenceId);
    }

    public function illustrationsDelete(): void
    {
        $this->requireLogin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $illu = $this->illustrationModel->findById($id);

        if ($illu) {
            $competenceId = (int) $illu['competence_id'];
            $this->illustrationModel->delete($id);
            $this->redirect('../illustrations?competence_id=' . $competenceId);
        }

        $this->redirect('../illustrations?competence_id=' . $competenceId);
    }

    /* -------- Culture -------- */

    public function cultureList(): void
    {
        $this->requireLogin();

        $items = $this->cultureModel->findAll();
        $this->render('admin/culture-list', [
            'items' => $items,
        ]);
    }

    public function cultureCreateForm(): void
    {
        $this->requireLogin();

        $this->render('admin/culture-form', [
            'mode' => 'create',
            'item' => [],
        ]);
    }

    public function cultureStore(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../culture');
        }

        $dateRaw = trim($_POST['date_evenement'] ?? '');

        $data = [
            'type'           => trim($_POST['type'] ?? ''),
            'titre'          => trim($_POST['titre'] ?? ''),
            'description'    => trim($_POST['description'] ?? ''),
            'date_evenement' => $dateRaw !== '' ? $dateRaw : null,
            'lien'           => trim($_POST['lien'] ?? '') ?: null,
            'image'          => trim($_POST['image'] ?? '') ?: null,
        ];

        $this->cultureModel->create($data);

        $this->redirect('../culture');
    }

    public function cultureEditForm(): void
    {
        $this->requireLogin();

        $id   = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $item = $this->cultureModel->findById($id);

        if (!$item) {
            (new ErrorController())->notFound();
            return;
        }

        $this->render('admin/culture-form', [
            'mode' => 'edit',
            'item' => $item,
        ]);
    }

    public function cultureUpdate(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../culture');
        }

        $id      = (int) ($_POST['id'] ?? 0);
        $dateRaw = trim($_POST['date_evenement'] ?? '');

        $data = [
            'type'           => trim($_POST['type'] ?? ''),
            'titre'          => trim($_POST['titre'] ?? ''),
            'description'    => trim($_POST['description'] ?? ''),
            'date_evenement' => $dateRaw !== '' ? $dateRaw : null,
            'lien'           => trim($_POST['lien'] ?? '') ?: null,
            'image'          => trim($_POST['image'] ?? '') ?: null,
        ];

        $this->cultureModel->update($id, $data);

        $this->redirect('../culture');
    }

    public function cultureDelete(): void
    {
        $this->requireLogin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($id > 0) {
            $this->cultureModel->delete($id);
        }

        $this->redirect('../culture');
    }
}
