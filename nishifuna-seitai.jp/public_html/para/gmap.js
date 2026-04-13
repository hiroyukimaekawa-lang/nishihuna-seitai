/**
 * 開始ズームサイズ
 * @type Number
 */
var START_ZOOM = 14;

/**
 * 開始中心位置
 * @type google.maps.LatLng
 */
var START_CENTER = new google.maps.LatLng(35.708896,139.960677);

/**
 * GoogleMapオブジェクト
 * @type google.maps.Map
 */
var gmap;

/**
 * 現在開いている情報ウィンドウ
 * @type google.maps.InfoWindow
 */
var openInfoWindow; 

/**
 * GoogleMapの初期処理
 * @param {String} id GoogleMap表示領域ID
 */
function gmap_initialize(id) {
  /**
   * 地図オプション
   * @param Object
   */
  var mapOption = {
    zoom: START_ZOOM,
    center:START_CENTER,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    navigationControlOptions: {
      style: google.maps.NavigationControlStyle.DEFAULT
    }
  };
  gmap = new google.maps.Map(document.getElementById(id), mapOption);
}

/**
 * マーカーデータのセット
 * @param {Object}   マーカーデータ
 */
function setMarkerData(makerArray) {

  // 登録データ分のマーカーを作成
  for (var i = 0; i < makerArray.length; i++) {
    var markerData = makerArray[i];
    var marker = new google.maps.Marker({
      position: markerData.position,
      title: markerData.title,
      map: gmap
    });

    // マーカーのclickリスナー登録
    setMarkerClickListener(marker, markerData);
  }
}

/**
 * マーカーのクリックイベントリスナーの登録
 * @param {google.maps.Marker} marker マーカーオブジェクト
 * @param {Object} markerData マーカーに設定する情報ウィンドウデータ
 */
function setMarkerClickListener(marker, markerData) {
  // マーカークリック時に情報ウィンドウを開く。
  // すでに開いているウィンドウがある場合は、閉じてから開く。
  google.maps.event.addListener(marker, 'click', function(event) {
    if (openInfoWindow) {
      openInfoWindow.close();
    }
    openInfoWindow = new google.maps.InfoWindow({
      content: markerData.content
    });
    google.maps.event.addListener(openInfoWindow,'closeclick',function(){
      openInfoWindow = null;
    })
    openInfoWindow.open(marker.getMap(), marker);
  });
}

