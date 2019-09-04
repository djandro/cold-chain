/*
(function ($) {
    // USE STRICT
    "use strict";
    $(".animsition").animsition({
      inClass: 'fade-in',
      outClass: 'fade-out',
      inDuration: 900,
      outDuration: 900,
      linkElement: 'a:not([target="_blank"]):not([href^="#"]):not([class^="chosen-single"])',
      loading: true,
      loadingParentElement: 'html',
      loadingClass: 'page-loader',
      loadingInner: '<div class="page-loader__spin"></div>',
      timeout: false,
      timeoutCountdown: 5000,
      onLoadEvent: true,
      browser: ['animation-duration', '-webkit-animation-duration'],
      overlay: false,
      overlayClass: 'animsition-overlay-slide',
      overlayParentElement: 'html',
      transition: function (url) {
        window.location.href = url;
      }
    });


  })(jQuery);
*/

(function ($) {
  // Use Strict
  "use strict";
  try {
    var progressbarSimple = $('.js-progressbar-simple');
    progressbarSimple.each(function () {
      var that = $(this);
      var executed = false;
      $(window).on('load', function () {

        that.waypoint(function () {
          if (!executed) {
            executed = true;
            /*progress bar*/
            that.progressbar({
              update: function (current_percentage, $this) {
                $this.find('.js-value').html(current_percentage + '%');
              }
            });
          }
        }, {
            offset: 'bottom-in-view'
          });

      });
    });
  } catch (err) {
    console.log(err);
  }
})(jQuery);


/*

(function ($) {
  // USE STRICT
  "use strict";

  // Scroll Bar
  try {
    var jscr1 = $('.js-scrollbar1');
    if(jscr1[0]) {
      const ps1 = new PerfectScrollbar('.js-scrollbar1');
    }

    var jscr2 = $('.js-scrollbar2');
    if (jscr2[0]) {
      const ps2 = new PerfectScrollbar('.js-scrollbar2');

    }

  } catch (error) {
    console.log(error);
  }

})(jQuery);

 */

(function ($) {
  // USE STRICT
  "use strict";

  // Select 2
  try {

    $(".js-select2").each(function (){
      $(this).select2({
        minimumResultsForSearch: 20,
        dropdownParent: $(this).next('.dropDownSelect2')
      });
    });

  } catch (error) {
    console.log(error);
  }


})(jQuery);

(function ($) {
  // USE STRICT
  "use strict";

  // Dropdown
  try {
    var menu = $('.js-item-menu');
    var sub_menu_is_showed = -1;

    for (var i = 0; i < menu.length; i++) {
      $(menu[i]).on('click', function (e) {
        e.preventDefault();
        $('.js-right-sidebar').removeClass("show-sidebar");
        if (jQuery.inArray(this, menu) == sub_menu_is_showed) {
          $(this).toggleClass('show-dropdown');
          sub_menu_is_showed = -1;
        }
        else {
          for (var i = 0; i < menu.length; i++) {
            $(menu[i]).removeClass("show-dropdown");
          }
          $(this).toggleClass('show-dropdown');
          sub_menu_is_showed = jQuery.inArray(this, menu);
        }
      });
    }
    $(".js-item-menu, .js-dropdown").click(function (event) {
      event.stopPropagation();
    });

    $("body,html").on("click", function () {
      for (var i = 0; i < menu.length; i++) {
        menu[i].classList.remove("show-dropdown");
      }
      sub_menu_is_showed = -1;
    });

  } catch (error) {
    console.log(error);
  }

  var wW = $(window).width();
    // Right Sidebar
    var right_sidebar = $('.js-right-sidebar');
    var sidebar_btn = $('.js-sidebar-btn');

    sidebar_btn.on('click', function (e) {
      e.preventDefault();
      for (var i = 0; i < menu.length; i++) {
        menu[i].classList.remove("show-dropdown");
      }
      sub_menu_is_showed = -1;
      right_sidebar.toggleClass("show-sidebar");
    });

    $(".js-right-sidebar, .js-sidebar-btn").click(function (event) {
      event.stopPropagation();
    });

    $("body,html").on("click", function () {
      right_sidebar.removeClass("show-sidebar");

    });


  // Sublist Sidebar
  try {
    var arrow = $('.js-arrow');
    arrow.each(function () {
      var that = $(this);
      that.on('click', function (e) {
        e.preventDefault();
        that.find(".arrow").toggleClass("up");
        that.toggleClass("open");
        that.parent().find('.js-sub-list').slideToggle("250");
      });
    });

  } catch (error) {
    console.log(error);
  }


  try {
    // Hamburger Menu
    $('.hamburger').on('click', function () {
      $(this).toggleClass('is-active');
      $('.navbar-mobile').slideToggle('500');
    });
    $('.navbar-mobile__list li.has-dropdown > a').on('click', function () {
      var dropdown = $(this).siblings('ul.navbar-mobile__dropdown');
      $(this).toggleClass('active');
      $(dropdown).slideToggle('500');
      return false;
    });
  } catch (error) {
    console.log(error);
  }
})(jQuery);


(function ($) {
  // USE STRICT
  "use strict";

  try {

    $('[data-toggle="tooltip"]').tooltip();

  } catch (error) {
    console.log(error);
  }

  // Chatbox
  try {
    var inbox_wrap = $('.js-inbox');
    var message = $('.au-message__item');
    message.each(function(){
      var that = $(this);

      that.on('click', function(){
        $(this).parent().parent().parent().toggleClass('show-chat-box');
      });
    });


  } catch (error) {
    console.log(error);
  }

})(jQuery);


var doAjax_params_default = {
  'url': null,
  'requestType': "POST",
  'contentType': 'application/json',
  'headers': { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },
  'dataType': 'json',
  'data': {},
  'beforeSendCallbackFunction': null,
  'successCallbackFunction': null,
  'completeCallbackFunction': null,
  'errorCallBackFunction': null
};

function doAjax(doAjax_params) {

  var url = doAjax_params['url'];
  var requestType = doAjax_params['requestType'];
  var contentType = doAjax_params['contentType'];
  var headers = doAjax_params['headers'];
  var dataType = doAjax_params['dataType'];
  var data = doAjax_params['data'];
  var beforeSendCallbackFunction = doAjax_params['beforeSendCallbackFunction'];
  var successCallbackFunction = doAjax_params['successCallbackFunction'];
  var completeCallbackFunction = doAjax_params['completeCallbackFunction'];
  var errorCallBackFunction = doAjax_params['errorCallBackFunction'];

  jQuery.ajax({
    url: url,
    type: requestType,
    contentType: contentType,
    processData: false,
    headers: headers,
    dataType: dataType,
    data: data,
    xhr: function(){
      var xhr = new window.XMLHttpRequest();
      xhr.upload.addEventListener("progress", function (evt) {
        if (evt.lengthComputable) {
          var percentComplete = evt.loaded / evt.total;
          jQuery('.progress.header-progress .progress-bar').css({
            width: percentComplete * 100 + '%'
          });
          if (percentComplete === 1) {
            jQuery('.progress.header-progress .progress-bar').addClass('hide');
          }
        }
      }, false);
      xhr.addEventListener("progress", function (evt) {
        if (evt.lengthComputable) {
          var percentComplete = evt.loaded / evt.total;
          jQuery('.progress.header-progress .progress-bar').css({
            width: percentComplete * 100 + '%'
          });
        }
      }, false);
      return xhr;
    },
    beforeSend: function(jqXHR, settings) {
      if (typeof beforeSendCallbackFunction === "function") {
        beforeSendCallbackFunction();
      }
    },
    success: function(data, textStatus, jqXHR) {
      if (typeof successCallbackFunction === "function") {
        successCallbackFunction(data);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      if (typeof errorCallBackFunction === "function") {
        errorCallBackFunction(jqXHR);
      }

    },
    complete: function(jqXHR, textStatus) {
      if (typeof completeCallbackFunction === "function") {
        completeCallbackFunction();
      }
    }
  });
}

function nameFormatter(value) {
  return '<span class="role user">' + value + '</span>';
}
function colorFormatter(value) {
  if(value == 'yellow') return '<span class="badge badge-warning">' + value + '</span>';
  if(value == 'red') return '<span class="badge badge-danger">' + value + '</span>';
  if(value == 'blue') return '<span class="badge badge-primary">' + value + '</span>';
  if(value == 'green') return '<span class="badge badge-success">' + value + '</span>';
}

function btnFormatter(value) {
  $html = '<div class="table-data-feature">';
  $html += '<button class="item btnItemEdit" data-toggle="tooltip" data-placement="top" title="Edit" data-original-title="Edit" data-item-id="' + value + '">';
  $html += '<i class="zmdi zmdi-edit"></i>';
  $html += '</button>';
  $html += '<button class="item btnItemDelete" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" data-item-id="' + value + '">';
  $html += '<i class="zmdi zmdi-delete"></i>';
  $html += '</button>';
  $html += '</div>';

  return $html;
}
