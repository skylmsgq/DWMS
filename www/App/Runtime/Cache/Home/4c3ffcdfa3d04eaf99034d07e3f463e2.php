<?php if (!defined('THINK_PATH')) exit();?><div class="panel panel-primary" id="div_map" style="margin-bottom:0px;">
    <div class="panel panel-heading" style="margin-bottom:0px; height:40px;">
        <h3 class="panel-title" style="float:left;">指定车辆历史回放</h3>
        <button type="button" class="btn btn-default btn-xs" id="toFullScreen" onclick="toFullScreen();" style="float:right;">全屏</button>
        <button type="button" class="btn btn-default btn-xs" id="exitFullScreen" onclick="exitFullScreen();" style="float:right;display:none;">退出全屏</button>
    </div>
    <div class="panel panel-body" style="margin-bottom:1px">
        <div id="noSelectionAlert"></div>
        <div class="row">
            <div class="col-md-2">
                <label class="sr-only" for="selectTransportUnit">运输单位：</label>
                <select class="form-control input-sm" id="selectTransportUnit" onchange="getVehicleList();">
                    <option value='-1'>请选择运输单位</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="sr-only" for="selectVehicle">运输车辆：</label>
                <select class="form-control input-sm" id="selectVehicle">
                    <option value='-1'>请选择运输车辆</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control input-sm" id="beginDate" value="2014-01-13">
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control input-sm" id="endDate" value="2014-01-14">
            </div>
            <div class="col-md-1">
                <label class="sr-only" for="selectSpeed">回放速度：</label>
                <select class="form-control input-sm" id="selectSpeed">
                    <option value='1'>慢</option>
                    <option value='2' selected="selected">中</option>
                    <option value='4'>快</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-info btn-sm" onclick="getVehicleRoute();">回放</button>
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

    var selectTransportUnit = $('#selectTransportUnit');
    for (var idx in transport_unit_json) {
        selectTransportUnit.append('<option id="" value="' + transport_unit_json[idx].transport_unit_id + '">' + transport_unit_json[idx].transport_unit_name + '</option>');
    }

    $(".anchorBL").hide();
}

function loadScript() {
    var script = document.createElement("script");
    script.src = "http://api.map.baidu.com/api?v=2.0&ak=KDdzQZSRLv89h4yrti56L5Gy&callback=setBMap";
    document.body.appendChild(script);
}

loadScript();

function getVehicleList() {
    if ($('#selectTransportUnit').val() == '-1') {
        myAlertFail('请先选择运输单位');
        return;
    }
    $.ajax({
        type: "POST",
        url: "<?php echo U('Home/DistrictMap/ajax_get_vehicle_list');?>",
        timeout: 2000,
        data: {
            "transport_unit_id": $('#selectTransportUnit').val()
        },
        success: function(vehicleList) {
            if (vehicleList == 'fail') {
                myAlertFail("获取车辆列表失败");
                return;
            }
            var selectVehicle = $('#selectVehicle');
            selectVehicle.html("<option value='-1'>请选择运输车辆</option>");
            for (var idx in transport_unit_json) {
                selectVehicle.append('<option id="" value="' + vehicleList[idx].vehicle_id + '">车牌号为：' + vehicleList[idx].vehicle_num + '的' + vehicleList[idx].vehicle_type + '</option>');
            }

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            myAlertFail("获取车辆列表ajax请求失败");
            console.log("Error:Ajax_Content_Load" + errorThrown);
            console.log("XMLHttpRequest.status:" + XMLHttpRequest.status);
            console.log("XMLHttpRequest.readyState:" + XMLHttpRequest.readyState);
            console.log("textStatus:" + textStatus);
        }
    });
}

function getVehicleRoute() {
    if ($('#selectTransportUnit').val() == '-1') {
        myAlertFail('请先选择运输单位');
        return;
    }
    if ($('#selectVehicle').val() == '-1') {
        myAlertFail('请先选择运输车辆');
        return;
    }
    if ($('#beginDate').val() == '' || $('#endDate').val() == '') {
        myAlertFail('请先选择历史回放起始日期和终止日期');
        return;
    }
    $.ajax({
        type: "POST",
        url: "<?php echo U('Home/DistrictMap/ajax_get_vehicle_route');?>",
        timeout: 2000,
        data: {
            "vehicle_id": $('#selectVehicle').val(),
            "beginDate": $('#beginDate').val(),
            "endDate": $('#endDate').val()
        },
        success: function(gps_data) {
            if (gps_data == 'fail') {
                myAlertFail("获取车辆历史数据失败");
                return;
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

            var iconPoint = new BMap.Point(gps_data[0].bmap_longitude, gps_data[0].bmap_latitude);
            var vehicleMarker = new BMap.Marker(iconPoint, {
                icon: lorryIconGreen,
                title: "危废运输车辆"
            });
            BaiduMap.addOverlay(vehicleMarker);

            var routeLength = gps_data.length;
            var dataIdx = 1;

            function playback(dataIdx) {
                var speedFactor = $('#selectSpeed').val();
                var newPoint = new BMap.Point(gps_data[dataIdx].bmap_longitude, gps_data[dataIdx].bmap_latitude);
                vehicleMarker.setPosition(newPoint);
                if (gps_data[dataIdx].offset_distance < 0.5) {
                    vehicleMarker.setIcon(lorryIconGreen);
                } else if ((gps_data[dataIdx].offset_distance >= 0.5) && (gps_data[dataIdx].offset_distance < 1)) {
                    vehicleMarker.setIcon(lorryIconYellow);
                } else {
                    vehicleMarker.setIcon(lorryIconRed);
                }
                if (gps_data[dataIdx].speed <= 20) {
                    var intervalTime = 200 / speedFactor;
                } else {
                    var intervalTime = 4000 / gps_data[dataIdx].speed / speedFactor;
                }
                if (dataIdx < routeLength) {
                    setTimeout(function() {
                        ++dataIdx;
                        playback(dataIdx);
                    }, intervalTime);
                } else {
                    return;
                }
            }
            setTimeout(playback(0), 100);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            myAlertFail("获取车辆历史数据ajax请求失败");
            console.log("Error:Ajax_Content_Load" + errorThrown);
            console.log("XMLHttpRequest.status:" + XMLHttpRequest.status);
            console.log("XMLHttpRequest.readyState:" + XMLHttpRequest.readyState);
            console.log("textStatus:" + textStatus);
        }
    });
}
</script>