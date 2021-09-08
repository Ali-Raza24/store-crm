//LOADER

(function addXhrProgressEvent($) {
  var originalXhr = $.ajaxSettings.xhr;
  $.ajaxSetup({
    xhr: function() {
      var req = originalXhr(),
        that = this;
      if (req) {
        if (
          typeof req.addEventListener == 'function' &&
          that.progress !== undefined
        ) {
          req.addEventListener(
            'progress',
            function(evt) {
              that.progress(evt);
            },
            false
          );
        }
        if (
          typeof req.upload == 'object' &&
          that.progressUpload !== undefined
        ) {
          req.upload.addEventListener(
            'progress',
            function(evt) {
              that.progressUpload(evt);
            },
            false
          );
        }
      }
      return req;
    }
  });
})(jQuery);

$(window).on('load', function() {
  $('div.alert')
    .not('.alert-important')
    .delay(10000)
    .fadeOut(350);

  ('use strict');
  $('.loader').fadeOut(800);

  setTimeout(function() {
    $(window).scrollTop(0);
  }, 200);

  $('a.pagescroll').on('click', function(event) {
    event.preventDefault();
    $('html,body').animate(
      {
        scrollTop: $(this.hash).offset().top
      },
      1200
    );
  });
});

jQuery(function($) {
  'use strict';

  //  sidebar Space specific
  sidebarSpace();

  $(window).on('resize', function() {
    sidebarSpace();
  });

  function sidebarSpace() {
    if ($(window).width() > 991) {
      $('#main-body').css({
        'margin-top': $('.web-header').outerHeight(),
        'padding-left': $('.sidebar').outerWidth()
      });
      $('.web-footer,.web-header').css({
        'padding-left': $('.sidebar').outerWidth()
      });
    } else {
      $('#main-body').css({
        'margin-top': $('.web-header').outerHeight(),
        'padding-left': 0
      });
      $('.web-footer, .web-header').css({
        'padding-left': 0
      });
    }
  }

  $(function() {
    /*var windowH = $(window).height();
    var wrapperH = $('body').height();
    if (!windowH < wrapperH) {

      $('body').css({
        height: $(window).height() + 'px'
      });
    }
    $(window).resize(function() {
      if (!windowH < wrapperH) {
        $('body').css({
          height: $(window).height() + 'px'
        });
      }
    });*/
  });

  // Filter selected
  $(function() {
    $('.order-list-drop .filter-opt').on('click', function() {
      $(this).toggleClass('selected');

      $(document).on('click.bs.dropdown.data-api', '.dropdown-menu', function(
        e
      ) {
        e.stopPropagation();
      });

      $('.js-select2').select2({
        theme: 'bootstrap',
        closeOnSelect: false,
        placeholder: '--Multi Select--',
        allowClear: true
      });

      // POpup on checked
      $('.show-selected .custom-control-input, #checkAll').on(
        'change',
        function() {
          if ($('.areas-list-check:checked').length > 0) {
            $('.selected-item-panel').addClass('active');
          } else if ($('.list-check:checked').length > 0) {
            $('.selected-item-panel').addClass('active');
          } else if ($('.testimonials-list-check:checked').length > 0) {
            $('.selected-item-panel').addClass('active');
          } else {
            $('.selected-item-panel').removeClass('active');
          }
        }
      );
    });

    $(document).on('click.bs.dropdown.data-api', '.dropdown-menu', function(e) {
      e.stopPropagation();
    });

    $('.js-select2').select2({
      closeOnSelect: false,
      placeholder: '--Multi Select--',
      allowClear: true
    });

    // POpup on checked
    $('.show-selected .custom-control-input, #checkAll').on(
      'change',
      function() {
        if ($('.areas-list-check:checked').length > 0) {
          $('.selected-item-panel').addClass('active');
        } else if ($('.list-check:checked').length > 0) {
          $('.selected-item-panel').addClass('active');
        } else {
          $('.selected-item-panel').removeClass('active');
        }
      }
    );
    /*$(function() {
        $('.item-show span').on('click', function() {
          $('.selected-item-panel').removeClass('active');
        });
      });*/

    //  Responsive Header
    if ($('.mobile-header').length) {
      $('.sidebar-toggle').on('click', function() {
        $('.sidebar, .close-sidebar').addClass('active');
      }),
        $('.close-sidebar').on('click', function() {
          $('.sidebar').removeClass('active'), $(this).removeClass('active');
        }),
        $('.header-meta-collapse').on('click', function() {
          $('.header-flexer').toggleClass('active');
        });
    }

    // right Popup
    $(function() {
      $('.add-business-btn').on('click', function() {
        $('body').toggleClass('add-business');
      });
    });

    $(function() {
      $('.add-area-btn').on('click', function() {
        $('body').toggleClass('add-area');
        $('body').toggleClass('add-customer');
      });
    });
    $(function() {
      $('.add-customer-btn').on('click', function() {
        $('body').toggleClass('add-customer');
      });
    });
    $(function() {
      $('.edit-area-btn').on('click', function() {
        $('body').toggleClass('edit-area');
      });
    });

    // right Popup
    $(function() {
      $('.add-discount-btn').on('click', function() {
        $('body').toggleClass('add-discount');
      });
    });

    $(function() {
      $('.manage-discount-btn').on('click', function() {
        $('body').toggleClass('manage-discount');
      });
    });

    $(function() {
      $('.all-product-btn').on('click', function() {
        $('body').toggleClass('all-product');
        $('body').toggleClass('add-customer');

        $('.order-edit-control')
          .removeClass('border-danger')
          .siblings('.input-info')
          .remove();
      });
    });

    // Checkbox showhide content
    $('[name=has_addons_or_variants]').each(function(i, d) {
      var p = $(this).prop('checked');
      if (p) {
        $('.item-tab')
          .eq(i)
          .addClass('on');
      }
    });
    $('[name=has_addons_or_variants]').on('change', function() {
      var p = $(this).prop('checked');
      var i = $('[name=has_addons_or_variants]').index(this);
      $('.item-tab').removeClass('on');
      $('.item-tab')
        .eq(i)
        .addClass('on');
    });

    // Pricing Table
    $('.pricing-table').on('click', function() {
      $(this).toggleClass('active');
    });

    // Counters
    /*$('.counter-box [data-to]').each(function() {
      var e = $(this).attr('data-to');
      $(this)
        .delay(6e3)
        .countTo({
          from: 1,
          to: e,
          speed: 3500,
          refreshInterval: 50
        });
    });*/

    // Range Slider
    $(function() {
      $('.noUi-handle').on('click', function() {
        $(this).width(50);
      });
      var rangeSlider = document.getElementById('slider-range');
      var moneyFormat = wNumb({
        decimals: 0,
        thousand: ','
        // prefix: '$'
      });
      noUiSlider.create(rangeSlider, {
        start: [0, 500],
        step: 1,
        range: {
          min: [1],
          max: [500]
        },
        format: moneyFormat,
        connect: true
      });

      // Set visual min and max values and also update value hidden form inputs
      rangeSlider.noUiSlider.on('update', function(values, handle) {
        document.getElementById('slider-range-value1').innerHTML = values[0];
        document.getElementById('slider-range-value2').innerHTML = values[1];
        $('[name="discount_min_used"]').val(moneyFormat.from(values[0]));
        $('[name="discount_max_used"]').val(moneyFormat.from(values[1]));
      });

      // slider 2
      var rangeSlider = document.getElementById('slider-range-amount');
      var moneyFormat = wNumb({
        decimals: 0,
        thousand: ',',
        prefix: 'AED'
      });
      noUiSlider.create(rangeSlider, {
        start: [1, 500],
        step: 1,
        range: {
          min: [1],
          max: [500]
        },
        format: moneyFormat,
        connect: true
      });

      // Set visual min and max values and also update value hidden form inputs
      rangeSlider.noUiSlider.on('update', function(values, handle) {
        document.getElementById('slider-amount-value1').innerHTML = values[0];
        document.getElementById('slider-amount-value2').innerHTML = values[1];

        $('[name="discount_min_amount"]').val(moneyFormat.from(values[0]));
        $('[name="discount_max_amount"]').val(moneyFormat.from(values[1]));
      });
    });

    $(document).ready(function() {
      jQuery(
        '<div class="quantity-nav"><span class="quantity-button quantity-up">&#xf106;</span><span class="quantity-button quantity-down">&#xf107</span></div>'
      ).insertAfter('.quantity input');
      jQuery('.quantity').each(function() {
        var spinner = jQuery(this),
          input = spinner.find('input[type="number"]'),
          btnUp = spinner.find('.quantity-up'),
          btnDown = spinner.find('.quantity-down'),
          min = input.attr('min'),
          max = input.attr('max');

        btnUp.click(function() {
          var oldValue = parseFloat(input.val());
          if (oldValue >= max) {
            var newVal = oldValue;
          } else {
            var newVal = oldValue + 1;
          }
          spinner.find('input').val(newVal);
          spinner.find('input').trigger('change');
        });

        btnDown.click(function() {
          var oldValue = parseFloat(input.val());
          if (oldValue <= min) {
            var newVal = oldValue;
          } else {
            var newVal = oldValue - 1;
          }
          spinner.find('input').val(newVal);
          spinner.find('input').trigger('change');
        });
      });
    });
  });

  //  Charts
  if ($('.chart').length) {
    if ($('#chart').length) {
      var options = {
        series: [
          {
            name: 'Total Sales',
            data: [0, 0, 0, 15, 0, 2, 0]
          }
        ],
        chart: {
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        colors: ['#00E396'],
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'],
            opacity: 0.5
          }
        },
        xaxis: {
          categories: ['04AM', '06AM', '08AM', '10AM', '12PM', '02PM', '04PM']
        }
      };
      var chart = new ApexCharts(document.querySelector('#chart'), options);
      chart.render();
    }

    if ($('#chart2').length) {
      var options = {
        series: [
          {
            name: 'Total Sales',
            data: [0, 0, 0, 15, 0, 2, 0]
          }
        ],
        chart: {
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        colors: ['#00E396'],
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'],
            opacity: 0.5
          }
        },
        xaxis: {
          categories: ['04AM', '06AM', '08AM', '10AM', '12PM', '02PM', '04PM']
        }
      };
      var chart = new ApexCharts(document.querySelector('#chart2'), options);
      chart.render();
    }
    if ($('#barchart').length) {
      var options = {
        series: [
          {
            data: [351, 578, 650, 790, 795, 925]
          }
        ],
        chart: {
          type: 'bar',
          height: 350,
          events: {
            click: function(chart, w, e) {}
          }
        },
        colors: [
          '#F1D1C2',
          '#F1DFC2',
          '#F1C3C2',
          '#F1C2DD',
          '#F1C2CF',
          '#DAC2F1'
        ],
        plotOptions: {
          bar: {
            borderRadius: 6,
            dataLabels: {
              position: 'top'
            }
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function(val) {
            return val;
          },
          offsetY: -20,
          style: {
            fontSize: '10px',
            colors: ['#9E9E9E']
          }
        },
        legend: {
          show: false
        },
        xaxis: {
          labels: {
            show: false,
            style: {
              colors: ['#9E9E9E'],
              fontSize: '10px'
            }
          }
        },
        yaxis: {
          axisTicks: {
            show: true
          },
          labels: {
            show: true,
            formatter: function(val) {
              return val;
            },
            style: {
              colors: ['#9E9E9E'],
              fontSize: '10px'
            }
          }
        }
      };
      var chart = new ApexCharts(document.querySelector('#barchart'), options);
      chart.render();
    }

    if ($('#piedonut').length) {
      var options = {
        series: [35, 25, 20, 15, 10, 5, 5],
        chart: {
          type: 'pie'
          // width: 350,
        },
        dataLabels: {
          enabled: false
        },
        colors: [
          '#C2E2F1',
          '#C2D4F1',
          '#C2C6F1',
          '#F1C2DD',
          '#F1C2CF',
          '#DAC2F1',
          '#E9C2F1'
        ],
        legend: {
          show: false
        }
      };
      var chart = new ApexCharts(document.querySelector('#piedonut'), options);
      chart.render();
    }

    if ($('#total-business').length) {
      var options = {
        chart: {
          height: 275,
          type: 'line',
          foreColor: '#444'
        },
        stroke: {
          curve: 'smooth'
        },
        series: [
          {
            name: 'Series 1',
            data: [50, 10, 40, 60, 15, 60, 30, 50]
          }
        ],
        fill: {
          type: 'gradient',
          gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.9,
            colorStops: [
              {
                offset: 0,
                color: '#22c2b7',
                opacity: 1
              },
              {
                offset: 20,
                color: '#7e829e',
                opacity: 1
              },
              {
                offset: 60,
                color: '#d36d8a',
                opacity: 1
              },
              {
                offset: 100,
                color: '#22c2b7',
                opacity: 1
              }
            ]
          }
        },
        grid: {
          borderColor: '#EEF2F5'
        },
        xaxis: {
          categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
        }
      };
      var chart = new ApexCharts(
        document.querySelector('#total-business'),
        options
      );
      chart.render();
    }
  }
  $('.form-control').hover(function() {
    $(this).toggleClass('active-tooltip');
  });

  $(function() {
    $('#logout').on('click', function() {
      $('#logoutForm').submit();
    });
  });

  $(function() {
    $('.variant').select2({
      tags: true,
      allowClear: true,
      tokenSeparators: [',', ' '],
      multiple: true
    });
  });
});

function formatValue(value) {
  let number = 0;
  if (!isNaN(value) && value !== undefined) {
    number = Math.floor(value * 100) / 100;
  }

  number = number.toFixed(2);
  return number;
}

$(function() {
  $('.item-show img').on('click', function() {
    $('.selected-item-panel').toggleClass('active');
    $('.list-check')
      .attr('checked', false)
      .prop('checked', false);
    $('#checkAll')
      .attr('checked', false)
      .prop('checked', false);
  });
});

$('.table-filter').on('hide.bs.dropdown', function(e) {
  if (e.clickEvent) {
    e.preventDefault();
  }
});
jQuery(window).on('load', function() {
  jQuery('#loader').fadeOut(800);
});

/*
$(function() {
  $('.order-edit-control').on('change', function() {
    $(this)
      .removeClass('border-danger')
      .siblings('.input-info')
      .remove();
  });
});
*/

$(function() {
  $('.clipboard-btn').tooltip({
    trigger: 'click',
    placement: 'top'
  });

  function setTooltip(message) {
    $('.clipboard-btn')
      .tooltip('hide')
      .attr('data-original-title', message)
      .tooltip('show');
  }

  function hideTooltip() {
    setTimeout(function() {
      $('.clipboard-btn').tooltip('hide');
    }, 1000);
  }

  var clipboard = new ClipboardJS('.clipboard-btn');
  clipboard.on('success', function(e) {
    // setTooltip('Copied!');
  });
});

$(function() {
  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });
  $(document).on('click', '[data-toggle="fileupload"]', function() {
    let $uploadPreview = $('#upload_preview');
    let $uploadMessage = $('#uploader_message');
    let $progressBar = $('#uploader_progress .progress-bar');
    let $btnUpload = $('[data-action="upload"]');
    let $btnCrop = $('[data-action="crop"]');
    let $btnClose = $('[data-action="cancel"]');
    let $formData = $(this).data('form-data');
    let $fileField = $('[data-file="file"]');
    let $title = $(this).data('data-modal-title');
    let $imgPreview = $('#upload_preview_item');
    $fileField.attr('name', $(this).data('name'));

    let $cropData = {};
    let $url = $(this).data('url');
    let $urlJson = $(this).data('url-json');
    let $toggleElement = $('[data-modal="image-upload"]');
    let $previewElement = $($(this).data('preview'));
    let $modalHeader = $('[data-modal-title="title"]');
    let $width = $(this).data('width');
    let $height = $(this).data('height');
    let $fieldName = $(this).data('field-name');
    let ratio = $width / $height;

    $toggleElement.modal('toggle');
    $modalHeader.text($title);

    $toggleElement.on('hide.bs.modal', function() {
      $progressBar.css('width', '0%');
      $btnUpload.text('Upload');
      $fileField.val('');
      $btnUpload.attr('disabled', false);
      $uploadMessage.text('');
      $fileField.attr('disabled', false);
      $('.cropper-container').hide();
      $btnCrop.text('Crop and upload');
      $imgPreview
        .attr('src', '')
        .css('display', 'none')
        .removeClass('cropper-hidden');
    });

    $fileField.fileupload({
      url: $url,
      formData: $formData,
      type: 'post',
      dataType: 'json',
      autoUpload: false,
      replaceFileInput: false,
      maxFileSize: 2000,
      start: function(e) {
        $progressBar.show();
        var $bar = $progressBar.find('.progress-bar');
        $bar.css('width', '1%');
        $uploadMessage.css('color', '#000000');
      },
      add: function(e, data) {
        $progressBar.css('width', '0%');
        $('.cropper-container').hide();
        $imgPreview
          .attr('src', '')
          .css('display', 'none')
          .removeClass('cropper-hidden');

        // data.context = $btnUpload.click(function() {
        $uploadMessage.text('Uploading....');
        $btnUpload.attr('disabled', true);

        data.submit();
        // });
        $fileField.attr('disabled', true);
      },
      progressall: function(e, data) {
        var progress = parseInt((data.loaded / data.total) * 100, 10);
        if (progress === 100) {
          progress = 99;
        }
        $progressBar.css('width', progress + '%').text(progress + '%');
      },
      fail: function(e, data) {
        console.log(e, data);
      },
      done: function(e, data) {
        if (data.result.status === 'OK') {
          $uploadMessage.css('color', '#000000');
          if (ratio > 0.1) {
            $btnUpload.text('Crop & upload');
          }
          $btnUpload.removeAttr('disabled');
          $progressBar
            .addClass('bg-success')
            .removeClass('progress-bar-animated')
            .css('width', '100%')
            .text('100%');
          $progressBar.delay(1000).hide(0);
          $uploadMessage.text('Upload finished.');
          $imgPreview.css('display', 'none');
          $imgPreview.attr('src', data.result.url).css('display', 'block');
          if (ratio < 0.1) {
            $previewElement.attr('src', data.result.url);
            setTimeout(function() {
              $toggleElement.modal('hide');
            }, 1000);
          }

          /*setTimeout(function() {
            $toggleElement.modal('hide');
          }, 1000);*/

          if (ratio > 0.1) {
            $imgPreview.cropper({
              aspectRatio: ratio,
              viewMode: 1,
              autoCropArea: 1,
              responsive: true,
              zoomable: false,
              background: false,
              crop: function() {
                $cropData = $(this)
                  .cropper('getCroppedCanvas')
                  .toDataURL('image/png');
              }
            });
            $('.cropper-container').show();
            $btnCrop.show();
          }
        } else {
          $imgPreview
            .attr('src', '')
            .css('display', 'none')
            .removeClass('cropper-hidden');
          $btnUpload.text('Upload');
          $fileField.val('');
          $btnUpload.attr('disabled', false);
          $fileField.attr('disabled', false);

          $uploadMessage.text(data.result.error);
          $uploadMessage.css('color', '#ff0000');
        }
      }
    });

    $btnCrop.click(function() {
      let formData = [];
      var obj = {};
      obj[$fieldName] = $cropData;
      formData = obj;

      $btnClose.attr('disabled', true);
      $btnCrop.text('Cropping...').attr('disabled', true);

      $progressBar.show();
      var $bar = $progressBar.find('.progress-bar');
      $bar.css('width', '1%');

      $.ajax({
        type: 'POST',
        url: $urlJson,
        cache: false,
        dataType: 'json',
        data: { images: formData },
        progress: function(evt) {
          if (evt.lengthComputable) {
            console.log(
              'Loaded ' + parseInt((evt.loaded / evt.total) * 100, 10) + '%'
            );
          } else {
            console.log('Length not computable.');
          }
        },
        progressUpload: function(evt) {
          // See above
        }
      }).done(function(data) {
        if (data.status === 'OK') {
          $('.cropper-container').hide();
          $imgPreview
            .attr('src', data.url)
            .css('display', 'block')
            .removeClass('cropper-hidden');
          $previewElement.attr('src', data.url);

          $btnClose.text('close');
          $btnCrop
            .text('Cropped')
            .removeAttr('disabled')
            .delay(1000)
            .hide();

          setTimeout(function() {
            $toggleElement.modal('hide');
          }, 1000);

          $imgPreview.cropper('destroy');
        }
      });
    });
  });
});
