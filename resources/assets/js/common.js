$(function() {

  // add to cart
  function cartAdd(sku) {
    $.ajax({
      method: 'POST',
      url: '/cart/add',
      data: {
        'sku': sku,
        _token: $('meta[name="csrf-token"]').attr('content')
      }
    }).done(function(response) {
      if (response.error) {
        alert(response.error);
      } else {
        if (response.basket) {
          $('.header-nav__cart').addClass('contains').html(response.basket);
        } else {
          $('.header-nav__cart').removeClass('contains');
        }
        $('.cart-list .count[data-sku=' + response.cur_sku + ']').val(response.cur_count);
      }
      $('.cart_total').html(response.total);
    });
  }

  // delete from cart
  function cartDel(sku) {
    $.ajax({
      method: 'POST',
      url: '/cart/del',
      data: {
        'sku': sku,
        _token: $('meta[name="csrf-token"]').attr('content')
      }
    }).done(function(response) {
      if (response.error) {
        alert(response.error);
      } else {
        if (response.basket) {
          $('.header-nav__cart').addClass('contains').html(response.basket);
        } else {
          $('.header-nav__cart').removeClass('contains').html('');
        }
        if (response.cur_count > 0) {
          $('.cart-list .count[data-sku=' + response.cur_sku + ']').val(response.cur_count);
        } else {
          $('.cart-list .count[data-sku=' + response.cur_sku + ']').closest('.cart-list__item').remove();
        }
        $('.cart_total').html(response.total);

        if (response.count < 1) {
          $('.cart-form').html('<h2 style="text-align:center">Ваша корзина пуста</h2>');
        }

      }
    });
  }


  // set inputmask
  var im = new Inputmask("9-999-999-99-99");
  im.mask('#phone');

  // filters
  var getFilterUrl = function() {
    var url = '';

    $('.catalog-filter li ul li.selected, .catalog-filter li.opened .pan').each(function() {

      var id = $(this).parent().closest('li').attr('id'),
        active = false;

      if ($(this).find('.from').length) {

        var from = $(this).find('.from').val().replace(/\s/g, '');
        var to = $(this).find('.to').val().replace(/\s/g, '');
        if (from > 0 || to > 0) {
          url += id + '[' + from + '-' + to + ']&';
          active = true;
        }

      } else if ($(this).hasClass('selected')) {
        var value = $(this).data('id') ? ($(this).data('id')) : $(this).text();
        url += id + '[' + value + ']&';
        active = true;
      }

      if (active) {
        $(this).closest('.catalog-filter>li').addClass('active');
      } else {
        $(this).closest('.catalog-filter>li').removeClass('active');
      }

    });

    var search = $('#search').val();
    if (search) url += 'search=' + search;

    return url;
  }

  // reload filter
  var reloadFilter = function() {
    var url = '/catalog?' + getFilterUrl();

    $('.products').addClass('products--loading');

    $.ajax({
      type: 'GET',
      url: url,
      success: function(data) {
        $('.showmore').html($(data).find('.showmore').html());
        $('.pages').html($(data).find('.pages').html());
        $('.pages').data('itemstotal', $(data).find('.pages').data('itemstotal'));
        $('.products-list').html($(data).find('.products-list').html());
        $('.products').removeClass('products--loading');
        history.pushState(null, null, url);
        var total = $('.pages').data('itemstotal');

        $('.catalog-filter button').each(function() {
          var s1 = parseInt(String(total).slice(-1)),
            s2 = parseInt(String(total).slice(-2));
          var ending1 = 'о',
            ending2 = 'ов';
          if (s1 == 1 && (s2 < 2 || s2 > 20)) {
            ending1 = '';
            ending2 = '';
          } else
          if (s1 > 1 && s1 < 5 && (s2 < 6 || s2 > 20)) {
            ending1 = 'о';
            ending2 = 'а';
          }
          $(this).html('найден' + ending1 + ' ' + total + ' товар' + ending2).show();
        });

      }
    });
  }

  var getCountTimeout = false;
  $('.catalog-filter input').keyup(function(e) {
    if (e.keyCode != 46 && e.keyCode != 13 && e.keyCode != 8 && e.key != undefined && e.key.search(/[0-9]/) < 0) return;
    $($(this).parent().find('button')[0]).html('Идет поиск...').show();
    if (getCountTimeout) clearTimeout(getCountTimeout);
    var that = this;

    getCountTimeout = setTimeout(function() {
      reloadFilter();
    }, 1000)
  });

  // choose filter + display
  $('.catalog-filter li .pan ul li').click(function(e) {
    $(this).toggleClass('selected');
    $($(this).parent().parent().find('button')[0]).html('Идет поиск...').show();
    reloadFilter();
    e.stopPropagation();
    e.preventDefault();
  });

  // clear filter
  $('.catalog-filter span.clear').click(function(e) {
    $(this).parent().find('li').each(function() {
      $(this).removeClass('selected');
    });
    $(this).parent().find('input').each(function() {
      $(this).val('');
    });

    $(this).closest('li').removeClass('active');

    reloadFilter();
    e.stopPropagation();
    e.preventDefault();
  });

  // filter item
  $('.catalog-filter>li').click(function() {
    var opened = $(this).hasClass('opened');
    $('.catalog-filter li').removeClass('opened');
    if (!opened) {
      $(this).addClass('opened');
    }
  });

  $('.catalog-filter>li input[type=text]').click(function(e) {
    e.stopPropagation();
  });

  // Only numbers and delete/backspace keys + number formatting
  $('.from, .to').keyup(function(e) {
    $(this).val(localNumberFormat($(this).val()));
  });

  // Only number keys should be displayed
  $('.from, .to').keypress(function(event) {
    if (isNaN(String.fromCharCode(event.which))) {
      event.preventDefault(); //stop character from entering input
    }
  });

  // Number format
  function localNumberFormat(val) {
    parsed = parseInt(val.replace(/\s+/g, ""));
    return isNaN(parsed) ? val : String(parsed).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1 ");
  }


  // search

  // close on click anywhere
  $(window).click(function(e) {
    var cl = Array.from(e.target.classList);
    if (!Array.isArray(cl) || cl.indexOf('header-nav__search') > -1) return;
    $('.header-nav__search.active').click();
  });

  $('.header-nav__search input').click(function(e) {
    e.stopPropagation();
  });

  $('.header-nav__search').click(function(e) {
    // hide filters
    $('.catalog-filter li').removeClass('opened');
    if ($(this).hasClass('active')) {
      $(this).removeClass('active').find('input').val('');
      $('.header-nav__cart').removeClass('small');
      $('.header-nav__search .search-result').hide().html('');
    } else {
      $(this).addClass('active');
      $('.header-nav__search input').focus();
      $('.header-nav__cart').addClass('small');
    }
  });

  $('.header-nav__search input').blur(function(e) {
    if ($(e.originalEvent.relatedTarget).hasClass('search-result__item')) return;
    if (!$(e.originalEvent.relatedTarget).hasClass('header-nav__search')) {
      $('.search-result__item').click();
    }
  });

  var search = function(s) {
    $.ajax({
      method: 'GET',
      url: '/catalog/search/?search=' + encodeURIComponent(s),
    }).done(function(response) {
      if (response.error) {
        console.log(response.error);
      } else {
        $('.header-nav__search .search-result').show().html(response);
      }
    });
  }

  var search_t = false;
  $('.header-nav__search input').keyup(function() {
    if ($(this).val().length < 3) return;
    if (search_t) {
      clearTimeout(search_t);
    }
    var that = this;
    search_t = setTimeout(function() {
      search($(that).val());
    }, 500);
  });

  if ($('.cart section').height() > $(window).height()) {
    $('body').addClass('fixed-form');
  }

  // empty cart click

  $('.header-nav__cart').click(function() {
    if (!$(this).hasClass('contains')) {
      $('.cart-empty').fadeIn();
      setTimeout(function() {
        $('.cart-empty').fadeOut();
      }, 2000);
      return false;
    }
  });

});
