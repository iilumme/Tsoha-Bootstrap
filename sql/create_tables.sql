CREATE TABLE Genre (
  genreID   SERIAL PRIMARY KEY,
  genreNimi VARCHAR(100) NOT NULL
);

CREATE TABLE Kayttaja (
  kayttajaID       SERIAL PRIMARY KEY,
  kayttajaTunnus   VARCHAR(20) NOT NULL,
  nimi             VARCHAR(20) NOT NULL,
  salasana         VARCHAR(20) NOT NULL,
  lempiGenre       INT         NOT NULL,
  kuva             INT         NOT NULL,
  rekisteroitynyt  TIMESTAMP   NOT NULL,
  viimeksiMuutettu TIMESTAMP   NOT NULL,
  FOREIGN KEY (lempiGenre) REFERENCES Genre (genreID) ON DELETE RESTRICT
);

CREATE TABLE Valtiot (
  valtioID   SERIAL PRIMARY KEY,
  valtioNimi VARCHAR(100) NOT NULL UNIQUE,
  valtioBio  VARCHAR(1000),
  lippu      VARCHAR(100)
);

CREATE TABLE Elokuva (
  leffaID          SERIAL PRIMARY KEY,
  leffaNimi        VARCHAR(100) NOT NULL,
  vuosi            INT          NOT NULL,
  valtio           INT          NOT NULL,
  kieli            VARCHAR(20)  NOT NULL,
  synopsis         VARCHAR(1000),
  traileriURL      VARCHAR(150),
  lisatty          TIMESTAMP    NOT NULL,
  viimeksiMuutettu TIMESTAMP    NOT NULL,
  FOREIGN KEY (valtio) REFERENCES Valtiot (valtioID) ON DELETE SET NULL
);

CREATE TABLE MasTardeLista (
  kayttajaID INT NOT NULL,
  leffaID    INT NOT NULL,
  FOREIGN KEY (kayttajaID) REFERENCES Kayttaja (kayttajaID) ON DELETE CASCADE,
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID) ON DELETE CASCADE
);

CREATE TABLE DVDLista (
  kayttajaID INT NOT NULL,
  leffaID    INT NOT NULL,
  FOREIGN KEY (kayttajaID) REFERENCES Kayttaja (kayttajaID) ON DELETE CASCADE,
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID) ON DELETE CASCADE
);

CREATE TABLE Katsotutlista (
  kayttajaID INT NOT NULL,
  leffaID    INT NOT NULL,
  FOREIGN KEY (kayttajaID) REFERENCES Kayttaja (kayttajaID) ON DELETE CASCADE,
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID) ON DELETE CASCADE
);

CREATE TABLE Suosikkilista (
  kayttajaID INT NOT NULL,
  leffaID    INT NOT NULL,
  FOREIGN KEY (kayttajaID) REFERENCES Kayttaja (kayttajaID) ON DELETE CASCADE,
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID) ON DELETE CASCADE
);


CREATE TABLE Artisti (
  artistiID        SERIAL PRIMARY KEY,
  artistiTyyppi    VARCHAR(20)  NOT NULL,
  etuNimi          VARCHAR(100) NOT NULL,
  sukuNimi         VARCHAR(100) NOT NULL,
  bio              VARCHAR(1000),
  kuva             VARCHAR(100),
  syntymavuosi     INT          NOT NULL,
  valtio           INT          NOT NULL,
  lisatty          TIMESTAMP    NOT NULL,
  viimeksiMuutettu TIMESTAMP    NOT NULL,
  FOREIGN KEY (valtio) REFERENCES Valtiot (valtioID) ON DELETE SET NULL
);


CREATE TABLE Kommentti (
  kayttajaID INT           NOT NULL,
  leffaID    INT           NOT NULL,
  teksti     VARCHAR(1000) NOT NULL,
  lisatty    TIMESTAMP     NOT NULL,
  PRIMARY KEY (kayttajaID, leffaID),
  FOREIGN KEY (kayttajaID) REFERENCES Kayttaja (kayttajaID) ON DELETE CASCADE,
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID) ON DELETE CASCADE
);

CREATE TABLE Sarja (
  sarjaID   SERIAL PRIMARY KEY,
  sarjaNimi VARCHAR(100) NOT NULL
);


CREATE TABLE ArtistiLaari (
  artistiID INT NOT NULL,
  leffaID   INT NOT NULL,
  FOREIGN KEY (artistiID) REFERENCES Artisti (artistiID) ON DELETE CASCADE,
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID) ON DELETE CASCADE
);

CREATE TABLE ArvioLaari (
  kayttajaID INT NOT NULL,
  leffaID    INT NOT NULL,
  tahti      INT NOT NULL,
  lisatty    TIMESTAMP,
  PRIMARY KEY (kayttajaID, leffaID),
  FOREIGN KEY (kayttajaID) REFERENCES Kayttaja (kayttajaID) ON DELETE CASCADE,
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID) ON DELETE CASCADE
);

CREATE TABLE SarjaLaari (
  sarjaID INT NOT NULL,
  leffaID INT NOT NULL,
  FOREIGN KEY (sarjaID) REFERENCES Sarja (sarjaID) ON DELETE CASCADE,
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID) ON DELETE CASCADE
);

CREATE TABLE GenreLaari (
  genreID INT NOT NULL,
  leffaID INT NOT NULL,
  FOREIGN KEY (genreID) REFERENCES Genre (genreID) ON DELETE CASCADE,
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID) ON DELETE CASCADE
);

CREATE TABLE Kyselyehdotus (
  kyselyID SERIAL PRIMARY KEY,
  kysely   VARCHAR(2000),
  lisatty  TIMESTAMP NOT NULL
);

CREATE TABLE Kyselyryhma (
  ryhmaID SERIAL PRIMARY KEY 
);

CREATE TABLE KyselyryhmaLaari (
  ryhmaID INT,
  kyselyID INT,
  FOREIGN KEY (ryhmaID) REFERENCES Kyselyryhma (ryhmaID) ON DELETE CASCADE,
  FOREIGN KEY (kyselyID) REFERENCES Kyselyehdotus (kyselyID) ON DELETE CASCADE
);

CREATE TABLE Viesti (
  viestiID      SERIAL PRIMARY KEY,
  lahettaja     INT NOT NULL,
  vastaanottaja INT NOT NULL,
  teksti        VARCHAR(2000),
  luettu        BOOLEAN,
  lahetetty     TIMESTAMP,
  FOREIGN KEY (lahettaja) REFERENCES Kayttaja (kayttajaID) ON DELETE CASCADE,
  FOREIGN KEY (vastaanottaja) REFERENCES Kayttaja (kayttajaID) ON DELETE CASCADE
);