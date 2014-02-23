<?php if (!defined('THINK_PATH')) exit();?><div class="panel panel-primary" id="div_map" style="margin-bottom:0px;">
    <div class="panel panel-heading" style="margin-bottom:0px; height:40px;">
        <h3 class="panel-title" style="float:left;">转移地图历史回放</h3>
        <button type="button" class="btn btn-default btn-xs" id="toFullScreen" onclick="toFullScreen();" style="float:right;">全屏</button>
        <button type="button" class="btn btn-default btn-xs" id="exitFullScreen" onclick="exitFullScreen();" style="float:right;display:none;">退出全屏</button>
    </div>
    <div class="panel panel-body" style="margin-bottom:1px">
        <div id="noSelectionAlert"></div>
        <div class="row">
            <div class="col-md-3">
                <input type="date" class="form-control input-sm" id="beginDate" value="2014-01-13">
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control input-sm" id="endDate" value="2014-01-14">
            </div>
            <div class="col-md-2">
                <label class="sr-only" for="selectSpeed">回放速度：</label>
                <select class="form-control input-sm" id="selectSpeed">
                    <option value='1'>慢</option>
                    <option value='2' selected="selected">中</option>
                    <option value='4'>快</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-info btn-sm" onclick="getVehicleRoutes();">回放</button>
            </div>
            <div class="col-md-3">
                <div id="playbackTimeDiv"></div>
            </div>
        </div>
        <div id="map_container" style="width:auto">地图加载中...</div>
    </div>
</div>

<script type="text/javascript" src="__PUBLIC__/js/shortestDist.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/fullscreen.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/myAlert.js"></script>

<script type="text/javascript">
if (typeof(intervalWarning) != 'undefined') {
    clearInterval(intervalWarning);
}
if (typeof(playbackTimeout) != 'undefined') {
    clearTimeout(playbackTimeout);
}

var polylineList = new Array();

function setBMap() {
    var windowHeight = $(window).height();
    $("#map_container").css("height", "" + windowHeight - 350 + "px");

    BaiduMap = new BMap.Map("map_container"); // 创建Map实例
    BaiduMap.centerAndZoom("上海", 11); // 初始化地图,设置中心点坐标和地图级别
    BaiduMap.addControl(new BMap.NavigationControl()); // 添加默认缩放平移控件
    BaiduMap.addControl(new BMap.ScaleControl()); // 添加默认比例尺控件
    BaiduMap.addControl(new BMap.OverviewMapControl()); //添加默认缩略地图控件
    BaiduMap.enableScrollWheelZoom(); //启用滚轮放大缩小
    BaiduMap.addControl(new BMap.MapTypeControl()); // 添加默认地图控件
    BaiduMap.setCurrentCity("上海"); // 设置地图显示的城市 此项是必须设置的
    var mapStyle = {
        features: ["road", "building", "water", "land", "point"],
        style: "light"
    };
    BaiduMap.setMapStyle(mapStyle);

    BaiduMap.addEventListener("click", function() {
        while (polyline = polylineList.pop()) {
            BaiduMap.removeOverlay(polyline);
        }
    });

    for (var idx in route_json) {
        route_decode_object[idx] = JSON.parse(route_json[idx].route_lng_lat.replace(/&quot;/g, '"'));
    }

    $(".anchorBL").hide();
}

function loadScript() {
    var script = document.createElement("script");
    script.src = "http://api.map.baidu.com/api?v=2.0&ak=KDdzQZSRLv89h4yrti56L5Gy&callback=setBMap";
    document.body.appendChild(script);
}

loadScript();

function getVehicleRoutes() {
    if ($('#beginDate').val() == '' || $('#endDate').val() == '') {
        myAlertFail('请先选择历史回放起始日期和终止日期');
        return;
    }
    $.ajax({
        type: "POST",
        url: "<?php echo U('Home/DistrictMap/ajax_get_vehicle_routes_test');?>",
        timeout: 5000,
        data: {
            "beginDate": $('#beginDate').val(),
            "endDate": $('#endDate').val()
        },
        success: function(gps_route_array) {
            if (gps_route_array == 'fail') {
                myAlertFail("获取转移地图历史数据失败");
                return;
            }

            if (typeof(playbackTimeout) != 'undefined') {
                clearTimeout(playbackTimeout);
            }
            BaiduMap.clearOverlays();

            var lorryIconGreen = new BMap.Icon("__PUBLIC__/image/truck_green.png", new BMap.Size(32, 40), {
                anchor: new BMap.Size(16, 40),
                imageOffset: new BMap.Size(0, 0)
            });
            var lorryIconYellow = new BMap.Icon("__PUBLIC__/image/truck_yellow.png", new BMap.Size(32, 40), {
                anchor: new BMap.Size(16, 40),
                imageOffset: new BMap.Size(0, 0)
            });
            var lorryIconRed = new BMap.Icon("__PUBLIC__/image/truck_red.png", new BMap.Size(32, 40), {
                anchor: new BMap.Size(16, 40),
                imageOffset: new BMap.Size(0, 0)
            });

            var vehicleMarkerList = new Array();
            var startTime = "9999-12-31 23:59:59";
            var endTime = "0000-00-00 00:00:00";

            var gpsRouteArray = new Array();
            for (var gpsIdx in gps_route_array) {

                gpsRouteArray[gpsIdx] = new Array();
                if (!gps_route_array[gpsIdx]) {
                    continue;
                }

                var idxLength = gps_route_array[gpsIdx].length;
                if (gps_route_array[gpsIdx][0].datetime < startTime) {
                    startTime = gps_route_array[gpsIdx][0].datetime;
                }
                if (gps_route_array[gpsIdx][idxLength - 1].datetime > endTime) {
                    endTime = gps_route_array[gpsIdx][idxLength - 1].datetime;
                }

                var iconPoint = new BMap.Point(gps_route_array[gpsIdx][0].bmap_longitude, gps_route_array[gpsIdx][0].bmap_latitude);
                var vehicleMarker = new BMap.Marker(iconPoint, {
                    icon: lorryIconGreen,
                    title: "危废运输车辆"
                });
                vehicleMarker.setTitle(gpsIdx);
                BaiduMap.addOverlay(vehicleMarker);
                vehicleMarkerList.push(vehicleMarker);

                vehicleMarker.addEventListener("rightclick", function(e) {
                    var markerIdx = this.getTitle() - '0';
                    var pointArray = new Array();
                    var lng, lat;
                    for (var pointIdx in route_decode_object[markerIdx]) {
                        lng = route_decode_object[markerIdx][pointIdx].lng;
                        lat = route_decode_object[markerIdx][pointIdx].lat;
                        pointArray.push(new BMap.Point(lng, lat));
                    }
                    var polyline = new BMap.Polyline(pointArray, {
                        strokeColor: "blue",
                        strokeWeight: 5, // 折线的宽度，以像素为单位。
                        strokeOpacity: 0.8 // 折线的透明度，取值范围0 - 1。
                    });
                    BaiduMap.addOverlay(polyline);
                    polylineList.push(polyline);
                });

                for (var dataIdx in gps_route_array[gpsIdx]) {
                    if (!gps_route_array[gpsIdx][dataIdx]) {
                        continue;
                    }
                    var dateTime = gps_route_array[gpsIdx][dataIdx].datetime;
                    var dateTimeObj = new Date(dateTime);
                    var newIdx = Math.floor(dateTimeObj.getHours() * 360 + dateTimeObj.getMinutes() * 6 + dateTimeObj.getSeconds() / 10);
                    gpsRouteArray[gpsIdx][newIdx] = gps_route_array[gpsIdx][dataIdx];
                }
            }

            var startTimeObj = new Date(startTime);
            var endTimeObj = new Date(endTime);
            var startIdx = Math.floor(startTimeObj.getHours() * 360 + startTimeObj.getMinutes() * 6 + startTimeObj.getSeconds() / 10);
            var endIdx = Math.floor(endTimeObj.getHours() * 360 + endTimeObj.getMinutes() * 6 + endTimeObj.getSeconds() / 10);
            var playbackTimeObj = startTimeObj;
            var playbackTimeDiv = $('#playbackTimeDiv');
            var intervalTime = 200 / $('#selectSpeed').val();

            function playback(dataIdx) {
                playbackTimeObj.setSeconds(playbackTimeObj.getSeconds() + 10);
                playbackTimeDiv.html(playbackTimeObj.getFullYear() + '/' + (playbackTimeObj.getMonth() + 1) + '/' + playbackTimeObj.getDate() + ' ' + playbackTimeObj.getHours() + ':' + playbackTimeObj.getMinutes());
                for (var gpsIdx in gpsRouteArray) {
                    if (!gpsRouteArray[gpsIdx][dataIdx]) {
                        continue;
                    }
                    var newPoint = new BMap.Point(gpsRouteArray[gpsIdx][dataIdx].bmap_longitude, gpsRouteArray[gpsIdx][dataIdx].bmap_latitude);
                    vehicleMarkerList[gpsIdx].setPosition(newPoint);
                    offsetDistance = gpsRouteArray[gpsIdx][dataIdx].offset_distance;
                    if (offsetDistance < 0.5) {
                        vehicleMarkerList[gpsIdx].setIcon(lorryIconGreen);
                    } else if ((offsetDistance >= 0.5) && (offsetDistance < 1)) {
                        vehicleMarkerList[gpsIdx].setIcon(lorryIconYellow);
                    } else {
                        vehicleMarkerList[gpsIdx].setIcon(lorryIconRed);
                    }
                }
                intervalTime = 200 / $('#selectSpeed').val();
                if (dataIdx < endIdx) {
                    playbackTimeout = setTimeout(function() {
                        ++dataIdx;
                        playback(dataIdx);
                    }, intervalTime);
                } else {
                    return;
                }
            }
            playback(startIdx);

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            myAlertFail("获取转移地图历史数据ajax请求失败");
            console.log("Error:Ajax_Content_Load" + errorThrown);
            console.log("XMLHttpRequest.status:" + XMLHttpRequest.status);
            console.log("XMLHttpRequest.readyState:" + XMLHttpRequest.readyState);
            console.log("textStatus:" + textStatus);
        }
    });
}
</script>