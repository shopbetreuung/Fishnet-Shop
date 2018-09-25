function getRowSize() {
	
	if ($(window).width() < 768) {
		return 1;
	} else if ($(window).width() < 992) {
		return 2;
	} else if ($(window).width() < 1200) {
		return 3;
	} else {
		return 3;
	}
}

function resizeProductBoxes() {
	var maxHeight = [];       
	var MyClass = "";
	var MyRow = 0;
	$(".equalize").each(function(){
		
		$(this).height('auto');
				
		MyClass = $(this).attr('class').replace('equalize', '').trim();
		MyRow = Math.ceil($(this).parent().attr("data-col") / getRowSize());
	
		if (typeof maxHeight[MyRow] == "undefined") {
			maxHeight[MyRow] = [];
		}
		if (typeof maxHeight[MyRow][MyClass] == "undefined") {
			maxHeight[MyRow][MyClass] = 0;
		}
		if ($(this).height() > maxHeight[MyRow][MyClass]) {
			maxHeight[MyRow][MyClass] = $(this).height();
		}
		
	});      

	$(".equalize").each(function(){
		
		MyClass = $(this).attr('class').replace('equalize', '').trim();
		MyRow = Math.ceil($(this).parent().attr("data-col") / getRowSize());
		$(this).height(maxHeight[MyRow][MyClass]);
		
	}); 	
}

$(window).on("load",function(){
   resizeProductBoxes();	
    
	$('[data-toggle="offcanvas"]').click(function () {
		$('.row-offcanvas').toggleClass('active')
	});
	
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        resizeProductBoxes();
    });
}); 

$(window).resize(function() {
    clearTimeout($.data(this, 'resizeTimer'));
    $.data(this, 'resizeTimer', setTimeout(function() {
       resizeProductBoxes();
    }, 50));
});