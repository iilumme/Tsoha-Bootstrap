-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Valtiot (valtioNimi, valtioBio) VALUES ('Meksiko', 'Lempimaani');

INSERT INTO Genre (genreNimi) VALUES ('Draama');

INSERT INTO Elokuva VALUES (DEFAULT, 'Amores perros',2001,(SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'),'espanja', null, 'Amores Perros koostuu kolmesta episodista. 
                  Jokaiseen liittyy tavalla tai toisella rakkaus (amor) ja koira (perro). 
                  Koirien ja päähenkilöiden kohtalot limittyvät saumattomasti toisiinsa: 
                  lemmikki voi olla tie menestykseen, ihmissuhteen symboli 
                  tai ainoa todellinen kiintymyksen kohde.', null, NOW(), NOW());

INSERT INTO GenreLaari VALUES ((SELECT genreID FROM Genre WHERE genreNimi='Draama'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));

INSERT INTO Kayttaja (kayttajaTunnus, nimi, salasana, lempiGenre, rekisteroitynyt, viimeksiMuutettu)
VALUES ('iilumme', 'Iina', 'hehe1995', (SELECT genreID FROM Genre WHERE genreNimi='Draama'), NOW(), NOW());

INSERT INTO Suosikkilista VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='iilumme'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));

INSERT INTO Katsotutlista VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='iilumme'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));

INSERT INTO DVDLista VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='iilumme'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));

INSERT INTO ArvioLaari VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='iilumme'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'),5);

INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, bio, syntymavuosi, valtio, lisatty, viimeksiMuutettu)
    VALUES ('Nayttelija', 'Diego', 'Luna Alexander', 'Diego Luna syntyi Mexico Cityssä vuonna 1979. Hän on yksi maailmanlaajuisesti tunnetuimmista meksikolaisista
            näyttelijöistä. Luna aloitti näyttelemisen 8-vuotiaana. Vuonna 2001 hän sai kansainvälistä näkyvyyttä 
            näytellessään elokuvassa Y tu Mamá también yhdessä toisen tunnetun meksikolaisen näyttelijän, 
            Gael García Bernalin, kanssa. Luna on tehnyt elokuvia niin Meksikossa, kuin USA:ssa ja Espanjassa.
', 1979, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());

INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, valtio, lisatty, viimeksiMuutettu)
    VALUES ('Nayttelija', 'Gael', 'García Bernal', 1978, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());

INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='García Bernal'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));

INSERT INTO Palkinto (palkintoNimi) VALUES ('Oscar, Paras ulkomaalainen elokuva');

INSERT INTO LeffaPalkintoLaari VALUES ((SELECT palkintoID FROM Palkinto WHERE palkintoNimi='Oscar, Paras ulkomaalainen elokuva'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'), 'N');

INSERT INTO Sarja (sarjaNimi) VALUES ('la Trilogía de la muerte');

INSERT INTO SarjaLaari VALUES ((SELECT sarjaID FROM Sarja WHERE sarjaNimi='la Trilogía de la muerte'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));