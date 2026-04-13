$(document).ready(function () {
  //called when key is pressed in textbox
  $(".number").on("keypress keyup blur",function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
     $(this).val($(this).val().replace(/[^0-9\.]/g,''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-Token': csrfToken
		}
	});	

  //   var stateId = $('#statebranch').val();
  //   var cid = $('#cid').val();
  //       $.ajax({
  //       type:"POST",      
  //       data:"state="+stateId+"&cid="+cid,
  //       url: webURL + "admin/checkcity",
  //       success:function(msg)
  //       {
  //         $("#citybranch").html(msg);
  //       }
  //   });
	

  // $('#statebranch').change(function(){
  //   var stateId = $('#statebranch').val();
  //       $.ajax({
  //       type:"POST",      
  //       data:"state="+stateId,
  //       url: webURL + "admin/checkcity",
  //       success:function(msg)
  //       {
  //         $("#citybranch").html(msg);
  //       }
  //   });
  //   });
	
	// var productId = $('#productbranch').val();
 //        $.ajax({
 //        type:"POST",      
 //        data:"product="+productId,
 //        url: webURL + "admin/checkqty",
	// 	dataType: 'json',
 //        success:function(response)
 //        {
 //          //$("#qtybranch").html(response);
	// 	  $('#availableQuantity').text('Available Quantity: ' + response.quantity);
	// 	  $('#quantityInput').attr('max', response.quantity);
 //        }
 //    });
	
	$('#productbranch').change(function(){
		//alert();
    var productId = $('#productbranch').val();
        $.ajax({
        type:"POST",      
        data:"product="+productId,
        url: webURL + "admin/checkqty",
		dataType: 'json',
        success:function(response)
        {
          //$("#qtybranch").html(response);
		  $('#availableQuantity').text('Available Quantity: ' + response.quantity);
		  $('#quantityInput').attr('max', response.quantity);
        }
    });
    });
	
	$('#quantityInput').on('input', function() {
        var inputQuantity = parseInt($(this).val());
        var availableQuantity = parseInt($('#quantityInput').attr('max'));

        if (inputQuantity > availableQuantity) {
            $('#errorMessage').show();
            $(this).val(availableQuantity); // Reset input to available quantity
        } else {
            $('#errorMessage').hide();
        }
    });
	
	/* Unique code validation */
	$('#org_code').blur(function() {
		var code = $(this).val();

		$.ajax({
			url: webURL + 'admin/checkOrgCode',
			type: 'POST',
			data: {code: code},
			dataType: 'json',
			success: function(response) {
				if (response.exists) {
					// Code is not unique
					$('#code_error').text('This code is already taken');
					$("#submitUserlogin").attr("disabled",true);
				} else {
					// Code is unique
					$('#code_error').text('');
					$("#submitUserlogin").attr("disabled",false);
				}
			}
		});
	});
	
	$('#itm_code').blur(function() {
		var code = $(this).val();

		$.ajax({
			url: webURL + 'admin/checkItemCode',
			type: 'POST',
			data: {code: code},
			dataType: 'json',
			success: function(response) {
				if (response.exists) {
					// Code is not unique
					$('#code_error').text('This code is already taken');
					$("#submitUserlogin").attr("disabled",true);
				} else {
					// Code is unique
					$('#code_error').text('');
					$("#submitUserlogin").attr("disabled",false);
				}
			}
		});
	});
	
	$(".downloadType").on('click', function () {
	  var currntId = $(this).attr('id');
	  $("#download_type").val(currntId);
	  $('#frmlist').submit();
		});
		$('#frmlist').on('click', function () {
	  $("#download_type").val('');
		});


});