jQuery(document).ready(function ($) {
	
//on load focus + loader -- start
$('.search-field').click(function(){ $("#solr-typeahead").focus(); });
window.onload = function() {
  $("#img-test").fadeOut("slow");
  $('.search-field').click();
};
  document.onreadystatechange = function() { 
    //alert(document.readyState);
    // $('.input-group-text').click(); 
    if (document.readyState === "complete") { 
        $("#img-test").hide();
        //$("#collapseOne1").show();
        console.log("if");
    } 
};
//on load focus + loader -- end		
  // url for request Solr
  var solosoeParams = window["solrUrl"];
  solrUrl = solosoeParams["solr_url"];
  siteUrl = solosoeParams["site_url"];
  carouselItems = solosoeParams["items"];
  console.log(carouselItems);
  $(".owl-carousel").owlCarousel({
    items: 8,
    margin: 10,
    loop: true,
    nav: true,
    dots: true,
    navText: [
      "<div class='nav-btn prev-slide'></div>",
      "<div class='nav-btn next-slide'></div>",
    ],
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 4,
      },
    },
  });

  // return name_code from solr
  var display_product = function (product) {
      
    return product.name_code;
  };

  var one_result;

  // transform solr search result
  var transform_products = function (data) {

    var docs = JSON.stringify(data.response.docs);
    var products = JSON.parse(docs);
    one_result = products.length;
    console.log(one_result);

    if (one_result == 1) {
		
      console.log(products);
      var prod_id = products[0].name_code;
      console.log(prod_id);
      // WE ALSO HAVE TO CHECK THAT prod_id ARE DIGITS
	  if (prod_id.length >= 6 && prod_id.length <= 13 && parseInt(prod_id)) {
		  $("#img-test").css("display", "flex");
          console.log("CODE LENGTH "+ prod_id.length);
		  console.log(siteUrl + products[0].prd_id);
          window.location.href = siteUrl + products[0].prd_id;
      }
    } else {
      return $.map(products, function (product) {
        return {
          id: product.id,
          name_code: product.name_code,
          prd_id: product.prd_id,
          score: product.score,
          prod_url: siteUrl + product.prd_id,
        };
      });
    }
  };

  // Bloodhound configuration
  var datasets = [
    {
      name: "products",
      source: new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace([
          "name_code",
          "prd_id",
        ]),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        identify: function (product) {
          return product.id;
        },
        sufficient: 1,
        remote: {
          url:
            "https://solr.solosoe.com/solr/product_name_code_v2/select?defType=dismax&fl=*%2Cscore&mm=70%25&pf=name&ps=1&qf=name_code&q=%QUERY",
          wildcard: "%QUERY",
          prepare: function (query, settings) {
            settings.beforeSend = function (jqXHR, settings) {
              settings.xhrFields = {
                withCredentials: true,
              };
            };
            settings.crossDomain = true;
            settings.dataType = "jsonp";
            settings.jsonp = "json.wrf";
            settings.url = settings.url.replace("%QUERY", query);
            settings.url = settings.url.replace(/ /g, "%20");
            console.log(settings.url);
            return settings;
          },
          transform: transform_products,
        },
        indexRemote: true,
      }),
      limit: 8,
      display: display_product,
    },
  ];

  // init typeahead
  $("#solr-typeahead")
    .typeahead(
      {
        minLength: 3,
        highlight: true,
        hint: true,
        autoselect: true,
        templates: {
          suggestion: function (data) {

            return "<p><strong>" + product.name_code + "</strong></p>";
          },
          


          /*Dimple : 10-09-2020*/
           /*empty: function(context){
               return "<p><strong> Empty</strong></p>";
            $("#product-name").text('No Results Found');
          },*/
          
        },
      },
      datasets
    )
    .on("typeahead:asyncrequest", function () {
      $(".Typeahead-spinner").show();
    })
    .on("typeahead:asynccancel typeahead:asyncreceive", function () {
      $(".Typeahead-spinner").hide();
    });


  // redirect to product page
  $("#solr-typeahead").bind("typeahead:select", function (ev, suggestion) {
    console.log("Selection: " + suggestion.prod_url);
    window.location.href = suggestion.prod_url;
  });

  // redirect for barcode scanner
  $("#solr-typeahead").bind("typeahead:render", function (
    ev,
    suggestions,
    flag,
    datasets
  ) {
    $("#solr-typeahead")
      .parent()
      .find(".tt-selectable:first")
      .addClass("tt-cursor");
  });

  /***dimple : 11-09-2020****/
  $('#solr-typeahead').on('typeahead:selected', function (e, datum) {
      $('.tt-input').val(datum.name_code);
  });
  /**dimple : 11-09-2020****/

  //toggle full description
  $("#pr-desc").each(function () {
    var $this = $(this);
    var text = $this.html();
    $this.data("full-text", text);
    var small = text.substring(0, 300);

    if (small.length < text.length) {
      $this.html(small);
      var $button = $(
        '<button id="description-toggle">Show description</button>'
      );
      $button.click(function () {
        $this.html($this.data("full-text"));
      });
      $this.append($button);
    }
  });

/***dimple: 11-09-202***/
 $("#demo").hide();
  $(document).on('keyup', ".tt-input", function(data) {
    if($(".tt-suggestion").length === 0 ){
        $("#Cima").hide();
        $("#test").show();
    }
});
/****dimple : 11-09-2020***/




});







