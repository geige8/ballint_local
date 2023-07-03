function sendAjaxRequest(url, callback) {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText) {
          callback(this.responseText);
        } else {
          console.log("La respuesta está vacía o incompleta.");
        }
      }
    };
    xhr.open("GET", url, true);
    xhr.send();
}

