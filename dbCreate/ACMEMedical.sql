

DROP DATABASE IF EXISTS ACMEMedical;

CREATE DATABASE IF NOT EXISTS ACMEMedical;

USE ACMEMedical;

-- Create patients table
CREATE TABLE IF NOT EXISTS patients (
    patient_id INT AUTO_INCREMENT NOT NULL UNIQUE,
    patient_first_name VARCHAR(100) NOT NULL,
    patient_last_name VARCHAR(100) NOT NULL,
    gender CHAR(6) NOT NULL CHECK (gender IN ('Male', 'Female', 'Other')),
    birthdate DATE NOT NULL,
    genetics VARCHAR(255),
    diabetes CHAR(3) NOT NULL CHECK (diabetes IN ('Yes', 'No')),
    other_conditions VARCHAR(255),
    PRIMARY KEY (patient_id)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

-- Insert sample data into patients table
INSERT INTO patients (patient_first_name, patient_last_name, gender, birthdate, genetics, diabetes, other_conditions) VALUES
    ('Natalie', 'Reed', 'Female', '1985-05-22', 'Family history of asthma', 'No', NULL),
    ('Daniel', 'Chen', 'Male', '1992-11-03', 'Brown eyes, lactose intolerant', 'Yes', 'Mild hypertension'),
    ('Alicia', 'Gomez', 'Female', '2000-01-15', NULL, 'No', NULL),
    ('Jordan', 'Taylor', 'Other', '1998-07-19', 'Tall stature', 'No', 'Chronic migraines'),
    ('Michael', 'Nguyen', 'Male', '1975-02-28', NULL, 'Yes', 'High cholesterol'),
    ('Rebecca', 'Smith', 'Female', '1988-12-10', 'Curly hair gene', 'No', NULL),
    ('James', 'Patel', 'Male', '1967-03-09', 'Asian descent', 'Yes', 'Arthritis'),
    ('Emily', 'Johnson', 'Female', '1995-08-25', NULL, 'No', NULL),
    ('Thomas', 'Lee', 'Male', '1980-06-30', 'Freckles, red hair', 'No', 'Seasonal allergies'),
    ('Sophie', 'Martinez', 'Female', '1999-04-07', NULL, 'Yes', 'Hypoglycemia');

-- Create doctors table
CREATE TABLE IF NOT EXISTS doctors (
    doctor_id INT AUTO_INCREMENT NOT NULL,
    doctor_first_name VARCHAR(100) NOT NULL,
    doctor_last_name VARCHAR(100) NOT NULL,
    doctor_specialty VARCHAR(255) NOT NULL,
    PRIMARY KEY (doctor_id)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

-- Insert sample data into doctors table
INSERT INTO doctors (doctor_first_name, doctor_last_name, doctor_specialty) VALUES
    ('Karen', 'Lopez', 'Pulmonology'),
    ('David', 'Miller', 'Internal Medicine'),
    ('Sarah', 'Green', 'Family Practice'),
    ('Brian', 'Anderson', 'Pediatrics'),
    ('Laura', 'Turner', 'Cardiology'),
    ('Steven', 'Hall', 'Endocrinology'),
    ('Rachel', 'Scott', 'Gastroenterology'),
    ('Anthony', 'Ward', 'Allergy & Immunology'),
    ('Lisa', 'Price', 'General Practice'),
    ('Robert', 'King', 'Psychiatry');

-- Create medications table
CREATE TABLE IF NOT EXISTS medications (
    medication_id INT AUTO_INCREMENT NOT NULL UNIQUE,
    medication_name VARCHAR(100) NOT NULL,
    medication_type VARCHAR(255),
    medication_dosage VARCHAR(255) NOT NULL,
    medication_quantity INT NOT NULL,
    medication_frequency CHAR(3) CHECK (medication_frequency IN ('QD', 'BID', 'TID', 'QHS')),
    PRIMARY KEY (medication_id)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

-- Insert sample data into medications table
INSERT INTO medications (medication_name, medication_type, medication_dosage, medication_quantity, medication_frequency) VALUES
    ('Vest', 'Therapeutic Device', 'N/A', 1, NULL),
    ('Acapella', 'Respiratory Device', 'N/A', 1, 'BID'),
    ('Pulmozyme', 'Enzyme Replacement', '2.5mg', 30, 'QD'),
    ('Inhaled Tobi', 'Antibiotic', '300mg', 56, 'BID'),
    ('Inhaled Colistin', 'Antibiotic', '1 million IU', 60, 'BID'),
    ('Hypertonic Saline', 'Solution', '3% solution', 30, 'BID'),
    ('Hypertonic Saline', 'Solution', '7% solution', 30, 'BID'),
    ('Azithromycin', 'Antibiotic', '250mg', 30, 'QD'),
    ('Clarithromycin', 'Antibiotic', '500mg', 14, 'BID'),
    ('Inhaled Gentamicin', 'Antibiotic', '80mg', 30, 'BID'),
    ('Enzymes', 'Digestive Aid', 'Creon 2400', 90, NULL);

-- Create prescriptions table
CREATE TABLE IF NOT EXISTS prescriptions (
    prescription_id INT AUTO_INCREMENT NOT NULL UNIQUE,
    medication_id INT NOT NULL,
    patient_id INT NOT NULL,
    prescription_lot_num VARCHAR(100) NOT NULL,
    prescription_expiration_date DATE NOT NULL,
    PRIMARY KEY (prescription_id),
    CONSTRAINT prescription_FK1 FOREIGN KEY (medication_id) REFERENCES medications (medication_id),
    CONSTRAINT prescription_FK2 FOREIGN KEY (patient_id) REFERENCES patients (patient_id)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

-- Insert sample data into prescriptions table
INSERT INTO prescriptions (medication_id, patient_id, prescription_lot_num, prescription_expiration_date) VALUES
    (1, 1, 'LOT123', '2025-12-31'),
    (2, 2, 'LOT124', '2025-12-31'),
    (3, 3, 'LOT125', '2025-12-31');

-- Create visits table with expected field names
DROP TABLE IF EXISTS visits;

CREATE TABLE IF NOT EXISTS visits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    visit_date DATE NOT NULL,
    doctor_seen VARCHAR(255),  -- full name of doctor
    fev1_values TEXT,          -- stores string like "3.2L, 3.4L, 3.3L"
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

-- Insert sample data into visits table
INSERT INTO visits (patient_id, visit_date, doctor_seen, fev1_values) VALUES
    (1, '2025-04-24', 'Dr. Karen Lopez', '3.2L, 3.3L, 3.1L'),
    (2, '2025-04-23', 'Dr. David Miller', '3.5L, 3.4L, 3.6L'),
    (3, '2025-04-22', 'Dr. Sarah Green', '4.0L, 4.1L, 4.0L');

CREATE USER IF NOT EXISTS "kermit"@"localhost" IDENTIFIED BY "sesame";
