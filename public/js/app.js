jQuery(document).ready(function ($) {
    // alert(1);
    $('#select-date-filter').datetimepicker({
        maxDate : moment(),
        // defaultDate: moment(),
        daysOfWeekDisabled: [5, 6],
        format: 'DD/MM/YYYY'
    });

    var totalBlockers = $('.late-reported-list li');
    if(totalBlockers.length>10){
        var button = $('<li>');
            button.addClass('show-more-blockers')
                .text('Show More')
                .on('click', function () {
                    totalBlockers.eq(9).nextAll('li').toggle()
                });
        totalBlockers.eq(9).nextAll('li').hide();
        button.insertAfter(totalBlockers.eq(9));
    }

});