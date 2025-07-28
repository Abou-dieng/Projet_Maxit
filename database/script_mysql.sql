
CREATE TABLE IF NOT EXISTS role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS `user` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prenom VARCHAR(100),
    nom VARCHAR(100),
    login VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role_id INT,
    adresse VARCHAR(255),
    nin VARCHAR(50),
    photorecto VARCHAR(255),
    photoverso VARCHAR(255),
    FOREIGN KEY (role_id) REFERENCES role(id)
);

CREATE TABLE IF NOT EXISTS compte (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numeros VARCHAR(100) UNIQUE,
    typecompte ENUM('Principal', 'Secondaire'),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    solde DECIMAL(15,2) DEFAULT 0,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES `user`(id)
);

CREATE TABLE IF NOT EXISTS `transaction` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    compte_id INT,
    user_id INT,
    montant DECIMAL(15,2) NOT NULL,
    typetransaction ENUM('Depos', 'Retrait', 'Paiement'),
    status ENUM('En_cours', 'terminer', 'Annuler'),
    FOREIGN KEY (compte_id) REFERENCES compte(id),
    FOREIGN KEY (user_id) REFERENCES `user`(id)
);
