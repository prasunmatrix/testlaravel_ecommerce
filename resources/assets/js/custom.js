var BASE_URL  = 'http://localhost/testprojects/testlaravel_ecommerce';
var base_url  = window.location.origin;
var host      = window.location.host;
var pathArray = window.location.pathname.split('/');

//=========================For Popup Message=================//
function openModel(message)
{
    $('body #PopupMessages').html('');
    $('body #PopupMessages').append('<div class="modal fade" id="MessageModal" tabindex="-1" role="dialog" aria-labelledby="ExampleModalLongTitle" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"></div><div class="modal-body text" style="margin-left: 125px;">'+message+'</div><div class="modal-footer"></div></div></div></div>');
    $('#MessageModal').modal({show:true});

    setTimeout(function() 
    {
        $('#MessageModal').modal('hide');
        location.reload(true);
    }, 3000);
}
function cartModal(message)
{
    $('body #PopupMessages').html('');
    $('body #PopupMessages').append('<div class="modal fade" id="MessageModal" tabindex="-1" role="dialog" aria-labelledby="ExampleModalLongTitle" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"></div><div class="modal-body text-center text">'+message+'</div><div class="modal-body text-center pt-0"><a href="cart" class="btn btn-success">GO TO BASKET</a></div><div class="modal-footer"></div></div></div></div>');
    $('#MessageModal').modal({show:true});

    setTimeout(function() 
    {
        $('#MessageModal').modal('hide');
        location.reload(true);
    }, 3000);
    
}
//=========================For Popup Message=================//
//========================Add Product to Cart================//
function add_to_cart(product_id){
  //alert(product_id);
  var url = BASE_URL+'/add_to_cart';
  if($('#qty').length > 0)
  {       
    var quantity = $('#qty').val();
  } 
  else
  {
    var quantity = 1;
  }
  //console.log(quantity);
  $.ajax({
    url:url,
    method:"GET",
    cache:false,
    data:{product_id:product_id,quantity:quantity},
    success:function(data){
      if(data == 0)
      {
          openModel("Product already added to your basket");

          return false;
      }
      else
      {
          cartModal("Item added to basket");

          return true;
      }
    }

  });
}
//========================Add Product to Cart================//
//========================Update Product to Cart================//
function updateProduct(product_id){
  //(product_id);
  var quantity=$("#qty"+product_id).val();
  //alert(quantity);
  var url = BASE_URL+'/update_cart';
  $.ajax({
    url:url,
    method:"GET",
    cache:false,
    data:{product_id:product_id,quantity:quantity},
    success:function(data){
      if(data == 0)
      {
        openModel("Product not updated");
        return false;
      }
      else
      {
        openModel("Product updated successfully");
        return true;
      }
    }
  });
}

//========================Update Product to Cart================//
//========================Prduct Delete from Cart===============//
function deleteProduct(product_id){
  //(product_id);
  //var quantity=$("#qty"+product_id).val();
  //alert(quantity);
  var url = BASE_URL+'/delete_product';
  $.ajax({
    url:url,
    method:"GET",
    cache:false,
    data:{product_id:product_id},
    success:function(data){
      if(data == 0)
      {
        openModel("Product not remove");
        return false;
      }
      else
      {
        openModel("Product remove successfully");
        return true;
      }
    }
  });
}
//========================Prduct Delete from Cart===============//
