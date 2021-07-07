/*
* 2007-2011 PrestaShop 
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 6594 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
ymaps.ready(init);
var rc_global = { };
    rc_global.screenParams = {
        width : 0,
        heigth : 0
    },
    // инициализация параметров экрана
    rc_global.initWindow = function() {
        rc_global.screenParams.width = $(window).width();
        rc_global.screenParams.heigth = $(window).height();
    };
// начальная загрузка
$(function(){   
    rc_global.initWindow();
    if (window.onorientationchange) {
        window.addEventListener("onorientationchange", rc_global.initWindow);
        }         
    else {
            $(window).bind('resize',rc_global.initWindow);
    };
    $(window).bind('scroll',function(){
        var modalBox = jQuery('.rc-modal-boxes');
        if (modalBox.length !== 1) {
            return;
        }
        scrollTop = $(window).scrollTop();
        windowHeight = $(window).height();
        modalBoxTop = modalBox.offset().top;
        modalBoxBottom = modalBoxTop+ modalBox.height();
        if ((windowHeight < modalBoxTop || scrollTop > modalBoxBottom)) {
            modalBox.css ({top: scrollTop + 20});
        }
        
    });
});  

function init() {
 //   n = JSON.stringify(pickupList);
    
    var myMap = new ymaps.Map('map', {
            center: [55.755773, 37.617761],
            zoom: 9
        }, {
            searchControlProvider: 'yandex#search'
        }),
        myPlacemark = [];
        for (var i=0;i<pickupList.length;i++) 
        {    
           myPlacemark[i] = new ymaps.Placemark(pickupList[i].geo_data.split(',',2),
            {hintContent: pickupList[i].name},{id:i});
            
            myMap.geoObjects.add(myPlacemark[i]);
            myPlacemark[i].events.add('mouseenter', function (e) {
            e.get('target').options.set('preset', 'islands#greenIcon');
			})
			.add('mouseleave', function (e) {
            e.get('target').options.unset('preset')})
			.add('touchstart', function (e) {
                            showModalBox(e.get('target').options.get('id'))
			}).add('click', function (e) {
                            showModalBox(e.get('target').options.get('id'))
			});
            
            
        }
    }

function cancel_clk()
{
    jQuery('.rc-modal-boxes').remove();
    jQuery('.rc-mask').remove();  
}

function resizeWindow()
{
  var currentTop = jQuery(window).scrollTop();
  var modalBox = $('.rc-modal-boxes');
  if (modalBox.length == 1) {
    var page=$('#page'); 
    var dlgParams = { width : page.width(),
                    left : page.offset().left
                  }
    modalBox.css({
                 left: dlgParams.left+10,
                  width: dlgParams.width-20, 
                  maxWidth: rc_global.screenParams.width });
    modalBox.css({top: (currentTop + 20)});
    
  }
}
function initModalBox()
{
    resizeWindow();
    jQuery('.winclose').add('.rc-mask').bind('click',function() {
        cancel_clk();
    });
     if (window.onorientationchange) {
     window.onorientationchange=function() {
        resizeWindow();
    } 
 }
 else {
    $(window).resize(function() {
         resizeWindow();      
    });
 }
    
}
function showModalBox(id)
{
    var pickupInfo=pickupList[id];
    var imgBlock = '';
    var priceBlock = '';
    if (pickupInfo.img) {
        imgBlock = '<div id="imgbox"><img id="activeImage" src="'+ 
                pickupInfo.img + '" alt="Пункт самовывоза"></div>'
    }
    if (pickupInfo.price) {
        priceBlock = '<div id="priceBlock"><p>Стоимость доставки <span class="price">'+ 
                pickupInfo.price + ' руб.</span></p></div>'
    }
    var modalTemplate = '<div class="rc-modal-boxes"><div class="rc-top"><span class="winclose close">x</span></div>' +
           '<div class="rc_content"></div></div><div id="rc-cropbox-mask" class="rc-mask rc-hide"></div>';
   $('body').prepend(modalTemplate);
   $('.rc-top').prepend('<p>Подробная информация</p>');
   $('.rc_content').append('<div id="rc-info-block"><p>'+pickupInfo.name +'</p></div>' +
           priceBlock + imgBlock +'<div class="rc-info">'+pickupInfo.description+'</din>');
   initModalBox();
   
  //  alert ('id='+pickupInfo.id_pickup);
}
function submitPublishCMS(url, redirect)
{
	var id_cms = $('#admin-action-cms-id').val();

	$.ajaxSetup({async: false});
	$.post(url+'/ajax.php', { submitPublishCMS: '1', id_cms: id_cms, status: 1, redirect: redirect },
		function(data)
		{
			if (data.indexOf('error') === -1)
				document.location.href = data;
		}
	);

	return true;
}