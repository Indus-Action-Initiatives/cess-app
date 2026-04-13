$(function () {
  //validation reset user password
  $("#resetpass").validate({
    rules: {
      password: {
          required: true,
          minlength: 8,
          pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/
      },
      confirmpassword:{
        required:true,
        equalTo:'#password'
      },
    },
    messages: {
      password: {
          required: "Please Enter Password",
          minlength: "Password must be at least 8 characters long",
          pattern: "Password must include uppercase, lowercase, number, and special character (like Abc@1234)"
      },
      confirmpassword:{
        required:"Please Enter Password",
        equalTo:"Passwords Don't Match"
      }
    },
  });
  $('#itemForm').validate({
    rules: {
      item_code: {
        required: true
      },
      item_name: {
        required: true
      },
      units: {
        required: true
      },
	  qty_min: {
        required: true
      },
    deal_hand: {
        required: true
      },
    },
    messages: {
      item_code: {
        required: "Please select a item code"
      },
      item_name: {
        required: "Please select a item name"
      },
	  units: {
        required: "Please enter a units"
      },
	  qty_min: {
        required: "Please enter a number"
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });	
  $('#divisionForm').validate({
    rules: {
      div_code: {
        required: true
      },
      div_name: {
        required: true
      },
    },
    messages: {
      div_code: {
        required: "Please enter a division code"
      },
      div_name: {
        required: "Please enter a division name"
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });	
  $('#sectionForm').validate({
    rules: {
      section_code: {
        required: true
      },
      section_name: {
        required: true
      },
      division_id: {
        required: true
      },
    },
    messages: {
      section_code: {
        required: "Please insert a section name"
      },
      section_name: {
        required: "Please insert a section code"
      },
      division_id: {
        required: "Please select division"
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });		
  $('#designationForm').validate({
    rules: {
      dgcode: {
        required: true
      },
      dgdesc: {
        required: true
      },
    },
    messages: {
      dgcode: {
        required: "Please enter a designation code"
      },
      dgdesc: {
        required: "Please enter a item designation desc"
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
  $('#userForm').validate({
    rules: {
      off_name: {
        required: true
      },
      off_empcode: {
        required: true
      },
      username: {
        required: true
      },
      password: {
          required: true,
          minlength: 8,
          pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/
      },
      confirmpassword:{
        required:true,
        equalTo:'#password'
      },
    },
    messages: {
      off_name: {
        required: "Please enter a name"
      },
      off_empcode: {
        required: "Please enter a employee code"
      },
      username: {
        required: "Please enter a username"
      },
      password: {
          required: "Please Enter Password",
          minlength: "Password must be at least 8 characters long",
          pattern: "Password must include uppercase, lowercase, number, and special character (like Abc@1234)"
      },
      confirmpassword:{
        required:"Please Enter Password",
        equalTo:"Passwords Don't Match"
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
  $('#drawingForm').validate({
    rules: {
      section_id: {
        required: true
      },
      division_id: {
        required: true
      },
      user_id: {
        required: true
      },
    },
    messages: {
      section_id: {
        required: "Please select a section code"
      },
      division_id: {
        required: "Please select a division code"
      },
      user_id: {
        required: "Please select a employee code"
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});