INSERT INTO role (nom) VALUES ('Administrateur');

INSERT INTO user (prenom, nom, login, password, role_id, adresse, nin, photorecto, photoverso)
VALUES ('Sylla', 'Talla', 'Tsylla', '1234', 1, 'Dakar', '123456789', 'recto.jpg', 'verso.jpg');

INSERT INTO compte (numeros, typecompte, solde, user_id)
VALUES ('CPT001', 'Principal', 10000.00, 1);

INSERT INTO transaction (compte_id, montant, typetransaction, status)
VALUES (1, 5000.00, 'Depos', 'En_cours');