//LOADER
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
    var windowH = $(window).height();
    var wrapperH = $('body').height();
    if (!windowH < wrapperH) {
      console.log($(window).height());
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
    });
  });

  // Filter selected
  $(function() {
    $('.order-list-drop .filter-opt').on('click', function() {
      $(this).toggleClass('selected');
    });
  });

  $(document).on('click.bs.dropdown.data-api', '.dropdown-menu', function(e) {
    e.stopPropagation();
  });

  $('.js-select2').select2({
    closeOnSelect: true,
    placeholder: '--Multi Select--',
    allowClear: true
  });

  // POpup on checked
  $('.show-selected .custom-control-input, #checkAll').on('change', function() {
    if ($('.areas-list-check:checked').length > 0) {
      $('.selected-item-panel').addClass('active');
      // $('#main-body').addClass('pointer-events-none');
    } else if ($('.list-check:checked').length > 0) {
      $('.selected-item-panel').addClass('active');
      // $('#main-body').addClass('pointer-events-none');
    } else if ($('.testimonials-list-check:checked').length > 0) {
      $('.selected-item-panel').addClass('active');
      // $('#main-body').addClass('pointer-events-none');
    } else {
      $('.selected-item-panel').removeClass('active');
      // $('#main-body').removeClass('pointer-events-none');
    }
  });
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
    });
  });

  // Checkbox showhide content
  $('[name=tab]').each(function(i, d) {
    var p = $(this).prop('checked');
    if (p) {
      $('.item-tab')
        .eq(i)
        .addClass('on');
    }
  });
  $('[name=tab]').on('change', function() {
    var p = $(this).prop('checked');
    var i = $('[name=tab]').index(this);
    $('.item-tab').removeClass('on');
    $('.item-tab')
      .eq(i)
      .addClass('on');
  });

  // Counters
  /*$('.counter-box [data-to]').each(function() {
    var e = $(this).attr('data-to');
    $(this)
      // .delay(6e3)
      .countTo({
        from: 0,
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
      document.getElementsByName('min-value').value = moneyFormat.from(
        values[0]
      );
      document.getElementsByName('max-value').value = moneyFormat.from(
        values[1]
      );
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
      document.getElementsByName('min-value').value = moneyFormat.from(
        values[0]
      );
      document.getElementsByName('max-value').value = moneyFormat.from(
        values[1]
      );
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
/*if ($('.chart').length) {
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
}*/
$('.form-control').hover(function() {
  $(this).toggleClass('active-tooltip');
});

$(function() {
  $('#logout').on('click', function() {
    $('#logoutForm').submit();
  });
});

$(function() {
  $('.item-show img').on('click', function() {
    $('.selected-item-panel').toggleClass('active');
    $('.list-check').attr('checked', false);
    $('.list-check').prop('checked', false);
    $('#checkAll').attr('checked', false);
    $('#checkAll').prop('checked', false);
    // $('#main-body').removeClass('pointer-events-none');
  });
});

$('.table-filter').on('hide.bs.dropdown', function(e) {
  if (e.clickEvent) {
    e.preventDefault();
  }
});

/*==========================*/
/ Page Loader /;
/*==========================*/
jQuery(window).on('load', function() {
  jQuery('#loader').fadeOut(800);
});

$(function() {
  $('.form-control')
    .on('change', function() {
      console.log($(this));
      $(this).removeClass('border-danger');
    })
    .on('focus', function() {
      $(this).removeClass('border-danger');
    });
});

$(function() {
  var clipboard = new ClipboardJS('.clipboard-btn');
});
