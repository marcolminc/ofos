document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('btn-submit').addEventListener('click', (event) => {
      // Perform validation
      let inputErrs = [];
      const namepattern = /^[a-zA-Z']+$/
      //let first_name, email, fone, upload, first_nameErr, nemErr, emailErr, foneErr, uploadErr;
      
      if (!validateName(document.getElementById('first_name').value)) {
        first_nameErr = 'only alphabets, \' allowed'
        document.getElementById('first_name_err').innerText = first_nameErr
        inputErrs.push(first_nameErr)
      }

       //middle name
      const middleNameInput = document.getElementById('middle_name');
      if (middleNameInput.value !== '' && !namepattern.test(middleNameInput.value)) {
         const middleNameErr = 'Only alphabets are allowed for names.';
         document.getElementById('middle_name_err').innerText = middleNameErr;
         inputErrs.push(middleNameErr);
       }
       
      if (!validateName(document.getElementById('last_name').value)) {
        last_nameErr = 'only alphabets, \' allowed'
        document.getElementById('last_name_err').innerText = first_nameErr
        inputErrs.push(last_nameErr)
      }
      if(!validateEmail(document.getElementById('email').value)) {
        emailErr = 'invalid email address'
        document.getElementById('email_err').innerText = emailErr
        inputErrs.push(emailErr)
      }

      if (!validateName(document.getElementById('username').value)) {
        usernameErr = 'only alphabets, \' allowed'
        document.getElementById('username_err').innerText = usernameErr
        inputErrs.push(usernameErr)
      }

      if (!validatePassword(document.getElementById('password').value)) {
        passwordErr = 'weak password, {a-z, A-Z, 0-9, special characters} * (8 - 12)'
        document.getElementById('password_err').innerText = passwordErr
        inputErrs.push(passwordErr)
      }
      if (document.getElementById('password').value !== document.getElementById('cpassword').value) {
        cpasswordErr = 'passwords do not match'
        document.getElementById('cpassword_err').innerText = cpasswordErr
        inputErrs.push(cpasswordErr)
      }

      //brand
      if (!validateBrand(document.getElementById('restaurant_name').value)) {
        restaurant_nameErr = 'only {alphabets, @ # - _\' . : & } allowed'
        document.getElementById('restaurant_name_err').innerText = restaurant_nameErr
        inputErrs.push(restaurant_nameErr)
      }
      if (!validateName(document.getElementById('category').value)) {
        categoryErr = 'only alphabets allowed'
        document.getElementById('category_err').innerText = categoryErr
        inputErrs.push(usernameErr)
      }
      if (!validateLocation(document.getElementById('location').value)) {
        locationErr = 'only {alphabets, -_ .:\'#} allowed'
        document.getElementById('location_err').innerText = locationErr
        inputErrs.push(locationErr)
      }
      if (!validateContact(document.getElementById('contact').value)) {
        contactErr = '+255123456789 or 0123456789'
        document.getElementById('contact_err').innerText = contactErr
        inputErrs.push(contactErr)
      }
      
      if (!validateTime(document.getElementById('open_hours').value)) {
        open_hoursErr = 'invalid opening time'
        document.getElementById('open_hours_err').innerText = open_hoursErr
        inputErrs.push(open_hoursErr)
      }

      if (!validateTime(document.getElementById('close_hours').value)) {
        close_hoursErr = 'invalid closing time'
        document.getElementById('close_hours_err').innerText = close_hoursErr
        inputErrs.push(close_hoursErr)
      }

      if (!validateFileUpload(document.getElementById('logo'))) {
        logoErr = 'logo image is required'
        document.getElementById('logo_err').innerText = logoErr
        inputErrs.push(logoErr)
      }

      if (!validateFileUpload(document.getElementById('cover'))) {
        coverErr = 'cover image is required'
        document.getElementById('cover_err').innerText = coverErr
        inputErrs.push(coverErr)
      }
      





  
      if (inputErrs.length === 0) {
        // No input errors, allow form submission
      //document.getElementById('validjs-form').submit()


      const formData = new FormData(document.getElementById('validjs-form'))
      var xmlhttp = new XMLHttpRequest();
      // xmlhttp.open("POST", "./jsvalid.php", true)
      xmlhttp.open("POST", "./handle_rep_reg.php", true)
      xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
      //handle positive response
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          alert(this.responseText)
          console.log(this.responseText)
          document.getElementById('validjs-form').reset()
        }
      }
      xmlhttp.send(formData)
 
      }
  
      event.preventDefault(); // Prevent form submission
    })






    //funtions:
function dispayMsg(success, msg) {
  const msgDiv = document.getElementById('msg');
  msgDiv.textContent = msg;
  
  if (success) {
    msgDiv.classList.add('success');
    msgDiv.classList.remove('error');
  } else {
    msgDiv.classList.add('error');
    msgDiv.classList.remove('success');
  }
}
function alerter() {
  alert('whatsapp')
}
function validateName(name) {
  const namepattern = /^[a-zA-Z']+$/
  if (name === '') {
    return false;
  }
  if (!namepattern.test(name)) {
    return false;
  }
  return true;
}

function validateEmail(email) {
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (email === '') {
    return false;
  } else if (!emailPattern.test(email)) {
    return false;
  }

  return true;
}

function validateContact(phoneNumber) {
  const phoneNumberPattern = /^(\+\d{1,13}|\d{10})$/;

  if (phoneNumber === '') {
    return false;
  } else if (!phoneNumberPattern.test(phoneNumber)) {
    return false;
  }

  return true;
}

function validatePassword(pass) {
  const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.,;:/\'`~\-_<>(){}\[\]])[a-zA-Z\d!@#$%^&*.,;:/\'`~\-_<>(){}\[\]]{8,15}$/
  if (pass === '') {
    return (false)
  } else if (!pattern.test(pass)) {
    return false
  }
  return true
}

function validateBrand(name) {
  const namePattern = /^[a-zA-Z0-9\-_ .:&'@#]+$/

  if (name === '') {
    return false;
  } else if (!namePattern.test(name)) {
    return false;
  }

  return true;
}

function validateLocation(location) {
  const locationPattern = /^[a-zA-Z0-9\-_ .:'#]+$/
  if (location === '') {
    return (false)
  } else if (!locationPattern.test(location)) {
    return (false)
  }
  return (true)
}

function validateTime(time) {
  const timePattern = /^(?:[01]\d|2[0-3]):(?:[0-5]\d)$/;

  if (time === '') {
    return false;
  } else if (!timePattern.test(time)) {
    return false;
  }

  return true;
}

function validateFileUpload(fileInput) {
  const allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];

  const file = fileInput.files[0];
  if (!file) {
    return false;
  }

  if (!allowedFileTypes.includes(file.type)) {
    return false;
  }

  // Additional validation logic if needed

  return true;
}



  })


  /////////////////////////

