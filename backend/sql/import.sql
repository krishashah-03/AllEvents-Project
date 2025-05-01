LOAD DATA INFILE 'C:\xampp\mysql\data\artists.csv'
INTO TABLE artist_table
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(name, genre, profile_picture_url, artist_id, location);
