"use strict";
$(function() {
  $('#city_selector').change(function(){
    $('.innoshop-state-field').hide();
    $('#' + $(this).val() + '_field').show();
  });
});
