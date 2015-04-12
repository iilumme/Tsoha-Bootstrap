
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Meksiko', 'Lempimaani', 'banderamexicana.jpg');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Argentiina', '', 'argentina.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Venezuela', '', 'venezuela.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Bolivia', '', 'bolivia.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Brasilia', '', 'brazil.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Chile', '', 'chile.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Kolumbia', '', 'colombia.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Costa Rica', '', 'costarica.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Kuuba', '', 'cuba.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Dominikaaninen Tasavalta', '', 'dominican.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Ecuador', '', 'ecuador.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('El Salvador', '', 'elsalvador.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Guatemala', '', 'guatemala.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Haiti', '', 'haiti.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Honduras', '', 'honduras.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Nicaragua', '', 'nicaragua.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Panama', '', 'panama.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Paraguay', '', 'paraguay.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Peru', '', 'peru.png');
INSERT INTO Valtiot (valtioNimi, valtioBio, lippu) VALUES ('Uruguay', '', 'uruguay.png');



INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Ohjaaja', 'Alejandro', 'González Iñárritu', 1963, 'inarritu.jpg', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Ohjaaja', 'Alfonso', 'Cuarón Orozco', 1961, 'alfonsocuaron.jpg', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Ohjaaja', 'Guillermo', 'del Toro Gómez', 1964, 'guillermodeltoro.jpg', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());

INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Kuvaaja', 'Emmanuel', 'Lubezki Morgenstern', 1964, 'emmanuellubezki.jpg', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Kuvaaja', 'Rodrigo', 'Prieto', 1965, 'rodrigoprieto.jpg', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());

INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Käsikirjoittaja', 'Armando', 'Bó Jr.', 0000 , 'armandobojr.jpg', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Argentiina'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Käsikirjoittaja', 'Miguel', 'Ferrari', 0000 , 'miguelferrari.jpg', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Venezuela'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Käsikirjoittaja', 'Guillermo', 'Arriaga Jordán', 1958 , 'guillermoarriaga.jpg', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());

INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, bio, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Näyttelijä', 'Diego', 'Luna Alexander', 'Diego Luna syntyi Mexico Cityssä vuonna 1979. Hän on yksi maailmanlaajuisesti tunnetuimmista meksikolaisista näyttelijöistä. Luna aloitti näyttelemisen 8-vuotiaana. Vuonna 2001 hän sai kansainvälistä näkyvyyttä näytellessään elokuvassa Y tu Mamá también yhdessä toisen tunnetun meksikolaisen näyttelijän, Gael García Bernalin, kanssa. Luna on tehnyt elokuvia niin Meksikossa, kuin USA:ssa ja Espanjassa.', 1979, 'diegoluna.jpg',(SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Näyttelijä', 'Gael', 'García Bernal', 1978,'gaelgarciabernal.jpg' ,(SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Näyttelijä', 'Sofía', 'Vergara Vergara', 1972, 'sofiavergara.jpg', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Kolumbia'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Näyttelijä', 'Emilio', 'Echevarría', 1944, 'emilioechevarria.jpg', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Näyttelijä', 'Vanessa', 'Bauche', 1973, 'vanessabauche.jpg', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Näyttelijä', 'Demián', 'Bichir Nájera', 1963, 'demianbichirc.jpg', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), NOW(), NOW());


INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Ohjaaja', 'Marcel', 'Rasquin', 0, '', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Venezuela'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Käsikirjoittaja', 'Rohan', 'Jones', 0, '', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Venezuela'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Kuvaaja', 'Enrique', 'Aular', 0, '', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Venezuela'), NOW(), NOW());

INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Näyttelijä', 'Eliú', 'Armas', 0, '', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Venezuela'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Näyttelijä', 'Fernando', 'Moreno', 0, '', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Venezuela'), NOW(), NOW());
INSERT INTO Artisti (artistiTyyppi, etuNimi, sukuNimi, syntymavuosi, kuva, valtio, lisatty, viimeksiMuutettu) VALUES ('Näyttelijä', 'Leany', 'Leal', 0, '', (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Venezuela'), NOW(), NOW());


INSERT INTO Genre (genreNimi) VALUES ('Draama');
INSERT INTO Genre (genreNimi) VALUES ('Komedia');
INSERT INTO Genre (genreNimi) VALUES ('Romantiikka');
INSERT INTO Genre (genreNimi) VALUES ('Dokumentti');
INSERT INTO Genre (genreNimi) VALUES ('Lyhytelokuva');
INSERT INTO Genre (genreNimi) VALUES ('Musikaali');
INSERT INTO Genre (genreNimi) VALUES ('Seikkailu');
INSERT INTO Genre (genreNimi) VALUES ('Toiminta');
INSERT INTO Genre (genreNimi) VALUES ('Jännitys');
INSERT INTO Genre (genreNimi) VALUES ('Lännenelokuva');
INSERT INTO Genre (genreNimi) VALUES ('Sci-fi');
INSERT INTO Genre (genreNimi) VALUES ('Animaatio');
INSERT INTO Genre (genreNimi) VALUES ('Anime');
INSERT INTO Genre (genreNimi) VALUES ('Fantasia');
INSERT INTO Genre (genreNimi) VALUES ('Kauhu');
INSERT INTO Genre (genreNimi) VALUES ('Rikos');
INSERT INTO Genre (genreNimi) VALUES ('Sota');



INSERT INTO Elokuva 
(leffaNimi, vuosi, valtio, kieli, synopsis, traileriURL, lisatty, viimeksiMuutettu) 
VALUES ('Amores perros',2001,(SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'),'espanja', 
        'Amores Perros koostuu kolmesta episodista. 
                  Jokaiseen liittyy tavalla tai toisella rakkaus (amor) ja koira (perro). 
                  Koirien ja päähenkilöiden kohtalot limittyvät saumattomasti toisiinsa: 
                  lemmikki voi olla tie menestykseen, ihmissuhteen symboli 
                  tai ainoa todellinen kiintymyksen kohde.', 'https://www.youtube.com/embed/xvwk-xYZcr0', NOW(), NOW());

INSERT INTO Elokuva
(leffaNimi, vuosi, valtio, kieli, synopsis, traileriURL, lisatty, viimeksiMuutettu)
VALUES ('Y tu mamá también', 2001, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), 'espanja',
        'Kaksi meksikolaisteinipoikaa lähtee tien päälle 10 vuotta heitä vanhemman espanjalaisnaisen kanssa.',
        'https://www.youtube.com/embed/3Qg6n7V3kO4', NOW(),NOW());

INSERT INTO Elokuva 
(leffaNimi, vuosi, valtio, kieli, synopsis, traileriURL, lisatty, viimeksiMuutettu)
VALUES ('21 gramos', 2003, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), 'englanti',
        'Sean Penn interpreta a un matemático gravemente enfermo, Naomi Watts interpreta a una afligida madre, y Benicio Del Toro interpreta a un convicto cuyo descubrimiento del Cristianismo se pone a prueba tras el accidente.',
        '', NOW(), NOW());

INSERT INTO Elokuva 
(leffaNimi, vuosi, valtio, kieli, synopsis, traileriURL, lisatty, viimeksiMuutettu)
VALUES ('Babel', 2006, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Meksiko'), 'englanti',
        'La historia de Babel comienza con dos niños marroquíes que prueban un rifle de su padre, apuntando hacia un autobús de turistas e hiriendo gravemente a una turista norteamericana y con esto causando una serie de sucesos en tres grupos de personas que se encuentran en tres partes del mundo: una adolescente sordomuda que vive en Tokio, un matrimonio de turistas americanos que están de vacaciones en Marruecos y una niñera mexicana que vive en Estados Unidos. ',
        '', NOW(), NOW());

INSERT INTO Elokuva
(leffaNimi, vuosi, valtio, kieli, synopsis, traileriURL, lisatty, viimeksiMuutettu)
VALUES ('Hermano', 2010, (SELECT valtioID FROM Valtiot WHERE valtioNimi = 'Venezuela'), 'espanja',
        'En un país dónde el deporte predominante es el béisbol, dos hermanos (Daniel y Julio) luchan por salir adelante a través de su deporte favorito, el fútbol, mientras viven el día a día en medio de la violencia y la pobreza en un peligroso barrio de Caracas.',
        'https://www.youtube.com/embed/5vrrRJDN64U', NOW(), NOW());


INSERT INTO GenreLaari VALUES ((SELECT genreID FROM Genre WHERE genreNimi='Draama'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO GenreLaari VALUES ((SELECT genreID FROM Genre WHERE genreNimi='Komedia'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Y tu mamá también'));
INSERT INTO GenreLaari VALUES ((SELECT genreID FROM Genre WHERE genreNimi='Draama'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Y tu mamá también'));
INSERT INTO GenreLaari VALUES ((SELECT genreID FROM Genre WHERE genreNimi='Draama'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='21 gramos'));
INSERT INTO GenreLaari VALUES ((SELECT genreID FROM Genre WHERE genreNimi='Draama'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Babel'));
INSERT INTO GenreLaari VALUES ((SELECT genreID FROM Genre WHERE genreNimi='Draama'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Hermano'));


INSERT INTO Sarja (sarjaNimi) VALUES ('la Trilogía de la muerte');
INSERT INTO SarjaLaari VALUES ((SELECT sarjaID FROM Sarja WHERE sarjaNimi='la Trilogía de la muerte'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO SarjaLaari VALUES ((SELECT sarjaID FROM Sarja WHERE sarjaNimi='la Trilogía de la muerte'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Babel'));
INSERT INTO SarjaLaari VALUES ((SELECT sarjaID FROM Sarja WHERE sarjaNimi='la Trilogía de la muerte'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='21 gramos'));




INSERT INTO Kayttaja (kayttajaTunnus, nimi, salasana, lempiGenre, rekisteroitynyt, viimeksiMuutettu)
VALUES ('iilumme', 'Iina', 'hehe1995', (SELECT genreID FROM Genre WHERE genreNimi='Draama'), NOW(), NOW());
INSERT INTO Kayttaja (kayttajaTunnus, nimi, salasana, lempiGenre, rekisteroitynyt, viimeksiMuutettu)
VALUES ('admin', 'Admin', 'administrator', (SELECT genreID FROM Genre WHERE genreNimi='Draama'), NOW(), NOW());
INSERT INTO Kayttaja (kayttajaTunnus, nimi, salasana, lempiGenre, rekisteroitynyt, viimeksiMuutettu)
VALUES ('talumme', 'Tapani', 'hauska', (SELECT genreID FROM Genre WHERE genreNimi='Komedia'), NOW(), NOW());
INSERT INTO Kayttaja (kayttajaTunnus, nimi, salasana, lempiGenre, rekisteroitynyt, viimeksiMuutettu)
VALUES ('kselantaus', 'Kristiina', 'rucola', (SELECT genreID FROM Genre WHERE genreNimi='Draama'), NOW(), NOW());
INSERT INTO Kayttaja (kayttajaTunnus, nimi, salasana, lempiGenre, rekisteroitynyt, viimeksiMuutettu)
VALUES ('sapez', 'Sampo', 'huuhkaja', (SELECT genreID FROM Genre WHERE genreNimi='Komedia'), NOW(), NOW());
INSERT INTO Kayttaja (kayttajaTunnus, nimi, salasana, lempiGenre, rekisteroitynyt, viimeksiMuutettu)
VALUES ('ohjaaja', 'Ohjaaja', 'tsoha1', (SELECT genreID FROM Genre WHERE genreNimi='Musikaali'), NOW(), NOW());


INSERT INTO Suosikkilista VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='iilumme'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO Suosikkilista VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='iilumme'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Hermano'));
INSERT INTO Suosikkilista VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='iilumme'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Y tu mamá también'));
INSERT INTO Katsotutlista VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='iilumme'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO MasTardeLista VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='iilumme'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO DVDLista VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='iilumme'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO ArvioLaari VALUES ((SELECT kayttajaID FROM Kayttaja WHERE kayttajaTunnus='iilumme'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'),5, NOW());
INSERT INTO Palkinto (palkintoNimi) VALUES ('Oscar, Paras ulkomaalainen elokuva');
INSERT INTO LeffaPalkintoLaari (palkintoID, leffaID, voitettu) VALUES ((SELECT palkintoID FROM Palkinto WHERE palkintoNimi='Oscar, Paras ulkomaalainen elokuva'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'), 'N');
INSERT INTO Kommentti (kayttajaID, leffaID, teksti, lisatty) VALUES (1,1,'Loistavan realistinen kuvaus elämästä.', NOW());



INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Bauche'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Echevarría'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Arriaga Jordán'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Prieto'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='García Bernal'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='González Iñárritu'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Amores perros'));

INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Cuarón Orozco'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Y tu mamá también'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='García Bernal'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Y tu mamá también'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Luna Alexander'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Y tu mamá también'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Lubezki Morgenstern'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Y tu mamá también'));

INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Arriaga Jordán'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='21 gramos'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Prieto'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='21 gramos'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='González Iñárritu'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='21 gramos'));


INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Arriaga Jordán'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Babel'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Prieto'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Babel'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='González Iñárritu'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Babel'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='García Bernal'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Babel'));


INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Rasquin'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Hermano'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Jones'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Hermano'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Aular'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Hermano'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Armas'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Hermano'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Moreno'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Hermano'));
INSERT INTO ArtistiLaari VALUES ((SELECT artistiID FROM Artisti WHERE sukuNimi='Leal'),(SELECT leffaID FROM Elokuva WHERE leffaNimi='Hermano'));

