$(function() {
    $( "#from" ).datepicker({
    changeMonth: true,
    dateFormat: "dd-mm-yy",
    onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
    }
    });
    $( "#to" ).datepicker({
        defaultDate: "+1d",
        changeMonth: true,
        dateFormat: "dd-mm-yy",
        onClose: function( selectedDate ) {
            $( "#from" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
});