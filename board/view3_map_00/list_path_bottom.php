</div>
<!-- //뷰페이지 end -->
</div>
<!-- //board wrapper end -->


<!-- <script src="http://maps.googleapis.com/maps/api/js?language=ko&amp;region=kr&amp;libraries=geometry<?if($settings_data['google_api_key']){echo '&key='.$settings_data['google_api_key'];}?>"></script>
<script type="text/javascript">
(function($) {
doc.ready(function() {
    (function() {
        var map = new google.maps.Map(document.getElementById('map_area'), {
            center: new google.maps.LatLng(+<?=$list['view3_addr_y']?>, +<?=$list['view3_addr_x']?>),
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        });

        var marker = new google.maps.Marker({
            map: map,
            position: {lat: +<?=$list['view3_addr_y']?>, lng: +<?=$list['view3_addr_x']?>},
            //title: '',
            icon: '<?=$markerImgPath?>'
        });
    }());
});
}(jQuery));
</script> -->

<script type="text/javascript">
<?
$markerImgPath = '/design/other/marker.png';
$markerImgSize = getImagesize(ROOT_INC.$markerImgPath);
?>

var marker = {
	src: '<?=$pc.$markerImgPath?>',
	offset: {x: <?=$markerImgSize[0] / 2?>, y: <?=$markerImgSize[1]?>},
	size: {x: <?=$markerImgSize[0]?>, y: <?=$markerImgSize[1]?>}
};
var placeInfo = {
	appkey: '<?=$settings_data['kakao_api_key'];?>',
	container: 'map_area',
	geocode: {lat: '<?=$list['view3_addr_y']?>', lng: '<?=$list['view3_addr_x']?>'},
	scrollwheel: false,
	marker: marker,
};


/**************************************************************************************************
 * KakaoMap | Kakao map api를 이용하여 지도를 출력합니다.
 *
 * @class KakaoMap
 * @constructor
 * @version 1.0
 *
 * @param {Object} placeInfo 옵션 객체
 *
 **************************************************************************************************/
(function($) {

    'use strict';

    window.KakaoMap = function(placeInfo) {

    	var _this = this;

    	var map,
    		mapContainer = document.getElementById(placeInfo.container),
    		mapOptions = {level: 4},
    		marker,
    		markerOptions,
            rv,
            resizeTimer = null;

        var opt = {
            mapTypeControl: true,
            zoomControl: true
        };



    	/*
    	 * KakaoMap class 초기화 함수
    	 *
    	 * @method initialize
    	 */
    	this.initialize = function() {
            if(typeof placeInfo.scrollwheel === 'boolean') mapOptions.scrollwheel = false;
            if(typeof placeInfo.level === 'number') mapOptions.level = placeInfo.level;
            if(typeof placeInfo.mapTypeControl === 'boolean') opt.mapTypeControl = placeInfo.mapTypeControl;
            if(typeof placeInfo.zoomControl === 'boolean') opt.zoomControl = placeInfo.zoomControl;
    		var src = '//dapi.kakao.com/v2/maps/sdk.js?autoload=false&libraries=services&appkey='+ placeInfo.appkey;
    		_this.cachedScript(src, function() {
    			_this.mapLoad();
    		});
    	};
		this.cachedScript = function( url, callback ) {
			// kakao에서 timestamp 제거 요청으로 인한 처리 20181030 yoonwoo1023
			var options = {
				dataType: "script",
				cache: true,
				url: url,
				success : callback
			};
			return jQuery.ajax( options );
		};
    	this.mapLoad = function() {
    		daum.maps.load(function() {
                var reg = /daumcdn|services\.js/g;
                for(var i=0, src, res; i<$('head > script').length; i++) {
                    if(typeof $('head > script').eq(i).attr('src') === 'undefined') continue;
                    src = $('head > script').eq(i).attr('src');
                    res = src.match(reg);
                    if(res !== null && res.length === 2) {
                        _this.cachedScript(src, function() {
                            if(typeof placeInfo.geocode === 'object') {
                				mapOptions.center = new daum.maps.LatLng(placeInfo.geocode.lat, placeInfo.geocode.lng);
                				_this.mapping();
                				if(typeof placeInfo.roadView === 'object') _this.roadView();
                			} else {
                				_this.geocoding(placeInfo.address, function() {
                					_this.mapping();
                					if(typeof placeInfo.roadView === 'object') _this.roadView();
                				});
                			}
                        });
                        break;
                    }
                }
    		});
    	};

    	/*
    	 * 주소를 경위도 좌표로 변환합니다.
    	 *
    	 * @method geocoding
    	 * @param {String} addr 주소
    	 * @param {Function} callback 콜백 함수
    	 */
    	this.geocoding = function(addr, callback) {
    		var geocoder = new daum.maps.services.Geocoder();
    		geocoder.addressSearch(addr, function(result, status) {
    			if(status === daum.maps.services.Status.OK) {
    				mapOptions.center = new daum.maps.LatLng(result[0].y, result[0].x);
    				callback();
    			}
    		});
    	};

    	/*
    	 * 지도를 출력합니다.
    	 *
    	 * @method mapping
    	 */
    	this.mapping = function() {
    		map = new daum.maps.Map(mapContainer, mapOptions);
    		this.addMarker();
    		this.addControl();
            this.addHandler();
    		if(typeof placeInfo.callback === 'function') placeInfo.callback();
    	};

    	/*
    	 * 마커를 표시합니다.
    	 *
    	 * @method addMarker
    	 */
    	this.addMarker = function() {
            markerOptions = {
    			position: mapOptions.center
    		};
    		if(typeof placeInfo.marker === 'object' && typeof placeInfo.marker.src === 'string') {
                markerOptions.image = new daum.maps.MarkerImage(
                    placeInfo.marker.src,
                    new daum.maps.Size(placeInfo.marker.size.x, placeInfo.marker.size.y),
                    {offset: new daum.maps.Point(placeInfo.marker.offset.x, placeInfo.marker.offset.y)}
                );
    		}
    		var marker = new daum.maps.Marker(markerOptions);
    		marker.setMap(map);
    	};

    	/*
    	 * 컨트롤을 올립니다.
    	 *
    	 * @method addControl
    	 */
    	this.addControl = function() {
            if(opt.mapTypeControl === true) map.addControl(new daum.maps.MapTypeControl(), daum.maps.ControlPosition.TOPLEFT);
    		if(opt.zoomControl === true) map.addControl(new daum.maps.ZoomControl(), daum.maps.ControlPosition.LEFT);
    	};

    	/*
    	 * 로드뷰를 출력합니다.
    	 *
    	 * @method roadView
    	 */
    	this.roadView = function() {
    		var rvOptions = placeInfo.roadView;
    		rv = new daum.maps.Roadview(document.getElementById(rvOptions.container));
    		var rvClient = new daum.maps.RoadviewClient();

    		rvClient.getNearestPanoId(mapOptions.center, 50, function(panoId) {
    			rv.setPanoId(panoId, mapOptions.center);
    		});
    	};

        this.addHandler = function() {
            $(window).resize(this.resize);
        };

        this.resize = function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                map.relayout();
                map.setCenter(mapOptions.center);
                if(typeof rv === 'object') rv.relayout();
            }, 100);
        };

    	// KakaoMap class 초기화 함수를 호출합니다.
    	this.initialize();
    };

    if(typeof placeInfo.length === 'undefined') window.instofKakaoMap = new KakaoMap(placeInfo);
    else {
        window.instofKakaoMap = [];
        for(var i=0; i<placeInfo.length; i++) {
            window.instofKakaoMap[i] = new KakaoMap(placeInfo[i]);
        }
    }

}(jQuery));

</script>
