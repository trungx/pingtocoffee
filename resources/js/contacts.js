
/**
 * Display editable datetime when add/edit contact log.
 *
 */

$('.contact-logs-form .change-datetime').click(function(e) {
  $('.contact-logs-form .date-it-happened').hide();
  $('.contact-logs-form .exact-datetime').show();
  e.preventDefault();
});