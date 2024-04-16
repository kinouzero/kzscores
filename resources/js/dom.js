jQuery(function () {
  initDom($('body'));
});

function initDom(scope) {
  // Select2
  initSelect2(scope.find('.select2'));

  // Datatable
  initDatatable(scope.find('.datatable'));

  // Switch form
  initSwitchForm(scope.find('.switch-form'));

  // Btn delete
  initBtnForm(scope.find('.btn-form'));

  // Input icon
  initInputIcon(scope.find('.input-icon'));

  // Change type
  initChangeType(scope.find('.change-type'));

  // Input number
  initInputNumber(scope.find('input[type="number"]'))

  // Sort
  initSort(scope.find('.sortable'));

  // Limit value
  initLimitValue(scope.find('.limit-value'));

  // Form with min one input
  initMinOne(scope.find('.min-one-input'))

  // Form with max one input
  initMaxOne(scope.find('.max-one-input'))

  // Row btns
  scope.find('.btn-add-row').click(function () {
    addRow($($(this).data('row-container')));
  });

  scope.find('.btn-remove-row').click(function () {
    removeRow($(this).closest('.row'), $(this).closest('.row-list'));
  });

  // Tooltip
  scope.find('[data-bs-toggle="tooltip"]').tooltip();

  // Popover
  scope.find('[data-bs-toggle="popover"]').popover({ html: true, sanitize: false })
    .on('show.bs.popover', function () {
      $('[data-bs-toggle="popover"]').not(this).popover('hide');
    })
    .on('shown.bs.popover', function () {
      $('#' + $(this).attr('aria-describedby')).find('.collapse').collapse();
      initDom($('#' + $(this).attr('aria-describedby')));
    });
}

function initSelect2(dom) {
  $.each(dom, function () {
    let select = this;
    $(select).select2({
      theme: 'bootstrap-5',
      placeholder: {
        id: '',
        text: $(select).data('placeholder')
      },
      allowClear: true,
      width: 'style'
    });

    if (!isTouchDevice()) $(document).on('click', function (e) {
      var container = $(select).siblings('.select2-container');
      if (!container.is(e.target) && container.has(e.target).length === 0) $(select).select2('close');
    });

    $(document).on('keydown', function (e) {
      if (e.key === "Escape") $(select).select2('close');
    });
  });
}

function initDatatable(dom) {
  dom.DataTable({
    "paging": true,
    "pagingType": "simple_numbers",
    "lengthChange": false,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "responsive": true,
    "layout": {
      topStart: 'search',
      topEnd: 'paging',
      bottomStart: 'info',
      bottomEnd: 'paging'
    }
  });
}

function initSwitchForm(dom) {
  dom.on('change', function () {
    $($(this).data('target')).collapse('toggle');
    $($(this).data('form'))[0].submit();
  })
}

function initBtnForm(dom) {
  dom.on('click', function (e) {
    e.preventDefault();
    $($(this).data('form'))[0].submit();
  });
}

function addRow(dom) {
  // Clean allert if needed
  dom.find('.alert').remove();

  let count = dom.find('.row').not('.row-clone').length;

  // Clone row
  let newRow = dom.find('.row-clone.d-none').clone().removeClass('row-clone d-none');
  newRow.html(newRow.html().replace(/uid/g, ++count));
  newRow.find('select').addClass('select2');
  dom.append(newRow);

  // Init
  initSelect2(newRow.find('.select2'));
  newRow.find('.btn-remove-row').click(function () {
    removeRow($(this).closest('.row'), $(this).closest('.row-list'));
  });
}

function removeRow(dom, parent) {
  dom.remove();
  if (parent.find('.row').not('.row-clone').length === 0) parent.append('<div class="alert alert-secondary text-center">' + parent.data('empty-msg') + '</div>')
}

function initInputIcon(dom) {
  dom.find('input').keyup(function () {
    dom.find('i').attr('class', $(this).val());
  });
}

function initChangeType(dom) {
  dom.on('select2:select', function (e) {
    let card = $(dom.data('card'));
    let btn = $(dom.data('btn'));
    if (e.params.data.id === 'select') {
      card.removeClass('d-none');
      btn.removeClass('d-none');
    } else {
      card.addClass('d-none');
      btn.addClass('d-none');
    }
  });
}

function initSort(dom) {
  dom.sortable({
    handle: '.sort-handle'
  });
}

function initInputNumber(dom) {
  dom.on('keydown', function (e) {
    if (!(e.key === "Enter" || e.key === "Backspace" || e.key === "Delete" || e.key === "ArrowLeft" || e.key === "ArrowRight" || e.key === "Tab" || (e.key >= "0" && e.key <= "9"))) e.preventDefault();
  });
}

function initLimitValue(dom) {
  dom.on('blur', function () {
    let value = parseInt($(this).val());
    let min = parseInt($(this).attr('min'));
    let max = parseInt($(this).attr('max'));
    let modulo = parseInt($(this).attr('modulo'));

    if (isNaN(value) || (modulo && ((value % modulo) !== 0)) || value < min || value > max) $(this).val(null);
  });
}

function initMinOne(dom) {
  dom.on('submit', function (e) {
    $(this).find('.alert-min').remove();
    let inputs = $(this).find('input.form-control:not(:disabled)').filter(function () {
      return $(this).val() !== '';
    });
    if (inputs.length === 0) {
      e.preventDefault();
      $(this).prepend('<div class="alert-min alert alert-danger">Ajouter un score</div>');
    }
  });
}

function initMaxOne(dom) {
  dom.on('submit', function (e) {
    $(this).find('.alert-max').remove();
    let inputs = $(this).find('input.form-control:not(:disabled)').filter(function () {
      $(this).removeClass('border-danger');
      return $(this).val() !== '';
    });
    if (inputs.length > 1) {
      e.preventDefault();
      $(this).prepend('<div class="alert-max alert alert-danger">Vous ne pouvez pas ajouter plusieurs score pendant le même tour</div>');
      $.each(inputs, function () {
        $(this).addClass('border-danger');
      });
    }
  });
}

function isTouchDevice() {
  return 'ontouchstart' in window || navigator.maxTouchPoints;
}