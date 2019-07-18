CRM.$(function ($) {
  // hide / show follow up activity fields if activity type is selected
  var followUpActivities = function() {
    $.each($('input[id^="activity_type_id"]'), function(i, element) {
      var lastChar = $(element).attr('id').substr(-1);
      if ($(element).val().length) {
        $('.crm-section.' + lastChar).show();
        // If Activity Type is "Other" show "Other Activity Type" field otherwise hide
        if ($('input#activity_type_id-' + lastChar).val() == 70) {
          $('input#custom_65-' + lastChar).parent().parent().show();
        }
        else {
          $('input#custom_65-' + lastChar).parent().parent().hide();
        }
        // var lastChar = $(element).id.substr(-1);
      }
      else {
        $('.crm-section.' + lastChar).hide();
      }
    });
    $('.crm-section input[id^="activity_type_id-0"]').parent().parent().show();
    $('.crm-section input[id^="activity_type_id-1"]').parent().parent().show();
    if ($('input#activity_type_id-1').val().length) {
      $('.crm-section input[id^="activity_type_id-2"]').parent().parent().show();
    }
    if ($('input#activity_type_id-2').val().length) {
      $('.crm-section input[id^="activity_type_id-3"]').parent().parent().show();
    }

  };

  // If Ask Made is "Other" show "Other Ask Type" field otherwise hide
  var showOtherAskTypeField = function() {
    $.each($('input[id^="custom_67"]'), function(i, element) {
      var lastChar = $(element).attr('id').substr(-1);
      if ($(element).val().length) {
        // If Activity Type is "Other" show "Other Activity Type" field otherwise hide
        if ($('input#custom_67-' + lastChar).val() == 66) {
          $('input#custom_68-' + lastChar).parent().parent().show();
        }
        else {
          $('input#custom_68-' + lastChar).parent().parent().hide();
        }
        $('input#custom_69-' + lastChar).parent().parent().show();
      }
      else {
        $('input#custom_69-' + lastChar).parent().parent().hide();
        $('input#custom_68-' + lastChar).parent().parent().hide();
      }
    });
  };

  // If Activity Status is "On Hold" or "Canceled" show "Reason" field otherwise hide
  var showReasonField = function() {
    $.each($('input[id^="status_id"]'), function(i, element) {
      var lastChar = $(element).attr('id').substr(-1);
      if ($(element).val().length) {
        // If Activity Type is "Other" show "Other Activity Type" field otherwise hide
        if ($('input#status_id-' + lastChar).val() == 3 || $('input#status_id-' + lastChar).val() == 9) {
          $('input#reason-' + lastChar).parent().parent().show();
        }
        else {
          $('input#reason-' + lastChar).parent().parent().hide();
        }
      }
      else {
        $('input#reason-' + lastChar).parent().parent().hide();
      }
    });
  };

  // If Contact Name field for first activity changes update all other activities if contact name fields if they are empty
  var selectContact = function () {
    if ($('input#target_id-0').val().length) {
      $.each($('[id^="target_id-"]'), function(i, element) {
        if (!$(element).val().length) {
          $(element).val($('#target_id-0').val()).trigger('change');
        }
      });
    }
  };

  followUpActivities();
  $('input[id^="activity_type_id"]').change(followUpActivities);
  $('input[id^="activity_type_id"]').change(showOtherAskTypeField);
  $('input[id^="custom_67"]').change(showOtherAskTypeField);
  $('input[id^="activity_type_id"]').change(showReasonField);
  $('input[id^="status_id"]').change(showReasonField);
  $('input#target_id-0').change(selectContact);
});
