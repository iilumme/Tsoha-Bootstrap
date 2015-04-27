$(document).ready(function () {
    $(function () {

        //Leffan tekijöiden lisäys

        var $artistilista = new Array();
        var $genrelista = new Array();
        var $sarjalista = new Array();

        var $valintakandidaatti;
        var $genrevalintakandidaatti;
        var $sarjavalintakandidaatti;


        $('.lisaaartisti').click(function (event) {
            console.log("kissakala");
            var $this = $(this);
            console.log($this.value);
            if ($valintakandidaatti !== 0 && $valintakandidaatti !== undefined) {
                $artistilista[$artistilista.length] = $valintakandidaatti;
                $('#hidd').val($artistilista);
                $('#lisatty').text('Artisti lisätty!');
                console.log($artistilista);
                $valintakandidaatti = 0;
            }

        }).change();

        $('.lisaagenre').click(function (event) {
            console.log("genre");
            var $this = $(this);
            console.log($this.value);
            if ($genrevalintakandidaatti !== 0 && $genrevalintakandidaatti !== '...') {
                $genrelista[$genrelista.length] = $genrevalintakandidaatti;
                $('#hiddgenre').val($genrelista);
                $('#lisatty').text('Genre lisätty!');
                console.log($genrelista);
                $genrevalintakandidaatti = 0;
            }
        }).change();

        $('.lisaasarja').click(function (event) {
            console.log("sarja");
            var $this = $(this);
            console.log($this.value);
            if ($sarjavalintakandidaatti !== 0 && $sarjavalintakandidaatti !== '...') {
                $sarjalista[$sarjalista.length] = $sarjavalintakandidaatti;
                $('#hiddsarja').val($sarjalista);
                $('#lisatty').text('Sarja lisätty!');
                console.log($sarjalista);
                $sarjavalintakandidaatti = 0;
            }

        }).change();

        //valinnat

        $('.artistivalinta').change(function () {
            $('#lisatty').text('');
            console.log("kalakissa");
            var $this = $(this);
            $valintakandidaatti = $this.val();
            console.log($this.val());
        });

        $('.genrevalinta').change(function () {
            $('#lisatty').text('');
            console.log("kalakissa");
            var $this = $(this);
            $genrevalintakandidaatti = $this.val();
            console.log($this.val());
        });

        $('.sarjavalinta').change(function () {
            $('#lisatty').text('');
            console.log("kalakissa");
            var $this = $(this);
            $sarjavalintakandidaatti = $this.val();
            console.log($this.val());
        });


        //ARTISTITYYPPI
        $('.lisaatyyppi').click(function (event) {
            console.log("tyyppi");
            var $this = $(this);
            console.log($this.val());
            var $tyyppi = $this.val();
            $('#tyyppi').val($tyyppi);
            $('#lisatyyppi').val($tyyppi);
        }).change();


        //Data-submit-type ajax

        $("form[data-submit-type='ajax']").submit(function (ev) {
            ev.preventDefault();
            var $form = $(this);
            $.ajax($form.attr('action'), {
                type: $form.attr('method'),
                data: $form.serialize(),
                dataType: 'json'
            })
                    .done(function (data) {
                    })
                    .fail(function (data) {
                        console.log('fail' + data.status);
                        $('#lisatty').text('Uusi artisti lisätty!');
                        $('#lisaysmodaali').modal('hide');
                        $('body').on('hidden.bs.modal', '.modal', function (event) {
                            $(this).removeData('bs.modal');
                        });
                    });
        });

        $("form[data-submit-type='ajax genre']").submit(function (ev) {
            ev.preventDefault();
            var $form = $(this);
            $.ajax($form.attr('action'), {
                type: $form.attr('method'),
                data: $form.serialize(),
                dataType: 'json'
            })
                    .done(function (data) {
                    })
                    .fail(function (data) {
                        console.log('fail' + data.status);
                        $('#lisatty').text('Uusi genre lisätty!');
                        $('#genrelisaysmodaali').modal('hide');
                        $('body').on('hidden.bs.modal', '.modal', function (event) {
                            $(this).removeData('bs.modal');
                        });
                    });
        });

        $("form[data-submit-type='ajax sarja']").submit(function (ev) {
            ev.preventDefault();
            var $form = $(this);
            $.ajax($form.attr('action'), {
                type: $form.attr('method'),
                data: $form.serialize(),
                dataType: 'json'
            })
                    .done(function (data) {
                    })
                    .fail(function (data) {
                        console.log('fail' + data.status);
                        $('#lisatty').text('Uusi sarja lisätty!');
                        $('#sarjalisaysmodaali').modal('hide');
                        $('body').on('hidden.bs.modal', '.modal', function (event) {
                            $(this).removeData('bs.modal');
                        });
                    });
        });


        //HAKU

        var $nayttelijalista = new Array();
        var $ohjaajalista = new Array();
        var $kuvaajalista = new Array();
        var $kasikirjoittajalista = new Array();
        var $hakusanalista = new Array();
        var concept;

        $('.search-panel .dropdown-menu').find('a').click(function (e) {
            e.preventDefault();
            var param = $(this).attr("href").replace("#", "");
            concept = $(this).text();
            console.log(concept);
            $('.search-panel span#search_concept').text(concept);
            $('.input-group #search_param').val(param);
        });



        $('#hakubutton').click(function () {
            console.log("kalakissa");
            var hakusana = $('#hakusana').val();
            console.log(hakusana);

            if (hakusana.length > 0) {
                if (concept === 'Ohjaaja') {
                    $ohjaajalista[$ohjaajalista.length] = hakusana;
                    $hakusanalista[$hakusanalista.length] = hakusana;
                } else if (concept === 'Näyttelijä') {
                    $nayttelijalista[$nayttelijalista.length] = hakusana;
                    $hakusanalista[$hakusanalista.length] = hakusana;
                } else if (concept === 'Kuvaaja') {
                    $kuvaajalista[$kuvaajalista.length] = hakusana;
                    $hakusanalista[$hakusanalista.length] = hakusana;
                } else if (concept === 'Käsikirjoittaja') {
                    $kasikirjoittajalista[$kasikirjoittajalista.length] = hakusana;
                    $hakusanalista[$hakusanalista.length] = hakusana;
                }
            }

            var teksti = "";
            console.log(teksti);

            for (i = 0; i < $hakusanalista.length; ++i) {
                teksti += $hakusanalista[i] + '\n';
            }

            console.log(teksti.length);

            if (teksti.length > 0) {
                $('#viesti').text(teksti + ' haussa');
            }

            $('#hakusana').val("");

            console.log($ohjaajalista);
            console.log($nayttelijalista);
            console.log($kuvaajalista);
            console.log($kasikirjoittajalista);

            $('#olista').val($ohjaajalista);
            $('#nlista').val($nayttelijalista);
            $('#kulista').val($kuvaajalista);
            $('#kalista').val($kasikirjoittajalista);
        });


        //LISTOJEN MUOKKAUS

        //LISÄYS
        $('#leffanlisaysmodaali').on('show.bs.modal', function (e) {
            $('#viestilisataan').hide();
        });

        var $lisattavat = new Array();
        var $liskandidaatti;

        //OPTION VALINTA
        $('.lisaysvalinta').change(function () {
            $('#viestilisataan').hide();
            $('#viestilisataan').text('');
            var $this = $(this);
            $liskandidaatti = $this.val();
            console.log($this.val());
        });

        //LISATTY ELOKUVA
        $('.lisaaelokuva').click(function (event) {
            var $this = $(this);
            console.log($this.value);
            if ($liskandidaatti !== 0 && $liskandidaatti !== undefined) {
                if ($.inArray($liskandidaatti, $lisattavat) === -1) {
                    $lisattavat[$lisattavat.length] = $liskandidaatti;
                    $('#lisataan').val($lisattavat);
                    $('#viestilisataan').text('Elokuva lisätty!');
                    $('#viestilisataan').show();
                    console.log($lisattavat);
                    $liskandidaatti = 0;
                }
            }
        }).change();

        //PERUUTTAMINEN
        $('.peruutalisays').click(function (event) {
            console.log("peruutetaan");
            $('#viestilisataan').hide();
            $('#viestilisataan').text('');
            $('.lisaysvalinta').val("0");
            $lisattavat = new Array();
        }).change();

        $('#leffanlisaysmodaali').on('hide.bs.modal', function (e) {
            console.log("per");
            $('#viestilisataan').text('');
            $('#viestilisataan').hide();
            $('.lisaysvalinta').val("0");
            $lisattavat = new Array();
        });


        //POISTO
        $('#leffanpoistomodaali').on('show.bs.modal', function (e) {
            $('#viestipoistetaan').hide();
        });

        var $poistettavat = new Array();
        var $kandidaatti;

        //OPTION VALINTA
        $('.poistovalinta').change(function () {
            $('#viestipoistetaan').text('');
            var $this = $(this);
            $kandidaatti = $this.val();
            console.log($this.val());
        });

        //POISTETAAN ELOKUVA
        $('.poistaelokuva').click(function (event) {
            var $this = $(this);
            console.log($this.value);
            if ($kandidaatti !== 0 && $kandidaatti !== undefined) {
                if ($.inArray($kandidaatti, $poistettavat) === -1) {
                    $poistettavat[$poistettavat.length] = $kandidaatti;
                    $('#poistetaan').val($poistettavat);
                    $('#viestipoistetaan').text('Elokuva lisätty!');
                    $('#viestipoistetaan').show();
                    console.log($poistettavat);
                    $kandidaatti = 0;
                }
            }
        }).change();

        //PERUUTTAMINEN
        $('.peruutapoisto').click(function (event) {
            console.log("peruutetaan");
            $('#viestipoistetaan').text('');
            $('.poistovalinta').val("0");
            $poistettavat = new Array();
        }).change();

        $('#leffanpoistomodaali').on('hide.bs.modal', function (e) {
            console.log("per");
            $('#viestipoistetaan').text('');
            $('.poistovalinta').val("0");
            $poistettavat = new Array();
        });

        $('form.destroy-form').on('submit', function (submit) {
            var $this = $(this);
            var confirmText = $this.attr('data-confirm');
            if (!confirm(confirmText)) {
                submit.preventDefault();
            }
        });

        var $poistettavatartistit = new Array();
        var $poistettavatgenret = new Array();
        var $poistettavatelokuvat = new Array();
        

        $('.closeartisti').click(function (event) {
            console.log("moi :D");
            var $this = $(this);
            console.log($this.val());
            if ($this.text() === 'Lisää') {
                $this.text('Poista');
                $idx = $poistettavatartistit.indexOf($this.val());
                $poistettavatartistit.splice($idx, 1);
            } else {
                $this.text('Lisää');
                $poistettavatartistit[$poistettavatartistit.length] = $this.val();
            }
            $('#poistettavatartistit').val($poistettavatartistit);
            console.log($poistettavatartistit);
        }).change();

        $('.closegenre').click(function (event) {
            console.log("moi :D");
            var $this = $(this);
            console.log($this.val());
            if ($this.text() === 'Lisää') {
                $this.text('Poista');
                $idx = $poistettavatgenret.indexOf($this.val());
                $poistettavatgenret.splice($idx, 1);
            } else {
                $this.text('Lisää');
                $poistettavatgenret[$poistettavatgenret.length] = $this.val();
            }
            $('#poistettavatgenret').val($poistettavatgenret);
            console.log($poistettavatgenret);
        }).change();


        $('.closeelokuva').click(function (event) {
            console.log("moi :D");
            var $this = $(this);
            console.log($this.val());
            if ($this.text() === 'Lisää') {
                $this.text('Poista');
                $idx = $poistettavatelokuvat.indexOf($this.val());
                $poistettavatelokuvat.splice($idx, 1);
            } else {
                $this.text('Lisää');
                $poistettavatelokuvat[$poistettavatelokuvat.length] = $this.val();
            }
            $('#poistettavatelokuvat').val($poistettavatelokuvat);
            console.log($poistettavatelokuvat);
        }).change();

        var $leffalista = new Array();

        var $leffavalintakandidaatti;

        $('.lisaaleffa').click(function (event) {
            console.log("leffa");
            var $this = $(this);
            console.log($this.value);
            if ($leffavalintakandidaatti !== 0 && $leffavalintakandidaatti !== '...') {
                $leffalista[$leffalista.length] = $leffavalintakandidaatti;
                $('#leffalista').val($leffalista);
                console.log($leffalista);
                $leffavalintakandidaatti = 0;
            }
        }).change();

        $('.leffavalinta').change(function () {
            console.log("kalakissa");
            var $this = $(this);
            $leffavalintakandidaatti = $this.val();
            console.log($this.val());
        });


        //LEFFAN MUOKKAUS -SARJAT
        var $poistettavatsarjat = new Array();

        $('.closesarja').click(function (event) {
            console.log("sarja");
            var $this = $(this);
            console.log($this.val());
            if ($this.text() === 'Lisää') {
                $this.text('Poista');
                $idx = $poistettavatsarjat.indexOf($this.val());
                $poistettavatsarjat.splice($idx, 1);
            } else {
                $this.text('Lisää');
                $poistettavatsarjat[$poistettavatsarjat.length] = $this.val();
            }
            $('#poistettavatsarjat').val($poistettavatsarjat);
            console.log($poistettavatsarjat);
        }).change();


    });
});


