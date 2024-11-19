-- Insérer des races 

INSERT INTO Races (label) VALUES  

('Lion'), 

('Tigre'); 

  

-- Insérer des habitats 

INSERT INTO Habitats (name, description, comment) VALUES  

('Savane', 'Une grande plaine herbeuse avec des arbres dispersés.', 'Aucun commentaire'), 

('Forêt Tropicale', 'Une forêt dense, chaude et humide.', 'Aucun commentaire'); 

  

-- Insérer des animaux 

INSERT INTO Animals (name, state, race_id, habitat_id) VALUES  

('Simba', 'En bonne santé', 1, 1), 

('Shere Khan', 'Blessé', 2, 2); 

  

-- Insérer des utilisateurs 

INSERT INTO Users (name, username, role_id) VALUES  

('Alice Dupont', 'alice.dupont@example.com', 1), 

('Bob Martin', 'bob.martin@example.com', 2); 

  

-- Insérer des rôles utilisateurs 

INSERT INTO UsersRoles (label) VALUES  

(ROLE_ADMIN), 

(ROLE_VETERINARIAN), 

('ROLE_EMPLOYEE'); 

  

-- Insérer des tâches 

INSERT INTO Tasks (name, description, createdAt, dueDate, status, animal_id, user_id) VALUES  

('Nourrir Simba', 'Nourrir Simba dans l\'habitat de la savane', '2024-11-19 08:00:00', '2024-11-19', 'En attente', 1, 2), 

('Nettoyer l\'enclos de Shere Khan', 'Nettoyer l\'enclos de la forêt tropicale pour Shere Khan', '2024-11-19 09:00:00', '2024-11-19', 'En cours', 2, 2); 

  

-- Insérer des commentaires 

INSERT INTO Comments (name, comment, date, isVisible) VALUES  

('Visiteur1', 'J\'ai adoré l\'enclos des lions !', '2024-11-19 10:00:00', TRUE), 

('Visiteur2', 'L\'habitat de la forêt tropicale est incroyable.', '2024-11-19 11:00:00', TRUE); 

  

-- Insérer des informations générales 

INSERT INTO Informations (contactAddress, contactPhone, contactEmail, openingDays, openingHours, adultPrice, childPrice, toddlerPrice, familyPrice, groupPrice, parkingInfo) VALUES  

('123 Allée du Zoo', '01-23-45-67-89', 'info@zooarcadia.com', 'Lun-Dim', '09:00 - 18:00', 15.00, 10.00, 5.00, 50.00, 100.00, 'Parking gratuit disponible'); 

  

-- Insérer des services 

INSERT INTO Services (name, description) VALUES  

('Restauration', 'Profitez d\'une variété de plats et de boissons dans nos restaurants.'), 

('Visite des habitats avec guide', 'Visite gratuite des habitats du zoo avec un guide.'), 

('Visite du zoo en petit train', 'Tour du zoo en petit train, idéal pour les enfants et les familles.');


