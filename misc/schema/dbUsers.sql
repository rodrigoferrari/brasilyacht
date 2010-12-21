CREATE TABLE users (
       username VARCHAR(32) NOT NULL
     , password VARCHAR(32) NOT NULL
     , email VARCHAR(80)
     , active BOOLEAN NOT NULL DEFAULT 1
     , last_access DATETIME NOT NULL
     , PRIMARY KEY (username)
);

