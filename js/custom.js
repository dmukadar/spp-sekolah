/* image url */
var IMAGE_URL = 'images/';

jQuery.noConflict();

jQuery(function($) {

	/* toggle boxes
	------------------------------------------------------------------------- */
	$('.box > h2').append('<img src="' + IMAGE_URL + 'icons/arrow_state_grey_expanded.png" class="toggle" />');
	$('img.toggle').click(function() {
		$(this).parent().next().slideToggle(200);
	});
	
	/* sortable table rows
	------------------------------------------------------------------------- */
	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};
	$('table.sortable tbody').sortable({
		handle: 'img.move',
		helper: fixHelper,
		placeholder: 'ui-state-highlight',
		forcePlaceholderSize: true
	}).disableSelection();

	/* sortable photos
	------------------------------------------------------------------------- */
	$('ul.sortable').sortable({
		placeholder: 'ui-state-highlight',
		forcePlaceholderSize: true
	});
	
	/* checkall
	------------------------------------------------------------------------- */
	var togel = false;
	$('#table1 .checkall').click(function() {
		$('#table1 :checkbox').attr('checked', !togel);
		togel = !togel;
	});
	var togel2 = false;
	$('#table2 .checkall').click(function() {
		$('#table2 :checkbox').attr('checked', !togel2);
		togel2 = !togel2;
	});

	/* detail table
	------------------------------------------------------------------------- */
	$('table.detailtable tr.detail').hide();
	$('table.detailtable > tbody > tr:nth-child(4n-3)').addClass('odd');
	$('table.detailtable > tbody > tr:nth-child(4n-1)').removeClass('odd').addClass('even');
	$('a.detail-link').click(function() {
		$(this).parent().parent().next().fadeToggle();
		return false;
	});
	
	/* superfish menu
	------------------------------------------------------------------------- */
	$('ul.sf-menu').superfish({
		delay: 107,
		animation: false,
		dropShadows: false
	});

	/* message boxes
	------------------------------------------------------------------------- */
	$('.msg').click(function() {
		$(this).fadeTo('slow', 0);
		$(this).slideUp(341);
	});

	/* wysiwyg editor
	------------------------------------------------------------------------- */
	$('#wysiwyg').wysiwyg();
	$('#newscontent').wysiwyg();

	/* facebox
	------------------------------------------------------------------------- */
	$('a[rel*=facebox]').facebox();

	/* date picker
	------------------------------------------------------------------------- */
	$('#dob').datepicker({
		changeMonth: true,
		changeYear: true
	});
	$('#newsdate').datepicker();

	/* accordion
	------------------------------------------------------------------------- */
	$('.accordion > h3:first-child').addClass('active');
	$('.accordion > div').hide();
	$('.accordion > h3:first-child').next().show();
	$('.accordion > h3').click(function() {
		if ($(this).hasClass('active')) {
			return false;
		}
		$(this).parent().children('h3').removeClass('active');
		$(this).addClass('active');
		$(this).parent().children('div').slideUp(200);
		$(this).next().slideDown(200);
	});

	/* tabs
	------------------------------------------------------------------------- */
	$('.tabcontent > div').hide();
	$('.tabcontent > div:first-child').show();
	$('.tabs > li:first-child').addClass('selected');
	$('.tabs > li a').click(function() {
		var tab_id = $(this).attr('href');
		$(tab_id).parent().children().hide();
		$(tab_id).fadeIn();
		$(this).parent().parent().children().removeClass('selected');
		$(this).parent().addClass('selected');
		return false;
	});
	
	/* form validation
	------------------------------------------------------------------------- */
	$('#myForm').validate();
	
	/* uniform
	------------------------------------------------------------------------- */
	$('.uniform input[type="checkbox"], .uniform input[type="radio"], .uniform input[type="file"]').uniform();

	/* cufon
	------------------------------------------------------------------------- */
	Cufon.replace('#site-title');
	Cufon.replace('article > h1');
	Cufon.replace('article > h2');
	Cufon.replace('article > h3');
	Cufon.replace('article > h4');
	Cufon.replace('article > h5');
	Cufon.replace('article > h6');

});

//flash message
function flashDialog(elementId, message, duration) {
	duration = duration * 1000;
	obj = jQuery('#' + elementId);

	obj.html(message);
	obj.slideDown();
	setTimeout(function() {obj.slideUp();}, duration);
}
