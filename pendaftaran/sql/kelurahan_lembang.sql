-- First, drop database if it exists
DROP DATABASE IF EXISTS data_daerah;

-- Create database
CREATE DATABASE data_daerah;

-- Use the database
USE data_daerah;

-- Drop tables in correct order (child tables first)
DROP TABLE IF EXISTS kelurahan_lembang;
DROP TABLE IF EXISTS kecamatan;
DROP TABLE IF EXISTS kabupaten;

-- Create Regency (Kabupaten) table
CREATE TABLE kabupaten (
    id VARCHAR(5) PRIMARY KEY,
    name VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Create Districts table
CREATE TABLE kecamatan (
    kemendagri_code VARCHAR(10) PRIMARY KEY,
    kabupaten_id VARCHAR(5) NOT NULL,
    district_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (kabupaten_id) REFERENCES kabupaten(id)
) ENGINE=InnoDB;

-- Create Administrative Areas table
CREATE TABLE kelurahan_lembang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kemendagri_code VARCHAR(10),
    area_name VARCHAR(100) NOT NULL,
    area_type ENUM('Lembang', 'Kelurahan') NOT NULL,
    FOREIGN KEY (kemendagri_code) REFERENCES kecamatan(kemendagri_code)
) ENGINE=InnoDB;

-- Insert Kabupaten data
INSERT INTO kabupaten (id, name) VALUES
('73.18', 'Tana Toraja'),
('73.26', 'Toraja Utara');

-- Insert Districts data
INSERT INTO kecamatan (kemendagri_code, kabupaten_id, district_name) VALUES
-- Tana Toraja
('73.18.31', '73.18', 'Masanda'),
('73.18.33', '73.18', 'Sangalla Selatan'),
('73.18.34', '73.18', 'Sangalla Utara'),
('73.18.35', '73.18', 'Malimbong Balepe'),
('73.18.37', '73.18', 'Rano'),
('73.18.38', '73.18', 'Kurra'),
('73.18.01', '73.18', 'Saluputi'),
('73.18.02', '73.18', 'Bittuang'),
('73.18.03', '73.18', 'Bonggakaradeng'),
('73.18.05', '73.18', 'Makale'),
('73.18.09', '73.18', 'Simbuang'),
('73.18.11', '73.18', 'Rantetayo'),
('73.18.12', '73.18', 'Mengkendek'),
('73.18.13', '73.18', 'Sangalla'),
('73.18.19', '73.18', 'Gandangbatu Sillanan'),
('73.18.20', '73.18', 'Rembon'),
('73.18.27', '73.18', 'Makale Utara'),
('73.18.28', '73.18', 'Mappak'),
('73.18.29', '73.18', 'Makale Selatan'),

-- Toraja Utara
('73.26.21', '73.26', 'Awan Rante Karua'),
('73.26.20', '73.26', 'Kapala Pitu'),
('73.26.19', '73.26', 'Sesean Suloara'),
('73.26.18', '73.26', 'Rantebua'),
('73.26.17', '73.26', 'Bangkelekila'),
('73.26.16', '73.26', 'Tondon'),
('73.26.15', '73.26', 'Kesu'),
('73.26.14', '73.26', 'Baruppu'),
('73.26.13', '73.26', 'Buntu Pepasan'),
('73.26.12', '73.26', 'Dende Piongan Napo'),
('73.26.11', '73.26', 'Tallunglipu'),
('73.26.10', '73.26', 'Balusu'),
('73.26.09', '73.26', 'Tikala'),
('73.26.08', '73.26', 'Sopai'),
('73.26.07', '73.26', 'Sanggalangi'),
('73.26.06', '73.26', 'Sadan'),
('73.26.05', '73.26', 'Buntao'),
('73.26.04', '73.26', 'Rindingallo'),
('73.26.03', '73.26', 'Nanggala'),
('73.26.02', '73.26', 'Sesean'),
('73.26.01', '73.26', 'Rantepao');

-- Insert Administrative Areas data
INSERT INTO kelurahan_lembang (kemendagri_code, area_name, area_type) VALUES
-- Masanda
('73.18.31', 'BelauBelau Utara', 'Lembang'),
('73.18.31', 'Kadundung', 'Lembang'),
('73.18.31', 'Paku', 'Lembang'),
('73.18.31', 'Paliorong', 'Lembang'),
('73.18.31', 'Pondingao', 'Lembang'),
('73.18.31', 'Ratte', 'Lembang'),
('73.18.31', 'Sesesalu', 'Lembang'),

-- Sangalla Selatan
('73.18.33', 'Batualu', 'Lembang'),
('73.18.33', 'Batualu Selatan', 'Lembang'),
('73.18.33', 'Raru Sibunuan', 'Lembang'),
('73.18.33', 'Tokesan', 'Lembang'),
('73.18.33', 'Rante Alang', 'Kelurahan'),

-- Sangalla Utara
('73.18.34', 'Bebo', 'Kelurahan'),
('73.18.34', 'Leatung', 'Kelurahan'),
('73.18.34', 'Leatung Matallo', 'Lembang'),
('73.18.34', 'Rantela''bi Kambisa', 'Lembang'),
('73.18.34', 'Saluallo', 'Lembang'),
('73.18.34', 'Tumbang Datu', 'Lembang'),

-- Malimbong Balepe
('73.18.35', 'Balepe', 'Lembang'),
('73.18.35', 'Kole Barebatu', 'Lembang'),
('73.18.35', 'Kole Sawangan', 'Lembang'),
('73.18.35', 'Lemo Menduruk', 'Lembang'),
('73.18.35', 'Leppan', 'Lembang'),
('73.18.35', 'Malimbong', 'Kelurahan'),

-- Rano
('73.18.37', 'Rano', 'Lembang'),
('73.18.37', 'Rano Tengah', 'Lembang'),
('73.18.37', 'Rano Timur', 'Lembang'),
('73.18.37', 'Rano Utara', 'Lembang'),
('73.18.37', 'Rumandan', 'Lembang'),

-- Kurra
('73.18.38', 'Bambalu', 'Kelurahan'),
('73.18.38', 'Limbong Sangpolo', 'Lembang'),
('73.18.38', 'Lipungan Tanete', 'Lembang'),
('73.18.38', 'Maroson', 'Lembang'),
('73.18.38', 'Rante Kurra', 'Lembang'),
('73.18.38', 'Rante Limbong', 'Lembang'),

-- Saluputi
('73.18.01', 'Batu Tiakka', 'Lembang'),
('73.18.01', 'Ra''bung', 'Lembang'),
('73.18.01', 'Ratte Talonge', 'Lembang'),
('73.18.01', 'Rea Tulak Langi', 'Lembang'),
('73.18.01', 'Salu Boronan', 'Lembang'),
('73.18.01', 'Salu Tapokko', 'Lembang'),
('73.18.01', 'Salutandung', 'Lembang'),
('73.18.01', 'Sa''tandung', 'Lembang'),
('73.18.01', 'Pattan Ulusalu', 'Kelurahan'),

-- Bittuang
('73.18.02', 'Balla', 'Lembang'),
('73.18.02', 'Bau', 'Lembang'),
('73.18.02', 'Burasia', 'Lembang'),
('73.18.02', 'Buttu Limbong', 'Lembang'),
('73.18.02', 'Kandua', 'Lembang'),
('73.18.02', 'Kole Palian', 'Lembang'),
('73.18.02', 'Le''tek', 'Lembang'),
('73.18.02', 'Pali', 'Lembang'),
('73.18.02', 'Patongloan', 'Lembang'),
('73.18.02', 'Rembo-Rembo', 'Lembang'),
('73.18.02', 'Sandana', 'Lembang'),
('73.18.02', 'Sasak', 'Lembang'),
('73.18.02', 'Se''seng', 'Lembang'),
('73.18.02', 'Tiroan', 'Lembang'),
('73.18.02', 'Bittuang', 'Kelurahan'),

-- Bonggakaradeng
('73.18.03', 'Bau', 'Lembang'),
('73.18.03', 'Bau Selatan', 'Lembang'),
('73.18.03', 'Buakayu', 'Lembang'),
('73.18.03', 'Mappa', 'Lembang'),
('73.18.03', 'Poton', 'Lembang'),
('73.18.03', 'Ratte Buttu', 'Kelurahan'),

-- Makale
('73.18.05', 'Ariang', 'Kelurahan'),
('73.18.05', 'Batupapan', 'Kelurahan'),
('73.18.05', 'Bombongan', 'Kelurahan'),
('73.18.05', 'Botang', 'Kelurahan'),
('73.18.05', 'Buntu Burake', 'Kelurahan'),
('73.18.05', 'Kamali Pentalluan', 'Kelurahan'),
('73.18.05', 'Lamunan', 'Kelurahan'),
('73.18.05', 'Lapandan', 'Kelurahan'),
('73.18.05', 'Manggau', 'Kelurahan'),
('73.18.05', 'Pantan', 'Kelurahan'),
('73.18.05', 'Rante', 'Kelurahan'),
('73.18.05', 'Tampo Makale', 'Kelurahan'),
('73.18.05', 'Tarongko', 'Kelurahan'),
('73.18.05', 'Tondon Mamullu', 'Kelurahan'),
('73.18.05', 'Lea', 'Lembang'),

-- Simbuang
('73.18.09', 'Makkodo', 'Lembang'),
('73.18.09', 'Pongbembe', 'Lembang'),
('73.18.09', 'Pongbembe Mesakada', 'Lembang'),
('73.18.09', 'Simbuang', 'Lembang'),
('73.18.09', 'Simbuang Batutallu', 'Lembang'),
('73.18.09', 'Sima', 'Kelurahan'),

-- Rantetayo
('73.18.11', 'Madandan', 'Lembang'),
('73.18.11', 'Tapparan Utara', 'Lembang'),
('73.18.11', 'Tonglo', 'Lembang'),
('73.18.11', 'Padangiring', 'Kelurahan'),
('73.18.11', 'Rantetayo', 'Kelurahan'),
('73.18.11', 'Tapparan', 'Kelurahan'),

-- Mengkendek
('73.18.12', 'Buntu Datu', 'Lembang'),
('73.18.12', 'Buntu Tangti', 'Lembang'),
('73.18.12', 'Gasing', 'Lembang'),
('73.18.12', 'Ke''pe Tinoring', 'Lembang'),
('73.18.12', 'Marinding', 'Lembang'),
('73.18.12', 'Pakala', 'Lembang'),
('73.18.12', 'Palipu', 'Lembang'),
('73.18.12', 'Pa''tengko', 'Lembang'),
('73.18.12', 'Randanan', 'Lembang'),
('73.18.12', 'Rante Dada', 'Lembang'),
('73.18.12', 'Simbuang', 'Lembang'),
('73.18.12', 'Uluway', 'Lembang'),
('73.18.12', 'Uluway Barat', 'Lembang'),
('73.18.12', 'Lemo', 'Kelurahan'),
('73.18.12', 'Rante Kalua', 'Kelurahan'),
('73.18.12', 'Tampo', 'Kelurahan'),
('73.18.12', 'Tengan', 'Kelurahan'),

-- Sangalla
('73.18.13', 'Bulian Massa''bu', 'Lembang'),
('73.18.13', 'Kaero', 'Lembang'),
('73.18.13', 'Turunan', 'Lembang'),
('73.18.13', 'Buntu Masakke', 'Kelurahan'),
('73.18.13', 'Tongko Sarapung', 'Kelurahan'),

-- Gandangbatu Sillanan
('73.18.19', 'Benteng Ambeso', 'Kelurahan'),
('73.18.19', 'Mebali', 'Kelurahan'),
('73.18.19', 'Salubarani', 'Kelurahan'),
('73.18.19', 'Betteng Deata', 'Lembang'),
('73.18.19', 'Buntu Limbong', 'Lembang'),
('73.18.19', 'Buntu Tabang', 'Lembang'),
('73.18.19', 'Gandangbatu', 'Lembang'),
('73.18.19', 'Garassik', 'Lembang'),
('73.18.19', 'Kaduaja', 'Lembang'),
('73.18.19', 'Pemanuken', 'Lembang'),
('73.18.19', 'Perindingan', 'Lembang'),
('73.18.19', 'Sillanan', 'Lembang'),

-- Rembon
('73.18.20', 'Banga', 'Lembang'),
('73.18.20', 'Batusura', 'Lembang'),
('73.18.20', 'Bua'' Tarrung', 'Lembang'),
('73.18.20', 'Buri', 'Lembang'),
('73.18.20', 'Kayuosing', 'Lembang'),
('73.18.20', 'Limbong', 'Lembang'),
('73.18.20', 'Maroson', 'Lembang'),
('73.18.20', 'Palesan', 'Lembang'),
('73.18.20', 'Sarapeang', 'Lembang'),
('73.18.20', 'To''pao', 'Lembang'),
('73.18.20', 'Ullin', 'Lembang'),
('73.18.20', 'Rembon', 'Kelurahan'),
('73.18.20', 'Talion', 'Kelurahan'),

-- Makale Utara
('73.18.27', 'Bungin', 'Kelurahan'),
('73.18.27', 'Lemo', 'Kelurahan'),
('73.18.27', 'Lion Tondok Iring', 'Kelurahan'),
('73.18.27', 'Sarira', 'Kelurahan'),
('73.18.27', 'Tambunan', 'Kelurahan'),

-- Mappak
('73.18.28', 'Butang', 'Lembang'),
('73.18.28', 'Dewata', 'Lembang'),
('73.18.28', 'Miallo', 'Lembang'),
('73.18.28', 'Sangpeparikan', 'Lembang'),
('73.18.28', 'Tanete', 'Lembang'),
('73.18.28', 'Kondodewata', 'Kelurahan'),

-- Makale Selatan
('73.18.29', 'Bone Buntu Sisong', 'Lembang'),
('73.18.29', 'Pa''buaran', 'Lembang'),
('73.18.29', 'Patekke', 'Lembang'),
('73.18.29', 'Randan Batu', 'Lembang'),
('73.18.29', 'Pasang', 'Kelurahan'),
('73.18.29', 'Sandabilik', 'Kelurahan'),
('73.18.29', 'Tiromanda', 'Kelurahan'),
('73.18.29', 'Tosapan', 'Kelurahan'),

-- Awan Rante Karua
('73.26.21', 'Awan', 'Lembang'),
('73.26.21', 'Batu Lotong', 'Lembang'),
('73.26.21', 'Buntu Karua', 'Lembang'),
('73.26.21', 'Londong Biang', 'Lembang'),

-- Kapala Pitu
('73.26.20', 'Benteng Ka''do', 'Lembang'),
('73.26.20', 'Bontong Mamullu', 'Lembang'),
('73.26.20', 'Kantun Poya', 'Lembang'),
('73.26.20', 'Kapala Pitu', 'Lembang'),
('73.26.20', 'Polo Padang', 'Lembang'),
('73.26.20', 'Sikuku', 'Lembang'),

-- Sesean Suloara
('73.26.19', 'Landorundun', 'Lembang'),
('73.26.19', 'Lempo', 'Lembang'),
('73.26.19', 'Sesean Matallo', 'Lembang'),
('73.26.19', 'Suloara', 'Lembang'),
('73.26.19', 'Tonga Riu', 'Lembang'),

-- Rantebua
('73.26.18', 'Ma''kuan Pare', 'Lembang'),
('73.26.18', 'Pitung Penanian', 'Lembang'),
('73.26.18', 'Rantebua', 'Lembang'),
('73.26.18', 'Rantebua Sanggalangi', 'Lembang'),
('73.26.18', 'Rantebua Sumalu', 'Lembang'),
('73.26.18', 'Bokin', 'Kelurahan'),
('73.26.18', 'Buangin', 'Kelurahan'),

-- Bangkelekila
('73.26.17', 'Bangkelekila', 'Lembang'),
('73.26.17', 'Batu Limbong', 'Lembang'),
('73.26.17', 'Tampan Bonga', 'Lembang'),
('73.26.17', 'To''yasa Akung', 'Lembang'),

-- Tondon
('73.26.16', 'Tondon', 'Lembang'),
('73.26.16', 'Tondon Langi', 'Lembang'),
('73.26.16', 'Tondon Matallo', 'Lembang'),
('73.26.16', 'Tondon Sibata', 'Lembang'),

-- Kesu
('73.26.15', 'Angin-angin', 'Lembang'),
('73.26.15', 'Rinding Batu', 'Lembang'),
('73.26.15', 'Sangbua', 'Lembang'),
('73.26.15', 'Tadongkon', 'Lembang'),
('73.26.15', 'Tallu Lolo', 'Lembang'),
('73.26.15', 'Ba''tan', 'Kelurahan'),
('73.26.15', 'Pantanakan Lolo', 'Kelurahan'),

-- Baruppu
('73.26.14', 'Baruppu Benteng Batu', 'Lembang'),
('73.26.14', 'Baruppu Parodo', 'Lembang'),
('73.26.14', 'Baruppu Utara', 'Lembang'),
('73.26.14', 'Baruppu Selatan', 'Kelurahan'),

-- Buntu Pepasan
('73.26.13', 'Batu Busa', 'Lembang'),
('73.26.13', 'Buntu Minanga', 'Lembang'),
('73.26.13', 'Pangkung Batu', 'Lembang'),
('73.26.13', 'Paonganan', 'Lembang'),
('73.26.13', 'Parandangan', 'Lembang'),
('73.26.13', 'Pengkaroan Manuk', 'Lembang'),
('73.26.13', 'Ponglu', 'Lembang'),
('73.26.13', 'Pulu-Pulu', 'Lembang'),
('73.26.13', 'Rante Uma', 'Lembang'),
('73.26.13', 'Roroan Barra-Barra', 'Lembang'),
('73.26.13', 'Sarambu', 'Lembang'),
('73.26.13', 'Talimbangan', 'Lembang'),
('73.26.13', 'Sapan', 'Kelurahan'),

-- Dende Piongan Napo
('73.26.12', 'Buntu Tagari', 'Lembang'),
('73.26.12', 'Dende', 'Lembang'),
('73.26.12', 'Kapolang', 'Lembang'),
('73.26.12', 'Madong', 'Lembang'),
('73.26.12', 'Paku', 'Lembang'),
('73.26.12', 'Parinding', 'Lembang'),
('73.26.12', 'Piongan', 'Lembang'),
('73.26.12', 'Pasang', 'Kelurahan'),

-- Tallunglipu
('73.26.11', 'Buntu Tallunglipu', 'Lembang'),
('73.26.11', 'Rantepaku Tallunglipu', 'Kelurahan'),
('73.26.11', 'Tagari Tallunglipu', 'Kelurahan'),
('73.26.11', 'Tallunglipu', 'Kelurahan'),
('73.26.11', 'Tallunglipu Matalo', 'Kelurahan'),
('73.26.11', 'Tampo Tallunglipu', 'Kelurahan'),
('73.26.11', 'Tantanan Tallunglipu', 'Kelurahan'),

-- Balusu
('73.26.10', 'Awa Kawasik', 'Lembang'),
('73.26.10', 'Balusu Ao Gading', 'Lembang'),
('73.26.10', 'Balusu Bangunlipu', 'Lembang'),
('73.26.10', 'Karua', 'Lembang'),
('73.26.10', 'Palangi', 'Lembang'),
('73.26.10', 'Balusu', 'Kelurahan'),
('73.26.10', 'Tagari', 'Kelurahan'),

-- Tikala
('73.26.09', 'Benteng Ka''do To''rea', 'Lembang'),
('73.26.09', 'Buntu Batu', 'Lembang'),
('73.26.09', 'Embatau', 'Lembang'),
('73.26.09', 'Pangden', 'Lembang'),
('73.26.09', 'Sereale', 'Lembang'),
('73.26.09', 'Buntu Barana', 'Kelurahan'),
('73.26.09', 'Tikala', 'Kelurahan'),

-- Sopai
('73.26.08', 'Langda', 'Lembang'),
('73.26.08', 'Marante', 'Lembang'),
('73.26.08', 'Nonongan Selatan', 'Lembang'),
('73.26.08', 'Salu', 'Lembang'),
('73.26.08', 'Salu Sarre', 'Lembang'),
('73.26.08', 'Salu Sopai', 'Lembang'),
('73.26.08', 'Tombang Langda', 'Lembang'),
('73.26.08', 'Nonongan Utara', 'Kelurahan'),

-- Sanggalangi
('73.26.07', 'Buntu La''bo', 'Lembang'),
('73.26.07', 'La''bo', 'Lembang'),
('73.26.07', 'Pata''padang', 'Lembang'),
('73.26.07', 'Tallung Penanian', 'Lembang'),
('73.26.07', 'Tandung La''bo', 'Lembang'),
('73.26.07', 'Paepalean', 'Kelurahan'),

-- Sa''dan
('73.26.06', 'Sa''dan Andulan', 'Lembang'),
('73.26.06', 'Sa''dan Ballo Pasange', 'Lembang'),
('73.26.06', 'Sa''dan Luku Lambe''na', 'Lembang'),
('73.26.06', 'Sa''dan Pebulian', 'Lembang'),
('73.26.06', 'Sa''dan Pesondongan', 'Lembang'),
('73.26.06', 'Sa''dan Tiroallo', 'Lembang'),
('73.26.06', 'Sa''dan Ulusalu', 'Lembang'),
('73.26.06', 'Sangkaropi', 'Lembang'),
('73.26.06', 'Sa''dan Malimbong', 'Kelurahan'),
('73.26.06', 'Sa''dan Matallo', 'Kelurahan'),

-- Buntao
('73.26.05', 'Issong Kalua', 'Lembang'),
('73.26.05', 'Misa''ba''bana', 'Lembang'),
('73.26.05', 'Rindingkila', 'Lembang'),
('73.26.05', 'Sapan Kua-kua', 'Lembang'),
('73.26.05', 'Tongkonan Bassae', 'Kelurahan'),
('73.26.05', 'Tullang Sura', 'Kelurahan'),

-- Rindingallo
('73.26.04', 'Ampang Batu', 'Lembang'),
('73.26.04', 'Buntu Batu', 'Lembang'),
('73.26.04', 'Lempo Poton', 'Lembang'),
('73.26.04', 'Limbong Malting', 'Lembang'),
('73.26.04', 'Lo''ko Uru', 'Lembang'),
('73.26.04', 'Mai''ting', 'Lembang'),
('73.26.04', 'Rindingallo', 'Lembang'),
('73.26.04', 'Pangala', 'Kelurahan'),
('73.26.04', 'Pangala Utara', 'Kelurahan'),

-- Nanggala
('73.26.03', 'Basokan', 'Lembang'),
('73.26.03', 'Karre Limbong', 'Lembang'),
('73.26.03', 'Karre Pananian', 'Lembang'),
('73.26.03', 'Lili''kira', 'Lembang'),
('73.26.03', 'Nanggala', 'Lembang'),
('73.26.03', 'Nanna Nanggala', 'Lembang'),
('73.26.03', 'Rante', 'Lembang'),
('73.26.03', 'Tandung Nanggala', 'Lembang'),
('73.26.03', 'Nanggala Sanpiak Salu', 'Kelurahan'),

-- Sesean
('73.26.02', 'Bori Lombongan', 'Lembang'),
('73.26.02', 'Bori Ranteletok', 'Lembang'),
('73.26.02', 'Buntu Lobo', 'Lembang'),
('73.26.02', 'Parinding', 'Lembang'),
('73.26.02', 'Bori', 'Kelurahan'),
('73.26.02', 'Deri', 'Kelurahan'),
('73.26.02', 'Palawa', 'Kelurahan'),
('73.26.02', 'Pangli', 'Kelurahan'),
('73.26.02', 'Pangli Selatan', 'Kelurahan'),

-- Rantepao
('73.26.01', 'Limbong', 'Lembang'),
('73.26.01', 'Saloso', 'Lembang'),
('73.26.01', 'Karassik', 'Kelurahan'),
('73.26.01', 'Laang Tanduk', 'Kelurahan'),
('73.26.01', 'Malangngo', 'Kelurahan'),
('73.26.01', 'Mentirotiku', 'Kelurahan'),
('73.26.01', 'Pasale', 'Kelurahan'),
('73.26.01', 'Penanian', 'Kelurahan'),
('73.26.01', 'Rante Pasele', 'Kelurahan'),
('73.26.01', 'Rantepao', 'Kelurahan'),
('73.26.01', 'Singki', 'Kelurahan');
