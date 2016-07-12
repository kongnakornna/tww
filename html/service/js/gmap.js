var newwindow;
var map, mm;
var marker;
var markersArray = new Array();

function _g(namex){   
	if (document.getElementById) {
		return document.getElementById(namex);
	} else if (document.all) {
		return document.all[namex];   
	} else {
		return null;
	}
}

var asProvinceLatLng = {
	1:'13.74055000, 100.51556000',
	101:'13.70803400, 100.58310900',
	102:'13.73061300, 100.50923100',
	103:'13.85916700, 100.70425300',
	104:'13.82528800, 100.68161100',
	105:'13.82879600, 100.55988000',
	106:'13.69431300, 100.47036500',
	107:'13.92284800, 100.60221800',
	108:'13.78954800, 100.56664900',
	109:'13.77526200, 100.51095900',
	110:'13.77836500, 100.45504800',
	111:'13.75749800, 100.36370100',
	112:'13.63266400, 100.50328200',
	113:'13.72495500, 100.48567300',
	114:'13.76272500, 100.47809100',
	115:'13.72341900, 100.47623200',
	116:'13.76023800, 100.59436400',
	117:'13.69619500, 100.45812400',
	118:'13.69619500, 100.45812400',
	119:'13.83472400, 100.52229500',
	120:'13.69303300, 100.50243600',
	121:'13.69179600, 100.41387500',
	122:'13.66750200, 100.64178800',
	123:'13.64320800, 100.37784300',
	124:'13.79093900, 100.48939000',
	125:'13.72494700, 100.51501900',
	126:'13.78560700, 100.66927900',
	127:'13.74590100, 100.53663700',
	128:'13.72241600, 100.68161100',
	129:'13.74013900, 100.51556200',
	130:'13.78332100, 100.54602500',
	131:'13.70619700, 100.59432200',
	132:'13.75602400, 100.49867900',
	133:'13.71307800, 100.43659900',
	134:'13.81325200, 100.73133500',
	135:'13.71742900, 100.51322800',
	136:'13.75907000, 100.53353600',
	137:'13.68171800, 100.50584000',
	138:'13.72186600, 100.77650600',
	139:'13.83067800, 100.61799800',
	140:'13.77414800, 100.60712800',
	141:'13.74243300, 100.56206400',
	142:'13.73529100, 100.62600300',
	143:'13.77141300, 100.69019300',
	144:'13.74019000, 100.51025800',
	145:'13.70820300, 100.52629900',
	146:'13.92123100, 100.65965000',
	147:'13.68558700, 100.35863600',
	148:'13.87148900, 100.86305500',
	149:'13.88748200, 100.57874800',
	150:'13.77653400, 100.57918700',
	2:'8.05804000, 98.91695000',
	3:'14.00401000, 99.54946000',
	4:'16.43370000, 103.50683000',
	5:'16.48508000, 99.52470000',
	6:'16.43309000, 102.83740200',
	7:'12.61034200, 102.10372100',
	8:'13.68755100, 101.07055900',
	9:'15.15112000, 100.15108800',
	10:'15.80794200, 102.03303200',
	11:'10.43109000, 99.13788000',
	12:'13.36210700, 100.98371000',
	13:'18.78956131, 98.98432731',
	14:'19.91162500, 99.83180600',
	15:'7.55768500, 99.61160000',
	16:'12.24406253, 102.51789093',
	17:'16.88603000, 99.12724000',
	18:'14.19947000, 101.20967000',
	19:'13.84055300, 100.05275000',
	20:'17.40850000, 104.78157000',
	21:'14.96922000, 102.10240200',
	22:'8.42160800, 99.96743300',
	23:'15.69065200, 100.11413600',
	24:'6.42758000, 101.82356000',
	25:'18.77762000, 100.76797000',
	26:'13.86283000, 100.51447000',
	27:'14.99408700, 103.10231300',
	28:'11.80323000, 99.80027000',
	29:'14.01986300, 100.52394200',
	30:'14.05175000, 101.37465000',
	31:'6.86781800, 101.24947700',
	32:'19.19152000, 99.87993000',
	33:'8.43918000, 98.51846000',
	34:'16.37812000, 100.38208000',
	35:'16.82465400, 100.25943400',
	36:'13.06075000, 100.03326000',
	37:'16.41928900, 101.15972300',
	38:'18.14554300, 100.14134300',
	39:'7.61686000, 100.07288300',
	40:'7.89026600, 98.39861000',
	41:'16.18361100, 103.29779800',
	42:'16.54549200, 104.72601800',
	43:'19.29974100, 97.96577700',
	44:'15.78848000, 104.15080300',
	45:'6.36989000, 101.23352000',
	46:'16.05289700, 103.65317200',
	47:'9.96672400, 98.63519800',
	48:'12.68172100, 101.25603200',
	49:'13.52865400, 99.81325800',
	50:'15.04995700, 100.89031000',
	51:'18.28350100, 99.50820600',
	52:'18.13541000, 98.91541000',
	53:'17.48720900, 101.72029400',
	54:'14.76293000, 104.45526000',
	55:'17.15438200, 104.13526500',
	56:'7.12405896, 100.59082031',
	57:'13.54713900, 100.27433600',
	58:'13.57124156, 100.63476562',
	59:'13.41271100, 100.00147600',
	60:'13.93407000, 102.10693000',
	61:'14.53137400, 100.91184100',
	62:'14.88675000, 100.40090200',
	63:'17.00598800, 99.82668900',
	64:'14.48698500, 100.13140700',
	65:'9.08311225, 99.35073852',
	66:'14.85985000, 103.49121000',
	67:'6.62307000, 100.06752200',
	68:'18.06231000, 103.56812000',
	69:'17.20624600, 102.43661200',
	70:'15.85828500, 104.62935700',
	71:'17.41481000, 102.78707800',
	72:'17.75522616, 100.21179199',
	73:'15.37850000, 100.02619900',
	74:'15.22973000, 104.85612100',
	75:'14.35106500, 100.57644600',
	76:'14.66238300, 100.30489000'
}

function addLoadEvent(func) {
	var oldonload = window.onload;
	
	if (typeof window.onload != 'function') {
		window.onload = func;
	} else {
		window.onload = function() {
			if (oldonload) {
				oldonload();
			}
			
			func();
		}
	}
}

function addmappoint(pt,act) {
	if(act == "add" || act == "edit") {
		var sPT = pt.toString();
		var asPT = sPT.match(/\((.+), (.+)\)/);
		
		oLat.value = asPT[1];
		oLng.value = asPT[2];
		oBtnDelMap.disabled = false;
		_g('lat_container').innerHTML = asPT[1];
		_g('lng_container').innerHTML = asPT[2];
		_g('latlng_container').style.display = '';
	} else {
		oLat.value = '';
		oLng.value = '';
		oBtnDelMap.disabled = true;
		_g('lat_container').innerHTML = '';
		_g('lng_container').innerHTML = '';
		_g('latlng_container').style.display = 'none';
	}
}

function confirmAdd(point) {
	if(confirm("คุณต้องการ mark จุดนี้ใช่หรือไม่ ?")) {
		addmappoint(point,'add');
		
		return true;
	}
	
	return false;
}

function confirmDelete(point) {
	var sMsg = 'คุณต้องการยกเลิก ?\n\nคุณสามารถลาดเพื่อเปลี่ยนสถานที่ได้.\n';
	if(confirm(sMsg)) {
		addmappoint(point,'del');
		return true;
	}
	
	return false;
}

function EditPoint(point) {
	addmappoint(point,'edit');
}

function ClearPoint() {
	//if(marker) {
	for(var i=0,iLen=markersArray.length; i<iLen; i++) {
		map.removeOverlay(markersArray[i]);
	}
	
	oLat.value = '';
	oLng.value = '';
	oBtnDelMap.disabled = true;
	_g('lat_container').innerHTML = '';
	_g('lng_container').innerHTML = '';
	_g('latlng_container').style.display = 'none';
	GEvent.addListener(map, "click", function(marker, point) {
		if(confirmAdd(point)) {
			var marker = new GMarker(point, {draggable: true});
			
			GEvent.addListener(marker, "dragstart", function() {
				var startpoint =  marker.getLatLng();
				map.closeInfoWindow();
			});
			
			GEvent.addListener(marker, "dragend", function() {
				var point = marker.getLatLng();
				EditPoint(point);
			});
			
			map.addOverlay(marker);
			markersArray.push(marker);
			GEvent.clearListeners(map, "click");
		}
	});
}

function MoveTo(loc) {
	var asLoc = loc.split('_');
	
	if(asLoc.length < 4) return;
	
	var asLatLng = asProvinceLatLng[asLoc[3]].match(/^(.+), (.+)$/);
	
	map.panTo(new GLatLng(asLatLng[1], asLatLng[2]));
	map.setZoom(11);
	
	ClearPoint();
}

function load() {
	if(GBrowserIsCompatible()) {
		map = new GMap2(document.getElementById("map"));
		map.setCenter(new GLatLng(13.75, 100.5167), 11);
		
		var mapControl = new GMapTypeControl();
		map.addControl(mapControl);
		map.addControl(new GLargeMapControl());
			
		GEvent.addListener(map, "click", function(marker, point) {
			if(confirmAdd(point)) {
				marker = new GMarker(point, {draggable: true});
				
				GEvent.addListener(marker, "dragstart", function() {
					var startpoint =  marker.getLatLng();
					map.closeInfoWindow();
				});
				
				GEvent.addListener(marker, "dragend", function() {
					var point = marker.getLatLng();
					EditPoint(point);
				});
				
				map.addOverlay(marker);
				markersArray.push(marker);
				GEvent.clearListeners(map, "click");
			} else {
				return;
			}
		});
	}
}


function load_edit() {
	if(GBrowserIsCompatible()) {
		var asLatLng = sLatLng.match(/^\((.+), (.+)\)$/);
		var sLat = parseFloat(asLatLng[1]);
		var sLng = parseFloat(asLatLng[2]);
				
		map = new GMap2(document.getElementById("map"));
		map.setCenter(new GLatLng(sLat, sLng), 11);
		
		var mapControl = new GMapTypeControl();
		map.addControl(mapControl);
		map.addControl(new GLargeMapControl());
			
		GEvent.addListener(map, "click", function(marker, point) {
			if(confirmAdd(point)) {
				var marker = new GMarker(point, {draggable: true});
				
				GEvent.addListener(marker, "dragstart", function() {
					var startpoint =  marker.getLatLng();
					map.closeInfoWindow();
				});
				
				GEvent.addListener(marker, "dragend", function() {
					var point = marker.getLatLng();
					EditPoint(point);
				});
				
				map.addOverlay(marker);
				GEvent.clearListeners(map, "click");
			}
		});
		
		var point = new GLatLng (sLat, sLng);
		marker= new GMarker(point, {draggable: true});
		
		GEvent.addListener(marker, "dragstart", function() {
			var startpoint =  marker.getLatLng();
			map.closeInfoWindow();
		});
		
		GEvent.addListener(marker, "dragend", function() {
			var point = marker.getLatLng();
			EditPoint(point);
		});
		
		map.addOverlay(marker);
		markersArray.push(marker);
		GEvent.clearListeners(map, "click");
	}
}