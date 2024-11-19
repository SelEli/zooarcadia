CREATE TABLE Animals ( 

  id INT AUTO_INCREMENT PRIMARY KEY, 

  name VARCHAR(255) NOT NULL, 

  state VARCHAR(255) NOT NULL, 

  race_id INT, 

  habitat_id INT, 

  FOREIGN KEY (race_id) REFERENCES Races(id), 

  FOREIGN KEY (habitat_id) REFERENCES Habitats(id) 

); 

  

CREATE TABLE Comments ( 

  id INT AUTO_INCREMENT PRIMARY KEY, 

  name VARCHAR(255) NOT NULL, 

  comment TEXT NOT NULL, 

  date DATETIME NOT NULL, 

  isVisible BOOLEAN NOT NULL 

); 

  

CREATE TABLE Habitats ( 

  id INT AUTO_INCREMENT PRIMARY KEY, 

  name VARCHAR(255) NOT NULL, 

  description TEXT NOT NULL, 

  comment TEXT 

); 

  

CREATE TABLE Images ( 

  id INT AUTO_INCREMENT PRIMARY KEY, 

  data BLOB NOT NULL, 

  animal_id INT, 

  habitat_id INT, 

  FOREIGN KEY (animal_id) REFERENCES Animals(id), 

  FOREIGN KEY (habitat_id) REFERENCES Habitats(id) 

); 

  

CREATE TABLE Informations ( 

  id INT AUTO_INCREMENT PRIMARY KEY, 

  contactAddress VARCHAR(255) NOT NULL, 

  contactPhone VARCHAR(255) NOT NULL, 

  contactEmail VARCHAR(255) NOT NULL, 

  openingDays VARCHAR(255) NOT NULL, 

  openingHours VARCHAR(255) NOT NULL, 

  adultPrice DECIMAL(10, 2) NOT NULL, 

  childPrice DECIMAL(10, 2) NOT NULL, 

  toddlerPrice DECIMAL(10, 2) NOT NULL, 

  familyPrice DECIMAL(10, 2) NOT NULL, 

  groupPrice DECIMAL(10, 2) NOT NULL, 

  parkingInfo VARCHAR(255) NOT NULL 

); 

  

CREATE TABLE Races ( 

  id INT AUTO_INCREMENT PRIMARY KEY, 

  label VARCHAR(255) NOT NULL 

); 

  

CREATE TABLE Services ( 

  id INT AUTO_INCREMENT PRIMARY KEY, 

  name VARCHAR(255) NOT NULL, 

  description TEXT NOT NULL 

); 

  

CREATE TABLE Users ( 

  id INT AUTO_INCREMENT PRIMARY KEY, 

  name VARCHAR(255) NOT NULL, 

  username VARCHAR(255) NOT NULL, 

  role_id INT NOT NULL, 

  FOREIGN KEY (role_id) REFERENCES UsersRoles(id) 

); 

  

CREATE TABLE UsersRoles ( 

  id INT AUTO_INCREMENT PRIMARY KEY, 

  label VARCHAR(255) NOT NULL 

); 

  

CREATE TABLE Tasks ( 

  id INT AUTO_INCREMENT PRIMARY KEY, 

  name VARCHAR(255) NOT NULL, 

  description VARCHAR(255), 

  createdAt DATETIME DEFAULT CURRENT_TIMESTAMP, 

  dueDate DATE, 

  status VARCHAR(255) NOT NULL, 

  animal_id INT, 

  user_id INT NOT NULL, 

  FOREIGN KEY (animal_id) REFERENCES Animals(id), 

  FOREIGN KEY (user_id) REFERENCES Users(id) 

); 
