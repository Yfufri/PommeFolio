CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE annees (
  id INT AUTO_INCREMENT PRIMARY KEY,
  label VARCHAR(20) NOT NULL
);

CREATE TABLE competences (
  id INT AUTO_INCREMENT PRIMARY KEY,
  annee_id INT NOT NULL,
  code VARCHAR(10) NOT NULL,
  titre VARCHAR(255) NOT NULL,
  description TEXT,
  CONSTRAINT fk_competences_annees
    FOREIGN KEY (annee_id) REFERENCES annees(id)
    ON DELETE CASCADE
);

CREATE TABLE acs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  competence_id INT NOT NULL,
  code VARCHAR(10) NOT NULL,
  titre VARCHAR(255) NOT NULL,
  description TEXT,
  CONSTRAINT fk_acs_competences
    FOREIGN KEY (competence_id) REFERENCES competences(id)
    ON DELETE CASCADE
);

CREATE TABLE illustrations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  competence_id INT NOT NULL,
  ac_id INT NULL,
  type ENUM('image','pdf','video','url') NOT NULL,
  path VARCHAR(255) NOT NULL,
  titre VARCHAR(255) NULL,
  CONSTRAINT fk_illustrations_competences
    FOREIGN KEY (competence_id) REFERENCES competences(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_illustrations_acs
    FOREIGN KEY (ac_id) REFERENCES acs(id)
    ON DELETE CASCADE
);

-- Utilisateur admin très simple
INSERT INTO users (username, password)
VALUES ('admin', 'monmotdepasse');  -- tu pourras remplacer par un hash plus tard

-- Années
INSERT INTO annees (label) VALUES ('BUT1'), ('BUT2'), ('BUT3');

-- Exemple de compétence BUT1
INSERT INTO competences (annee_id, code, titre, description)
VALUES (1, 'C1', 'Installer et configurer un système', 'Compétence 1 de BUT1 sur l’installation et la configuration.');

-- Exemple d’AC pour cette compétence
INSERT INTO acs (competence_id, code, titre, description)
VALUES
(1, 'AC1', 'Utiliser un terminal', 'Maîtrise des commandes de base du terminal.'),
(1, 'AC2', 'Installer un OS', 'Installation d’un système d’exploitation sur une machine.'),
(1, 'AC3', 'Installer des applications', 'Installation et gestion des applications sur l’OS.');

-- Illustration globale à la compétence (ex : PDF)
INSERT INTO illustrations (competence_id, ac_id, type, path, titre)
VALUES (1, NULL, 'pdf', 'assets/pdf/guide_vm_linux.pdf', 'Guide VM Linux');

-- Illustration spécifique à une AC (ex : image pour AC1)
INSERT INTO illustrations (competence_id, ac_id, type, path, titre)
VALUES (1, 1, 'image', 'assets/img/terminal_screen.png', 'Capture d’écran terminal');
