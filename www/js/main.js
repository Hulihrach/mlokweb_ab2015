var colorBefore;
$(function(){
	$(".glyphicon-remove#article-remove").on({ 
    mouseenter: function() {
	    colorBefore = $(this).parent().css("background-color");
        $(this).parent().css("background-color", "#a94442");
        $(this).parent().parent().css("background-color", "#a94442");
    },
    mouseleave: function() {
        $(this).parent().css("background-color", colorBefore);
        $(this).parent().parent().css("background-color", colorBefore);
    },
	})
});

function makeControls(){
	//var screenSize = window.screen.width;
	//console.log(screenSize);
	var objs = document.getElementsByClassName("top-panel")[0].childNodes;
	//console.log(objs);
	var j = 0;
	var controls = new Array();
	for(var i = 0; i<objs.length; i++) {
		if(objs[i].tagName == "A" || objs[i].tagName == "SPAN") {
			//console.log(objs[i]);
			controls[j++] = objs[i];
		}
	}
	var d = 90/(controls.length-1);
	//var Dy = 12/(controls.length-1);
	//console.log(d);
	//console.log(Dy);
	var x = 5; var dx = 0;
	var y = 2; var dy = 0;
	for(var i = 0; i<controls.length; i++) {
		controls[i].style.top = (i%2 == 0) ? "2%" : "calc(12% - 35pt)";
		controls[i].style.left = (x + dx) + "%";
		//console.log(controls[i].getElementsByTagName("SPAN")[0]);
		if(controls[i].getElementsByTagName("SPAN")[0]) {controls[i].getElementsByTagName("SPAN")[0].style.top = ((i+2)%2 == 0) ? "32pt" : "-15pt"};
		//dy = dy + Dy;
		dx = dx + d;
	}
	var c0 = controls[0].getBoundingClientRect();
	var c1 = controls[1].getBoundingClientRect();
	var angle = Math.atan((c1.top-c0.top)/(c1.left-c0.left));
	console.log(angle);
	makeStart(controls[0].childNodes[1], angle);
	makeLines(angle, controls);
}

function makeStart(s, baseangle) {
	//console.log(s);
	var one = document.createElement("DIV");
	//var l = Math.sqrt(Math.pow(5+d,2)+Math.pow(2,2));
	//var lpx = window.screen.width*0.01*l;
	//console.log(baseangle);
	//console.log(l);
	one.style.width = "40px";

	try {
	//console.log("foo");
		one.style.transform = "rotate(" + (baseangle + Math.PI/2) + "rad)";
	}
	catch(err) { //IE 9
		one.style["-ms-transform"] = "rotate" + (baseangle + Math.PI/2) + "rad)";
	}
	s.appendChild(one);
	return baseangle;
}

function makeLines(angle, controls) {
	//var X = document.documentElement.clientWidth;
	//var Y = document.documentElement.clientHeight;
	//console.log(X,Y);
	var d = 90/(controls.length-1);
	var dy = 0;
	for(var i = 0; i < controls.length-1; i++) {
		var l = document.createElement("DIV");
		//console.log(controls[i].getElementsByTagName("DIV")[0].getBoundingClientRect().top)
		var cTop = controls[i].getElementsByTagName("DIV")[0].getBoundingClientRect().top;
		l.className = "line";
		l.style.height = "3pt";
		l.style.width = "calc(-28pt + " + d + "%)";
		l.style.left = "calc(" + (i*d) + "% + 31pt + 5%)" ;
 		//var posCorrect = (l.style.width);
		//console.log(posCorrect);
		try {
			//console.log("foo");
			l.style.transform = (i%2 == 0) ? "rotate(" + angle + "rad)" : "rotate(-" + angle + "rad)";
		}
		catch(err) { //IE 9
			l.style["-ms-transform"] = (i%2 == 0) ? "rotate(" + angle + "rad)" : "rotate(-" + angle + "rad)";
		}
		var top_panel = document.getElementsByTagName("DIV")[0];
		//console.log(top_panel);
		l = top_panel.appendChild(l);
		//console.log(l.getBoundingClientRect().height);
		l.style.top = (i == 0) ? "calc(2% + 20pt)" : ((i%2 == 0) ? "calc(" + cTop + "px + 22pt)" : "calc(" + (cTop - l.getBoundingClientRect().height) + "px + 22pt)");
		//console.log(l);
		dy = dy + 2;
	}
}
