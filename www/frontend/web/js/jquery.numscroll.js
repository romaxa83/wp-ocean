(function($) {
	
	function isInt(num) {
		var res = false;
		try {
			if(String(num).indexOf(".") == -1 && String(num).indexOf(",") == -1) {
				res = parseInt(num) % 1 === 0 ? true : false;

			}
		} catch(e) {
			res = false;
		}
		return res;
	}
	function isHasSpaces(num) {
		var res = -1;
		if(num.indexOf(' ') > -1) {
			var tempNum = String(num).replace(" ", ".");
			return false;
			try {
				if(String(tempNum).indexOf(".") != -1) {
					var index = String(tempNum).indexOf(".") + 1;
					var count = String(tempNum).length - index;
					if(index > 0) {
						res = count;
					}
				}
			} catch(e) {
				res = -1;
			}
			return res;
		}
		else {
			return res;
		}

	}
	function isFloat(num) {
		var res = -1;
		try {
			if(String(num).indexOf(".") != -1) {
				var index = String(num).indexOf(".") + 1;
				var count = String(num).length - index;
				if(index > 0) {
					res = count;
				}
			}
		} catch(e) {
			res = -1;
		}
		return res;
	}

	$.fn.numScroll = function(options) {
		
		var settings = $.extend({
			'time': 1500,
			'delay': 0
		}, options);
		
		return this.each(function() {
			var $this = $(this);
			var $settings = settings;
			
			var num = $this.attr("data-num") || $this.text();
			var temp = 0;
			$this.text(temp);
			var isHasSpaces = false;
			if(String(num).indexOf(' ') != -1) {
				num = String(num).replace(' ', '.');
				num = parseFloat(num);
				var indexSp = String(num).indexOf(".");
				var counterSp = String(num).length - indexSp;
				num = num.toFixed(counterSp);
				isHasSpaces = true;
			}
			var numIsInt = isInt(num);
			var numIsFloat = isFloat(num);
		

		
			var step = (num / $settings.time) * 10;
			setTimeout(function() {
				var numScroll = setInterval(function() {
				 if(numIsInt) {
						$this.text(Math.floor(temp));
					} else if(numIsFloat != -1) {
							if(isHasSpaces) {
								var newNum = temp.toFixed(counterSp);
								newNum = String(newNum).replace('.', ' ');
								$this.text(newNum);
							}
							else {
								$this.text(temp.toFixed(numIsFloat));
							}
						
					} else {
						$this.text(num);
						clearInterval(numScroll);
						return;
					}
					temp += step;
					if(temp > num) {
						if(isHasSpaces) {
							var newNum2 = String(num).replace('.', ' ');
							$this.text(newNum2);
							clearInterval(numScroll);
							return;
						}
						else {
							$this.text(num);
							clearInterval(numScroll);
						}
					}
				}, 1);
			}, $settings.delay);
			
		});
	};

})(jQuery);