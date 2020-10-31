(function($) {
 
    $.fn.imSlider = function() {

        if(this.length > 1) {
            this.each(function(){ $(this).imSlider(); });
            return;
        }

        // wrap object
        $(this).wrap('<div class="imSlider"></div>')
            .after('<nav><span class="prev"><</span><span class="next">></span></nav>');

        // remove whitespace
        $(this).html($(this).html().replace(/>\s+</g,'><').trim());
        
        // pad elements
        var len = $(this).children().length;
        var mod = len % 6;
        var add = (mod > 0 ? 6 - mod : 0) + (len <= 6 ? 6 : 0);
        for(i = 0; i<add; i++) {
            $(this).append($($(this).children()[i]).clone());
        }

        // reorder elements
        $(this).children().first().addClass('active');
        for(var i=0; i<$(this).children().length-2; i++) {
            if(i<4) {
                $(this).append($(this).children().first());
            } else {
                $(this).prepend($(this).children()[i-4]);
            }
        }

        var prevX = 0;
        var dragging = false;

        $(this).on('touchstart dragstart', function(e) {
            dragging = true;
            prevX = e.clientX || e.originalEvent.touches[0].clientX;
            e.preventDefault();
        });

        $(window).on('touchmove mousemove', function(e) {
            if(!dragging) return;
            var curX = e.pageX || (e.originalEvent.touches && e.originalEvent.touches[0].pageX);
            if(Math.abs(prevX - curX)>10) {
                dragging = false;
                if(prevX > curX) next(); else prev();
                prevX = curX;
            }
        });

        $(this).parent().find('.next').click(function(){next()});
        $(this).parent().find('.prev').click(function(){prev()});

        var el = this;
        var next = function() {
            if($(el).is('.prev, .next')) return;
            $(el).removeClass('notransition').addClass('next');
            var active = $(el).children('.active');
            active.one('transitionend', function(e) {
                $(el).addClass('notransition').removeClass('next');
                $(active.prev().prev().detach()).prependTo(el);
                $(active.prev().prev().detach()).appendTo(el);
                active.removeClass('active').next().addClass('active');
            });
        }

        var prev = function() {
            if($(el).is('.prev, .next')) return;
            $(el).removeClass('notransition');

            var active = $(el).children('.active');
            var tmp = $(el).find('.active').prev().prev().prev().after(
                active.next().next().next().detach()
            ).detach();

            $(el).addClass('prev');

            $(el).children('li.active+li').one('transitionend', function(e) {
                $(el).addClass('notransition').removeClass('prev');
                active.removeClass('active').prev().addClass('active').prev().before(
                    $(el).children().first().detach()
                ).prev().prev().before(tmp);
            });
        }

    };

}(jQuery));
