$(document).ready(function() {

    $(document).on('click', '.showDetailsProdukt', function(e) {
        var tr = $('.showDetailsProdukt').index(this)
        if (document.getElementsByClassName("detailsProduktTs")[tr].style.display == "block") {
            document.getElementsByClassName("detailsProduktTs")[tr].style.display = ""
        } else {
            document.getElementsByClassName("detailsProduktTs")[tr].style.display = "block"
        }
    })

})