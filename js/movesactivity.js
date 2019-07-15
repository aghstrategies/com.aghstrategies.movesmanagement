CRM.$(function ($) {

  // If Activity Type is "Other" show "Other Activity Type" field otherwise hide
  var showOtherActTypeField = function() {
    if ($('input#activity_type_id').val() == 66) {
      $('input#custom_65').parent().parent().show();
    }
    else {
      $('input#custom_65').parent().parent().hide();
    }
  };
  showOtherActTypeField();
  $('input#activity_type_id').change(showOtherActTypeField);


  // If Ask Made is "Other" show "Other Ask Type" field otherwise hide
  var showOtherAskTypeField = function() {
    if ($('input#custom_67').val() == 66) {
      $('input#custom_68').parent().parent().show();
    }
    else {
      $('input#custom_68').parent().parent().hide();
    }

    if ($('input#custom_67').val().length) {
      $('input#custom_69').parent().parent().show();
    }
    else {
      $('input#custom_69').parent().parent().hide();
    }
  };
  showOtherAskTypeField();
  $('input#custom_67').change(showOtherAskTypeField);

  // If Activity Status is "On Hold" or "Canceled" show "Reason" field otherwise hide
  var showOtherReasonField = function() {
    if ($('input#status_id').val() == 3 || $('input#status_id').val() == 9) {
      $('input#reason').parent().parent().show();
    }
    else {
      $('input#reason').parent().parent().hide();
    }
  };
  showOtherReasonField();
  $('input#status_id').change(showOtherReasonField);

});
