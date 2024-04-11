jQuery(function () {
  yamNumbersTotal();
  yamNumbersBonus();
  yamFiguresTotal();
  yamTotal();
  yamBestPlayer();
});

function yamNumbersTotal() {
  $('.yam-form').each(function () {
    let form = $(this);
    let inputs = form.find('.yam-number');
    let total = form.find('.yam-total-numbers');

    let score = 0;
    inputs.each(function () {
      let value = parseInt($(this).val());
      if (isNaN(value)) return;
      score += value;
    });
    total.val(score || 0);

    inputs.on('blur', function () {
      let score = 0;
      inputs.each(function () {
        let value = parseInt($(this).val());
        if (isNaN(value)) return;
        score += value;
      });
      total.val(score || 0).trigger('change');
    });
  });
}

function yamNumbersBonus() {
  $('.yam-form').each(function () {
    let form = $(this);
    let total = form.find('.yam-total-numbers');
    let bonus = form.find('.yam-total-bonus');

    if (parseInt(total.val()) >= 63) {
      bonus.val(35);
      bonus.addClass('border-success');
    } else {
      bonus.val(0);
      bonus.removeClass('border-success');
    }

    total.on('change', function () {
      if (parseInt($(this).val()) >= 63) {
        bonus.val(35);
        bonus.addClass('border-success');
      } else {
        bonus.val(0);
        bonus.removeClass('border-success');
      }
    })
  });
}

function yamFiguresTotal() {
  $('.yam-form').each(function () {
    let form = $(this);
    let inputs = form.find('.yam-figure');
    let total = form.find('.yam-total-figures');

    let score = 0;
    inputs.each(function () {
      let value = parseInt($(this).val());
      if (isNaN(value)) return;
      score += value;
    });
    total.val(score || 0);

    inputs.on('blur', function () {
      let score = 0;
      inputs.each(function () {
        let value = parseInt($(this).val());
        if (isNaN(value)) return;
        score += value;
      });
      total.val(score || 0).trigger('change');
    });
  });
}

function yamTotal() {
  $('.yam-form').each(function () {
    let form = $(this);
    let total = form.find('.yam-total');

    let totalNumbers = form.find('.yam-total-numbers');
    let totalFigures = form.find('.yam-total-figures');
    let totalBonus = form.find('.yam-total-bonus');

    total.val(parseInt(totalNumbers.val()) + parseInt(totalFigures.val()) + parseInt(totalBonus.val()) || 0).trigger('change');

    totalNumbers.on('change', function () {
      total.val(parseInt(totalNumbers.val()) + parseInt(totalFigures.val()) + parseInt(totalBonus.val()) || 0).trigger('change');
    });

    totalFigures.on('change', function () {
      total.val(parseInt(totalNumbers.val()) + parseInt(totalFigures.val()) + parseInt(totalBonus.val()) || 0).trigger('change');
    });
  });
}

function yamBestPlayer() {
  let totals = $('.yam-total');
  let maxValue = 0;
  let maxElement = null;

  totals.each(function () {
    let value = parseInt($(this).val());
    if (value > maxValue) {
      maxValue = value;
      maxElement = $(this);
    }
  });

  totals.removeClass('border-success');
  if (maxElement) maxElement.addClass('border-success');

  totals.on('change', function () {
    let maxValue = 0;
    let maxElement = null;

    totals.each(function () {
      let value = parseInt($(this).val());
      if (value > maxValue) {
        maxValue = value;
        maxElement = $(this);
      }
    });

    totals.removeClass('border-success');
    if (maxElement) maxElement.addClass('border-success');
  });
}
