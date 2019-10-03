$(document).ready(function () {
    $('.add_image_link').click(function () {
       setTimeout(function () {
           $('#trick_images .form-check-input').click(function () {
               $('#trick_images .form-check-input').prop('checked', false);
               $(this).prop('checked', true);
           });
       }, 400);
    });
});