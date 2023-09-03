document.addEventListener("DOMContentLoaded", function () {
  const sidebarIzq = document.getElementById("sidebarIzq");
  const sidebarDer = document.getElementById("sidebarDer");
  const main = document.getElementById("Log");

  const toggleButton = document.getElementById("toggleSidebar");

  toggleButton.addEventListener("click", function () {
    // Obtener la altura del article
    const articleHeight = document.querySelector('article').clientHeight;
    console.log(articleHeight);

    // Establecer la altura máxima del aside
    if(sidebarDer){
      sidebarDer.style.height = `${articleHeight}px`;
    }

    const computedStyles = window.getComputedStyle(sidebarIzq);
    const widthValue = parseFloat(computedStyles.width);

    // Si existe la sideBarDer
    if (sidebarDer) {
      if (widthValue != 0) {
        sidebarIzq.style.width = "0%";
        main.style.width = "80%";
        sidebarDer.style.width = "20%";

      } else {
        sidebarIzq.style.width = "20%";
        main.style.width = "80%";
        sidebarDer.style.width = "0%";
      }
    } else {
      if (widthValue === 0) {
        sidebarIzq.style.width = "20%";
        main.style.width = "80%";
      } else {
        sidebarIzq.style.width = "0%";
        main.style.width = "100%";
      }
    }
  });
});
