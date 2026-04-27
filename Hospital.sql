DROP DATABASE IF EXISTS hospital_db;
CREATE DATABASE hospital_db;
USE hospital_db;

CREATE TABLE Department (
    department_id INT AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(100)
);

CREATE TABLE Admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100)
);

CREATE TABLE Patient (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    age INT,
    gender VARCHAR(10),
    phone VARCHAR(15),
    address TEXT
);

CREATE TABLE Doctor (
    doctor_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    specialization VARCHAR(100),
    phone VARCHAR(15),
    department_id INT,
    FOREIGN KEY (department_id) REFERENCES Department(department_id)
);

CREATE TABLE Doctor_Availability (
    availability_id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT,
    date DATE,
    start_time TIME,
    end_time TIME,
    FOREIGN KEY (doctor_id) REFERENCES Doctor(doctor_id)
);

CREATE TABLE Appointment (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    appointment_date DATE,
    appointment_time TIME,
    status VARCHAR(20),
    FOREIGN KEY (patient_id) REFERENCES Patient(patient_id),
    FOREIGN KEY (doctor_id) REFERENCES Doctor(doctor_id)
);

CREATE TABLE Medical_Record (
    record_id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT,
    diagnosis TEXT,
    notes TEXT,
    FOREIGN KEY (appointment_id) REFERENCES Appointment(appointment_id)
);

CREATE TABLE Prescription (
    prescription_id INT AUTO_INCREMENT PRIMARY KEY,
    record_id INT,
    date DATE,
    FOREIGN KEY (record_id) REFERENCES Medical_Record(record_id)
);

CREATE TABLE Medicine (
    medicine_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    price DECIMAL(10,2)
);

CREATE TABLE Prescription_Medicine (
    prescription_id INT,
    medicine_id INT,
    dosage VARCHAR(50),
    duration VARCHAR(50),
    PRIMARY KEY (prescription_id, medicine_id),
    FOREIGN KEY (prescription_id) REFERENCES Prescription(prescription_id),
    FOREIGN KEY (medicine_id) REFERENCES Medicine(medicine_id)
);

CREATE TABLE Lab_Test (
    test_id INT AUTO_INCREMENT PRIMARY KEY,
    test_name VARCHAR(100),
    cost DECIMAL(10,2)
);

CREATE TABLE Patient_Lab_Test (
    appointment_id INT,
    test_id INT,
    result VARCHAR(100),
    PRIMARY KEY (appointment_id, test_id),
    FOREIGN KEY (appointment_id) REFERENCES Appointment(appointment_id),
    FOREIGN KEY (test_id) REFERENCES Lab_Test(test_id)
);

CREATE TABLE Bill (
    bill_id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT,
    total_amount DECIMAL(10,2),
    FOREIGN KEY (appointment_id) REFERENCES Appointment(appointment_id)
);

CREATE TABLE Payment (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    bill_id INT,
    amount DECIMAL(10,2),
    payment_mode VARCHAR(20),
    FOREIGN KEY (bill_id) REFERENCES Bill(bill_id)
);

CREATE TABLE Insurance (
    insurance_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    provider VARCHAR(100),
    FOREIGN KEY (patient_id) REFERENCES Patient(patient_id)
);

CREATE TABLE Feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    rating INT,
    comments TEXT,
    FOREIGN KEY (patient_id) REFERENCES Patient(patient_id),
    FOREIGN KEY (doctor_id) REFERENCES Doctor(doctor_id)
);

-- Sample Data
INSERT INTO Department VALUES
(1,'Cardiology'),
(2,'Dermatology'),
(3,'Orthopedic');

INSERT INTO Doctor VALUES
(1,'Dr Sharukesh','Cardio','9999999991',1),
(2,'Dr Kriti','Skin','9999999992',2),
(3,'Dr Ashima','Bone','9999999993',3);

INSERT INTO Patient VALUES
(1,'Daksh',20,'Male','9999999999','Pune'),
(2,'Adithya',25,'Male','8888888888','Kerala'),
(3,'Jay', 22, 'Male', '9988776655', 'Kolkata'),
(4,'Mreenoual', 35, 'Female', '9090909090', 'Gujarat');

INSERT INTO Medicine VALUES
(1,'Paracetamol',20),
(2,'Ibuprofen',30);

INSERT INTO Lab_Test VALUES
(1,'Blood Test',300),
(2,'X-Ray',700);

DELIMITER //

CREATE PROCEDURE BookAppointment(
    IN p_id INT,
    IN d_id INT,
    IN a_date DATE,
    IN a_time TIME
)
BEGIN
    INSERT INTO Appointment(
        patient_id,
        doctor_id,
        appointment_date,
        appointment_time,
        status
    )
    VALUES(
        p_id,
        d_id,
        a_date,
        a_time,
        'Scheduled'
    );
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER auto_bill
AFTER INSERT ON Appointment
FOR EACH ROW
BEGIN
    INSERT INTO Bill (appointment_id, total_amount)
    VALUES (NEW.appointment_id, 500);
END //

DELIMITER ;

CALL BookAppointment(1,1,'2026-05-02','11:00:00');

SELECT * FROM Appointment;
SELECT * FROM Bill;

CALL BookAppointment(2,2,'2026-05-03','12:00:00');
CALL BookAppointment(1,2,'2026-05-04','01:00:00');

SELECT * FROM Bill;