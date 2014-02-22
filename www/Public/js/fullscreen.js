var containerHeight = $('#div_container').css("height");
var containerWidth = $('#div_container').css("width");

function toFullScreen() {
    BaiduMap.disableAutoResize();
    var curPixel = BaiduMap.pointToPixel(BaiduMap.getCenter());
    var newPixel = new BMap.Pixel(curPixel.x - 135, curPixel.y - 103);
    var newCenter = BaiduMap.pixelToPoint(newPixel);
    $('#div_header').css("display", "none");
    $('#div_footer').css("display", "none");
    $('#div_sidebar').css("display", "none");
    //$('#div_row').removeClass('row');
    $('#div_input-group').css("display", "none");
    $('#div_content').removeClass('col-md-9');
    $('#content-container-panel').removeClass('panel-body');

    var windowHeight = $(window).height();
    var windowWidth = $(window).width();

    $('#div_container').css("height", windowHeight + "px");
    $('#div_container').css("width", windowWidth - 4 + "px");

    $('#map_container').css("height", windowHeight - 70 - 4 + "px");

    $('#toFullScreen').css("display", "none");
    $('#exitFullScreen').css("display", "inline");
    BaiduMap.checkResize();
    BaiduMap.setCenter(newCenter);
    BaiduMap.enableAutoResize();
}

function exitFullScreen() {
    BaiduMap.disableAutoResize();
    var curPixel = BaiduMap.pointToPixel(BaiduMap.getCenter());
    var newPixel = new BMap.Pixel(curPixel.x + 135, curPixel.y + 99);
    var newCenter = BaiduMap.pixelToPoint(newPixel);
    $('#div_header').css("display", "inherit");
    $('#div_footer').css("display", "inherit");
    $('#div_sidebar').css("display", "inherit");
    //$('#div_row').addClass('row');
    $('#div_input-group').css("display", "inherit");
    $('#div_content').addClass('col-md-9');
    $('#content-container-panel').addClass('panel-body');

    $('#div_container').css("height", containerHeight);
    $('#div_container').css("width", containerWidth);

    var windowHeight = $(window).height();
    $("#map_container").css("height", "" + windowHeight - 350 + "px");

    $('#toFullScreen').css("display", "inline");
    $('#exitFullScreen').css("display", "none");
    BaiduMap.checkResize();
    BaiduMap.setCenter(newCenter);
    BaiduMap.enableAutoResize();
}