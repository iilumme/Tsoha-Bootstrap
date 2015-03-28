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
            $artistilista[$artistilista.length] = $valintakandidaatti;
            $('#hidd').val($artistilista);
            console.log($artistilista);
        }).change();
        
        $('.lisaagenre').click(function (event) {
            console.log("genre");
            var $this = $(this);
            console.log($this.value);
            $genrelista[$genrelista.length] = $genrevalintakandidaatti;
            $('#hiddgenre').val($genrelista);
            console.log($genrelista);
        }).change();
        
        $('.lisaasarja').click(function (event) {
            console.log("sarja");
            var $this = $(this);
            console.log($this.value);
            $sarjalista[$sarjalista.length] = $sarjavalintakandidaatti;
            $('#hiddsarja').val($sarjalista);
            console.log($sarjalista);
        }).change();
        

        $('.artistivalinta').change(function () {
            console.log("kalakissa");
            var $this = $(this);
            $valintakandidaatti = $this.val();
            console.log($this.val());
        });       
        
        $('.genrevalinta').change(function () {
            console.log("kalakissa");
            var $this = $(this);
            $genrevalintakandidaatti = $this.val();
            console.log($this.val());
        });
        
        $('.sarjavalinta').change(function () {
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
        }).change();
        
    });
});
