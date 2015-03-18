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
  rekisteroitynyt  TIMESTAMP   NOT NULL,
  viimeksiMuutettu TIMESTAMP   NOT NULL,
  FOREIGN KEY (lempiGenre) REFERENCES Genre (genreID)
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
  kuva             VARCHAR(100),
  synopsis         VARCHAR(1000),
  traileriURL      VARCHAR(150),
  lisatty          TIMESTAMP    NOT NULL,
  viimeksiMuutettu TIMESTAMP    NOT NULL,
  FOREIGN KEY (valtio) REFERENCES Valtiot (valtioID)
);

CREATE TABLE MasTardeLista (
  kayttajaID INT PRIMARY KEY NOT NULL,
  leffaID    INT             NOT NULL,
  FOREIGN KEY (kayttajaID) REFERENCES Kayttaja (kayttajaID),
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID)
);

CREATE TABLE DVDLista (
  kayttajaID INT PRIMARY KEY NOT NULL,
  leffaID    INT             NOT NULL,
  FOREIGN KEY (kayttajaID) REFERENCES Kayttaja (kayttajaID),
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID)
);

CREATE TABLE Katsotutlista (
  kayttajaID INT PRIMARY KEY NOT NULL,
  leffaID    INT             NOT NULL,
  FOREIGN KEY (kayttajaID) REFERENCES Kayttaja (kayttajaID),
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID)
);

CREATE TABLE Suosikkilista (
  kayttajaID INT PRIMARY KEY NOT NULL,
  leffaID    INT             NOT NULL,
  FOREIGN KEY (kayttajaID) REFERENCES Kayttaja (kayttajaID),
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID)
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
  FOREIGN KEY (valtio) REFERENCES Valtiot (valtioID)
);

CREATE TABLE Palkinto (
  palkintoID   SERIAL PRIMARY KEY,
  palkintoNimi VARCHAR(100) NOT NULL
);

CREATE TABLE Kommentti (
  kayttajaID INT           NOT NULL,
  leffaID    INT           NOT NULL,
  teksti     VARCHAR(1000) NOT NULL,
  lisatty    TIMESTAMP     NOT NULL,
  PRIMARY KEY (kayttajaID, leffaID),
  FOREIGN KEY (kayttajaID) REFERENCES Kayttaja (kayttajaID),
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID)
);

CREATE TABLE Sarja (
  sarjaID   SERIAL PRIMARY KEY,
  sarjaNimi VARCHAR(1000) NOT NULL
);


CREATE TABLE ArtistiLaari (
  artistiID INT NOT NULL,
  leffaID   INT NOT NULL,
  FOREIGN KEY (artistiID) REFERENCES Artisti (artistiID),
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID)
);

CREATE TABLE LeffaPalkintoLaari (
  palkintoID INT  NOT NULL,
  leffaID    INT  NOT NULL,
  voitettu   CHAR NOT NULL,
  FOREIGN KEY (palkintoID) REFERENCES Palkinto (palkintoID),
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID)
);

CREATE TABLE ArtistiPalkintoLaari (
  palkintoID INT  NOT NULL,
  artistitID INT  NOT NULL,
  voitettu   CHAR NOT NULL,
  FOREIGN KEY (palkintoID) REFERENCES Palkinto (palkintoID),
  FOREIGN KEY (artistitID) REFERENCES Artisti (artistiID)
);

CREATE TABLE ArvioLaari (
  kayttajaID INT NOT NULL,
  leffaID    INT NOT NULL,
  tahti      INT NOT NULL,
  PRIMARY KEY (kayttajaID, leffaID),
  FOREIGN KEY (kayttajaID) REFERENCES Kayttaja (kayttajaID),
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID)
);

CREATE TABLE SarjaLaari (
  sarjaID INT NOT NULL,
  leffaID INT NOT NULL,
  FOREIGN KEY (sarjaID) REFERENCES Sarja (sarjaID),
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID)
);

CREATE TABLE GenreLaari (
  genreID INT NOT NULL,
  leffaID INT NOT NULL,
  FOREIGN KEY (genreID) REFERENCES Genre (genreID),
  FOREIGN KEY (leffaID) REFERENCES Elokuva (leffaID)
);