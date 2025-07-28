DO $$ BEGIN
    CREATE TYPE type_compte AS ENUM ('Principal', 'Secondaire');
EXCEPTION
    WHEN duplicate_object THEN null;
END $$;

DO $$ BEGIN
    CREATE TYPE type_status_transaction AS ENUM ('En_cours', 'Termine', 'Annuler');
EXCEPTION
    WHEN duplicate_object THEN null;
END $$;

DO $$ BEGIN
    CREATE TYPE type_transaction AS ENUM ('Depos', 'Retrait', 'Paiement');
EXCEPTION
    WHEN duplicate_object THEN null;
END $$;

CREATE TABLE IF NOT EXISTS role (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS "users" (
    id SERIAL PRIMARY KEY,
    prenom VARCHAR(100),
    nom VARCHAR(100),
    login VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role_id INTEGER REFERENCES role(id),
    adresse VARCHAR(255),
    nin VARCHAR(50),
    date_naissance DATE NOT NULL,
    lieu_naissance VARCHAR(100),
    copie_cni VARCHAR(255),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP);



CREATE TABLE IF NOT EXISTS compte (
    id SERIAL PRIMARY KEY,
    numeros VARCHAR(100) UNIQUE,
    typecompte type_compte,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    solde NUMERIC(15,2) DEFAULT 0,
    user_id INTEGER REFERENCES "users"(id)
);



CREATE TABLE IF NOT EXISTS transaction (
    id SERIAL PRIMARY KEY,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    compte_id INTEGER REFERENCES compte(id),
    montant NUMERIC(15,2) NOT NULL,
    typetransaction type_transaction,
    status type_status_transaction
);

-- Insertion des rôles de base
INSERT INTO role (id, nom) 
SELECT 1, 'Client' 
WHERE NOT EXISTS (SELECT 1 FROM role WHERE id = 1);

INSERT INTO role (id, nom) 
SELECT 2, 'Commercial' 
WHERE NOT EXISTS (SELECT 1 FROM role WHERE id = 2);
