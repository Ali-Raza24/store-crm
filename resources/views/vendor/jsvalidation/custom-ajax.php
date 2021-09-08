<script>
  jQuery(document).ready(function() {

    $("<?= $validator['selector']; ?>").each(function() {
      $(this).validate({
        errorElement: 'div',
        errorClass: 'danger-border',
        errorElementClass:'input-info danger-bg',

        errorPlacement: function(error, element) {
          if (element.parent('.input-group').length ||
            element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
            error.insertAfter(element);
            error.addClass('input-info danger-bg')

            // else just place the validation message immediately after the input
          } else {
            error.insertAfter(element);
            error.addClass('input-info danger-bg')
          }
        },
        highlight: function(element) {
          $(element).closest('.form-control').removeClass('is-valid').addClass('danger-border'); // add the Bootstrap error class to the control group
        },

          <?php if (isset($validator['ignore']) && is_string($validator['ignore'])): ?>

        ignore: "<?= $validator['ignore']; ?>",
          <?php endif; ?>


        unhighlight: function(element) {
          $(element).closest('.form-control').removeClass('danger-border input-info danger-bg').addClass('is-valid');
        },

        success: function(element) {
          $(element).closest('.form-control').removeClass('danger-border input-info danger-bg').addClass('is-valid'); // remove the Boostrap error class from the control group
          $(element).remove()
        },

        focusInvalid: true,
          <?php if (Config::get('jsvalidation.focus_on_error')): ?>
        invalidHandler: function(form, validator) {

          if (!validator.numberOfInvalids())
            return;

          $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top
          }, <?= Config::get('jsvalidation.duration_animate') ?>);

        },
        submitHandler: function (form) {
          $.ajax({
            type: $(form).attr('method'),
            url: $(form).attr('action'),
            data: $(form).serialize(),
            dataType : 'json'
          })
            .done(function (response) {
              if (response.status === true) {
                $(form).find('.alert-message').prepend('<div class="alert alert-success alert-dismissible">'+response.message+'</div>').delay(5000).hide(0)
                $(form).find('input').val('').removeClass('is-valid')
                $(form).find('select').val('').removeClass('is-valid')
              }
            });
          return false; // required to block normal submit since you used ajax
        },
          <?php endif; ?>

        rules: <?= json_encode($validator['rules']); ?>
      })
    });
  });
</script>
