$(function vh($) {
    $('#step1,#step2').on('click', '.js-accordionTrigger', function (e) {
        e.preventDefault();
        var thisAnswer = $(this).closest('dt').next();
        var thisQuestion = $(this);
        thisQuestion.toggleClass('is-collapsed');
        thisQuestion.toggleClass('is-expanded');

        thisAnswer.toggleClass('is-collapsed');
        thisAnswer.toggleClass('is-expanded');

        thisAnswer.toggleClass('animateIn');

        if(thisAnswer.hasClass('is-collapsed')) {
            thisAnswer.attr('aria-hidden', 'true');
            thisQuestion.attr('aria-expanded', 'false');
        } else {
            thisAnswer.attr('aria-hidden', 'false');
            thisQuestion.attr('aria-expanded', 'true');
        }
    });
});