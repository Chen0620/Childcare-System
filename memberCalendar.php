// Event Calendar
// copyright Stephen Chapman, 10th June 2006, 22nd January 2010

var tb = 't'; // top or bottom (t or b)
var headbg = '#cccccc';  // table heading background colour
var todaybg = '#99cccc'; // current selected date background colour
var textclr = '#000000'; // text colour
var linkclr = '#ff9999'; // link text colour
var noMessage =  'No event messages to display for today'; // message to display when no entry in array

var dA = new Array(); var x = 0;
// first 8 characters in ccyymmdd format for single date events
// first 8 characters in 0000mmdd format for every year events
dA[x++] = "00000101 New Year";
dA[x++] = "00000214 Valentine's day";
dA[x++] = "00000709 Steve's Birthday";
dA[x++] = "00000919 Site Anniversary";
dA[x++] = "00001206 St Nicholas' Day";
// dA[x++] = "20060610 New Event Calendar Started today";

// permission is granted to use this javascript provided that the below code is not altered
var pageLoaded = 0; window.onload = function() {pageLoaded = 1;}
function loaded(i,f) {if (document.getElementById && document.getElementById(i) != null) f(); else if (!pageLoaded) setTimeout('loaded(\''+i+'\','+f+')',100);
}
function monthlength(month,year) {var dd = new Date(year, month, 0);return dd.getDate();}
var moy = ['January','February','March','April','May','June','July','August','September','October','November','December'];var today = new Date();var selDate = today.getFullYear()+getmmdd(today.getMonth()+1,today.getDate());
function dispCal(yy,mm) {if (mm < 0 || mm > 12) {alert('month must be between 1 and 12'); return false;} if (yy != 0 && (yy < 1901 || yy > 2100)) {alert('year must be after 1900 and before 2101'); return false;} var dow = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']; var calendar = new Date();  var today = calendar.getDate(); calendar.setDate(1); if (yy > 1900) calendar.setFullYear(yy); if (mm > 0) calendar.setMonth(mm - 1); var yy = year = calendar.getFullYear(); var month = calendar.getMonth(); calendar.setDate(today); var weekday = calendar.getDay(); var daysInMonth = monthlength(month+1,year); var hilite_start = '<td width="30" style="background:' + todaybg + '" align="center"><b>'; var td_start = '<td width="30" align="center">'; var cal = '<div id="cal"><div style="border:1pt solid #cccccc;width:238px"><table border="0" cellspacing="0" cellpadding="2" align="center"><tr><td colspan="7" style="background:' + headbg + '" align="center"><b>' + moy[month]  + ' ' + year + '<\/b><\/td><\/tr><tr>'; for(dex=0; dex < 7; dex++) {cal += td_start + dow[dex] + '</td>';} cal += '<\/tr><tr>'; var day2 = today; for (dex = today; dex > 6; dex -=7) day2 = dex; weekday -= day2 - 1; while (weekday < 0) weekday += 7; for(dex=0; dex < weekday; dex++) cal += td_start + ' <\/td>'; for(dex=1; dex <= daysInMonth; dex++) {if(weekday == 7) {cal += '</tr><tr>'; weekday = 0;} if(selDate==year+getmmdd(month+1,dex)) cal += hilite_start +'<span '+clickDate(dex,month,year) + '>'+ dex + '<\/span><\/b><\/td>'; else cal += td_start + '<span '+clickDate(dex,month,year) + '>' + dex + '<\/span><\/td>'; weekday += 1;} for(dex=weekday; dex < 7; dex++) cal += td_start + ' <\/td>'; cal += '<\/tr><\/table><\/div>';if (document.getElementById) {var mmb = month;  mm = month + 1; var yya = yyb = yy; if (mmb <1) {mmb += 12; yyb--;} var mma = month + 2; if (mma > 12) {mma -= 12; yya++;} var yb = yy -1; var ya = yy +1; cal += '<table border="0" cellspacing="0" cellpadding="2" width="210"><tr><td><a href="#" onclick="if (cala = dispCal('+yb+','+mm+')) {document.getElementById(\'cal\').innerHTML = cala; return false;}"><<</a></td><td><a href="#" onclick="if (cala = dispCal('+yyb+','+mmb+')) {document.getElementById(\'cal\').innerHTML = cala; return false;}"><</a></td><td align="right"><a href="#" onclick="if (cala = dispCal('+yya+','+mma+')) {document.getElementById(\'cal\').innerHTML = cala; return false;}">></a></td><td align="right"><a href="#" onclick="if (cala = dispCal('+ya+','+mm+')) {document.getElementById(\'cal\').innerHTML = cala; return false;}">>></a></td></tr></table>';} else {cal += '<div> </div>';} cal += '</div>'; return cal;}
function start() {var x = '<div id="calDate" style="border:1pt solid #cccccc;width:238px"><\/div>'; var y = ''; if (tb == 't') y = x + dispCal(0,0); else y = dispCal(0,0) + x; document.getElementById('calendar').innerHTML = y; ev();}
loaded('calendar',start);
function clickDate(day, month, year) {var ct = nextDate(year + getmmdd(month+1,day));if (ct == '') ct = nextDate('0000' + getmmdd(month+1,day));if (ct == '') return 'style="color:'+textclr+'"'; else return 'style="cursor:pointer;color:'+linkclr+'" onclick="selDate = '+year+ getmmdd(month+1,day)+'; isDate(' + day + ',' + month + ',' + year + ');return false;"';}function isDate(dayVal,monthVal,yearVal) {var ct = nextDate(yearVal + getmmdd(monthVal+1,dayVal));if (ct == '') ct = nextDate('0000' + getmmdd(monthVal+1,dayVal));if (ct == '') ct = noMessage;document.getElementById('calDate').innerHTML = selDate + ':<br \/>' +ct; return false;}function nextDate(yymmdd) {var x = dA.length;for (var i = 0; i < x; i++) {if (dA[i].substr(0,8) == yymmdd) return dA[i].substr(8);}return '';}function getmmdd(mm,dd) {return (mm > 9 ? '' + mm : '0' + mm) + (dd > 9 ? dd : '0' + dd);}
function ev() {var ct = nextDate(selDate);var ct = nextDate(selDate);if (ct == '') ct = nextDate('0000' + selDate.substr(4));if (ct == '') ct = noMessage; document.getElementById('calDate').innerHTML = selDate + ':<br \/> ' +ct;}