var client = null;
var lastresults = null;
var lastoffset = 0;
var viewmode = 0;
var didyoumean = '';
var historial = [];
var shistorial = [];

const cookiename = 'apretaste';


function isset(v) {
	return typeof v !== 'undefined';
}

function showHelp() {
	
	if ($("#help").html() == '') {
		var help = client.ApretasteWeb.help();

		// BEGIN Salvi. Rafa client.ApretasteWeb.help() is returning NULL. I created this line to work meanwhile, but we HAVE TO fix this!
		help = "Creee un nuevo correo electronico para anuncios@apretaste.com<br/>Escriba en el asunto: BUSCAR televisor lcd<br/>Envie el correo. En menos de tres minutos recibira un email con los televisores a la venta en Cuba.";
		// END Salvi
	
		$("#help").html("<h2>Aprenda a utilizar Apretaste! con su correo electr&oacute;nico</h2><br/>" + help);
	}

	showHistorial();

	$("#container1").remove();
	$("#container2").show();
	
	$("#results").html($("#help").html());
	
	events();
}

function showTerms() {
	if ($("#terms").html() == '') {
		var terms = client.ApretasteWeb.terms();
		$("#terms").html("<h2>T&eacute;rminos de uso</h2><br/>" + terms);
	}
	showHistorial();
	$("#container1").remove();
	$("#container2").show();
	$("#results").html($("#terms").html());
	events();
}

function search(offset) {
	var frase = $("#subject").val();

	if ($("#container").val() == "1") {
		$("#container1").remove();
		$("#container2").show();
		$("#subject").val(frase);
		$("#container").val("2");
		$("html").scrollTop(0);
		$("body").scrollTop(0);

		if (!isset(historial))
			historial = [];

		showHistorial();
		events();

	}

	if (!isset(offset))
		var offset = 0;
	lastoffset = offset;

	$("#results").html('<img src="static/loading.gif"/>');

	lastresults = client.ApretasteWeb.search(frase, $("#price-min").val(), $("#price-max").val(), isset($("#photo").attr("checked")), isset($("#phone").attr("checked")), offset);
	
	var timestamp = 0;
	
	shistorial[shistorial.length] = {
		phrase: frase,
		timestamp: timestamp,
		results: lastresults,
		offset: offset,
		pricemin: $("#price-min").val(),
		pricemax: $("#price-max").val(),
		photo: isset($("#photo").attr("checked")),
		phone: isset($("#phone").attr("checked"))			
	};	
	
	saveCurrentState();
	
	showall();
}

function showall(){
	
	switch (viewmode) {
		
		case 1:
			viewList();
			break;
		case 2:
			viewIcons();
			break;
			
		default:
			viewDetails();
			break;

	}

	showHistorial();
	showRecommended();
	showPaginado();

	$(".paginado").show();
	$("#results").css("margin-top", "5px");
	$("body").scrollTop(0);
	$("html").scrollTop(0);
}

function searchThis(frase) {
	$("#subject").val(frase);
	didyoumean = client.ApretasteWeb.didyoumean(frase);
	if (didyoumean == frase)
		didyoumean = '';
	search();
}

function searchmore(offset) {
	search(offset);
}

function getHTMLDidYouMean() {
	var html = '';
	if (didyoumean != '') {
		html = "<div style=\"padding:10px;\">Quiz&aacute;s quiso decir o desee buscar: ";
		html += "<a href= \"#\" onclick=\"searchThis('" + didyoumean + "');\">"
				+ didyoumean + "</a>";
		html += '</div>';
	}
	return html;
}

/**
 * View ads as list
 */
function viewList() {
	if (isset(lastresults))
		if (lastresults != null) {
			html = getHTMLDidYouMean();

			if (lastresults.results.length > 0) {

				html += '<table width=\"700\">';

				for ( var i in lastresults.results) {
					var ad = lastresults.results[i];
					var phones = '';
					for ( var j in ad.phones) {
						phones += ad.phones[j] + ', ';
					}
					html += "<tr class = \"list-row\"><td align=\"right\" width=\"50\">";
					if (ad.price > 0)
						html += "<span class=\"price\">" + ad.price + " "
								+ ad.currency + "</span>";
					html += "</td><td><label id=\"" + ad.id
							+ "\" class=\"title\">" + ad.title
							+ "</label></td><td width=\"100\">" + phones
							+ "</td></tr>";

				}
				html += "</table>";
			} else {
				html = "Su b&uacute;squeda no produjo resultados";
			}

			$("#results").html(html);
			$("label.title").click(function() {
				showAd($(this).attr("id"));
			});

			viewmode = 1;
			$(".viewmode").css("border-left", "none");
			$(".viewmode").css("border-right", "none");
			$(".viewmode").css("background", "transparent");
			$(".viewmode").css("border-bottom", "1px solid green");
			$("#btnList").css("border-left", "1px solid green");
			$("#btnList").css("border-right", "1px solid green");
			$("#btnList").css("border-bottom", "0px");
			$("#btnList").css("background", "white");
			$("#btnList").css("padding-left", "5px");
			$("#results").css("width", "500px");
		}
}

/**
 * View ads with details
 */
function viewDetails() {
	if (isset(lastresults))
		if (lastresults != null) {
			var html = '';
			var ra = false;

			html = getHTMLDidYouMean();

			if (lastresults.results.length > 0) {
				if (lastresults.results[0].rank_title == 0) {
					html += '<h3>Solo se encontraron resultados aproximados:</h3>';
				}

				html += '<table>';

				for ( var i in lastresults.results) {

					var ad = lastresults.results[i];
					var img = "<img class=\"adimage\" src=\"index.php?path=ad_image&id="
							+ ad.id + "\&resized=60\" width=\"60\">";

					if (ad.rank_title == 0 && !ra) {
						if (i > 0)
							html += "<tr><td><h3>Resultados aproximados</h3></td></tr>";
						ra = true;
					}

					var phones = '';
					for ( var j in ad.phones) {
						phones += ad.phones[j] + ', ';
					}
					html += "<tr><td><label id=\"" + ad.id
							+ "\"class=\"title\">" + ad.title + "</label><br/>"
							+ img + "<p class=\"body\">";

					if ("" + ad.body != 'null')
						html += ad.body;

					html += "</p></td></tr>";
					html += "<tr><td class=\"ad\">";
					if (ad.price > 0)
						html += "<span class=\"price\">" + ad.price + " "
								+ ad.currency
								+ "</span><span class=\"splitter\">|</span>";

					if (phones != '')
						html += "Tel: " + phones;
					html += "<span class=\"splitter\">|</span>"
							+ ad.post_date.substr(0, 10) + " </td></tr>";
				}
				html += "</table>";

			} else {
				html = 'Su b&uacute;squeda no produjo resultados';
			}

			$("#results").html(html);

			$("label.title").click(function() {
				showAd($(this).attr("id"));
			});

			viewmode = 0;
			$(".viewmode").css("border-left", "none");
			$(".viewmode").css("border-right", "none");
			$(".viewmode").css("border-bottom", "1px solid green");
			$(".viewmode").css("background", "transparent");
			$("#btnDetails").css("border-left", "1px solid green");
			$("#btnDetails").css("border-right", "1px solid green");
			$("#btnDetails").css("border-bottom", "0px");
			$("#btnDetails").css("padding-left", "5px");
			$("#btnDetails").css("background", "white");

			showHistorial();
		}
		
		saveCurrentState();
}

function showAd(id) {

	var ad = getAdFromHistorial(id);
	if (ad == false)
		ad = client.ApretasteWeb.getAd(id);

	addToHistorial(ad);
	var phones = '';
	for ( var j in ad.phones) {
		phones += ad.phones[j] + ', ';
	}

	var html = '';
	var img = "<img class=\"adimage\" src=\"index.php?path=ad_image&id="
			+ ad.id + "\&resized=300\" width=\"300\"><br/>";
	html += "<table><tr><td colspan=\"2\">";
	if (ad.price > 0)
		html += "<label class=\"price\">$" + ad.price + "</label><br/>";
	html += ad.post_date.substr(0, 10) + "<h2>" + ad.title
			+ '</h2></td></tr><tr>';

	if (ad.image != '' && "" + ad.image != 'null' && ad.image + "" != '')
		html += '<td valign="top">' + img + "</td>";

	html += "<td valign=\"top\" align=\"left\">";

	if ("" + ad.body != 'null')
		html += '<div class="ad-body">' + ad.body + "</div>";

	if (phones != '')
		html += "<br>Tel: <strong>" + phones + "</strong>";
	html += "</td></tr></table>";
	$("#results").html(html);

	showHistorial();
	$("html").scrollTop(0);
	$("body").scrollTop(0);
}

function addToHistorial(ad) {
	var existe = false;

	for ( var i in historial) {
		if (historial[i].id == ad.id) {
			existe = true;
			break;
		}
	}

	if (!existe) {
		if (!isset(historial) || historial == null)
			historial = [];
		historial[historial.length] = ad;
	}
	
	saveCurrentState();

}

function saveCurrentState(){
	var state = {};
	
	state.historial = historial;	
	state.phrase = $("#subject").val();
	state.viewmode = viewmode;
	state.searchs = shistorial;
	state = json_encode(state);	
	
	$.cookie(cookiename, state, {expires: 30});
}

function loadLastState(){
	var state = json_decode($.cookie(cookiename));
	if (isset(state)) if (state != null) {
		if (isset(state.historial)) historial = state.historial;
		if (isset(state.phrase)) $("#subject").val(state.phrase);
		if (isset(state.viewmode)) viewmode = state.viewmode;
		if (isset(state.searchs)) shistorial = state.searchs;
	}
}

function getAdFromHistorial(id) {
	var existe = false;
	for ( var i in historial) {
		if (historial[i].id == id) {
			return historial[i];
		}
	}
	return false;
}

function delHistorial(id) {
	var hist = [];
	for ( var i in historial) {
		if (historial[i].id != id)
			hist[hist.length] = historial[i];
	}
	historial = hist;
	$("#h-" + id).fadeOut("slow");
	$("#h-" + id).remove();
	saveCurrentState();

}

function showHistorial() {
	var html = '<h3>Historial de anuncios vistos</h3><table>';
	for ( var i in historial) {
		var img = '';
		if (historial[i].image == true) {
			img = "<img class=\"adimage\" src=\"index.php?path=ad_image&id="
					+ historial[i].id + "\&resized=30\" width=\"30\"><br/>";
		}
		html += '<tr id="h-'
				+ historial[i].id
				+ '"><td>'
				+ img
				+ '</td><td><div class="historial-item"><a href="#" onclick="showAd(\''
				+ historial[i].id
				+ '\');">'
				+ historial[i].title
				+ '</a></div></td><td width="15"><button class="mini-delete" onclick="delHistorial(\''
				+ historial[i].id
				+ '\');" title="Eliminar del historial">x</button></td></tr>';
	}
	html += '</table><label style="color: gray;">Puede observar los anuncios del historial sin necesidad de estar conectado a Internet.</label>';
	$("#historial").html(html);
	$("#historial").show();
	$("#results").css("width", "600px");
}

/**
 * View ads as icons
 */
function viewIcons() {
	if (isset(lastresults))
		if (lastresults != null) {
			var html = getHTMLDidYouMean();
			if (lastresults.results.length > 0) {
				html += '<table>';
				var j = 0;
				for ( var i in lastresults.results) {
					j++;
					var ad = lastresults.results[i];
					var img = '';
					if (j == 1)
						html += "<tr>";
					html += "<td align=\"center\" valign=\"top\">";
					if (ad.image != null) {
						img = "<img class=\"adimage\" src=\"index.php?path=ad_image&id="
								+ ad.id + "\&resized=100\" width=\"100\">";
					}
					html += img + "<br/><label id=\"" + ad.id
							+ "\" class=\"title-mini\">" + ad.title
							+ "</label><br/>";
					if (ad.price > 0)
						html += ad.price + " " + ad.currency;
					if (j == 4) {
						html += "</tr>";
						j = 0;
					}

				}
				html += "</table>";
			} else {
				html += 'Su b&uacute;squeda no produjo resultados';
			}

			$("#results").html(html);
			$("label.title-mini").click(function() {
				showAd($(this).attr("id"));
			});
			viewmode = 2;
			$(".viewmode").css("border-left", "none");
			$(".viewmode").css("border-right", "none");
			$(".viewmode").css("border-bottom", "1px solid green");
			$(".viewmode").css("background", "transparent");
			$("#btnIcons").css("border-left", "1px solid green");
			$("#btnIcons").css("border-right", "1px solid green");
			$("#btnIcons").css("border-bottom", "0px");
			$("#btnIcons").css("padding-left", "5px");
			$("#btnIcons").css("background", "white");
			$("#results").css("width", "500px");
		}
		
		saveCurrentState();
}

function showPaginado() {
	if (isset(lastresults)) if (lastresults != null){
		var total = lastresults.total;
		var html = '';
		if (total > 10) {
			var pages = total / 10;
			if (pages > 1)
				for ( var i = 1; i <= pages; i++) {
					html += '<button class="link" onclick="searchmore('
							+ ((i - 1) * 10) + ');">' + i + '</button>';
				}
		}
		$("#paginado-bottom").html(html);
	} else {
		$("#paginado-bottom").html('');
	}
}

function events() {
	$("#search").click(function() {
		$("html").scrollTop(0);
		$("body").scrollTop(0);
		didyoumean = client.ApretasteWeb.didyoumean($("#subject").val());
		if (didyoumean == $("#subject").val())
			didyoumean = '';
		search();
	});

	$("#subject").keypress(function(e) {
		if (e.keyCode == 13) {
			$("html").scrollTop(0);
			$("body").scrollTop(0);
			didyoumean = client.ApretasteWeb.didyoumean($("#subject").val());
			if (didyoumean == $("#subject").val())
				didyoumean = '';
			search();
		}
	});

	$("#price-min").keypress(function(e) {
		if (e.keyCode == 13) {
			$("html").scrollTop(0);
			$("body").scrollTop(0);
			didyoumean = client.ApretasteWeb.didyoumean($("#subject").val());
			if (didyoumean == $("#subject").val())
				didyoumean = '';
			search();
		}
	});

	$("#price-max").keypress(function(e) {
		if (e.keyCode == 13) {
			$("html").scrollTop(0);
			$("body").scrollTop(0);
			didyoumean = client.ApretasteWeb.didyoumean($("#subject").val());
			if (didyoumean == $("#subject").val())
				didyoumean = '';
			search();
		}
	});
}

function getHTMLDwords() {

	var h = '';

	if (isset(lastresults))
		if (lastresults != null) {
			for ( var i in lastresults.dwords) {
				h += '<a href="#" onclick="searchThis($(\'#subject\').val() + \' \' + this.innerHTML)">'
						+ lastresults.dwords[i] + '</a>';
			}
		}

	return h;

}

function showRecommended() {
	
	$("#recommended").hide();
	
	if (isset(lastresults))
		if (lastresults != null) {
			if (lastresults.recommended_phrases.length > 0) {
				var h = '<h2>Frases recomendadas</h2>';
				for ( var i in lastresults.recommended_phrases) {
					h += '<a href="#" onclick = "searchThis(this.innerHTML);">'
							+ lastresults.recommended_phrases[i] + '</a><br/>';
				}
				$("#recommended").html(h);
				$("#recommended").show();
			}
		}

}
$(function() {
	client = new phpHotMapClient("index.php?path=server");
	
	loadLastState();
	var phrase = '';
	if ($("#subject").val()!='') {
		phrase = $("#subject").val();
		search();
	}
	if (historial.length > 0 || $("#subject").val()!='')
	{
		$("#container1").remove();
		$("#container2").show();
		showall();
		$("#subject").val(phrase);
		
	} else $("#container").val("1");
	
	events();	
});
