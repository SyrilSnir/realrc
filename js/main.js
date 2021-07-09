var companyCodes = [];
var afterSelectPoint = function (price,code,address,widget) {
    var $bxPriceBlock = $('.boxberry_block').find('.carrier_price'),
        $btnNext = $('.cart_navigation > input.exclusive');
    $bxPriceBlock.html('<span class="price">'+ price +',00 руб</span>');
    $("#pickups_list option[data-code='" + code + "']").prop('selected', 'selected');
    $('#selected_pvz').addClass('active').text('Выбран ПВЗ: '+ address);
    $btnNext.removeClass('exclusive_disabled');
    $btnNext.removeAttr('disabled');
    if (typeof widget === 'object') {
        widget.geo.axiMap.balloon.close();
    }
}
var selectPoint = function( a ) {
    $.get('boxberry.php',{ 
        set_pvz : 1,
        pvz_params : {
            "company" : a["company"],
            "address" : a["address"],
            "price" : a["price"],
            "code" : a["code"],
            "geo_lon" : a["lon"],
            "geo_lat" : a["lat"],
            } 
        }, function(data){
                alert('DATA=', data);
                if (data != 1) {
                    location.reload();
                }
               afterSelectPoint (a.price,a.code,a.address);
            });   
    
}
var start_widget = function() {
    // спмсок кодов компании
    $('#carrierTable input').on('change',function() {        
        var $selectedItem = $(this),
            $btnNext = $('.cart_navigation > input.exclusive'),
            $bxContainer = $('.boxberry_container'),
            $bxList = $('#pickups_list');
        if ($selectedItem.hasClass('boxberry')) {
            var $bxContainer =  $('.boxberry_container');                
            if (!$('#selected_pvz').hasClass('active')) {
                $btnNext.attr('disabled','');            
                $btnNext.addClass('exclusive_disabled');
            }
            $bxContainer.removeClass('hide');           
        } else {
            $bxContainer.addClass('hide');
            $btnNext.removeClass('exclusive_disabled');
            $btnNext.removeAttr('disabled');
        }
    });
    if ($('#carrierTable input:checked').hasClass('boxberry')) {
        $('#carrierTable input').trigger('change');
    } 
}
var axi_widget = {};
var axi_analytics = {};

axi_analytics.data = {};
axi_analytics.data.errors = [];

axi_widget.protocol = window.location.protocol;
axi_widget.selection_result = null;
axi_widget.version = '1.2';
axi_widget.config = {};
axi_widget.map_loading_log = {};
axi_widget.map_loading_log.attempts = 0;

axi_widget.build_request_object = function(method, url) {
  var xhr = new XMLHttpRequest();

  if ("withCredentials" in xhr) {
    xhr.open(method, url, true);

  } else if (typeof XDomainRequest !== "undefined") {
    xhr = new XDomainRequest();
    xhr.open(method, url);

  } else {
    xhr = null;
  }

  return xhr;
};

axi_analytics.add = function (value, exception) {
	if (exception !== undefined) {
		value = value + ' : ' + exception;
	}

    axi_analytics.data.errors.push(value);
    axi_analytics.send();
};

axi_analytics.clean = function () {
    axi_analytics.data = {};
    axi_analytics.data.errors = [];
};

axi_analytics.send = function () {
	axi_analytics.data.method = 'collect';
	axi_analytics.data.token = axi_widget.config.token;
	axi_analytics.data.config = axi_widget.config;
	axi_analytics.data.map_loading_log_attempts = axi_widget.map_loading_log.attempts;

	aJ.post(axi_widget.protocol + '//axiomus.ru/widget/analytics.php', axi_analytics.data);
};

axi_widget.assign_fix = function(oa,ob,to){
	if(typeof(Object.assign) !== 'undefined'){
		if(typeof(to) === 'object'){
			return Object.assign(oa,ob,to);
		}else{
			return Object.assign(oa,ob);
		}
	}else{
		var no = {};
		if(typeof(oa) === 'object'){
			for(var p in oa){
				no[p] = oa[p];
			}
		}
		if(typeof(ob) === 'object'){
			for(var r in ob){
				no[r] = ob[r];
			}
		}
		if(typeof(to) === 'object'){
			for(var g in to){
				no[g] = to[g];
			}
		}
		return no;
	}
};

axi_widget.get_config = function(){
	var s = aJ('script[wtype=axi_widget]');

	if (s.length > 0) {
		//console.log($(s).attr('config'));

		var result = false;

		try{
			result = JSON.parse(aJ(s).attr('config').replace(/'/g,'"'));

		}catch(e){
			console.error('Ошибка в JSON конфигурации виджета');
			axi_analytics.add('Ошибка в JSON конфигурации виджета');
		}

		return result;

	} else {
		console.error('У скрипта виджета не найден атрибут "config"');
		axi_analytics.add('У скрипта виджета не найден атрибут "config"');

		return false;
	}
};

axi_widget.init_delivery = function(){
	if(typeof(axi_widget.config.token_dadata) !== 'undefined' && axi_widget.config.token_dadata !== ''){
		if(typeof(aJ(".-aw-address").suggestions) !== 'function'){
			aJ.getScript(axi_widget.protocol+'//cdn.jsdelivr.net/jquery.suggestions/16.8/js/jquery.suggestions.min.js').fail(function (jqxhr, settings, exception) {
                axi_analytics.add(axi_widget.protocol+'//cdn.jsdelivr.net/jquery.suggestions/16.8/js/jquery.suggestions.min.js', exception);
            });

			aJ('head').append(aJ('<link rel="stylesheet" type="text/css" wtype="awcss" />').attr('href', axi_widget.protocol+'//cdn.jsdelivr.net/jquery.suggestions/16.8/css/suggestions.css'));
		}
		var dadatainit = setInterval(function(){
		if(typeof(aJ(".-aw-address").suggestions) === 'function'){
			clearInterval(dadatainit);
			aJ(".-aw-address").suggestions({
				serviceUrl: axi_widget.protocol+"//suggestions.dadata.ru/suggestions/api/4_1/rs",
				token: axi_widget.config.token_dadata,
				type: "ADDRESS",
				count: 5,
				onSelect: function(suggestion) {
					//console.log(suggestion);
				}
			});

			aJ('input[action=-aw-calc_delivery]').on('click',function(){
				get_price_delivery();
			});

			aJ('.-aw-address').keypress(function (e) {
			  if (e.which == 13) {
				aJ('input[action=-aw-calc_delivery]').click();

				return false;   
			  }
			});

			aJ('.-aw-address').on('focus',function(){
				var padding_top = '';

				if(String(axi_widget.config.height).indexOf('%') >= 0){
					padding_top += '10%';
				}

				if(String(axi_widget.config.height).indexOf('px') >= 0){
					padding_top = parseInt(parseInt(axi_widget.config.height)*0.45);
					padding_top += 'px';
				}

				aJ('.-aw-delivery_field').css('padding-top',padding_top);
				aJ('.-aw-delivery_result').html('');
			});
			}
		},20);

	}else{
	var deliveryinit = setInterval(function(){
			if(typeof(get_price_delivery) === 'function'){
				clearInterval(deliveryinit);
				aJ('input[action=-aw-calc_delivery]').on('click',function(){
					get_price_delivery();
				});

				aJ('.-aw-address').keypress(function (e) {
					  if (e.which == 13) {
						aJ('input[action=-aw-calc_delivery]').click();
						return false;   
					  }
				});

				aJ('.-aw-address').on('focus',function(){
					var padding_top = '';

					if(String(axi_widget.config.height).indexOf('%') >= 0){
						padding_top += '10%';
					}

					if(String(axi_widget.config.height).indexOf('px') >= 0){
						padding_top = parseInt(parseInt(axi_widget.config.height)*0.45);
						padding_top += 'px';
					}

					aJ('.-aw-delivery_field').css('padding-top',padding_top);
					aJ('.-aw-delivery_result').html('');
				});
				
			}
		},20);
	}
};

axi_widget.init_carry = function(){
	if(typeof(ymaps) === 'undefined'){
		var add_key = '';

		if(typeof(axi_widget.config.token_yandex) !== 'undefined' && axi_widget.config.token_yandex !== ''){
			add_key = '&apikey='+axi_widget.config.token_yandex;
		}

		aJ.getScript(axi_widget.protocol+'//api-maps.yandex.ru/2.1/?lang=ru_RU&coordorder=latlong&mode=release'+add_key).fail(function (jqxhr, settings, exception) {
            axi_analytics.add(axi_widget.protocol+'//api-maps.yandex.ru/2.1/?lang=ru_RU&coordorder=latlong&mode=release', exception);
        });
	}

	if(typeof(axi_widget.geo) === 'undefined'){
		aJ.getScript(axi_widget.protocol+'//axiomus.ru/widget/'+axi_widget.version+'/scripts/geo.js').fail(function (jqxhr, settings, exception) {
			axi_analytics.add(axi_widget.protocol+'//axiomus.ru/widget/'+axi_widget.version+'/scripts/geo.js', exception);
        });
	}
		var custom_img = function(){
			if(typeof(axi_widget.config.custom_pvz_icon) !== 'undefined' && axi_widget.config.custom_pvz_icon !== ''){
				if(typeof(axi_widget.config.custom_icon_width) !== 'undefined' && typeof(axi_widget.config.custom_icon_height) !== 'undefined'){
					if(axi_widget.config.custom_icon_width > 0 || axi_widget.config.custom_icon_height > 0){
						return true;
					}else{
						console.log('Custom pvz image size is 0x0!');
                        axi_analytics.add('Custom pvz image size is 0x0!');
						return false;
					}
				}else{
					return false;
				}
			}else{
				return true;
			}
		}

		var yinit = setInterval(function(){
			if(typeof(ymaps) !== 'undefined' && typeof(initMap) !== 'undefined' && typeof(ymaps.geolocation) !== 'undefined' && custom_img()){
				clearInterval(yinit);
				if((typeof(axi_widget.config.geolocation) !== 'undefined' && axi_widget.config.geolocation === 'true' && typeof(ymaps.geolocation.get) === 'function') && (typeof(axi_widget.config.lon) === 'undefined' || typeof(axi_widget.config.lon) === 'undefined' || axi_widget.config.lat === '' || axi_widget.config.lon === '' || axi_widget.config.lat === 0 || axi_widget.config.lon === 0 )){
					var geoposition_result = ymaps.geolocation.get({provider: 'yandex', autoReverseGeocode: false}).then(function (result) {
						//console.log(result);
						axi_widget.config.lat = result.geoObjects.position[0];
						axi_widget.config.lon = result.geoObjects.position[1];
						axi_widget.geo = {};
						ymaps.ready(initMap);
					});
					
				}else{
					if(typeof(axi_widget.config.lon) === 'undefined' || typeof(axi_widget.config.lon) === 'undefined' || axi_widget.config.lat === '' || axi_widget.config.lon === '' || axi_widget.config.lat === 0 || axi_widget.config.lon === 0 || isNaN(parseInt(axi_widget.config.lat)) || isNaN(parseInt(axi_widget.config.lon))){
						axi_widget.config.lat = 55.820431;
						axi_widget.config.lon = 37.597148;
					}
					axi_widget.geo = {};
					ymaps.ready(initMap);
				}
			}
			axi_widget.map_loading_log.attempts++; 
		},1001);
};

axi_widget.init = function(){
	
	if(typeof($) !== 'function'){
		window.aJ = jQuery.noConflict(false);
		window.$ = window.aJ;

	} else {
		window.aJ = jQuery;
	}
	
	if(aJ('div#axi_widget').length > 0){
		if(aJ.isEmptyObject(axi_widget.config) === false){
			if(typeof(axi_widget.config.notload) === 'undefined'){
				console.error('Ошибка инициализации - виджет уже инициализирован ранее. Для переинициализации виджета сначала вызовите функцию axi_widget.destroy()');
          		axi_analytics.add('Ошибка инициализации - виджет уже инициализирован ранее. Для переинициализации виджета сначала вызовите функцию axi_widget.destroy()');
				return;
			}
		}

		if(axi_widget.config = axi_widget.get_config()){
			if(typeof(axi_widget.config.notload) !== 'undefined' && axi_widget.config.notload === 1){
				return;
			}

			if(axi_widget.config.token.length > 16){
				axi_widget.config.token = axi_widget.config.token.substr(0,16);
			}

			if(typeof(axi_widget.config.height) !== 'undefined' && parseInt(axi_widget.config.height) > 0){
				if(String(axi_widget.config.height).indexOf('%') < 0){
					if((parseInt(window.innerHeight) < parseInt(axi_widget.config.height) + 39) && ('ontouchstart' in window || navigator.MaxTouchPoints > 0 || navigator.msMaxTouchPoints > 0)){
						if(parseInt(window.innerHeight) <= parseInt(axi_widget.config.height) + 39){
							
						//	console.log(window.innerHeight <= parseInt(axi_widget.config.height) + 39);
						//	console.log('changing height...');
						//	console.log('old: '+parseInt(axi_widget.config.height) + 39);
						//	console.log('new: '+parseInt(window.innerHeight) - 165);
							axi_widget.config.height = parseInt(window.innerHeight) - 165;
						}
					}
					if(String(axi_widget.config.height).indexOf('px') < 0){
						axi_widget.config.height += 'px';
					}
				}else{
					axi_widget.config.height = '100%';
				}
			}else{
				axi_widget.config.height = '100%';
			}
			
			var default_carry = '';
			var default_delivery = '';
			var hide_carry = '';
			var hide_delivery = '';

			if(typeof(axi_widget.config.width) !== 'undefined' && parseInt(axi_widget.config.width) > 0){
				if(String(axi_widget.config.width).indexOf('%') >= 0){
					aJ('div#axi_widget').css('width',axi_widget.config.width);
					axi_widget.config.width = 'width:'+axi_widget.config.width;
				}else{
					if(String(axi_widget.config.width).indexOf('px') >= 0){
						axi_widget.config.width = parseInt(axi_widget.config.width);
					}
					aJ('div#axi_widget').css('width',axi_widget.config.width+'px');
					axi_widget.config.width = 'width:'+axi_widget.config.width+'px';
				}
			}else{
				aJ('div#axi_widget').css('width','100%');
				axi_widget.config.width = 'width:100%';
			}

			if((typeof(axi_widget.config.default_type) === 'undefiened' || axi_widget.config.default_type === 'carry') || axi_widget.config.calc_enable === 'false'){
				default_carry = '-aw-selected';
				hide_delivery = '-aw-hidden';
			}else{
				default_delivery = '-aw-selected';
				hide_carry = '-aw-hidden';
			}

			if(axi_widget.config.default_type === 'delivery' && axi_widget.config.delivery_enable === 'false'){
				default_carry = '-aw-selected';
				hide_delivery = '-aw-hidden';
			}

			if(axi_widget.config.default_type === 'carry' && axi_widget.config.carry_enable === 'false'){
				default_delivery = '-aw-selected';
				hide_carry = '-aw-hidden';
			}

			var aw_type = function(){
				if(axi_widget.config.delivery_enable === 'true' && axi_widget.config.carry_enable === 'true' && axi_widget.config.calc_enable === 'true'){
					return '<div class="-aw-navigation font-bold">'+
								'<ul>'+
									'<li class="-aw-nav '+default_carry+'" tab="carry">Самовывоз</li>'+
									'<li class="-aw-nav '+default_delivery+'" tab="delivery">Доставка</li>'+
								'</ul>'+
							'</div>';
					}else{
						if(axi_widget.config.delivery_enable === 'true'){
							return '';
						}
						if(axi_widget.config.carry_enable === 'true' || axi_widget.config.calc_enable === 'false'){
							return '';
						}
						
					}
			}
			
			var aw_carry_html = function(){
				var html = '';
				if(axi_widget.config.carry_enable === 'true' || axi_widget.config.calc_enable === 'false'){
					if(axi_widget.config.delivery_enable === 'false'){
						aJ('#-aw-load_locker').css('transform','translate(-50%, 0%)');
						aJ('#-aw-load_locker').addClass('-aw-hidden');
					}
					setTimeout(axi_widget.init_carry(),150);
						
						html = '<div class="-aw-content carry '+hide_carry+'" style="height:'+axi_widget.config.height+';'+axi_widget.config.width+'">'+
									'<div class="-aw-carry_result"></div>'+
									'<div id="awmap" style="height:'+axi_widget.config.height+';'+axi_widget.config.width+'"></div>'+
								'</div>';

				}else{
					html = '';
				}
				return html;
			}

			var aw_delivery_html = function(){
				var html = '';
				if(axi_widget.config.delivery_enable === 'true'){
					setTimeout(axi_widget.init_delivery(),150);
					html = '<div class="-aw-wide"></div>';
					var padding_top = '';

					if(String(axi_widget.config.height).indexOf('%') >= 0){
						padding_top += '10%';
					}

					if(String(axi_widget.config.height).indexOf('px') >= 0){
						padding_top = parseInt(parseInt(axi_widget.config.height)*0.45);
						padding_top += 'px';
					}
					
					html += '<div class="-aw-content delivery '+hide_delivery+'" style="min-height:'+axi_widget.config.height+';'+axi_widget.config.width+'">'+
					'<div class="-aw-wide  -aw-center -aw-calc-result-row-err"></div>'+
						'<div class="-aw-row_n -aw-wide -aw-delivery_field" style="padding-top:'+padding_top+';">'+
							'<div class="-aw-r_65  -aw-top"><input class="-aw-address" type="text" name="address" placeholder="Город, улица, дом, кв." autocomplete="off"></div>'+
							'<div class="-aw-r_20  -aw-top"><input class="-aw-button -aw-calc_delivery" type="button" weld="-aw-address" action="-aw-calc_delivery" value="Рассчитать"></div>'+
						'</div>'+
						'<div class="-aw-wide -aw-delivery_result  -aw-row_n"></div>'+
					'</div>';
				}else{
					html = '';
				}
				return html;
			}

			var aw_html = aw_type()+
			'<div class="-aw-tabs"">'+aw_carry_html()+aw_delivery_html()+
			'</div>';

			aw_html += '<div id="-aw-load_locker" style="height:100%;'+axi_widget.config.width+'">'+
							'<div id="-aw-load_icon"></div>'+
						'</div>';
			if(typeof(axi_widget.config.custom_pvz_icon) !== 'undefined' && axi_widget.config.custom_pvz_icon !== ''){
				aw_html += '<img class="-aw-hidden -aw-custom-icon-block"/>';
			}
			
			aJ('#axi_widget').append(aw_html);
			
			if(typeof(axi_widget.config.custom_pvz_icon) !== 'undefined' && axi_widget.config.custom_pvz_icon !== ''){
				aJ(".-aw-custom-icon-block")
				.attr("src", axi_widget.config.custom_pvz_icon)
				.on('load',function() {
					axi_widget.config.custom_icon_width = this.width; 
					axi_widget.config.custom_icon_height = this.height;
					//console.log('img loaded...');
					//console.log('w: '+axi_widget.config.custom_icon_width);
					//console.log('h: '+axi_widget.config.custom_icon_height);
				})
			}

			aJ('head').append('<link wtype="awcss" href="'+axi_widget.protocol+'//fonts.googleapis.com/css?family=PT+Sans:regular,italic,bold,bolditalic" rel="stylesheet" type="text/css" />');
			
			if(typeof(axi_widget.config.css) === 'undefined' || axi_widget.config.css === '' || axi_widget.config.css === 0 ){
				if(axi_widget.protocol === 'http:'){
					aJ('head').append( aJ('<link rel="stylesheet" type="text/css" wtype="awcss" />').attr('href', axi_widget.protocol+'//axiomus.ru/widget/'+axi_widget.version+'/styles/widget.css') );
				}else{
					aJ('head').append( aJ('<link rel="stylesheet" type="text/css" wtype="awcss" />').attr('href', axi_widget.protocol+'//axiomus.ru/widget/'+axi_widget.version+'/styles/widget_secure.css') );
				}
			}else{
				aJ('head').append( aJ('<link rel="stylesheet" type="text/css" wtype="awcss" />').attr('href', axi_widget.config.css) );
			}

			aJ.getScript(axi_widget.protocol+'//axiomus.ru/widget/'+axi_widget.version+'/scripts/calc.js').fail(function (jqxhr, settings, exception) {
                axi_analytics.add(axi_widget.protocol+'//axiomus.ru/widget/'+axi_widget.version+'/scripts/calc.js', exception);
            });
			
			if(axi_widget.config.carry_enable === 'false'){
				aJ('#-aw-load_locker').addClass('-aw-hidden');
			}
			
			if(typeof(axi_widget.config.custom_color) !== 'undefined' && axi_widget.config.custom_color !== ''){
			 var aw_custom_color = '<style>'+
				'.-aw-button {'+
				'	border: 1px solid '+axi_widget.config.custom_color+';'+
				'	background-color: '+axi_widget.config.custom_color+';'+
				'}'+
				'.-aw-navigation ul li.-aw-selected {'+
				'	background-color: '+axi_widget.config.custom_color+';'+
				'}'+
				'.-aw-navigation ul>li {'+
				'	background: '+axi_widget.config.custom_color.replace(')', ', 0.65)').replace('rgb', 'rgba')+';'+
				'}'+
				'#-aw-load_icon,.-aw-load_icon_pvz{'+
				'	border-top-color: '+axi_widget.config.custom_color+'!important;'+
				'}'+
				'.-aw-navigation {'+
   				'	border-bottom: 4px solid '+axi_widget.config.custom_color+';'+
				'}'+
				'.-aw-calc-result-opts > div > img, .-aw-pvz-search-results-tooltip>div:nth-child(4), .-aw-cc {'+
				'	filter: grayscale(100%);'+
				'}</style>';
			aJ('#axi_widget').append(aw_custom_color);
			}
			if(typeof(axi_widget.config.disable_button) !== 'undefined' && (axi_widget.config.disable_button === 'true' || axi_widget.config.disable_button === true)){
				 var aw_disable_button = '<style>'+
				'.-aw-pvz_calc_price_block {'+
				'	min-height: 50px!important;'+
				'}</style>';
			aJ('#axi_widget').append(aw_disable_button);
			}
		
			aJ('.-aw-nav').on('click', function(){
				aJ(this).siblings().removeClass('-aw-selected');
				aJ(this).addClass('-aw-selected');
				var navobj = '.-aw-content.'+aJ(this).attr('tab');
				aJ('.-aw-content').addClass('-aw-hidden');
				aJ(navobj).toggleClass('-aw-hidden');
			});
		}
	}else{
		console.error('Не найден блок для отображения виджета Axiomus! Укажите в HTML разметке блок <div id="axi_widget"> </div>');
		axi_analytics.add('Не найден блок для отображения виджета Axiomus! Укажите в HTML разметке блок <div id="axi_widget"> </div>');
	}
};

axi_widget.destroy = function(div){
	if(typeof(axi_widget.geo) !== 'undefined' && typeof(axi_widget.geo.axiMap) !== 'undefined' && axi_widget.geo.axiMap !== null && typeof(axi_widget.geo.axiMap.destroy) === 'function'){
		axi_widget.geo.axiMap.destroy();
		axi_widget.geo.axiMap = function(){return;};
	}

	aJ('link[wtype=awcss]').remove();

	if(typeof(div) === 'undefined'){
		div = '#axi_widget';
	}

	axi_widget.config = {};
	aJ(div).children().remove();
    axi_analytics.clean();
};

axi_widget.geo_load_callback = function(data){
}

if(document.readyState === 'complete'){
	(function(){
		if(typeof($) !== 'function' || $.fn.jquery < "2.1.4"){
		// $ = function(){};
		var getScript = function (source, callback) {
			var script = document.createElement('script');
			var prior = document.getElementsByTagName('script')[0];
			script.async = 1;
			prior.parentNode.insertBefore(script, prior);
		
			script.onload = script.onreadystatechange = function( _, isAbort ) {
				if(isAbort || !script.readyState || /loaded|complete/.test(script.readyState) ) {
					script.onload = script.onreadystatechange = null;
					script = undefined;
		
					if(!isAbort) { if(callback) callback(); }
				}
			};
		script.src = source;
	}
			getScript(axi_widget.protocol+'//axiomus.ru/widget/'+axi_widget.version+'/scripts/jquery-2.1.4.min.js', axi_widget.init);
		}else{
			start_widget();
		}
	})();

}else{
	window.onload = function(){
		if(typeof($) !== 'function' || $.fn.jquery < "2.1.4"){
		// $ = function(){};

		var getScript = function (source, callback) {
			var script = document.createElement('script');
			var prior = document.getElementsByTagName('script')[0];
			script.async = 1;
			prior.parentNode.insertBefore(script, prior);
		
			script.onload = script.onreadystatechange = function( _, isAbort ) {
				if(isAbort || !script.readyState || /loaded|complete/.test(script.readyState) ) {
					script.onload = script.onreadystatechange = null;
					script = undefined;
		
					if(!isAbort) { if(callback) callback(); }
				}
			};

			script.src = source;
		}
		getScript(axi_widget.protocol+'//axiomus.ru/widget/'+axi_widget.version+'/scripts/jquery-2.1.4.min.js', axi_widget.init);
		
		}else{
			start_widget();
		}
	};
}