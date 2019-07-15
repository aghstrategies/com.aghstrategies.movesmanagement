CRM.$(function ($) {
  // hide / show follow up activity fields if activity type is selected
  var followUpActivities = function() {
    $.each($('input[id^="activity_type_id"]'), function(i, element) {
      var lastChar = $(element).attr('id').substr(-1);
      if (lastChar != '0') {
        if ($(element).val().length) {
          $('.crm-section.' + lastChar).show();
          // var lastChar = $(element).id.substr(-1);
        }
        else {
          $('.crm-section.' + lastChar).hide();
        }
      }
    });
    $('.crm-section input[id^="activity_type_id"]').parent().parent().show();
  };

  followUpActivities();
  $('input[id^="activity_type_id"]').change(followUpActivities);

  // TODO get this JS to work for multiples (-1, -2 etc.)
  // // If Activity Type is "Other" show "Other Activity Type" field otherwise hide
  // var showOtherActTypeField = function() {
  //   if ($('input#activity_type_id').val() == 70) {
  //     $('input#custom_65').parent().parent().show();
  //   }
  //   else {
  //     $('input#custom_65').parent().parent().hide();
  //   }
  // };
  // showOtherActTypeField();
  // $('input#activity_type_id').change(showOtherActTypeField);
  //
  //
  // // If Ask Made is "Other" show "Other Ask Type" field otherwise hide
  // var showOtherAskTypeField = function() {
  //   if ($('input#custom_67').val() == 66) {
  //     $('input#custom_68').parent().parent().show();
  //   }
  //   else {
  //     $('input#custom_68').parent().parent().hide();
  //   }
  //
  //   // if ($('input#custom_67').val().length) {
  //   //   $('input#custom_69').parent().parent().show();
  //   // }
  //   // else {
  //   //   $('input#custom_69').parent().parent().hide();
  //   // }
  // };
  // showOtherAskTypeField();
  // $('input#custom_67').change(showOtherAskTypeField);
  //
  // // If Activity Status is "On Hold" or "Canceled" show "Reason" field otherwise hide
  // var showOtherReasonField = function() {
  //   if ($('input#status_id').val() == 3 || $('input#status_id').val() == 9) {
  //     $('input#reason').parent().parent().show();
  //   }
  //   else {
  //     $('input#reason').parent().parent().hide();
  //   }
  // };
  // showOtherReasonField();
  // $('input#status_id').change(showOtherReasonField);

});
