function initMap() {
axi_widget.geo.axiMap = {};
var timer = false;
var zoom_timer = false;
axi_widget.geo.axCoords = [];
axi_widget.geo.axCollection;
var firstRun = true;
var coords = [];
axi_widget.protocol = window.location.protocol;
axi_widget.geo.d_type = function is_touch_device() {
 return (('ontouchstart' in window)
	  || (navigator.MaxTouchPoints > 0)
	  || (navigator.msMaxTouchPoints > 0));
}
//console.log(axi_widget.config);
var cod_allow = 'false';
var start_zoom = 15;
var first_move = true;
if(typeof(axi_widget.config.cod_type) !== 'undefined' && axi_widget.config.cod_type !== 'false'){
	cod_allow = 1;
}
									  
axi_widget.geo.json = {
	"token": axi_widget.config.token,
	"method": "point",
		"lon" : axi_widget.config.lon,
		"lat" : axi_widget.config.lat,
	"limit" : 1000,
	"maxdis" : 50000,
	"company": axi_widget.config.carry_companies.join(','),
	"zoom":15,
	"cod_allow":cod_allow
};	


if(typeof(axi_widget.config.start_zoom) !== 'undefined' && axi_widget.config.start_zoom >= 1 && axi_widget.config.start_zoom <= 18){
	axi_widget.geo.json.zoom = axi_widget.config.start_zoom;
	start_zoom = axi_widget.config.start_zoom;
}
var last_reload_coords = [axi_widget.geo.json.lat,axi_widget.geo.json.lon];
var last_zoom = axi_widget.geo.json.zoom;
var reload_range = {
		'4':40000000,
		'8':800000,
		'9':400000,
		'12':75000,
		'13':18000,
		'18':6000
	};
    axi_widget.geo.axiMap = new ymaps.Map('awmap', {
		center: [axi_widget.config.lat, axi_widget.config.lon],
		zoom: start_zoom,
		controls: []
		}, {
			searchControlProvider: 'yandex#map',
			/*restrictMapArea:[[43,18],[82,194]],*/
			minZoom: 4,
			maxZoom: 18
		});
	axi_widget.geo.axiMap.options.set('dblClickZoomDuration', 500);
	axi_widget.geo.axiMap.behaviors.disable('scrollZoom');
		
	axi_widget.geo.axiMap.controls
		.add("geolocationControl", {float: "left"})
		.add("searchControl", {float: "left", position: {top: 10, left: 50}, size : 'large'})
		.add("zoomControl", {float: "left", position: {top: 100, left: 10},size : 'large'})	
		.add("fullscreenControl", {float: "left", position: {top: 55, left: 10},size : 'large'});	
		
	// вешаем событие на изменение области просмотра карты
	
	axi_widget.geo.axiMap.events.add("boundschange", function (e) {		
	//console.log('event');
		if(!timer && !zoom_timer){
			//console.log('!!!!!Load!');
			axi_widget.geo.json.zoom = axi_widget.geo.axiMap.getZoom();
			axi_widget.geo.json.company = axi_widget.config.carry_companies;
			axi_widget.geo.json.cod_allow = 'false';
			if(typeof(axi_widget.config.cod_type) !== 'undefined' && axi_widget.config.cod_type !== 'false'){
				axi_widget.geo.json.cod_allow = 1;
			}

				last_reload_coords = [axi_widget.config.lat, axi_widget.config.lon];
				last_zoom = axi_widget.geo.json.zoom;
			if(last_reload_coords !== null){
				for(k in reload_range){
					if(axi_widget.geo.json.zoom <= k){
						coords = last_reload_coords;
						var r_dist = reload_range[k]/2;
						var a = Math.pow((last_reload_coords[0] - coords[0]),2);
						var b = Math.pow((last_reload_coords[1] - coords[1]),2);
						var cur_dist = (Math.sqrt(a + b))*111000;
						if(cur_dist >= r_dist || last_zoom !== axi_widget.geo.json.zoom){
							last_reload_coords = coords;
							last_zoom = axi_widget.geo.json.zoom;
							load_geo();
						}else{
							//console.log('Distance less than needs to do reload:'+cur_dist+' ; needed more than: '+r_dist);
						}
						break;
					}
				}
			}else{
				coords = axi_widget.geo.axiMap.getCenter();
				last_reload_coords = coords;
				last_zoom = axi_widget.geo.json.zoom;
				load_geo();
			}
		}
	}); 
	
	axi_widget.geo.axiMap.events.add("mousedown", function (e) {
		if(!timer){
			//console.log('mouse_down');
			timer = true;
			setTimeout(function () {
				timer = false;
				zoom_timer = false;
			},550);
		}else{
			//console.log('dbl_click');
			zoom_timer = true;
		}
	}); 
	axi_widget.geo.axiMap.geoObjects.events.add(['balloonopen'], function (e) {
            $.get('boxberry.php',{ set_sum : 1 } , function (a) {
                if (a != 1) {
                    location.reload();
                }
		if($('.-aw-carry_result_block_info').length > 0){
			$('.-aw-carry_result_block_info').remove();
		}                
		var target = e.get('target');
		get_price_carry(target.data_pvz);
		$('.-aw-select-btn').on('click',function(){
		if(typeof(axi_widget.config.callback) !== 'undefined' && typeof(window[axi_widget.config.callback]) === 'function'){
			//var c_data = Object.assign(axi_widget.selection_result);
			//var t_data = Object.assign(target.data_pvz);
			var c_data = axi_widget.assign_fix(axi_widget.selection_result,{});
			var t_data = axi_widget.assign_fix(target.data_pvz,{});
			delete(c_data.opt_txt);
			delete(t_data.opt_txt);
			//window[axi_widget.config.callback](Object.assign(t_data,c_data));
			window[axi_widget.config.callback](axi_widget.assign_fix(t_data,c_data));
		}
            });
        });
	axi_widget.geo.axiMap.geoObjects.events.add(['balloonclose'], function (e) {
        $('.-aw-select-btn').unbind();
    });
	});
		
	// загружаем ПВЗ при первом запуске		
	
	find_geo([axi_widget.config.lat, axi_widget.config.lon]); /*
	setInterval(function(){
	if(typeof(axi_widget.geo.axiMap) !== 'undefined' && typeof(axi_widget.geo.axiMap.getZoom) === 'function' && axi_widget.geo.axiMap.getZoom() <= 12){
		if(typeof(axi_widget.geo.axiMap.balloon) !== 'undefined'){ 
			if($('.-aw-carry_result_block_info').length === 0 && !axi_widget.geo.axiMap.balloon.isOpen()){
				$('.-aw-carry_result').append('<div class="-aw-carry_result_block_info">Приблизьте чтобы увидеть все точки</div>');
			}
		}
		
	}else{
		if($('.-aw-carry_result_block_info').length > 0){
			$('.-aw-carry_result_block_info').remove();
		}
	}
},1000);*/
	setTimeout (function () {
		var fullscreenControl = axi_widget.geo.axiMap.controls.get('fullscreenControl');
		fullscreenControl.events.add('fullscreenenter', function(e){
				$('html').addClass('-aw-htmloverflowhidden');
				//$('#maplayer-pvz').addClass('mapfullscreen');
		});
		fullscreenControl.events.add('fullscreenexit', function(e){
				$('html').removeClass('.-aw-htmloverflowhidden');
				//$('#maplayer-pvz').removeClass('mapfullscreen');
		})
		$('#-aw-load_locker').addClass('-aw-hidden');
		axi_widget.geo.axiMap.container.fitToViewport();
	},2400);
}



function load_geo(){
	timer = false;
	zoom_timer = false;
	axi_widget.geo.axCollection = {};	
	axi_widget.geo.axCoords = [];
	setTimeout (function () {
			find_geo([axi_widget.config.lat, axi_widget.config.lon]);
		}, 
	100);
}

function drawMap (resp) {	
	var answer = $('.-aw-carry_result');
	var icon;
	var icon_height = 44;
	var icon_width = 44;
	axi_widget.geo.axCollection = new ymaps.GeoObjectCollection(null, {
		preset: 'islands#blueIcon'
	});
	if(typeof(axi_widget.config.custom_pvz_icon) !== 'undefined' && axi_widget.config.custom_pvz_icon !== ''){
		icon_width = axi_widget.config.custom_icon_width;
		icon_height = axi_widget.config.custom_icon_height;
	}	
	for (var i = 0, l = axi_widget.geo.axCoords.length; i < l; i++) {
		switch (axi_widget.geo.axCoords[i].name) {
			case "Аксиомус":
				icon = location.protocol+'//axiomus.ru/widget/'+axi_widget.version+'/pictures/yandex-ax.svg';
				break;
			case "DPD":
				icon = location.protocol+'//axiomus.ru/widget/'+axi_widget.version+'/pictures/yandex-dpd.svg';
				break;
			case "BoxBerry":
				icon = location.protocol+'//axiomus.ru/widget/'+axi_widget.version+'/pictures/yandex-box.svg';
				break;
			case "Почта РФ":
				icon = location.protocol+'//axiomus.ru/widget/'+axi_widget.version+'/pictures/yandex-post.svg';
				break;
			case "Почта РФ ЦВПП":
				icon = location.protocol+'//axiomus.ru/widget/'+axi_widget.version+'/pictures/yandex-post2.svg';
				break;
			case "TopDelivery":
				icon = location.protocol+'//axiomus.ru/widget/'+axi_widget.version+'/pictures/yandex-top.svg';
				break;
		}
		

		var z_index = function(name){
			if(name === 'Аксиомус'){
				return 651;
			}else{
				return 650;
			}
		}
		
		//console.log(d_type);
		if(axi_widget.geo.d_type() === false){
			var ic_size = [34,40];
			var ic_off = [4, -40];
			var crd = [0,(ic_size[1])*-0.5];
		}else{
			var ic_size = [44,52]; //55 64
			var ic_off = [22, -52]; // 5 64
			var crd = [0,(ic_size[1])*-0.45]
		}
		
		var ic_offset = [0,0];
		if(typeof(axi_widget.config.custom_pvz_icon) !== 'undefined' && axi_widget.config.custom_pvz_icon !== ''){
			icon = axi_widget.config.custom_pvz_icon;
			var ic_size = [parseInt(icon_width),parseInt(icon_height)];
			ic_offset = [parseInt(icon_width)*-0.31, parseInt(icon_height)*-0.5];
			var ic_off = [(parseInt(icon_width)*-0.31)+14, (parseInt(icon_height)*-1.05)];
			var crd = [0,0]; 
		}
		//console.log(Math.sqrt(Math.pow(ic_size[0]*0.5,2)+Math.pow(ic_size[1]*0.5,2)));
		var point = new ymaps.Placemark(axi_widget.geo.axCoords[i].coords, {
			hintContent: axi_widget.geo.axCoords[i].name,
			balloonContent: axi_widget.geo.axCoords[i].descr
		}, {
			iconLayout: 'default#image',
			iconImageHref: icon,
			iconImageSize: ic_size,
			iconOffset : ic_offset,
			iconShape: {
            type: 'Circle',
            coordinates: crd,
            radius: Math.sqrt(Math.pow(ic_size[0]*0.5,2)+Math.pow(ic_size[1]*0.5,2))
        },
			zIndex: z_index(axi_widget.geo.axCoords[i].name),
			backgroundRepeat:'no-repeat',
			balloonAutoPanDuration: 200,
			balloonOffset: ic_off,
			hideIconOnBalloonOpen: false
		})
		point.code = axi_widget.geo.axCoords[i].code;
		point.geo = axi_widget.geo.axCoords[i].coords;
		var price = function(pdata){
			var c_price = pdata;

			if((typeof(axi_widget.config.carry_add_price) !== 'undefined' && axi_widget.config.carry_add_price > 0) || (typeof(axi_widget.config.carry_add_percent) !== 'undefined' && axi_widget.config.carry_add_percent > 0)){
				if(typeof(axi_widget.config.carry_add_price) !== 'undefined'){
					c_price = pdata + axi_widget.config.carry_add_price;
				}else{
					c_price = pdata + pdata*axi_widget.config.carry_add_percent*0.01;
				}
			}
			if(typeof(axi_widget.config.carry_fix) !== 'undefined' && axi_widget.config.carry_fix > 0){
				c_price = axi_widget.config.carry_fix;
			}
				
			return c_price;
			 // тут обработка опций настроек
		}
		
		point.data_pvz = axi_widget.geo.axCoords[i].data_pvz;
	//	point.data_pvz.price = price(point.data_pvz.price);
		axi_widget.geo.axCollection.add(point);
	}
	$('.-aw-carry_result_block').remove();
	axi_widget.geo.axiMap.geoObjects.removeAll();//
	axi_widget.geo.axiMap.geoObjects.add(axi_widget.geo.axCollection);
	axi_widget.geo.axCollection = null;//
}

function find_geo(coords){
	axi_widget.geo.json.limit = 1000;
	axi_widget.geo.json.maxdis = 50000;
	if (coords) {
		axi_widget.geo.json.lon = coords[1];
		axi_widget.geo.json.lat = coords[0];
	}else{
		console.log('Empty coords');
	}
	
	var answer = $('.-aw-carry_result');
	answer.append('<div class="-aw-carry_result_block"> Идет поиск . . .</div>');
	
	var send_data = null;
	for(key in axi_widget.geo.json) {
		if (key != 'zoom') {
			if(send_data === null){
				send_data = key+'='+axi_widget.geo.json[key];
			}else{
				send_data = send_data+'&'+key+'='+axi_widget.geo.json[key];
			}
		}
	}
	
	var xhr = axi_widget.build_request_object("POST", location.protocol+'//axiomus.ru/calc/api_geo.php');
	if(!xhr){
		answer.innerHTML = 'Ошибка отправки запроса!';
		return;
	}
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.timeout = 30000;
	//console.log(send_data);
	xhr.send(send_data);  
	xhr.onreadystatechange = function(){
		if(xhr.readyState === 4 && xhr.status === 200){
			if(xhr.responseText !== ''){				
				i = 0;
				n = 1;
				var geo_resp = JSON.parse ( xhr.responseText );
				console.log(geo_resp.pvz);
				var groups = [];
				for(n in  geo_resp.pvz){
				   if(typeof(geo_resp.pvz[n].company) !== 'undefined'){
					   var company = geo_resp.pvz[n].company;
					   if(typeof(groups[company]) !== 'undefined'){
							groups[company].push(geo_resp.pvz[n]);
					   }else{
							groups[company] = [];
						    groups[company].push(geo_resp.pvz[n]);
					   }
				   }
				}
				if((typeof(geo_resp.error) !== undefined && typeof(geo_resp[i]) === undefined) || (typeof(geo_resp.ok) !== undefined && geo_resp.ok === 0) || geo_resp.pvz.error){
					var err = geo_resp.error || geo_resp.pvz.error;
					var resp_html = '<div class="-aw-carry_result_block">'+err+'</div>';	
				} else {
					resp_html = '';
					var cnt = 0;
					//console.log(groups);
					for (n in groups){
						//console.log(n);
						if(typeof(groups[n][0]) === 'undefined' || typeof(groups[n][0].type_company) === 'undefined'){
							continue;
						}
						
						cnt++;
						var css;
						
						//console.log(groups[n]);
						//console.log(groups[n][0]);
						var currentCompany = groups[n][0].company;
						
						switch (groups[n][0].type_company) {
							case 0:
								css="pvz_ax";
								break;
							case 1:
								css="pvz_post";
								break;
							case 2:
								css="pvz_dpd";
								break;
							case 4:
								css="pvz_top";
								break;
							case 51:
								css="pvz_box";
								break;
						}
						
						for (i in groups[n]) {							
							
								var divAx = '';
								var disp = "none";
								if (i == 0) disp = "block";
								var cl = "-aw-pvz-search-result";
								var orderNumber = "groups"+cnt;
								var b_cnt = {};
								var opts = '';
								var btn_html = '';
								if(typeof(groups[n][i].opt_txt) !== 'undefined'){
										if(Object.keys(groups[n][i].opt_txt).length > 0){
											opts = '<div class="-aw-calc-result-opts" style="margin-top: 10px">';
											
											for(o in groups[n][i].opt_txt){
												var image_link = groups[n][i].opt_txt[o].img;
												if(axi_widget.protocol !== 'http:'){
													//console.log(groups[n][i].opt_txt[o].img);
													if(typeof(groups[n][i].opt_txt[o].img) !== 'undefined'){
														image_link = groups[n][i].opt_txt[o].img.replace(/http/g,"https");
													}
												}
												opts += '<div class="-aw-center" helper="'+groups[n][i].opt_txt[o].name+'"><img src="'+image_link+'" alt="'+groups[n][i].opt_txt[o].name+'"/></div>';
											}
												
											opts += '</div>';
										}
								}
									// ###
									// Кастомизация точек самовывоза
									
									var c_pvz_name = '';
									var c_pvz_icon = '';
									
									if(typeof(groups[n][i].cvpp) !== 'undefined'){
										cvp = ' ЦВПП';
									}else{
										cvp = '';	
									}
									
									if(typeof(axi_widget.config.custom_pvz_name) !== 'undefined' && axi_widget.config.custom_pvz_name !== ''){
										c_pvz_name = axi_widget.config.custom_pvz_name;
									}else{
										c_pvz_name = groups[n][i].company;
										if(groups[n][i].type_company == 1){
											c_pvz_name = 'Почта '+groups[n][i].code+cvp;
										}
										
									}
									
									if(typeof(axi_widget.config.custom_pvz_icon) !== 'undefined' && axi_widget.config.custom_pvz_icon !== ''){
										c_pvz_icon =  'style="background: url('+axi_widget.config.custom_pvz_icon+') no-repeat; background-size: 27px;"';
										css = '';
									}

									// ###
									var button_text = function(){
										if(typeof(axi_widget.config.button_text) !== 'undefined' && axi_widget.config.button_text !== ''){
											return axi_widget.config.button_text;
										}else{
											return 'Выбрать';
										}
									}
									
									if(typeof(axi_widget.config.disable_button) === 'undefined' || axi_widget.config.disable_button === '' || axi_widget.config.disable_button === 'false'){
										btn_html = "<div class='-aw-pvz_select -aw-font-bold -aw-center'><input type='button' class='-aw-select-btn -aw-button' value='"+button_text()+"'/></div>";
									}
									
									b_cnt = {
										"data_pvz":groups[n][i],
										"coords": [groups[n][i].lat, groups[n][i].lon],
										"name": groups[n][i].company+cvp,
										"code":groups[n][i].code+'_'+groups[n][i].type_company,
										"descr": "<div class='-aw-pvz-search-results-tooltip'>"+
											"<div class='"+css+" -aw-font-bold' "+c_pvz_icon+">"+c_pvz_name+"</div>"+
											"<div class=''></div><div>"+groups[n][i].address+"</div>"+
											"<div>"+groups[n][i].schedule+"</div>"+
											opts+
											"<div class='-aw-pvz_calc_price_block'>"+
												"<div class='-aw-pvz_price -aw-font-bold'></div>"+
												"<div class='-aw-pvz_days'></div>"+
												btn_html+
											"</div>"+
											"</div>"};
									if(typeof(groups[n][i].cvpp) !== 'undefined'){
										b_cnt.cvpp = groups[n][i].cvpp;
									}                                                                                   
                                                                        if (companyCodes.indexOf(groups[n][i].code) !== -1) {
                                                                            axi_widget.geo.axCoords.push(b_cnt);
                                                                        }
						}
						
					}					
				}
				setTimeout(drawMap(resp_html), 300);					
			}else{
				answer.innerHTML = 'Что-то пошло не так :(';
			}
		}
	};
	xhr.ontimeout = function(){	
		answer.innerHTML = 'Похоже у нас что-то сломалось :( <br>Попробуйте еще раз';
	};
	xhr.onerror = function(){
		answer.innerHTML = 'Ошибка отправки запроса!';
	};	
}