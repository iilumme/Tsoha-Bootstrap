INSERT INTO Valtiot (valtioNimi, valtioBio) VALUES ('Meksiko', 'Lempimaani');
INSERT INTO Valtiot (valtioNimi) VALUES ('Argentiina');
INSERT INTO Valtiot (valtioNimi) VALUES ('Venezuela');
INSERT INTO Valtiot (valtioNimi) VALUES ('Bolivia');
INSERT INTO Valtiot (valtioNimi) VALUES ('Brasilia');
INSERT INTO Valtiot (valtioNimi) VALUES ('Chile');
INSERT INTO Valtiot (valtioNimi) VALUES ('Kolumbia');
INSERT INTO Valtiot (valtioNimi) VALUES ('Costa Rica');
INSERT INTO Valtiot (valtioNimi) VALUES ('Kuuba');
INSERT INTO Valtiot (valtioNimi) VALUES ('Dominikaaninen Tasavalta');
INSERT INTO Valtiot (valtioNimi) VALUES ('Ecuador');
INSERT INTO Valtiot (valtioNimi) VALUES ('El Salvador');
INSERT INTO Valtiot (valtioNimi) VALUES ('Guatemala');
INSERT INTO Valtiot (valtioNimi) VALUES ('Haiti');
INSERT INTO Valtiot (valtioNimi) VALUES ('Honduras');
INSERT INTO Valtiot (valtioNimi) VALUES ('Nicaragua');
INSERT INTO Valtiot (valtioNimi) VALUES ('Panama');
INSERT INTO Valtiot (valtioNimi) VALUES ('Paraguay');
INSERT INTO Valtiot (valtioNimi) VALUES ('Peru');
INSERT INTO Valtiot (valtioNimi) VALUES ('Uruguay');

INSERT INTO Genre (genreNimi) VALUES ('Draama');

INSERT INTO Elokuva VALUES (DEFAULT, 'Amores perros',2001,(SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'),'espanja', 'Amores Perros koostuu kolmesta episodista. 
                  Jokaiseen liittyy tavalla tai toisella rakkaus (amor) ja koira (perro). 
                  Koirien ja päähenkilöiden kohtalot limittyvät saumattomasti toisiinsa: 
                  lemmikki voi olla tie menestykseen, ihmissuhteen symboli 
                  tai ainoa todellinen kiintymyksen kohde.', '<iframe width="560" height="315" src="https://www.youtube.com/embed/xvwk-xYZcr0" frameborder="0" allowfullscreen></iframe>', NOW(), NOW());

INSERT INTO GenreLaari VALUES ((SELECT genreID FROM Genre WHERE genreNimi='Draama'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));

INSERT INTO Kayttaja (kayttajaTunnus, nimi, salasana, lempiGenre, rekisteroitynyt, viimeksiMuutettu)
VALUES ('iilumme', 'Iina', 'hehe1995', (SELECT genreID FROM Genre WHERE genreNimi='Draama'), NOW(), NOW());

INSERT INTO Suosikkilista VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='iilumme'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));

INSERT INTO Katsotutlista VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='iilumme'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));

INSERT INTO DVDLista VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='iilumme'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));

INSERT INTO ArvioLaari VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='iilumme'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'),5, NOW());

INSERT INTO Palkinto (palkintoNimi) VALUES ('Oscar, Paras ulkomaalainen elokuva');

INSERT INTO LeffaPalkintoLaari (palkintoID, leffaID, voitettu) VALUES ((SELECT palkintoID FROM Palkinto WHERE palkintoNimi='Oscar, Paras ulkomaalainen elokuva'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'), 'N');

INSERT INTO Sarja (sarjaNimi) VALUES ('la Trilogía de la muerte');

INSERT INTO SarjaLaari VALUES ((SELECT sarjaID FROM Sarja WHERE sarjaNimi='la Trilogía de la muerte'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));

INSERT INTO Kommentti (kayttajaID, leffaID, teksti, lisatty) VALUES (1,1,'Loistavan realistinen kuvaus elämästä.', NOW());


INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, valtio, lisatty, viimeksiMuutettu) VALUES ('Ohjaaja', 'Alejandro', 'González Iñárritu', 1963, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, valtio, lisatty, viimeksiMuutettu) VALUES ('Ohjaaja', 'Alfonso', 'Cuarón Orozco', 1961, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, valtio, lisatty, viimeksiMuutettu) VALUES ('Ohjaaja', 'Guillermo', 'del Toro Gómez', 1964, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, valtio, lisatty, viimeksiMuutettu) VALUES ('Kuvaaja', 'Emmanuel', 'Lubezki Morgenstern', 1964, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, valtio, lisatty, viimeksiMuutettu) VALUES ('Kuvaaja', 'Rodrigo', 'Prieto', 1965, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());

INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, valtio, lisatty, viimeksiMuutettu) VALUES ('Kasikirjoittaja', 'Armando', 'Bó Jr.', 0000 , (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Argentiina'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, valtio, lisatty, viimeksiMuutettu) VALUES ('Kasikirjoittaja', 'Miguel', 'Ferrari', 0000 , (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Venezuela'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, valtio, lisatty, viimeksiMuutettu) VALUES ('Kasikirjoittaja', 'Guillermo', 'Arriaga Jordán', 1958 , (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());

INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, bio, syntymavuosi, valtio, lisatty, viimeksiMuutettu) VALUES ('Nayttelija', 'Diego', 'Luna Alexander', 'Diego Luna syntyi Mexico Cityssä vuonna 1979. Hän on yksi maailmanlaajuisesti tunnetuimmista meksikolaisista näyttelijöistä. Luna aloitti näyttelemisen 8-vuotiaana. Vuonna 2001 hän sai kansainvälistä näkyvyyttä näytellessään elokuvassa Y tu Mamá también yhdessä toisen tunnetun meksikolaisen näyttelijän, Gael García Bernalin, kanssa. Luna on tehnyt elokuvia niin Meksikossa, kuin USA:ssa ja Espanjassa.', 1979, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, valtio, lisatty, viimeksiMuutettu) VALUES ('Nayttelija', 'Gael', 'García Bernal', 1978, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, valtio, lisatty, viimeksiMuutettu) VALUES ('Nayttelija', 'Sofía', 'Vergara Vergara', 1972, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Kolumbia'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, valtio, lisatty, viimeksiMuutettu) VALUES ('Nayttelija', 'Emilio', 'Echevarría', 1944, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, valtio, lisatty, viimeksiMuutettu) VALUES ('Nayttelija', 'Vanessa', 'Bauche', 1973, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, valtio, lisatty, viimeksiMuutettu) VALUES ('Nayttelija', 'Demián', 'Bichir Nájera', 1963, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());

INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Bauche'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Echevarría'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Arriaga Jordán'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Prieto'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='García Bernal'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='González Iñárritu'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));

INSERT INTO Kayttaja (kayttajaTunnus, nimi, salasana, lempiGenre, rekisteroitynyt, viimeksiMuutettu)
VALUES ('admin', 'Admin', 'administrator', (SELECT genreID FROM Genre WHERE genreNimi='Draama'), NOW(), NOW());


INSERT INTO DVDLista VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='admin'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));