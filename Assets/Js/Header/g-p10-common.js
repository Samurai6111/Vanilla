// /Js_/Header/g--p10-ajax-common.js
function show_ajax_loading_spinner() {
	// ---------- domを定義 ----------
	html =
		'<div id="overlay">'
		+ '<div class="cv-spinner">'
		+ '<span class="spinner"></span>'
		+ '</div>'
	+ '</div>'

	// ---------- domを設置 ----------
	$('body').prepend(html)

	$(document).ajaxSend(function() {
    $("#overlay").fadeIn(300);
  });
}

function hide_ajax_loading_spinner() {
	setTimeout(function(){
		$("#overlay").fadeOut(300);
	},500);
}

/** --------------------------------
 * URLのパラメータの値を取得する
 *
 * @param key
 */
function get_param(key) {
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	return urlParams.get(key)
}

/** --------------------------------
 * URLのパラメータの値を配列で取得する
 *
 * @param key
 */
function get_params(key) {
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);

	return urlParams.getAll(key)
}
