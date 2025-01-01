-- Creazione del database
CREATE DATABASE IF NOT EXISTS gpersone;
USE gpersone;

-- Tabella ruoli
CREATE TABLE IF NOT EXISTS ruoli (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) UNIQUE NOT NULL
);

-- Inserimento dei ruoli
INSERT INTO ruoli (nome) VALUES ('Amministratore'), ('Utente');

-- Tabella anagrafiche
CREATE TABLE IF NOT EXISTS anagrafiche (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50),
    cognome VARCHAR(90),
    sesso ENUM('M', 'F', 'ND') NOT NULL,
    nas_luogo VARCHAR(50),
    nas_regione VARCHAR(40),
    nas_prov VARCHAR(2),
    nas_cap VARCHAR(5),
    data_nascita DATE,
    cod_fiscale VARCHAR(16) UNIQUE NOT NULL,
    res_luogo VARCHAR(50),
    res_regione VARCHAR(40),
    res_prov VARCHAR(2),
    res_cap VARCHAR(5),
    indirizzo VARCHAR(90),
    telefono VARCHAR(15),
    email VARCHAR(60) UNIQUE,
    pass_email VARCHAR(255),
    id_ruolo INT NOT NULL,
    FOREIGN KEY (id_ruolo) REFERENCES ruoli(id) ON DELETE RESTRICT
);

-- Tabella nuclei familiari
CREATE TABLE IF NOT EXISTS nuclei_familiari (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_nucleo VARCHAR(100),
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabella relazioni familiari
CREATE TABLE IF NOT EXISTS relazioni_familiari (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_persona INT NOT NULL,
    id_nucleo INT NOT NULL,
    grado_parentela VARCHAR(50) NOT NULL,
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_persona) REFERENCES anagrafiche(id) ON DELETE CASCADE,
    FOREIGN KEY (id_nucleo) REFERENCES nuclei_familiari(id) ON DELETE CASCADE
);

-- Tabella notifiche
CREATE TABLE IF NOT EXISTS notifiche (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_richiedente INT NOT NULL,
    cf_target VARCHAR(16) NOT NULL,
    grado_parentela_proposto VARCHAR(50),
    stato ENUM('In attesa', 'Approvata', 'Rifiutata') DEFAULT 'In attesa',
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_richiedente) REFERENCES anagrafiche(id) ON DELETE CASCADE
);

-- Dati di esempio nella tabella Anagrafiche
INSERT INTO anagrafiche (nome, cognome, sesso, nas_luogo, nas_regione, nas_prov, nas_cap, data_nascita, cod_fiscale, res_luogo, res_regione, res_prov, res_cap, indirizzo, telefono, email, pass_email, id_ruolo)
VALUES 
('Isaia', 'Busana', 'M', 'Bellegra', 'Lazio', 'RM', '00030', '1934-08-28', 'BSNSIA34M28A749L', 'Volpeglino', 'Piemonte', 'AL', '15050', 'Via G.Di Breganze, 19', '0131/949127', 'isaia.busana@lycos.it', 'OI35yatfT24C', 1),
('Dionigi', 'Zen', 'M', 'Riva del Garda', 'Trentino Alto Adige', 'TN', '38066', '2017-11-21', 'ZNEDNG17S21H330J', 'Carapelle', 'Puglia', 'FG', '71041', 'Via G.Keplero, 278', '0881/479753', NULL, 'LY55qwnqM14V', 2),
('Gesualdo', 'Luis', 'M', 'Loiano', 'Emilia Romagna', 'BO', '40050', '1982-04-30', 'LSUGLD82D30E655Q', 'Moliterno', 'Basilicata', 'PZ', '85047', 'Via I.Lanza, 29/g', '0971/203262', 'g.luis@gmail.it', 'XA21keiuJ68E', 2),
('Ausilia', 'Ghidoni', 'F', 'Molise', 'Molise', 'CB', '86020', '1997-08-04', 'GHDSLA97M44F294I', 'Carrù', 'Piemonte', 'CN', '12061', 'Via A.Brofferio, 89', '0173/169365', 'a.ghidoni@gmail.it', 'EW37xtppX46B', 2),
('Pierluigi', 'Bisio', 'M', 'Bova', 'Calabria', 'RC', '89033', '1938-08-14', 'BSIPLG38M14B097D', 'Montebello Vicentino', 'Veneto', 'VI', '36054', 'Via A.Greppi, 295', '0444/799978', 'pierluigi.bisio@katamail.it', 'KY08xrhmY44N', 2);

-- Tabella per le sessioni
CREATE TABLE IF NOT EXISTS sessions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  token VARCHAR(255) NOT NULL,
  user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES anagrafiche(id) ON DELETE CASCADE
);
