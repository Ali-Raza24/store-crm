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
          } else if(element.prop('type') === 'file') {
            var imgErrors = $('#image-errors');
            error.insertAfter(imgErrors);
            error.addClass('text-danger')
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
          <?php if (\Config::get('jsvalidation.focus_on_error')): ?>
        invalidHandler: function(form, validator) {

          if (!validator.numberOfInvalids())
            return;

          /*$('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top
          }, 5000);*/
          $('.add-customer-panel').animate(
            {
              scrollTop: $('.add-customer-panel').offset().top
            },
            1000
          )

        },
        submitHandler: function (form) {
          if ($(form).attr('id') === 'brandForm' || $(form).attr('id') === 'categoryForm') {
            $.ajax({
              type: $(form).attr('method'),
              url: $(form).attr('action'),
              data: $(form).serialize(),
              dataType: 'json'
            })
              .done(function(response) {
                if (response.status === true) {
                  $(form).find('.alert-message').prepend('<div class="alert alert-success alert-dismissible">' + response.message + '</div>').show().delay(5000).hide(0);
                  setTimeout(function() {
                    $(form).find('.alert-success').remove();
                  },6000)
                  $(form).find('input').val('').removeClass('is-valid')
                  $(form).find('select').val('').removeClass('is-valid')
                  $('.modal').modal('hide');
                }

                if ($(form).attr('id') === 'categoryForm') {
                  $('#categories').select2("trigger", "select", {
                    data: { id: response.data.id, text:  response.data.title},
                    ajax: {
                      url: '<?php echo route('get-all-categories'); ?>',
                      dataType: 'json',
                      delay: 250,
                      width:'resolve',
                      data: function (params) {
                        return {
                          search: params.term
                        };
                      },
                      processResults: function (response) {
                        return {
                          results: response
                        };

                      },
                      cache: true
                    }
                  });
                }
                if ($(form).attr('id') === 'brandForm') {
                  $('#brand_id').select2("trigger", "select", {
                    data: { id: response.data.id, text: response.data.title },
                    ajax: {
                      url: '<?php echo route('get-all-brands'); ?>',
                      dataType: 'json',
                      delay: 250,
                      width:'resolve',
                      data: function (params) {
                        return {
                          search: params.term
                        };
                      },
                      processResults: function (response) {
                        return {
                          results: response
                        };

                      },
                      cache: true
                    }
                  });
                }
              });
            return false; // required to block normal submit since you used ajax
          }else{
            $(form)[0].submit();
          }
        },
          <?php endif; ?>

        rules: <?= json_encode($validator['rules']); ?>
      })
    });
  });
</script>
