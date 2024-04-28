// formValidation.js

export function dispayMsg(success, msg) {
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
  
  export function alerter() {
    alert('whatsapp');
  }
  
  export function validateName(name) {
    const namepattern = /^[a-zA-Z']+$/;
    if (name === '') {
      return false;
    }
    if (!namepattern.test(name)) {
      return false;
    }
    return true;
  }
  
  export function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  
    if (email === '') {
      return false;
    } else if (!emailPattern.test(email)) {
      return false;
    }
  
    return true;
  }
  
  export function validateContact(phoneNumber) {
    const phoneNumberPattern = /^(\+\d{1,13}|\d{10})$/;
  
    if (phoneNumber === '') {
      return false;
    } else if (!phoneNumberPattern.test(phoneNumber)) {
      return false;
    }
  
    return true;
  }
  
  export function validatePassword(pass) {
    const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.,;:/\'`~\-_<>(){}\[\]])[a-zA-Z\d!@#$%^&*.,;:/\'`~\-_<>(){}\[\]]{8,15}$/;
    if (pass === '') {
      return false;
    } else if (!pattern.test(pass)) {
      return false;
    }
    return true;
  }
  
  export function validateBrand(name) {
    const namePattern = /^[a-zA-Z0-9\-_ .:&'@#]+$/;
  
    if (name === '') {
      return false;
    } else if (!namePattern.test(name)) {
      return false;
    }
  
    return true;
  }
  
  export function validateLocation(location) {
    const locationPattern = /^[a-zA-Z0-9\-_ .:'#]+$/;
    if (location === '') {
      return false;
    } else if (!locationPattern.test(location)) {
      return false;
    }
    return true;
  }
  
  export function validateTime(time) {
    const timePattern = /^(?:[01]\d|2[0-3]):(?:[0-5]\d)$/;
  
    if (time === '') {
      return false;
    } else if (!timePattern.test(time)) {
      return false;
    }
  
    return true;
  }
  
  export function validateFileUpload(fileInput) {
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
  