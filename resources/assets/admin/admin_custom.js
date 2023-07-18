var BASE_URL  = 'http://localhost/testprojects/testlaravel';
var base_url  = window.location.origin;
var host      = window.location.host;
var pathArray = window.location.pathname.split('/');

//=========================For Popup Message=================//
function openModel(message)
{
    $('body #PopupMessages').html('');
    $('body #PopupMessages').append('<div class="modal fade" id="MessageModal" tabindex="-1" role="dialog" aria-labelledby="ExampleModalLongTitle" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"></div><div class="modal-body text">'+message+'</div><div class="modal-footer"></div></div></div></div>');
    $('#MessageModal').modal({show:true});

    setTimeout(function() 
    {
        $('#MessageModal').modal('hide');
    }, 3000);
}
//=========================For Popup Message=================//
//==========================ADMIN CATEGORY==================================//

$(document).on('change', '#category_name', function (e) {
  var category_name = $('#category_name').val();
  //alert(category_name);
  var url = BASE_URL+'/get_category_slug';        
  
  $.ajax({
      type: "GET",
      url: url,
      data: {category_name: category_name},
      cache: false,
      success: function(result) 
      {
          if(result.status == 0)
          {
            openModel('This generated slug already exists');
            $('#add_category').prop('disabled', true);
            $('#category_slug').val(''); 
            return false;
          }
          else
          {
            var slug = result.slug;
            $('#category_slug').val(slug); 
            $('#add_category').prop('disabled', false);
            return true;
          }                 
      }
  });
});

//==========================ADMIN CATEGORY==================================//
//==============================ADMIN PRODUCT===============================//
$(document).on('change', '#product_name', function (e) {
  var product_name = $('#product_name').val();
  //alert(product_name);
  var url = BASE_URL+'/product_get_details';        
  
  $.ajax({
      type: "GET",
      url: url,
      data: {product_name: product_name},
      cache: false,
      success: function(result) 
      {
          if(result.status == 0)
          {
            openModel('This generated slug already exists');
            $('#add_product').prop('disabled', true);
            $('#slug').val(''); 
            return false;
          }
          else
          {
            var slug = result.slug;
            $('#slug').val(slug); 
            $('#add_product').prop('disabled', false);
            return true;
          }                 
      }
  });
});

$(document).on('change', '#sku_code', function (e) {    
  var sku_code = $('#sku_code').val();
  var url = BASE_URL+'/product_get_sku';        
    
  $.ajax({
      type: "GET",
      url: url,
      data: {sku_code: sku_code},
      cache: false,
      success: function(result) 
      {
          if(result.status == 0)
          {
            openModel('This SKU code alredy exists');
            $('#sku_code').val(''); 
            return false;
          }
          else
          {
            openModel('This SKU code not exists');
            return true;
          }                   
      }
  });
});
//==============================ADMIN PRODUCT===============================//
//=============================CHANGE POPULARITY============================//
function update_popular(id,is_popular){
  var is_popular= is_popular;
  //alert(is_popular);
  var product_id=id;
  var url = BASE_URL+'/update_popular';
  $.ajax({
    type: "GET",
    url: url,
    data: {is_popular:is_popular,product_id:product_id},
    cache: false,
    success: function(result)
    {
      if(result==1)
      {
        location.reload();
        return true;
      }
      else
      {
        return false;
      }
    }
  });
}
//=============================CHANGE POPULARITY============================//
