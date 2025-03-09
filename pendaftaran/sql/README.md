# Database Schema Documentation - Toraja Region Administrative Areas

## Overview
This database schema manages the administrative hierarchy of Tana Toraja and Toraja Utara regions.

## Tables Structure

### 1. kabupaten (Regencies)
- `id`: Unique identifier (e.g., '73.18' for Tana Toraja)
- `name`: Regency name

### 2. kecamatan (Districts)
- `kemendagri_code`: Unique district code (e.g., '73.18.31')
- `kabupaten_id`: Reference to parent regency
- `district_name`: District name

### 3. kelurahan_lembang (Administrative Areas)
- `id`: Auto-increment ID
- `kemendagri_code`: Reference to parent district
- `area_name`: Area name
- `area_type`: Either 'Lembang' or 'Kelurahan'

## Common Queries

### Get all areas in a specific district
```sql
SELECT area_name, area_type 
FROM kelurahan_lembang 
WHERE kemendagri_code = '73.18.31';  -- Example for Masanda district
```

### Count Lembang and Kelurahan per district
```sql
SELECT 
    k.district_name,
    SUM(CASE WHEN kl.area_type = 'Lembang' THEN 1 ELSE 0 END) as lembang_count,
    SUM(CASE WHEN kl.area_type = 'Kelurahan' THEN 1 ELSE 0 END) as kelurahan_count
FROM kecamatan k
LEFT JOIN kelurahan_lembang kl ON k.kemendagri_code = kl.kemendagri_code
GROUP BY k.kemendagri_code, k.district_name;
```

### Get complete hierarchy for an area (improved query)
```sql
SELECT 
    kb.name as kabupaten_name,
    kc.district_name as kecamatan_name,
    kl.area_name,
    kl.area_type
FROM kelurahan_lembang kl
JOIN kecamatan kc ON kl.kemendagri_code = kc.kemendagri_code
JOIN kabupaten kb ON kc.kabupaten_id = kb.id
WHERE kl.area_name LIKE '%Rantepao%';  -- Example search
```

## Notes
- Lembang is equivalent to desa (village) in other regions
- Kelurahan is an administrative unit typically found in urban areas
- Kemendagri codes follow the format: [Province].[Regency].[District]