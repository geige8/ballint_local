document.addEventListener("DOMContentLoaded", function () {
    const sidebarIzq = document.getElementById("sidebarIzq");
    const sidebarDer = document.getElementById("sidebarDer");
    const main = document.getElementById("Log");
  
    const toggleButton = document.getElementById("toggleSidebar");
  
    toggleButton.addEventListener("click", function () {
      // Cambia el ancho del aside dependiendo de su estado actual
      if (sidebarIzq.style.width === "20%" && sidebarDer && sidebarDer.style.width === "0%") {
        sidebarIzq.style.width = "0%";
        sidebarDer.style.width = "20%";
        main.style.width = "80%";
      } else {
        if (sidebarIzq.style.width === "0%") {
          sidebarIzq.style.width = "20%";
          if (sidebarDer) {
            sidebarDer.style.width = "0%";
          }
          main.style.width = "80%";
        } else {
          sidebarIzq.style.width = "0%";
          if (sidebarDer) {
            sidebarDer.style.width = "0%";
          }
          main.style.width = "100%";
        }
      }
    });
  });
  

  