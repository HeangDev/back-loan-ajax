"use strict";

var System = {};

// global instance
System.global = {
  'async_content': {},
  'datatables': {}
};

// core module
System.helper = {};
System.popup = {};
System.async = {};
System.config = {
  datatable: {}
};

// module : helper
System.helper.uid = function (prefix) {
  if (typeof (prefix) == 'undefined') prefix = '';
  return prefix + 'xxxxxxxxxxxxx'.replace(/[x]/g, function (c) {
    var r = Math.random() * 16 | 0,
      v = c == 'x' ? r : (r & 0x3 | 0x8);
    return v.toString(16);
  });
}

// module : popup
System.popup.alert = function (title, message, onOK) {
  alert(title + '\n' + message);
  if (typeof (onOK) === 'function') onOK();
}

System.popup.confirm = function (title, message, onOK, onCancel) {
  if (confirm(title + '\n' + message)) {
    if (typeof (onOK) === 'function') onOK();
  } else {
    if (typeof (onCancel) === 'function') onCancel();
  }
}

System.config.datatable.lengthMenu = [
  [10, 25, 50, 100, -1],
  [10, 25, 50, 100, 'ทั้งหมด']
];
System.config.datatable.language = {
  'decimal': '',
  'emptyTable': 'ไม่พบข้อมูล',
  'info': 'แสดงข้อมูลแถวที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ แถว',
  'infoEmpty': 'ไม่พบข้อมูล',
  'infoFiltered': '(ค้นหาจากข้อมูลทั้งหมด _MAX_ แถว)',
  'infoPostFix': '',
  'thousands': ',',
  'lengthMenu': 'การแสดงผล _MENU_ แถว',
  'loadingRecords': 'กำลังโหลด...',
  'processing': '<i class="fa fa-spinner fa-pulse"></i> กำลังประมวลผล...',
  'search': '',
  'searchPlaceholder': 'ระบุข้อความค้นหา',
  'zeroRecords': 'ไม่พบข้อมูลที่ค้นหา',
  'paginate': {
    'first': 'หน้าแรก',
    'last': 'หน้าสุดท้าย',
    'previous': 'ก่อนหน้า',
    'next': 'ถัดไป'
  },
  'aria': {
    'sortAscending': ': จัดเรียงจากน้อยไปมาก',
    'sortDescending': ': จัดเรียงจากมากไปน้อย'
  }
}

System.toggle_tooltip = function () {
  $('.tooltip').remove();
  $('[data-toggle="tooltip"], .toggle-tooltip').tooltip({
    'container': 'body'
  });
  $('[data-toggle="popover"], .toggle-popover').popover({
    'container': 'body'
  });
}

System.toggle_submit = function () {
  $(document).on('click', '.toggle-submit, [data-toggle="submit"]', function (e) {
    var $this = $(this);
    var target = (typeof ($this.attr('data-target')) != 'undefined') ? $this.attr('data-target') : false;

    var $target = $(target);
    if (target != false && $target.length > 0 && $target.prop('tagName') == 'FORM') {
      if ($target[0].checkValidity()) {
        $target.submit();
        $target[0].reportValidity();
      }
    } else {
      console.error('Toggle Submit : Target <form> not found.');
    }
  });
}

System.toggle_confirm = function () {
  $(document).on('click', 'a.toggle-confirm, a[data-toggle="confirm"]', function (e) {
    e.preventDefault();
    var link = this.href;
    var message = $(this).attr('data-message');
    if (typeof (message) == 'undefined') {
      message = 'Do you want to confirm this operation?';
    }
    var onOK = function () {
      window.location.href = link;
    }
    var onCancel = function () {}

    System.popup.confirm(message, '', onOK, onCancel);
  });
}

System.toggle_modal = function () {
  $(document).on('click', '.toggle-modal', function (e) {
    e.preventDefault();
    var $this = $(this);
    var $target = $($this.attr('data-target'));

    $target.modal();

    // auto fill modal input
    var $params = $this.find('.modal-param');

    for (var i = 0; i < $params.length; i++) {
      var $param = $params.eq(i);
      var input_type = $param.attr('type');
      if (input_type == 'radio') {
        if (!$param.prop('checked')) {
          continue;
        }
      }
      var key = $param.attr('name');
      var value = $param.val();
      var attribute = (typeof ($param.attr('data-attribute')) != 'undefined') ? $param.attr('data-attribute') : 'name';
      var method = (typeof ($param.attr('data-method')) != 'undefined') ? $param.attr('data-method') : 'val';
      
      var $target_input = $target.find('[' + attribute + '="' + key + '"]');
      
      var target_type = $target_input.attr('type');
      if (target_type == 'radio') {
        $target_input.each(function (idx, ele) {
          if ($target_input.eq(idx).val() == value) {
            $target_input.eq(idx).prop('checked', true);
          }
        });
      } else {
        if(method == 'val') {
          $target_input.val(value);
        } else {
          $target_input.html(value);
        }
      }
      
      if (typeof ($target_input.data('trigger')) != 'undefined') {
        target_input.trigger($target_input.data('trigger'));
      }
    }
  });

  $(document).on('shown.bs.modal', function (e) {
    var $modal = $(e.target);
    $(document).off('focusin.modal');
    $modal.find('[autofocus]').focus();
  });
}

System.handle_form_submit = function () {
  $(document).on('submit', 'form:not(.no-confirm)', function (e) {
    e.preventDefault();
    var $this = $(this);
    var message = $(this).attr('data-message');
    if (typeof (message) == 'undefined') {
      message = 'Do you want to confirm this operation?';
    }
    System.popup.confirm(message, '', function() {
      $this.addClass('no-confirm');
      $this.submit();
      $this.removeClass('no-confirm');
    }, null);
  });
}

System.handle_logout = function () {
  $(document).on('click', '.btn-logout', function (e) {
    e.preventDefault();
    var link = this.href;
    var onOK = function () {
      window.location.href = link;
    }
    var onCancel = function () {}

    System.popup.confirm('Do you want to logout?', '', onOK, onCancel);
  });
}

System.init_ajax = function() {
  $(document).ajaxStart(function () {
    // if (System.settings.pace_module && typeof (Pace) != 'undefined') {
    //   Pace.restart();
    // }
  });
  // setup ajax
  $.ajaxSetup({
    'headers': {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    'type': 'POST',
    'dataType': 'json',
    'catch': false,
    'error': function (xhr, status, error) {
      var message;
      if (xhr.status === 0) {
        message = 'Not connected.\nPlease verify your network connection.';
      } else if (xhr.status == 404) {
        message = 'The requested page not found. [404]';
      } else if (xhr.status == 500) {
        message = 'Internal Server Error [500].';
      } else if (status === 'parsererror') {
        message = 'Requested JSON parse failed.';
      } else if (status === 'timeout') {
        message = 'Time out error.';
      } else if (status === 'abort') {
        message = 'Ajax request aborted.';
      } else {
        message = 'Uncaught Error.\n' + xhr.responseText;
      }
      System.popup.alert('error', message);
      console.log(xhr.responseText);
    }
  });
}

// module : async
System.async.init_async_content = function ($scope) {
  if ((typeof ($scope) == 'undefined')) {
    $scope = $(document);
  }

  $scope.find('.async-content').each(function (idx, ele) {
    var $async_content = $(ele);
    $async_content.async_option = {};
    $async_content.async_data = {};
    if (typeof ($async_content.attr('data-autoload')) != 'undefined') {
      $async_content.async_option.autoload = $async_content.attr('data-autoload');
    } else {
      $async_content.async_option.autoload = true;
    }
    if (typeof ($async_content.attr('data-async-append')) != 'undefined') {
      $async_content.async_option.append = $async_content.attr('data-async-append');
    } else {
      $async_content.async_option.append = false;
    }
    $async_content.async_option.ghost = $async_content.hasClass('async-ghost');
    $async_content.async_option.global = $async_content.hasClass('global-loader');

    $async_content.init = false;
    $async_content.url = $async_content.data('url');
    if (typeof ($async_content.url) == 'undefined') {
      console.error('Async-Content: Missing Parameter [url]');
      return;
    }
    $async_content.find('.async-param').each(function (idx, ele) {
      var $input = $(ele);
      var key = $input.attr('data-name')
      if (typeof (key) == 'undefined') {
        key = $input.attr('name');
      }
      $async_content.async_data[key] = $input.val();
      $input.remove();
    });

    $async_content.show_loader = function () {
      if (!$async_content.hasClass('async-loading')) {
        $async_content.addClass('async-loading');
        if (!$async_content.async_option.ghost && !$async_content.async_option.global) {
          var html = '<div class="loader-overlay">' +
            '<div class="pusher"></div>' +
            '<div class="loader-text bold">' +
            '<i class="fa fa-spinner fa-pulse mr-2"></i>' +
            'กำลังโหลด...' +
            '</div></div>';
          $async_content.append(html);
        } else if ($async_content.async_option.global) {
          var html = '<div class="loader-overlay global-overlay">' +
            '<div class="pusher"></div>' +
            '<div class="loader-text bold">' +
            '<i class="fa fa-spinner fa-pulse mr-2"></i>' +
            'กำลังโหลด...' +
            '</div></div>';
          $('body').append(html);
        }
      }
    }

    $async_content.hide_loader = function () {
      if ($async_content.hasClass('async-loading')) {
        if (!$async_content.async_option.ghost && !$async_content.async_option.global) {
          $async_content.find('.loader-overlay').remove();
        } else if ($async_content.async_option.global) {
          $('.loader-overlay').remove();
        }
        $async_content.removeClass('async-loading');
      }
    }

    $async_content.reload = function (callback, force_reload) {
      force_reload = (typeof (force_reload) == 'undefined') ? false : force_reload;
      if (!$async_content.hasClass('async-loading') || force_reload) {
        $async_content.show_loader();
        $.ajax({
          'url': $async_content.url,
          'data': $async_content.async_data,
          'type': 'GET',
          'dataType': 'html',
          'global': false,
          'success': function (response) {
            if ($async_content.async_option.append) {
              $async_content.append(response);
            } else {
              $async_content.html(response);
            }
            System.toggle_tooltip($async_content);
            // System.initFormInput($async_content);
            // System.initTemplate($async_content);
            $async_content.init = true;
            $(document).resize();
          },
          'complete': function () {
            if (typeof (callback) == 'function') {
              callback();
            } else if (typeof (callback) == 'object') {
              for (idx in callback) {
                if (typeof (callback[idx]) == 'function') {
                  callback[idx]();
                }
              }
            }
            $async_content.hide_loader();
            var id = $async_content.attr('id');

            if (typeof (id) != 'undefined') {
              System.global.async_content[id] = $async_content;
            }
          }
        });
      }
    }

    $async_content.force_reload = function (callback) {
      $async_content.reload(callback, true);
    }

    var id = $async_content.attr('id');
    if (typeof (id) != 'undefined') {
      System.global.async_content[id] = $async_content;
    }

    if ($async_content.async_option.autoload == true || $async_content.async_option.autoload == 'true') {
      var callback = $async_content.data('callback');
      $async_content.reload(callback, true);
    }
  });
}

System.async.init_async_form = function () {
  var $ghost = $('#async_form_ghost');
  if ($ghost.length == 0) {
    $('body').append('<div id="async_form_ghost"></div>');
    $ghost = $('#async_form_ghost');
    $ghost.css('display', 'none');
  }

  $(document).on('submit', '.async-form', function (e) {
    e.preventDefault();

    var $async_form = $(this);
    var url = $async_form.data('url');
    var datatype = (typeof ($async_form.attr('data-datatype')) != 'undefined') ? $async_form.attr('data-datatype') : 'html';
    var reset_param = (typeof ($async_form.attr('data-reset-param')) != 'undefined') ? $async_form.attr('data-reset-param') : false;
    var method = (typeof ($async_form.attr('method')) != 'undefined') ? $async_form.attr('method') : 'post';

    var noreset = $async_form.hasClass('no-reset');
    var nopace = $async_form.hasClass('no-pace');
    var is_global = $async_form.hasClass('global-loader');
    var remove = $async_form.hasClass('remove-on-success');
    var reload = $async_form.hasClass('reload-on-success');
    var close_modal = !$async_form.hasClass('modal-opened');
    var statesave = $async_form.hasClass('state-save');

    var callback = $async_form.attr('data-callback');

    var async_content_id = $async_form.attr('data-async-content');
    
    if (typeof (async_content_id) != 'undefined' && typeof (System.global.async_content[async_content_id]) != 'undefined') {
      var $async_content = System.global.async_content[async_content_id];
    }

    var $modal = $async_form.parents('.modal');

    if ($modal.length > 0 && close_modal == true) {
      $modal.modal('hide');
      $('body').removeClass('modal-open');
      $('.modal-backdrop').remove();
    }

    if (typeof (url) != 'undefined') {
      var show_loader = function () {
        if (!$async_form.hasClass('async-loading')) {
          $async_form.addClass('async-loading');
          if (is_global) {
            var html = '<div class="loader-overlay global-overlay">' +
              '<div class="pusher"></div>' +
              '<div class="loader-text bold">' +
              '<i class="fa fa-spinner fa-pulse"></i>' +
              '</div></div>';
            $('body').append(html);
          } else if (typeof ($async_content) != 'undefined') {
            $async_content.show_loader();
          }
        }
      }

      var hide_loader = function () {
        if ($async_form.hasClass('async-loading')) {
          if (is_global) {
            $('.loader-overlay').remove();
          }
          $async_form.removeClass('async-loading');
        }
      }

      var form_data = new FormData(this);
      
      if (!$async_form.hasClass('async-loading')) {
        $async_form.find('[type="submit"]').prop('disabled', true);
        show_loader();
        $.ajax({
          'url': url,
          'type': method,
          'data': form_data,
          'processData': false,
          'contentType': false,
          'dataType': datatype,
          'global': !nopace,
          'success': function (response) {
            if (typeof ($async_content) != 'undefined') {
              if (datatype == 'html') {
                $async_content.html(response);
                $async_content.hide_loader();
              } else {
                $ghost.html(response);
                $async_form.find('.async-param').each(function (idx, ele) {
                  var $input = $(ele);
                  var key = $input.attr('data-name');
                  if (typeof (key) == 'undefined') {
                    key = $input.attr('name');
                  }
                  System.async.data(async_content_id, key, $input.val());
                });
                $async_content.force_reload(callback);
              }
            } else if (typeof (callback) == 'function') {
              callback(response);
            }
            if (!noreset) {
              $async_form[0].reset();
              $async_form.find('input').trigger('change');
              $async_form.find('select').trigger('change');
            }
            if (remove) {
              $async_form.remove();
            }
            if (reload) {
              window.location.reload();
            }
          },
          'complete': function () {
            $async_form.find('[type="submit"]').prop('disabled', false);

            if (is_global) {
              $('.loader-overlay').remove();
            }
            hide_loader();
          }
        });
      }
    } else {
      if (typeof ($async_content) != 'undefined') {
        var form_data = $async_form.serializeArray();
        if (reset_param) {
          $async_content.async_data = {};
        }
        for (var i = 0; i < form_data.length; i++) {
          var data = form_data[i];
          System.async.data(async_content_id, data.name, data.value);
        }
        var tmp_callback = [];
        tmp_callback.push(callback);
        tmp_callback.push(function () {
          $async_form.find('[type="submit"]').prop('disabled', false);
        });
        $async_content.reload(tmp_callback);
      } else if (typeof (callback) == 'function') {
        callback(response);
        $async_form.find('[type="submit"]').prop('disabled', false);
      }
      if (!noreset && !statesave) {
        $async_form[0].reset();
        $async_form.find('input').trigger('change');
        $async_form.find('select').trigger('change');
      }
    }
    if (statesave) {
      var async_data = $async_content.async_data;
      var state_url = window.location.pathname + '?';
      for (var name in async_data) {
        state_url += (name + '=' + async_data[name]);
        state_url += '&';
      }
      window.history.replaceState($('body').html(), document.title, state_url);
    }
  });

  $(document).on('click', '.async-link', function (e) {
    e.preventDefault();
    var $async_link = $(this);
    var reset_param = (typeof ($async_link.attr('data-reset-param')) != 'undefined') ? $async_link.attr('data-reset-param') : false;
    var url = $async_link.data('url');
    var is_global = $async_link.hasClass('global-loader');

    var async_content_id = $async_link.attr('data-async-content');
    if (typeof (async_content_id) != 'undefined' && typeof (System.global.async_content[async_content_id]) != 'undefined') {
      var $async_content = System.global.async_content[async_content_id];
    }

    if (typeof ($async_content) != 'undefined') {
      if (reset_param) {
        $async_content.async_data = {};
      }
      var async_data = $async_link.find('.async-param');
      for (var i = 0; i < async_data.length; i++) {
        var $input = async_data.eq(i);
        var key = $input.attr('data-name');
        if (typeof (key) == 'undefined') {
          key = $input.attr('name');
        }
        System.async.data(async_content_id, key, $input.val());
      }
      $async_content.reload();
    }

    var statesave = (typeof ($async_link.attr('data-async-statesave')) != 'undefined') ? $async_link.attr('data-async-statesave') : false;
    if (statesave) {
      var async_data = $async_content.async_data;
      var state_url = window.location.pathname + '?';
      for (var name in async_data) {
        state_url += (name + '=' + async_data[name]);
        state_url += '&';
      }
      window.history.replaceState($('body').html(), document.title, state_url);
    }
  });
}

System.async.data = function (id, key, value) {
  var ret = null;
  if (typeof (System.global.async_content[id]) == 'undefined') {
    console.error('Async-Content: Undefined Async ID: [' + id + ']');
  } else {
    var $async_content = System.global.async_content[id];
    if (typeof (key) != 'undefined') {
      if (typeof (value) != 'undefined') {
        // set
        $async_content.async_data[key] = value;
      }
      // get by key
      ret = $async_content.async_data[key];
    } else {
      // get all
      ret = $async_content.async_data;
    }
  }
  return ret;
}

System.async.option = function (id, key, value) {
  var ret = null;
  if (typeof (System.global.async_content[id]) == 'undefined') {
    console.error('Async-Content: Undefined Async ID: [' + id + ']');
  } else {
    var $async_content = System.global.async_content[id];
    if (typeof (value) != 'undefined') {
      $async_content.async_option[key] = value;
    }
    ret = $async_content.async_option[key];
  }
  return ret;
}

System.async.querystring = function (id) {
  var ret = '?';
  if (typeof (System.global.async_content[id]) == 'undefined') {
    console.error('Async-Content: Undefined Async ID: [' + id + ']');
  } else {
    var $async_content = System.global.async_content[id];
    for (key in $async_content.async_data) {
      ret += key + '=' + $async_content.async_data[key] + '&';
    }
  }
  return ret;
}

System.async.reload = function (id, callback) {
  if (typeof (id) == 'undefined') {
    for (async_id in System.global.async_content) {
      System.global.async_content[async_id].reload();
    }
  } else {
    if (typeof (System.global.async_content[id]) == 'undefined') {
      console.error('Async-Content: Undefined Async ID: [' + id + ']');
    } else {
      System.global.async_content[id].reload(callback);
    }
  }
}


System.init_datatable = function ($scope) {
  if (typeof (jQuery.fn.dataTable) != 'undefined') {
    // init datatable & plugins
    var $table = null;
    var $table_search = null;
    if (typeof ($scope) == 'undefined') {
      System.global.datatables = {};
      $table = $('.data-table');
      $table_search = $('.w-data-table-search');
    } else {
      $table = $scope.find('.data-table');
      $table_search = $scope.find('.data-table-search');
    }
    
    $table.each(function (idx, ele) {
      var $this = $(this);
      var id = $this.attr('id');
      var state_save = $this.attr('data-statesave');
      var order = $this.attr('data-orders');
      var local_search = $this.attr('data-local-search');
      // var lengthMenu = [
      //   System.helper.DataTable.lengthMenu[0].slice(0),
      //   System.helper.DataTable.lengthMenu[1].slice(0)
      // ];

      var options = {
        'autoWidth': false,
        'language': System.config.datatable.language,
        'lengthMenu': System.config.datatable.lengthMenu,
        'columnDefs': [{
          'targets': 'no-sort',
          'orderable': false
        }],
        'bDestroy': true,
        'stateSave': (typeof (state_save) != 'undefined') ? state_save : false
      };

      var $tr = $this.find('tbody tr');
      $tr.addClass('fadeIn animated');
      var $datatable = $this.DataTable(options);
      $this.css('display', 'table');
      // $tr.removeClass('d-none');
      $datatable.on('draw', function () {
        $tr.removeClass('d-none');
      });

      // if (typeof (order) != 'undefined') {
      //   $datatable.order([eval(order)]).draw();
      // }

      // if (typeof (id) != 'undefined') {
      //   System.global.datatables[id] = $datatable;

      //   if (typeof (options.buttons) != 'undefined') {
      //     var $button_container = $('.button-container[for="' + id + '"]');
      //     if ($button_container.length > 0) {
      //       $button_container.html($datatable.buttons().container());
      //     }
      //   }
      // }
      if ($this.hasClass('no-search')) {
        var $parent = $this.parents('.dataTables_wrapper');
        var $filter = $parent.find('.dataTables_filter');
        $filter.remove();
      }
      if ($this.hasClass('no-pagelength')) {
        var $parent = $this.parents('.dataTables_wrapper');
        var $length = $parent.find('.dataTables_length');
        $length.remove();
      }

      // $(document).resize();
      if (!$this.hasClass('no-search') && local_search) {
        // generate search input

        var th_search = '<thead><tr>';
        $this.find('thead th').each(function (th_i, th_e) {
          var $th = $(this);
          if ($th.hasClass('no-search-ignore')) {

          } else if (!$th.hasClass('no-search')) {
            var title = $.trim($(th_e).text());
            var list_id = System.helper.uid('list_');

            th_search += '<th class="p-0"><input class="form-control form-control-sm rounded-0" type="search" placeholder="Filter by ' + title + '" title="Filter by ' + title + '" list="' + list_id + '" /></th>';
          } else {
            if ($th.css('display') != 'none') {
              th_search += '<th></th>';
            }
          }
        });
        th_search += '</tr></thead>';
        var $th_search = $(th_search);
        $this.find('thead').after($th_search);

        // apply search
        $datatable.columns().every(function (i) {
          var that = this;
          var $th = $this.find('thead').eq(1).find('th').eq(i);
          var $search_input = $th.find('input');

          if ($search_input.length > 0) {
            $search_input.on('keyup change', function () {
              if (that.search() !== this.value) {
                that.search(this.value).draw();
              }
            });
            var list_id = $search_input.attr('list');

            var $list = $('<datalist id="' + list_id + '"></datalist>');

            var list_data = {};
            for (var d_idx = 0; d_idx < that.nodes().length; d_idx++) {
              var $node = $(that.nodes()[d_idx]);
              if (typeof ($node.data('search')) != 'undefined') {
                list_data[$.trim($node.data('search'))] = 1;
              } else {
                list_data[$.trim($node.text())] = 1;
              }
            }

            for (var key in list_data) {
              var $tmp_dom = $('<div></div>');
              $tmp_dom.html(key);
              var text = $.trim($tmp_dom.text());
              if (text != '') {
                $list.append('<option value="' + text + '">');
              }
            }
            $search_input.after($list);
          }
        });
      }

    });

    // init datatable search
    // $table_search.each(function (idx, ele) {
    //   var $this = $(this);
    //   var table_id = $this.attr('for');
    //   if (typeof (table_id) != 'undefined') {
    //     if (typeof (System.global.datatables[table_id]) != 'undefined') {
    //       var $datatable = System.global.datatables[table_id];
    //       $this.val($datatable.search());
    //     }

    //     // binding event
    //     $this.off('keyup');
    //     $this.on('keyup', function (e) {
    //       $datatable.search($this.val()).draw();
    //     });
    //   }
    // });
  }
}

System.init_forminput = function ($scope) {
  if (typeof ($scope) == 'undefined') {
    $scope = $(document);
  }

  // select all string in textbox on focus
  $scope.off('click', '.select-focus');
  $scope.on('click', '.select-focus', function (e) {
    var $this = $(this);
    $this.select();
  });

  $scope.off('keydown', '.number-only');
  $scope.on('keydown', '.number-only', function (e) {
    var accept_key = [
      '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
      'Tab',
      'Enter',
      'Backspace',
      'Delete',
      'ArrowUp',
      'ArrowRight',
      'ArrowDown',
      'ArrowLeft',
      'Home',
      'End',
      '.',
      '-'
    ];

    if (accept_key.indexOf(e.key) == -1 && !e.ctrlKey) {
      e.preventDefault()
    }
  });

  // autofill required input
  $scope.off('change', 'input[required]');
  $scope.on('change', 'input[required]', function (e) {
    if (this.type == 'number') {
      if ($.trim(this.value) == '') {
        this.value = 0;
      }
    } else if (this.type == 'text') {
      this.value = $.trim(this.value);
    }
  });

  $scope.off('change', 'textarea[required]');
  $scope.on('change', 'textarea[required]', function (e) {
    this.value = $.trim(this.value);
  });

  $scope.off('change', '.dropdown-link');
  $scope.on('change', '.dropdown-link', function (e) {
    window.location.href = this.value;
  });

  if (typeof (Select2) != 'undefined') {
    $scope.find('.toggle-select2, [data-toggle="select2"]').each(function (idx, ele) {
      var $this = $(ele);
      if (typeof ($this.data('select2')) == 'undefined') {
        var $opt = $this.find('option');
        if ($opt.length > 1000) {
          $this.select2({
            'minimumInputLength': 3
          });
        } else {
          $this.select2();
        }
      }
    });
  }

  $scope.off('change', '.range-input')
  $scope.on('change', '.range-input', function (e) {
    var $this = $(this);
    var target = $this.attr('data-range-target');
    var attr = $this.attr('data-range-attr');
    if (typeof (target) == 'undefined') {
      return;
    }
    attr = (typeof (attr) == 'undefined') ? 'min' : attr;
    var $target = $(target);

    $target.attr(attr, $this.val());
  });
  
  $scope.find('.range-input').trigger('change');
}

$(document).ready(function () {
  System.init_ajax();
  System.async.init_async_content();
  System.async.init_async_form();
  System.toggle_tooltip();
  System.toggle_submit();
  System.toggle_confirm();
  System.toggle_modal();
  System.handle_form_submit();
  System.handle_logout();
  System.init_forminput();
  System.init_datatable();
});