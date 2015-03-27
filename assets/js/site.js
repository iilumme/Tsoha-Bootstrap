$(document).ready(function () {
    //alert('Hello World!');
    $(function () {
        var $artistilista = new Array();
        var $valintakandidaatti;
        $('#lisaaartisti').click(function (event) {
            console.log("kissakala");
            var $this = $(this);
            console.log($this.value);
            $artistilista[$artistilista.length] = $valintakandidaatti;
            console.log($artistilista);
        }).change();


        $('.artistivalinta').change(function () {
            console.log("kalakissa");
            var $this = $(this);
            $valintakandidaatti = $this.val();
            console.log($this.val());
        });
    });
});
