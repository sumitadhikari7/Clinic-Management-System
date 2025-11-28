-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Nov 28, 2025 at 05:37 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinic_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor` int(11) DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('scheduled','completed','cancelled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `doctor`, `appointment_date`, `appointment_time`, `status`) VALUES
(16, 9, 9, '2025-08-07', '12:00:00', 'completed'),
(18, 18, NULL, '2025-07-31', '19:00:00', 'scheduled'),
(20, 16, 8, '2025-07-15', '16:30:00', 'cancelled'),
(21, 18, 7, '2025-07-25', '21:43:00', 'scheduled'),
(23, 19, NULL, '2025-07-31', '12:30:00', 'scheduled');

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `User` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`User`, `Password`, `role`) VALUES
('admin', '482c811da5d5b4bc6d497ffa98491e38', 'admin'),
('staff', 'de9bf5643eabf80f4a56fda3bbb84483', 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `expiry_date` date NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `received_on` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`item_id`, `item_name`, `category`, `quantity`, `expiry_date`, `supplier_name`, `received_on`, `status`) VALUES
(1, 'Aspirin', 'First Aid', 1200, '2031-06-15', 'MedSupply Pvt Ltd', '2025-06-01', 'Available'),
(2, 'Bandage', 'Equipment', 40, '0000-00-00', 'Hans Pvt Ltd', '2025-07-15', 'Low Stock'),
(3, 'Flexon', 'Medicine', 300, '2029-11-24', 'PharmaExpress', '2025-05-08', 'Available'),
(4, 'Daptomycin', 'Antibiotics', 500, '2028-11-25', 'Pharma X Nepal', '2025-07-30', 'available'),
(5, 'Hep B', 'Vaccine', 20, '2027-10-14', 'Merck & Co.', '2025-07-10', 'Low Stock'),
(7, 'Ciprofloxanin', 'Antibiotics', 50, '2028-10-17', 'PharmaExpress', '2025-07-17', 'Low Stock'),
(8, 'Ibuprofen', 'Medicine', 50, '2026-07-17', 'MedSupply Pvt Ltd', '2025-06-01', 'Low Stock'),
(9, 'Thermometer', 'Equipments', 900, '0000-00-00', 'Hans Pvt Ltd', '2025-07-17', 'Available'),
(10, 'Amoxicillin', 'Antibiotics', 100, '2025-07-02', 'PharmaExpress', '2022-02-17', 'Expired');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `visit_date` date NOT NULL,
  `diagnosis` varchar(100) NOT NULL,
  `medication` varchar(100) NOT NULL,
  `followup_date` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `name`, `age`, `gender`, `address`, `phone`, `visit_date`, `diagnosis`, `medication`, `followup_date`, `status`) VALUES
(8, 'Federico Chiesa', 20, 'male', 'Turin', '+98-54542564', '2025-07-13', 'Muscle Tear', 'Acetaminophen', '2025-07-31', 'discharged'),
(9, 'Reece James', 25, 'male', 'London', '+61-76565445', '2025-07-03', 'Hamstring Injury', 'Muscle Relaxant', '2025-07-13', 'active'),
(16, 'Eden Hazard', 35, 'male', 'Madrid', '+01-9865478', '2025-01-03', 'Ankle Injury', 'Topical analgesics', '2025-03-27', 'active'),
(17, 'Diogo Jota', 29, 'male', 'Liverpool', '+01-9865470', '2025-01-25', 'Rib Injury', 'NSAID', '0000-00-00', 'deceased'),
(18, 'Kylian Mbappe', 26, 'male', 'Madrid', '+01-9865499', '2025-06-18', 'Fever', 'Paracetamol', '0000-00-00', 'inactive'),
(19, 'Marco Reus', 35, 'male', 'California', '+01-87764432', '2025-07-25', 'Knee Injury', 'Acetaminophen', '2025-07-31', 'active'),
(20, 'jhgsay', 76, 'male', 'hgasgyu', '87665564', '2025-07-30', 'bhasbj', 'bandage, cetamol', '2025-07-30', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `staff_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `role` varchar(30) NOT NULL,
  `department` varchar(30) DEFAULT NULL,
  `contact` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `joined` date NOT NULL,
  `status` varchar(30) DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`staff_id`, `name`, `role`, `department`, `contact`, `email`, `joined`, `status`) VALUES
(5, 'Rodrygo Goes', 'Cleaner', '', '+977-687246765', 'goesrodri@gmail.com', '2025-07-17', 'On Leave'),
(6, 'Antonio Rudiger', 'Receptionist', '', '+977-6872467', 'neto@gmail.com', '2025-07-12', 'Available'),
(7, 'Dr. Dean Huijsen', 'Doctor', 'Pediatrics', '+98-87863756', 'deanhuijsen@gmail.com', '2025-07-17', 'Available'),
(8, 'Dr. James Rodriguez', 'Doctor', 'Emergency', '+977-687246766', 'james@gmail.com', '2025-07-01', 'Available'),
(9, 'Dr. Trent Alexander Arnold', 'Doctor', 'Pediatrics', '+977-687246769', 'taa@gmail.com', '2025-07-13', 'On Leave'),
(10, 'Dr. Raul Asencio', 'Doctor', 'Emergency', '+98-87863759', 'raulasencio@gmail.com', '2025-05-01', 'Available'),
(11, 'David Alaba', 'Nurse', 'Emergency', '+977-687246770', 'd_alaba@gmail.com', '2025-07-01', 'Available'),
(12, 'Eduardo Camavinga', 'Pharmacist', NULL, '+98-87863750', 'edu_camavinga@gmail.com', '2025-07-09', 'Available'),
(13, 'Jesus Vallejo', 'Cleaner', NULL, '+977-687246775', 'j_vallejo@gmail.com', '2025-06-05', 'On Leave'),
(17, 'Dr. Vinicius Jr', 'Doctor', 'Pediatrics', '+977-687246777', 'vini7@gmail.com', '2025-07-07', 'Available'),
(18, 'Lamine Yamal', 'Cleaner', NULL, '+02-87762543', 'cleanerlamine@gmail.com', '2025-07-25', 'Available'),
(19, 'Mac Allister', 'Receptionist', NULL, '+09-82564233', 'mallister@gmail.com', '2025-07-26', 'Available');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `fk_appointments_patient` (`patient_id`),
  ADD KEY `fk_appointments_doctor` (`doctor`);

--
-- Indexes for table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`User`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `contact` (`contact`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_appointments_doctor` FOREIGN KEY (`doctor`) REFERENCES `staffs` (`staff_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_appointments_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
