$(function() {
    $("form[name='classAdd']").validate({
      // Specify validation rules
      rules: {
        className: "required",
      },
      // Specify validation error messages
      messages: {
        className: "Please enter class name",
        
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    $("form[name='teacherAdd']").validate({
        rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            teacherName: "required",
            classTaken: "required",
            contactNo: "required",
            address: "required",
            gender : "required",
            email: {
              required: true,
              email: true
            }
        },
          // Specify validation error messages
        messages: {
            teacherName: "Please enter teacher's name",
            classTaken: "Please select classes taken by him/her",
            contactNo: "Please enter contact no",
            address: "Please enter teacher's address",
            email: "Please enter a valid email address",
            gender: "Please select the gender"
        },
          // Make sure the form is submitted to the destination defined
          // in the "action" attribute of the form when valid
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("form[name='studentAdd']").validate({
        rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            studentName: "required",
            class: "required",
            contactNo: "required",
            address: "required",
            gender: "required",
            fatherName: "required",
            motherName: "required",
            annualIncome: "required",
            dob: "required",
            email: {
              required: true,
              email: true
            }
        },
          // Specify validation error messages
        messages: {
            studentName: "Please enter student's name",
            fatherName: "Please enter father's name",
            motherName: "Please enter mother's name",
            dob: "Please select date of birth",
            annualIncome: "Please enter annual income",
            class: "Please select the class",
            contactNo: "Please enter contact no",
            address: "Please enter student's address",
            email: "Please enter a valid email address",
            gender: "Please select the gender"
        },
          // Make sure the form is submitted to the destination defined
          // in the "action" attribute of the form when valid
        submitHandler: function(form) {
            form.submit();
        }
    });
    $("form[name='teacher_self_update']").validate({
        rules: {
          name: "required",
          gender: "required",
          classTaken: "required",
          address: "required",
          contact: "required",
        },
          // Specify validation error messages
        messages: {
            name: "Please enter your name",
            classTaken: "Please select the class taken by you",
            contact: "Please enter your contact no",
            address: "Please enter your address",
            gender: "Please select the gender"
        },
          // Make sure the form is submitted to the destination defined
          // in the "action" attribute of the form when valid
        submitHandler: function(form) {
            form.submit();
        }
    });
});