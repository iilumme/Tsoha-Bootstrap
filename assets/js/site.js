$(document).ready(function () {
    $(function () {
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


        $('.lisaatyyppi').click(function (event) {
            console.log("tyyppi");
            var $this = $(this);
            console.log($this.val());
            var $tyyppi = $this.val();
            $('#tyyppi').val($tyyppi);
            $('#lisatyyppi').val($tyyppi);
        }).change();


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
        
        
        var $nayttelijalista = new Array();
        var $ohjaajalista = new Array();
        var $kuvaajalista = new Array();
        var $kasikirjoittajalista = new Array();
        
        $('.search-panel .dropdown-menu').find('a').click(function(e) {
		e.preventDefault();
		var param = $(this).attr("href").replace("#","");
		var concept = $(this).text(); 
                console.log(concept);
		$('.search-panel span#search_concept').text(concept);
		$('.input-group #search_param').val(param);
	});
       
        
        $('.hakubutton').click(function () {
            console.log("kalakissa");
            var hakusana = $('#hakubutton').attr('value');
            console.log(hakusana);
        });
        
    });
});


