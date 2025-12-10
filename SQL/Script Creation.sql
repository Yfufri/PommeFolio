USE pommefolio;

-- Table des utilisateurs (panel admin)
CREATE TABLE IF NOT EXISTS users
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50)  NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE = InnoDB;

-- Table des années (BUT1, BUT2, BUT3)
CREATE TABLE IF NOT EXISTS annees
(
    id    INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(20) NOT NULL
) ENGINE = InnoDB;

-- Table des compétences
CREATE TABLE IF NOT EXISTS competences
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    annee_id    INT          NOT NULL,
    code        VARCHAR(10)  NOT NULL,
    titre       VARCHAR(255) NOT NULL,
    description TEXT,
    CONSTRAINT fk_competences_annees
        FOREIGN KEY (annee_id) REFERENCES annees (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Table des AC
CREATE TABLE IF NOT EXISTS acs
(
    id            INT AUTO_INCREMENT PRIMARY KEY,
    competence_id INT          NOT NULL,
    code          VARCHAR(10)  NOT NULL,
    titre         VARCHAR(255) NOT NULL,
    description   TEXT,
    CONSTRAINT fk_acs_competences
        FOREIGN KEY (competence_id) REFERENCES competences (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Table des illustrations (image/pdf/video/url, globale ou par AC)
CREATE TABLE IF NOT EXISTS illustrations
(
    id            INT AUTO_INCREMENT PRIMARY KEY,
    competence_id INT                                NOT NULL,
    ac_id         INT                                NULL,
    type          ENUM ('image','pdf','video','url') NOT NULL,
    path          VARCHAR(255)                       NOT NULL,
    titre         VARCHAR(255)                       NULL,
    CONSTRAINT fk_illustrations_competences
        FOREIGN KEY (competence_id) REFERENCES competences (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT fk_illustrations_acs
        FOREIGN KEY (ac_id) REFERENCES acs (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Table Culture générale
CREATE TABLE IF NOT EXISTS culture_items
(
    id             INT AUTO_INCREMENT PRIMARY KEY,
    type           VARCHAR(50)  NOT NULL,
    titre          VARCHAR(255) NOT NULL,
    description    TEXT,
    date_evenement DATE         NULL,
    lien           VARCHAR(255) NULL
) ENGINE = InnoDB;
