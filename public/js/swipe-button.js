var OFFSET_LEFT = 8;

function getX(e) {
  if (e.type.startsWith('mouse')) return e.clientX;

  var oe = e.originalEvent || e;
  if (oe.touches && oe.touches[0]) return oe.touches[0].pageX;
  if (oe.changedTouches && oe.changedTouches[0]) return oe.changedTouches[0].pageX;
  return 0;
}

function openBootstrapModalById(id) {
  var el = document.getElementById(String(id));
  if (!el) return;

  var instance = bootstrap.Modal.getOrCreateInstance(el);
  instance.show();
}

$('.btn-start').each(function () {
  var $button = $(this);                
  var $slider = $button.find('.btn-swipe');
  var $text = $button.find('.swipe-text');

  var initialX = 0;
  var maxMove = 0;
  var isDragging = false;

  function resetSlider() {
    $text.stop(true).fadeTo(200, 1);
    $slider.stop(true).animate({ left: OFFSET_LEFT + 'px' }, 250);
  }

  function onSuccess() {
    var action = $button.data('action'); 

    if (action === 'modal') {
      var targetId = $button.data('target'); 
      openBootstrapModalById(targetId);
      resetSlider();
      return;
    }

    window.location.href = $button.attr('href');
  }

  $slider.on('mousedown touchstart', function (e) {
    e.preventDefault();

    isDragging = true;
    initialX = getX(e);

    maxMove = $button.width() - $slider.outerWidth() - OFFSET_LEFT;
    if (maxMove < 0) maxMove = 0;

    $slider.css({ left: OFFSET_LEFT + 'px' });
  });

  $(document).on('mousemove touchmove', function (e) {
    if (!isDragging) return;

    var currentX = getX(e);
    var dx = currentX - initialX;

    if (dx < 0) dx = 0;
    if (dx > maxMove) dx = maxMove;

    var percent = maxMove === 0 ? 1 : (1 - dx / maxMove);
    $text.stop(true).fadeTo(0, percent);

    $slider.css({ left: (dx + OFFSET_LEFT) + 'px' });
  });

  $(document).on('mouseup touchend touchcancel', function (e) {
    if (!isDragging) return;
    isDragging = false;

    var endX = getX(e);
    var dx = endX - initialX;

    if (dx >= maxMove * 0.95) {
      $slider.stop(true).animate(
        { left: (maxMove + OFFSET_LEFT) + 'px' },
        120,
        onSuccess
      );
      return;
    }

    resetSlider();
  });

  $button.on('click', function (e) {
    var leftNow = parseFloat($slider.css('left')) || 0;
    var endLeft = maxMove + OFFSET_LEFT;

    if (leftNow < endLeft - 2) {
      e.preventDefault();
    }
  });

  var targetId = $button.data('target');
  if ($button.data('action') === 'modal' && targetId != null) {
    var modalEl = document.getElementById(String(targetId));
    if (modalEl) {
      modalEl.addEventListener('hidden.bs.modal', function () {
        resetSlider();
      });
    }
  }
});
