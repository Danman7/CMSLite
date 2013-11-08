$(function() {
	//Place active class on the current active item in a menu
	var segment_str = window.location.pathname; // gets the url and returns segment1/segment2/segment3/segment4
	var segment_array = segment_str.split( '/' ); //split the url
	var last_segment = segment_array[segment_array.length - 1]; //get the last segment
    urlRegExp = new RegExp(last_segment.replace(/\/$/,''));    
    $('.navbar ul.nav li a').each(function(){
        if(urlRegExp.test(this.href)){
            $(this).parent().addClass('active');
        }
    });
});