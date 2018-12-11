
<script type="text/javascript">
function getObj(objID)
{
    if (document.getElementById) {return document.getElementById(objID);}
    else if (document.all) {return document.all[objID];}
    else if (document.layers) {return document.layers[objID];}
}

function checkClick(e) {
	e?evt=e:evt=event;
	CSE=evt.target?evt.target:evt.srcElement;
	if (CSE.tagName!='SPAN')
	if (getObj('fcs'))
		if (!isChild(CSE,getObj('fcs')))
			getObj('fcs').style.display='none';
}

function isChild(s,d) {
	while(s) {
		if (s==d)
			return true;
		s=s.parentNode;
	}
	return false;
}

function Left(obj)
{
	var curleft = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
	}
	else if (obj.x)
		curleft += obj.x;
	return curleft;
}

function Top(obj)
{
	var curtop = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	}
	else if (obj.y)
		curtop += obj.y;
	return curtop;
}

// Calendar script
var now = new Date;
var sccd=now.getDate();

var sccm=now.getMonth();
//if (sccm<10) {sccm= '0'+sccm;}

var sccy=now.getFullYear();


var ccm=now.getMonth();
//if (ccm<10) {ccm= '0'+ccm;}


var ccy=now.getFullYear();

// For current selected date
var selectedd, selectedm, selectedy;

document.write('<table id="fcs" style="display:none;" cellpadding="3">');

document.write('<tr style="font:normal 14px;" onselectstart="return false"><td style="cursor:pointer;font-size:16px" onclick="upmonth(-1)" class="m_arrow"><i class="icon-angle-circled-left"></i></td><td colspan="5" id="mns" align="center"></td><td align="right" style="cursor:pointer;font-size:16px" onclick="upmonth(1)" class="m_arrow"><i class="icon-angle-circled-right"></i></td></tr>');

document.write('<tr style="background:#B5B5B9;font:14px;color:#FFFFFF"><td align=center><?php echo $lang_days_short[1]; ?></td><td align=center><?php echo $lang_days_short[2]; ?></td><td align=center><?php echo $lang_days_short[3]; ?></td><td align=center><?php echo $lang_days_short[4]; ?></td><td align=center><?php echo $lang_days_short[5]; ?></td><td align=center><?php echo $lang_days_short[6]; ?></td><td align=center><?php echo $lang_days_short[7]; ?></td></tr>');
for(var kk=1;kk<=6;kk++) {
	document.write('<tr>');
	for(var tt=1;tt<=7;tt++) {
		num=7 * (kk-1) - (-tt);
		document.write('<td id="cv' + num + '">&nbsp;</td>');
	}
	document.write('</tr>');
}
document.write('<tr><td colspan="7" align="center" style="cursor:pointer;font:13px;background:#1B98F7; color:#fff;" onclick="today()" class="cl_today"><?php echo $lang['today']; ?>: '+addnull(sccd,sccm+1,sccy)+'</td></tr>');

//document.write('<tr><td colspan="7" align="center" style="cursor:pointer;font:13px;background:#FF4D00; color:#fff;" onclick="reset_date()" class="cl_today"><?php echo $lang['reset']; ?></td></tr>');

document.write('</table>');

document.all?document.attachEvent('onclick',checkClick):document.addEventListener('click',checkClick,false);


function reset_date() {
updobj.value='';
getObj('fcs').style.display='none';
}

var updobj;
function lcs(ielem) {
	updobj=ielem;
	//getObj('fcs').style.left=Left(ielem)+'px';
	//getObj('fcs').style.top=Top(ielem)+ielem.offsetHeight+'px';
	getObj('fcs').style.display='';

	// First check date is valid
	curdt=ielem.value+'.'+now.getFullYear(); //====FIX YEAR
	curdt=ielem.value;
	curdtarr=curdt.split('.');
	isdt=true;
	for(var k=0;k<curdtarr.length;k++) {
		if (isNaN(curdtarr[k]))
			isdt=false;
	}
	if (isdt&(curdtarr.length==3)) {
		ccm=curdtarr[1]-1;
		ccy=curdtarr[2];
		selectedd=parseInt ( curdtarr[0], 10 );
		selectedm=parseInt ( curdtarr[1]-1, 10 );
		selectedy=parseInt ( curdtarr[2], 10 );

		prepcalendar(curdtarr[0],curdtarr[1]-1,curdtarr[2]);
	}

}

function evtTgt(e){
	var el;
	if(e.target)el=e.target;
	else if(e.srcElement)el=e.srcElement;
	if(el.nodeType==3)el=el.parentNode; // defeat Safari bug
	return el;
}
function EvtObj(e){if(!e)e=window.event;return e;}
function cs_over(e) {
	evtTgt(EvtObj(e)).style.background='#1b98f7';
	
}
function cs_out(e) {
	evtTgt(EvtObj(e)).style.background='#f7f7f9';
	
}
function cs_click(e) {
	updobj.value=calvalarr[evtTgt(EvtObj(e)).id.substring(2,evtTgt(EvtObj(e)).id.length)];
	getObj('fcs').style.display='none';
}

var mn=new Array('<?php echo $lang_monts['01']; ?>','<?php echo $lang_monts['02']; ?>','<?php echo $lang_monts['03']; ?>','<?php echo $lang_monts['04']; ?>','<?php echo $lang_monts['05']; ?>','<?php echo $lang_monts['06']; ?>','<?php echo $lang_monts['07']; ?>','<?php echo $lang_monts['08']; ?>','<?php echo $lang_monts['09']; ?>','<?php echo $lang_monts['10']; ?>','<?php echo $lang_monts['11']; ?>','<?php echo $lang_monts['12']; ?>');
var mnn=new Array('31','28','31','30','31','30','31','31','30','31','30','31');
var mnl=new Array('31','29','31','30','31','30','31','31','30','31','30','31');
var calvalarr=new Array(42);

function f_cps(obj) {
	obj.style.background='#f7f7f9';
	obj.style.font='10px';
	obj.style.color='#101321';
	obj.style.textAlign='center';
	obj.style.textDecoration='none';
	obj.style.border='none';//'1px solid #606060';
	obj.style.cursor='pointer';
}

function f_cpps(obj) {
	obj.style.background='#1b98f7';
	obj.style.font='10px';
	obj.style.color='#fff';
	obj.style.textAlign='center';
	obj.style.textDecoration='line-through';
	obj.style.border='none';
	obj.style.cursor='default';
}

function f_hds(obj) {
	obj.style.background='#1b98f7';
	obj.style.font='bold 10px';
	obj.style.color='#fff';
	obj.style.textAlign='center';
	obj.style.border='none';
	obj.style.cursor='pointer';
}

// day selected
function prepcalendar(hd,cm,cy) {
	now=new Date();
	sd=now.getDate();
	td=new Date();
	td.setDate(1);
	td.setFullYear(cy);
	td.setMonth(cm);
	cd=td.getDay();
	if (cd==0)cd=6; else cd--;
	//getObj('mns').innerHTML=mn[cm]+'&nbsp;<span style="cursor:pointer" onclick="upmonth(-12)">&lt;</span>'+cy+'<span style="cursor:pointer" onclick="upmonth(12)">&gt;</span>';
	
	getObj('mns').innerHTML=mn[cm]+' '+cy+''; 
	//getObj('mns').innerHTML=mn[cm]; // FIX YEAR
	
	marr=((cy%4)==0)?mnl:mnn;
	for(var d=1;d<=42;d++) {
		cv=getObj('cv'+parseInt(d));
		f_cps(cv);
		if ((d >= (cd -(-1)))&&(d<=cd-(-marr[cm]))) {
			dip=((d-cd < sd)&&(cm==sccm)&&(cy==sccy));
			htd=((hd!='')&&(d-cd==hd));

			cv.onmouseover=cs_over;
			cv.onmouseout=cs_out;
			cv.onclick=cs_click;

			// if today
			if (sccm == cm && sccd == (d-cd) && sccy == cy)
				
				cv.style.color='#1b98f7';

			// if selected date
			if (cm == selectedm && cy == selectedy && selectedd == (d-cd) )
			{
				cv.style.background='#669900';
				cv.style.color='#fff';
				//cv.style.fontSize='1.1em';
				//cv.style.fontStyle='italic';
				//cv.style.fontWeight='bold';

				// when use style.background
				cv.onmouseout=null;
			}

			cv.innerHTML=d-cd;

			calvalarr[d]=addnull(d-cd,cm-(-1),cy);
		}
		else {
			cv.innerHTML='&nbsp;';
			cv.onmouseover=null;
			cv.onmouseout=null;
			cv.onclick=null;
			cv.style.cursor='default';
			}
	}
}

prepcalendar('',ccm,ccy);

function upmonth(s)
{
	marr=((ccy%4)==0)?mnl:mnn;

	ccm+=s;
	if (ccm>=12)
	{
		ccm-=12;
		ccy++;
	}
	else if(ccm<0)
	{
		ccm+=12;
		ccy--;
	}
	prepcalendar('',ccm,ccy);
}

function today() {
	updobj.value=addnull(now.getDate(),now.getMonth()+1,now.getFullYear());
	getObj('fcs').style.display='none';
	prepcalendar('',sccm,sccy);
}

function addnull(d,m,y)
{
	var d0=d,m0=m;
	if (d<10)d0='0'+d;
	if (m<10)m0='0'+m;

	return d0+'.'+m0+'.'+y;
	//return d0+'.'+m0; // FIX YEAR
}
</script>