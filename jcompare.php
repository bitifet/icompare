<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head><!--{{{-->
  <title>jCompare</title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <style type="text/css" media="screen">
    body>* {
      margin:auto;
    }
  </style>
</head><!--}}}-->
<body><!--{{{-->
  <table class="compare"><!--{{{-->
    <tr>
      <td></td>
      <th>Item 1</th>
      <th>Item 2</th>
      <th>Item 3</th>
      <th>Item 4</th>
      <th>Item 5</th>
      <th>Item 6</th>
      <th>Item 7</th>
      <th>Item 8</th>
    </tr>
    <tr>
      <th>Color</th>
      <td>Red</td>
      <td>Green</td>
      <td>Blue</td>
      <td>Green</td>
      <td>Yellow</td>
      <td>Magenta</td>
      <td>Brown</td>
      <td>Yellow</td>
    </tr>
    <tr>
      <th>Height</th>
      <td>1m</td>
      <td>2m</td>
      <td>1m</td>
      <td>2m</td>
      <td>173cm</td>
      <td>1.54m</td>
      <td>3.04m</td>
      <td>10m</td>
    </tr>
    <tr>
      <th>Width</th>
      <td>3m</td>
      <td>3m</td>
      <td>2m</td>
      <td>1m</td>
      <td>7m</td>
      <td>1.25m</td>
      <td>7m</td>
      <td>9m</td>
    </tr>
    <tr>
      <th>Wheigt</th>
      <td>8kg</td>
      <td>16kg</td>
      <td>7kg</td>
      <td>8kg</td>
      <td>899Kg</td>
      <td>30g</td>
      <td>900g</td>
      <td>2Kg</td>
    </tr>
    <tr>
      <th>Age</th>
      <td>20</td>
      <td>15</td>
      <td>22</td>
      <td>35</td>
      <td>79</td>
      <td>11</td>
      <td>32</td>
      <td>55</td>
    </tr>
    <tr>
      <th>Organization</th>
      <td>Samsung</td>
      <td>Canonical</td>
      <td>Debian</td>
      <td>Red Hat</td>
      <td>Google</td>
      <td>Bitifet</td>
      <td>Pirate Partey</td>
      <td>Debian</td>
    </tr>
    <tr>
      <th>Price</th>
      <td>77</td>
      <td>88.20</td>
      <td>15</td>
      <td>1</td>
      <td>45</td>
      <td>7.05</td>
      <td>1</td>
      <td>7.50</td>
    </tr>
    <tr>
      <th>Currency</th>
      <td>$</td>
      <td>$</td>
      <td>$</td>
      <td>€</td>
      <td>€</td>
      <td>€</td>
      <td>€</td>
      <td>pts</td>
    </tr>
    <tr>
      <th>Stock</th>
      <td>Yes</td>
      <td>No</td>
      <td>Yes</td>
      <td>Yes</td>
      <td>Yes</td>
      <td>No</td>
      <td>No</td>
      <td>No</td>
    </tr>
  </table><!--}}}-->
</body><!--}}}-->
<script type="text/javascript" charset="utf-8"><!--{{{-->






(function( $ ){

  var $this;
  var self = {};
  var Items=new Array();
  var Propertys=new Array();

  var settings;

///          contrast = $('<div />', {
///            text : $this.attr('title')
///          });


  self.getItems=function( ) { // ... /*{{{*/

	 var t = $this;
	 $this.find("tr").each(function(i){
		 if(! i) { // Header (first row)
			 $(this).find("th").each(function(j){
				 var k=j+2; // Ordinal position excluding left heading.
				 Items[j]={
					 "label" : $(this).text(),
					 "active" : true,
					 "props" : {},
					 "self" : t.find("tr").find("td:nth-child("+k+"),th:nth-child("+k+")")
				 };
			 });
		 } else { // Rest of the table
			 var $this=$(this);
			 var prop;
			 // Read property name:
			 $this.find("th").first().each(function(){ // Usually should be only one.
				prop=$(this).text();
			 });
			 // Store property values for each item:
			 $this.find("td").each(function(j){
				 Items[j].props[prop]=$(this).text();
			 });
			 // Initialyze property status:
			 Propertys[prop]={
				 value : null,
				 active : true,
				 "self" : $this.find("td,th")
			 };
		 };

	 });

	 console.log(Propertys["Age"].self);
	 $(Propertys["Age"].self).css("background", "yellow");
    ///console.log(Items);


     return Items;
  };/*}}}*/





  self.show=function( ) { // ... 
  };
  self.hide=function( ) { // ... 
  };
  self.update=function( content ) { // ...
  };

// -----------------------------------

  self.init=function( options ) {/*{{{*/

    return this.each(function(){

      
      // If the plugin hasn't been initialized yet
      if ( ! settings ) {
        $this = $(this),
      
        // Default options:/*{{{*/
        settings=$.extend({
          "bgcolor" : "#00aaaa",
          "tr-bgcolor" : null,
          "th-bgcolor" : "#99dddd",
          "td-bgcolor" : "#aaaaaa",
        }, options);/*}}}*/

        // Style initialization:/*{{{*/
        $this.css("background", settings["bgcolor"]);
        $this.find("tr").css("background", settings["tr-bgcolor"]);
        $this.find("th").css("background", settings["th-bgcolor"]);
        $this.find("td").css("background", settings["td-bgcolor"]);
        /*}}}*/

        // Setup:
        self.getItems();
       
      }

      
    });
  };/*}}}*/

  self.destroy=function( ) {/*{{{*/

    return this.each(function(){

    })

  };/*}}}*/

  $.fn.contrast = function( method ) {/*{{{*/
    if ( self[method] ) {
      return self[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return self.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on jQuery.contrast' );
    }    
  }/*}}}*/


})( jQuery );


$(".compare").contrast({
///  "th-bgcolor" : "magenta"
});





  
</script><!--}}}-->
</html>
