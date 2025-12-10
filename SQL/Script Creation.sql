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
    lien           VARCHAR(255) NULL,
    image          VARCHAR(255) NULL
) ENGINE = InnoDB;

INSERT INTO culture_items (type, titre, description, date_evenement, image)
VALUES ('Lecture Personnelle',
        'Les Misérables',
        'Auteur : Victor Hugo
Les Misérables m’ont surtout marqué par la façon dont le roman mêle misère sociale et espoir de rédemption : à travers Jean Valjean, on sent qu’un simple geste de bonté peut bouleverser une vie, et que la littérature peut rendre très concrètes des notions de justice et de solidarité qu’on aborde souvent de façon abstraite.',
        '2025-12-10',
        'uploads/culture/lesMiserables.jpg');

INSERT INTO culture_items (type, titre, description, date_evenement, image)
VALUES ('Lecture Personnelle',
        'Fight Club',
        'Auteur : Chuck Palahniuk
Fight Club m’a donné l’impression de revoir certains cours de philo de terminale en version survoltée : la crise d’identité, la révolte contre une société de consommation vide de sens, et surtout cette manière de faire douter de ce qui est vraiment réel ou simplement produit par notre imagination.',
        '2025-12-10',
        'uploads/culture/fight-club.jpg');

INSERT INTO culture_items (type, titre, description, date_evenement, image)
VALUES ('Lecture Personnelle',
        'La Peste',
        'Auteur : Albert Camus
La Peste m’a rappelé le malaise du Covid : cette même ville qui se referme, ces gestes du quotidien soudain suspects, et pourtant, au milieu de l’absurde et de la peur, une petite obstination à rester humain ensemble.',
        '2025-12-10',
        'uploads/culture/la-peste.png');

INSERT INTO culture_items (type, titre, description, date_evenement, lien, image)
VALUES ('Sport',
        'Handball',
        'Entrainement de handball tout les mardis soirs avec le SUAPS de l/université.',
        '2025-12-10',
        'https://mon-ent-etudiant.univ-lemans.fr/_resource/Ca-bouge/Planning%20des%20activit%C3%A9s%20SUAPS%20Laval.pdf',
        'uploads/culture/la-peste.png');

INSERT INTO culture_items (type, titre, description, date_evenement, lien, image)
VALUES ('Voyage',
        'Voyage à Paris avec ma Promo',
        'Lors de notre sortie d’une journée à Paris, notre groupe de BUT Informatique a eu l’opportunité de découvrir plusieurs lieux emblématiques de la capitale, alliant histoire, culture et patrimoine.',
        '2025-12-10',
        'voyage-paris',
        'uploads/culture/CoverParis.PNG');

INSERT INTO culture_items (type, titre, description, date_evenement, image)
VALUES ('Géographie',
        'Connaissances Géographiques Européennes',
        'Je connais le nom, le drapeau, et la localisation de tout les pays européens, ainsi que la majorité des capitales.',
        '2025-12-10',
        'uploads/culture/europe.png');

INSERT INTO culture_items (type, titre, description, date_evenement, image)
VALUES ('Permis',
        'Permis Moto',
        'En 2025, j''ai passé mon permis A2 (Moto) et fait l''acquisition de mon premier deux-roues.
Ce projet a été entièrement autofinancé grâce à un emploi en restauration rapide, exercé en parallèle de ma formation.',
        '2025-12-10',
        'uploads/culture/moto.PNG');

