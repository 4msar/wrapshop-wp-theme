jQuery(document).ready(function($){
	
	
	// Gallery Image Change
	$(document).ready(function(){
		
		$(document).on("click", ".product_gal img", function() {
			var cur_img = $(this).attr('src');
			//alert(cur_img);
			$('#cov_img img').fadeOut('fast', function () {
				$(this).removeAttr('srcset');
				$(this).removeAttr('src');
				
				$(this).attr("srcset",cur_img);
				$(this).attr("src",cur_img);
					
					$(this).fadeIn('fast');
				});
			
		});
	});
	// AJAX GET PRODUCT DETAILS 
	function get_product_details(pid, p, n){
		$.ajax({
			url: wrapshop_ajaxurl,
			data: {
				action: "product_quick_view",
				product_id: pid,
				prev:n,
				next:p
			},
			success: function(t) {
				$('.cd-quick-view').empty().html(t);
				
				$('.cd-quick-view').css({
					'visibility':'visible',
					'opacity' : '1',
					'-webkit-animation-name': 'zoomIn',
					'animation-name': 'zoomIn'
					
					});
				
				$('body').css({
					'overflow':'hidden'
				});
				
				$('a#product_id_'+pid+' i.ws-qvb').removeClass('loading');
				$('a#product_id_'+pid).removeAttr('style');
				
			},
			error: function(t) {
				console.log(t);
				//alert(t);
			}
		});
	}
	
	$(document).on("click", ".product_quick_view_button", function(t) {
		t.preventDefault();
		var i = $(this);
		var n = $(this).data("product_id");
		var current = $(this).data("product_id");
		p1 = find_nav_ids(n).qv_next;
		p2 = find_nav_ids(n).qv_prev;
		get_product_details(n,p1, p2);
		
		$('a#product_id_'+n+' i.ws-qvb').addClass('loading');
		$('a#product_id_'+n).css({
			'color':'rgba(255,255,255, 0.2)',
			'opacity' : '1'
		});
	});
	$(document).on("click", ".nxt-prev-product .prev", function(t) {
		t.preventDefault();
		var i = $(this);
		var n = $(this).data("previd");
		$('.cd-quick-view .product .cd-slider-wrapper, .cd-item-info').css({
			'visibility' : 'hidden',
			'transition' : '0.8s',
			'opacity' : '0',
			'-webkit-animation-name': 'zoomOut',
			'animation-name': 'zoomOut'
		});
		$('#ajax_load').css({
			'visibility' : 'visible',
			'transition' : '0.8s',
			'opacity' : '1'
		});
		
		p1 = find_nav_ids(n).qv_next;
		p2 = find_nav_ids(n).qv_prev;
		get_product_details(n,p1,p2);
		
	});
	$(document).on("click", ".nxt-prev-product .nxt", function(t) {
		t.preventDefault();
		var i = $(this);
		var n = $(this).data("nxtid");
		$('.cd-quick-view .product .cd-slider-wrapper, .cd-item-info').css({
			'visibility' : 'hidden',
			'transition' : '0.8s',
			'opacity' : '0',
			'-webkit-animation-name': 'zoomOut',
			'animation-name': 'zoomOut'
		});
		
		$('#ajax_load').css({
			'visibility' : 'visible',
			'transition' : '0.8s',
			'opacity' : '1'
		});
		
		p1 = find_nav_ids(n).qv_next;
		p2 = find_nav_ids(n).qv_prev;
		get_product_details(n,p1,p2);
	});
	
	
	var qv_length = $('.product_quick_view_button').length;
	function find_nav_ids(p_id){
		var curr_index = $("[data-product_id="+p_id+"]").index('.product_quick_view_button');
		var curr_length = curr_index + 1;
		var next_index,prev_index;
		var qv_btn = $('.product_quick_view_button');
		//Find next button
		if(curr_length == qv_length){
			next_index = 0;
			 
		}
		else{
			next_index = curr_index + 1;
		}

		//Find prev button
		if(curr_length == 1){
			prev_index = qv_length - 1;
		}
		else{
			prev_index = curr_index - 1;
		}

		var qv_next = qv_btn.eq(next_index).attr('data-product_id');
		var qv_prev = qv_btn.eq(prev_index).attr('data-product_id');
		return {'product_id': p_id , 'qv_next': qv_next , 'qv_prev': qv_prev};

	}
	//////////////////////////////////////////////////////////////////
	
	
	
	$(document).keyup(function(event){
		//check if user has pressed 'Esc'
		if(event.which=='27'){
			closeQuickView( true);
		}
	});
	// //close the quick view panel
	$('body').on('click', function(event){
		if( ($(event.target).is('.cd-close') || $(event.target).is('.cd-close i') || $(event.target).is('.cd-quick-view')) ) {
			closeQuickView( true);
		}
	});
	function closeQuickView() {
		var close = $('.cd-close'),
		selectedImage = $('.empty-box').find('img');
		$('.cd-quick-view').css({
			'visibility' : 'hidden',
			'transition' : '0.8s',
			'opacity' : '0',
			'-webkit-animation-name': 'zoomOut',
			'animation-name': 'zoomOut'
		});
		$('body').css({
			'overflow':'auto'
		});
		
	}
	
	
	// SHOP PAGE CATEGORY
	$(document).ready(function(){
		//$("li.product-category").css('display', 'inline');
		//$("li.product-category:last").a('<br>')
		$("<li class='end-product-category'></li>").insertAfter("li.product-category:last");
		//.css({'content':"\A", 'white-space':'pre'});
	});
});