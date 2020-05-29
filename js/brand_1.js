(function($) {

    'use strict';

	window.Counting = function(elems, options) {

		var _this = this;

        var opt = {type: 'text', unit: 'px', duration: 100, delay: 1000, interval: 5000, repeat: 0, loop: 1, diff: 100, min: 0, max: 10, slowFx: false, slowV: 10, anim: false};

		for(var prop in options) {
			opt[prop] = options[prop];
		}

		var	numbers = [], repeatTimer = null, slotTimer = [], repeat = 0, distance = opt.max - opt.min, slowlyI = 0, animTl = [];

		var LENGTH = elems.length,
            LIMIT = distance * opt.loop * LENGTH - 1;

		this.initialize = function() {
			for(var i=0, start; i<LENGTH; i++) {
                numbers[i] = [];
				start = elems.eq(i).data('number') + 1;
				for(var j=0; j<distance * opt.loop; j++) {
					if(opt.anim === false && start === distance) start = opt.min;
					numbers[i][j] = start;
					start++;
				}
			}
            if(opt.type === 'img' && opt.anim === true) {
                this.setTimeline();
            }
		};

        this.action = function() {
            if(opt.type === 'img' && opt.anim === true) {
                for(var i=0; i<LENGTH; i++) {
                    animTl[i].restart(true, false);
                }
            } else {
                for(var i=0; i<LENGTH; i++) {
                    for(var j=0; j<distance * opt.loop; j++) {
                        this.queue(i, j);
                    }
                }
            }
        };

        this.queue = function(i, j) {
            if(opt.slowFx === true) j - (distance * (opt.loop - 1)) >= 0 ? slowlyI++ : slowlyI = 0;
            var t = (j * opt.duration) + (i * opt.delay) + (Math.pow(slowlyI, 2) * opt.slowV);
            var k = distance * opt.loop * i + j;
            slotTimer[k] = setTimeout(function() {
                if(opt.type === 'text') {
                    elems.eq(i).text(numbers[i][j]);
                } else {
                    opt.unit === 'px' ? elems.eq(i).css({backgroundPositionY: -(opt.diff * numbers[i][j])}) : elems.eq(i).css({top: -(numbers[i][j] * 100) + '%'});
                }
                if(k === LIMIT) {
                    if(opt.repeat === 1 || repeat < opt.repeat - 1) {
                        _this.setTimer();
                        repeat++;
                    } else {
                        typeof opt.callback === 'function' ? opt.callback() : null;
                    }
                }
            }, t);
		};

		this.setTimer = function() {
			clearTimeout(repeatTimer);
			repeatTimer = setTimeout(function() {
				_this.action();
			}, opt.interval);
		};

        this.setTimeline = function(i, j) {
            for(var i=0; i<LENGTH; i++) {
                animTl[i] = new TimelineLite({paused: true, delay: i * (opt.delay / 1000), onComplete: function() {
                    if(opt.repeat === 1 || repeat < opt.repeat - 1) {
                        _this.setTimer();
                        repeat++;
                    } else {
                        typeof opt.callback === 'function' ? opt.callback() : null;
                    }
                }});
                for(var j=0; j<distance * opt.loop; j++) {
                    if(opt.slowFx === true) j - (distance * (opt.loop - 1)) >= 0 ? slowlyI++ : slowlyI = 0;
                    if(opt.unit === 'px') {
                        animTl[i].to(elems.eq(i), (opt.duration / 1000) + (Math.pow(slowlyI, 2) * (opt.slowV / 1000)), {backgroundPositionY: -(opt.diff * numbers[i][j])});
                    } else {
                        animTl[i].to(elems.eq(i), (opt.duration / 1000) + (Math.pow(slowlyI, 2) * (opt.slowV / 1000)), {top: -(numbers[i][j] * 100) + '%'});
                    }
                }
            }
        };

		this.initialize();
	};

}(jQuery));

var counter1 = new Counting($('.numbering1 > li'), {
    duration: 40,
    delay: 300,
    interval: 1000,
    // repeat: 1
});
var counter2 = new Counting($('.numbering2 > li'), {
    duration: 40,
    delay: 300,
    interval: 1000,
    // repeat: 1
});
var counter3 = new Counting($('.numbering3 > li'), {
    duration: 40,
    delay: 300,
    interval: 1000,
    // repeat: 1
});
var counter4 = new Counting($('.numbering4 > li'), {
    duration: 40,
    delay: 300,
    interval: 1000,
    // repeat: 1
});

new YMotion([
	[
		{method: 'call', fx: function() {
			counter1.action();
            counter2.action();
            counter3.action();
            counter4.action();
        }}
	],
    [
        {el: '.el2_1', set: {opacity:0}, to: {opacity:1}, d: 0.6},
        {el: '.el2_2', set: {height:"0"}, to: {height:"100%"}, d: 0.6},
        {el: '.el2_3', set: {height:"0"}, to: {height:"100%"}, d: 0.6},
    ],
    [
        {el: '.el3_1', set: {opacity:0}, to: {opacity:1}, d: 0.6},
        {el: '.el3_2', set: {height:"0"}, to: {height:"100%"}, d: 0.6},
        {el: '.el3_3', set: {height:"0"}, to: {height:"100%"}, d: 0.6},
    ],
    [
        {el: '.el4_1', set: {opacity:0}, to: {opacity:1}, d: 0.6},
        {el: '.el4_2', set: {height:"0"}, to: {height:"100%"}, d: 0.6},
        {el: '.el4_3', set: {height:"0"}, to: {height:"100%"}, d: 0.6},
    ],
    [
        {el: '.el5_1', set: {opacity:0}, to: {opacity:1}, d: 0.6},
        {el: '.el5_2', set: {height:"0"}, to: {height:"100%"}, d: 0.6},
        {el: '.el5_3', set: {height:"0"}, to: {height:"100%"}, d: 0.6},
    ],

]).activate();
