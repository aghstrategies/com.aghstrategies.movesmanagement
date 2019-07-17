CRM.$(function ($) {
  //Moves custom setting above buttons on "Edit Price Field" form
  $('.crm-price-field-block-date_change').insertAfter('.crm-activity-form-block-status_id');
  $('.crm-price-field-block-reason').insertAfter('.crm-activity-form-block-status_id');
  $('.deleteme').remove();
});
