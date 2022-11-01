(function(){
  "use strict";
  Array.from(document.forms["filter-form"].elements)
    .filter(element => ["INPUT", "SELECT"].includes(element.tagName))
    .forEach(element => element.addEventListener("change", () => element.form.submit()));
})();