
 // modified Isotope methods for gutters in masonry
  $.Isotope.prototype._getMasonryGutterColumns = function() {
    var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;
        containerWidth = this.element.width();
  
    this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
                  // or use the size of the first item
                  this.$filteredAtoms.outerWidth(true) ||
                  // if there's no items, use size of container
                  containerWidth;

    this.masonry.columnWidth += gutter;

    this.masonry.cols = Math.floor( ( containerWidth + gutter ) / this.masonry.columnWidth );
    this.masonry.cols = Math.max( this.masonry.cols, 1 );
  };

  $.Isotope.prototype._masonryReset = function() {
    // layout-specific props
    this.masonry = {};
    // FIXME shouldn't have to call this again
    this._getMasonryGutterColumns();
    var i = this.masonry.cols;
    this.masonry.colYs = [];
    while (i--) {
      this.masonry.colYs.push( 0 );
    }
  };

  $.Isotope.prototype._masonryResizeChanged = function() {
    var prevSegments = this.masonry.cols;
    // update cols/rows
    this._getMasonryGutterColumns();
    // return if updated cols/rows is not equal to previous
    return ( this.masonry.cols !== prevSegments );
  };

$(document).ready(function() {

  function initialize() {
    var reelradioLoc = new google.maps.LatLng(45.421869, -75.738738);
    var mapOptions = {
      center: reelradioLoc,
      zoom: 16,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      disableDefaultUI: true
    };
    var map = new google.maps.Map(document.getElementById("mapcanvas"), mapOptions);

    var marker = new google.maps.Marker({
      position: reelradioLoc,
      title:"RÉÉL-Radio"
    })
    marker.setMap(map)
  }

  $('#mapcanvas').exists(function(){
      initialize();
  });

	$('.home .articles').isotope({
		// options
		itemSelector : 'article',
		layoutMode : 'masonry',
		masonry : {
			columnWidth : 300,
			gutterWidth : 20
		}
	});

  $('.page-template-emissions-php .articles').isotope({
    // options
    itemSelector : 'article',
    layoutMode : 'masonry',
    masonry : {
      columnWidth : 450,
      gutterWidth : 20
    }
  });


  $('.blogroll').imagesLoaded( function(){
    
    $('.blogroll').isotope({
      // options
      itemSelector : 'li',
        layoutMode: 'cellsByRow',
        cellsByRow : {
            columnWidth : 180,
            rowHeight : 120
          }
    });
  
  });

	$('.sub-menu').siblings('a').click(function(e) {
    
    e.preventDefault();
    $('ul.sub-menu').slideUp(100);

    if ( $(this).siblings('ul.sub-menu').css('display') != 'none' ){

      $(this).siblings('ul.sub-menu').slideUp(100);

    } else {

      $(this).siblings('ul.sub-menu').slideDown(100); 

    }

	});

  $('.sub-menu').parent('li.menu-item').addClass('menu-parent');
	
  $('.menu-parent > a').append('<span class="arrow">/</span>');

  $('.wp-post-image[width!="700"]').css({
    'position':'static',
    'top':'auto',
    'left' : 'auto',
    'display': 'block',
    'margin': '0 auto 40px'
  })

})
