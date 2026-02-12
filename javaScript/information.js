document.addEventListener('DOMContentLoaded', function () {

  const form = document.querySelector("form");
  const password = document.getElementById("password");
  const strengthFill = document.getElementById("strength-fill");

  if (form && password && strengthFill) {
    form.addEventListener("submit", function (event) {
      const pass = password.value.trim();

     
      if (pass.length < 8) {
        event.preventDefault(); 
        alert("❌ Password must be at least 8 characters.");
        return false;
      }
      
      // السماح بإرسال الفورم إلى save_info.php
      return true;
    });

    
    function checkStrength(pass) {
      let hasLetters = /[A-Za-z]/.test(pass);
      let hasNumbers = /[0-9]/.test(pass);
      let hasSymbols = /[^A-Za-z0-9]/.test(pass);
      return [hasLetters, hasNumbers, hasSymbols].filter(Boolean).length;
    }

   
    password.addEventListener("input", function () {
      let val = password.value.trim();

      if (val === "") {
        strengthFill.style.width = "0";
        strengthFill.style.background = "transparent";
        return;
      }

      if (val.length < 8) {
        strengthFill.style.width = "33%";
        strengthFill.style.background = "red";
        return;
      }

      let types = checkStrength(val);
      if (types === 1) {
        strengthFill.style.width = "33%";
        strengthFill.style.background = "red";
      } else if (types === 2) {
        strengthFill.style.width = "66%";
        strengthFill.style.background = "yellow";
      } else {
        strengthFill.style.width = "100%";
        strengthFill.style.background = "green";
      }
    });
  }
});
