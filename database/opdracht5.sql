-- ============================================================================
-- Opdracht 5 - BE: J2-P3 User Stories
-- Database Script: Overzicht Geleverde Producten
-- Framework: MVC-pattern met OOP en PDO
-- ============================================================================

DROP DATABASE IF EXISTS opdracht5;
CREATE DATABASE opdracht5;
USE opdracht5;

-- ============================================================================
-- TABEL: Contact
-- ============================================================================
CREATE TABLE Contact (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Straat VARCHAR(100) NOT NULL,
    Huisnummer VARCHAR(10) NOT NULL,
    Postcode VARCHAR(10) NOT NULL,
    Stad VARCHAR(50) NOT NULL,
    IsActief BIT DEFAULT 1,
    Opmerking VARCHAR(250),
    DatumAangemaakt DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- ============================================================================
-- TABEL: Leverancier
-- ============================================================================
CREATE TABLE Leverancier (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Naam VARCHAR(100) NOT NULL,
    ContactPersoon VARCHAR(100) NOT NULL,
    LeverancierNummer VARCHAR(20) UNIQUE NOT NULL,
    Mobiel VARCHAR(15) NOT NULL,
    ContactId INT,
    IsActief BIT DEFAULT 1,
    Opmerking VARCHAR(250),
    DatumAangemaakt DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (ContactId) REFERENCES Contact(Id) ON DELETE SET NULL
);

-- ============================================================================
-- TABEL: Allergen
-- ============================================================================
CREATE TABLE Allergeen (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Naam VARCHAR(50) NOT NULL,
    Omschrijving VARCHAR(200),
    IsActief BIT DEFAULT 1,
    Opmerking VARCHAR(250),
    DatumAangemaakt DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- ============================================================================
-- TABEL: Product
-- ============================================================================
CREATE TABLE Product (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Naam VARCHAR(100) NOT NULL,
    Barcode VARCHAR(20) UNIQUE NOT NULL,
    IsActief BIT DEFAULT 1,
    Opmerking VARCHAR(250),
    DatumAangemaakt DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- ============================================================================
-- TABEL: ProductPerAllergeen (Link table)
-- ============================================================================
CREATE TABLE ProductPerAllergeen (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    ProductId INT NOT NULL,
    AllergeenId INT NOT NULL,
    IsActief BIT DEFAULT 1,
    Opmerking VARCHAR(250),
    DatumAangemaakt DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (ProductId) REFERENCES Product(Id) ON DELETE CASCADE,
    FOREIGN KEY (AllergeenId) REFERENCES Allergeen(Id) ON DELETE CASCADE,
    UNIQUE KEY uc_product_allergeen (ProductId, AllergeenId)
);

-- ============================================================================
-- TABEL: ProductPerLeverancier
-- ============================================================================
CREATE TABLE ProductPerLeverancier (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    LeverancierId INT NOT NULL,
    ProductId INT NOT NULL,
    DatumLevering DATE NOT NULL,
    Aantal INT NOT NULL,
    DatumEerstVolgendeLevering DATE,
    IsActief BIT DEFAULT 1,
    Opmerking VARCHAR(250),
    DatumAangemaakt DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (LeverancierId) REFERENCES Leverancier(Id) ON DELETE CASCADE,
    FOREIGN KEY (ProductId) REFERENCES Product(Id) ON DELETE CASCADE,
    INDEX idx_datum_levering (DatumLevering),
    INDEX idx_product_id (ProductId),
    INDEX idx_leverancier_id (LeverancierId)
);

-- ============================================================================
-- TABEL: Magazijn
-- ============================================================================
CREATE TABLE Magazijn (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    ProductId INT NOT NULL,
    VerpakkingsEenheid DECIMAL(5,2) NOT NULL,
    AantalAanwezig INT,
    IsActief BIT DEFAULT 1,
    Opmerking VARCHAR(250),
    DatumAangemaakt DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (ProductId) REFERENCES Product(Id) ON DELETE CASCADE,
    UNIQUE KEY uc_product_verpakking (ProductId, VerpakkingsEenheid)
);

-- ============================================================================
-- INSERT: Contact Data
-- ============================================================================
INSERT INTO Contact (Straat, Huisnummer, Postcode, Stad) VALUES
('Van Gilslaan', '34', '1045CB', 'Hilvarenbeek'),
('Den Dolderpad', '2', '1067RC', 'Utrecht'),
('Fredo Raalteweg', '257', '1236OP', 'Nijmegen'),
('Bertrand Russellhof', '21', '2034AP', 'Den Haag'),
('Leon van Bonstraat', '213', '145XC', 'Lunteren'),
('Bea van Lingenlaan', '234', '2197FG', 'Sint Pancras');

-- ============================================================================
-- INSERT: Leverancier Data
-- ============================================================================
INSERT INTO Leverancier (Naam, ContactPersoon, LeverancierNummer, Mobiel, ContactId) VALUES
('Venco', 'Bert van Linge', 'L1029384719', '06-28493827', 1),
('Astra Sweets', 'Jasper del Monte', 'L1029284315', '06-39398734', 2),
('Haribo', 'Sven Stalman', 'L1029324748', '06-24383291', 3),
('Basset', 'Joyce Stelterberg', 'L1023845773', '06-48293823', 4),
('De Bron', 'Remco Veenstra', 'L1023857736', '06-34291234', 5),
('Quality Street', 'Johan Nooij', 'L1029234586', '06-23458456', 6),
('Hom Ken Food', 'Hom Ken', 'L1029234599', '06-23458477', NULL);

-- ============================================================================
-- INSERT: Allergeen Data
-- ============================================================================
INSERT INTO Allergeen (Naam, Omschrijving) VALUES
('Gluten', 'Dit product bevat gluten'),
('Gelatine', 'Dit product bevat gelatine'),
('AZO-Kleurstof', 'Dit product bevat AZO-kleurstoffen'),
('Lactose', 'Dit product bevat lactose'),
('Soja', 'Dit product bevat soja');

-- ============================================================================
-- INSERT: Product Data
-- ============================================================================
INSERT INTO Product (Naam, Barcode) VALUES
('Mintnopjes', '8719587231278'),
('Schoolkrijt', '8719587326713'),
('Honingdrop', '8719587327836'),
('Zure Beren', '8719587321441'),
('Cola Flesjes', '8719587321237'),
('Turtles', '8719587322245'),
('Witte Muizen', '8719587328256'),
('Reuzen Slangen', '8719587325641'),
('Zoute Rijen', '8719587322739'),
('Winegums', '8719587327527'),
('Drop Munten', '8719587322345'),
('Kruis Drop', '8719587322265'),
('Zoute Ruitjes', '8719587323256'),
('Drop ninja\'s', '8719587323277');

-- ============================================================================
-- INSERT: ProductPerAllergeen Data
-- ============================================================================
INSERT INTO ProductPerAllergeen (ProductId, AllergeenId) VALUES
(1, 2), (1, 1), (1, 3),
(3, 4),
(6, 5),
(9, 2), (9, 5),
(10, 2),
(12, 4),
(13, 1), (13, 4), (13, 5),
(14, 5);

-- ============================================================================
-- INSERT: ProductPerLeverancier Data
-- ============================================================================
INSERT INTO ProductPerLeverancier (LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering) VALUES
(1, 1, '2023-04-09', 23, '2023-04-16'),
(1, 1, '2023-04-18', 21, '2023-04-25'),
(1, 2, '2023-04-09', 12, '2023-04-16'),
(1, 3, '2023-04-10', 11, '2023-04-17'),
(2, 4, '2023-04-14', 16, '2023-04-21'),
(2, 4, '2023-04-21', 23, '2023-04-28'),
(2, 5, '2023-04-14', 45, '2023-04-21'),
(2, 6, '2023-04-14', 30, '2023-04-21'),
(3, 7, '2023-04-12', 12, '2023-04-19'),
(3, 7, '2023-04-19', 23, '2023-04-26'),
(3, 8, '2023-04-10', 12, '2023-04-17'),
(3, 9, '2023-04-11', 1, '2023-04-18'),
(4, 10, '2023-04-16', 24, '2023-04-30'),
(5, 11, '2023-04-10', 47, '2023-04-17'),
(5, 11, '2023-04-19', 60, '2023-04-26'),
(5, 12, '2023-04-11', 45, NULL),
(5, 13, '2023-04-12', 23, NULL),
(7, 14, '2023-04-14', 20, NULL);

-- ============================================================================
-- INSERT: Magazijn Data
-- ============================================================================
INSERT INTO Magazijn (ProductId, VerpakkingsEenheid, AantalAanwezig) VALUES
(1, 5, 453),
(2, 2.5, 400),
(3, 5, 1),
(4, 1, 800),
(5, 3, 234),
(6, 2, 345),
(7, 1, 795),
(8, 10, 233),
(9, 2.5, 123),
(10, 3, NULL),
(11, 2, 367),
(12, 1, 467),
(13, 5, 20);

-- ============================================================================
-- STORED PROCEDURES
-- ============================================================================

-- Stored Procedure: GetProductsByDateRange
DELIMITER $$
CREATE PROCEDURE GetProductsByDateRange(
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT 
        p.Id,
        p.Naam,
        p.Barcode,
        l.Naam AS LeverancierNaam,
        SUM(ppl.Aantal) AS TotalAantal,
        COUNT(DISTINCT ppl.DatumLevering) AS AantalLeveringen
    FROM Product p
    INNER JOIN ProductPerLeverancier ppl ON p.Id = ppl.ProductId
    INNER JOIN Leverancier l ON ppl.LeverancierId = l.Id
    WHERE ppl.DatumLevering BETWEEN p_start_date AND p_end_date
    AND p.IsActief = 1
    AND l.IsActief = 1
    GROUP BY p.Id, p.Naam, p.Barcode, l.Naam
    ORDER BY l.Naam ASC, p.Naam ASC;
END $$
DELIMITER ;

-- Stored Procedure: GetProductSpecification
DELIMITER $$
CREATE PROCEDURE GetProductSpecification(
    IN p_product_id INT,
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT 
        ppl.DatumLevering,
        p.Naam AS ProductNaam,
        l.Naam AS LeverancierNaam,
        ppl.Aantal,
        GROUP_CONCAT(a.Naam SEPARATOR ', ') AS Allergen
    FROM ProductPerLeverancier ppl
    INNER JOIN Product p ON ppl.ProductId = p.Id
    INNER JOIN Leverancier l ON ppl.LeverancierId = l.Id
    LEFT JOIN ProductPerAllergeen ppa ON p.Id = ppa.ProductId
    LEFT JOIN Allergeen a ON ppa.AllergeenId = a.Id
    WHERE ppl.ProductId = p_product_id
    AND ppl.DatumLevering BETWEEN p_start_date AND p_end_date
    AND p.IsActief = 1
    AND l.IsActief = 1
    GROUP BY ppl.DatumLevering, p.Naam, l.Naam, ppl.Aantal
    ORDER BY ppl.DatumLevering DESC;
END $$
DELIMITER ;

-- Stored Procedure: GetAllergensForProduct
DELIMITER $$
CREATE PROCEDURE GetAllergensForProduct(IN p_product_id INT)
BEGIN
    SELECT 
        a.Id,
        a.Naam,
        a.Omschrijving
    FROM Allergeen a
    INNER JOIN ProductPerAllergeen ppa ON a.Id = ppa.AllergeenId
    WHERE ppa.ProductId = p_product_id
    AND a.IsActief = 1
    AND ppa.IsActief = 1;
END $$
DELIMITER ;

-- Stored Procedure: GetProductsWithoutLeveringen
DELIMITER $$
CREATE PROCEDURE GetProductsWithoutLeveringen(
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT COUNT(*) AS HasResults
    FROM Product p
    INNER JOIN ProductPerLeverancier ppl ON p.Id = ppl.ProductId
    WHERE ppl.DatumLevering BETWEEN p_start_date AND p_end_date
    AND p.IsActief = 1;
END $$
DELIMITER ;
