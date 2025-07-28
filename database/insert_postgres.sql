-- Étape 1 : insérer les rôles
INSERT INTO role (id, nom) VALUES 
(1, 'Client'),
(2, 'Commercial')
ON CONFLICT (id) DO NOTHING;

-- Étape 2 : insérer des utilisateurs
INSERT INTO "users" (id, prenom, nom, login, password, role_id, adresse, nin,date_naissance, lieu_naissance)
VALUES 
(1, 'Amadou', 'Ba', 'amadou.ba', 'hashedpass1', 1, 'Dakar', '1999000100001','1992-01-19', 'Dakar'),
(2, 'Fatou', 'Diop', 'fatou.diop', 'hashedpass2', 2, 'Thiès', '1998000200002','2000-01-19' , 'Thiès');

-- Étape 3 : insérer les comptes (doivent référencer des `user_id` valides)
INSERT INTO compte (id, numeros, typecompte, solde, user_id)
VALUES
(1, 'CP001', 'Principal', 50000, 1),
(2, 'CP002', 'Secondaire', 25000, 2);

-- Étape 4 : insérer des transactions (doivent référencer des `compte_id` valides)
INSERT INTO transaction (compte_id, montant, typetransaction, status)
VALUES
(1, 10000, 'Depos', 'Termine'),
(2, 5000, 'Retrait', 'En_cours');
