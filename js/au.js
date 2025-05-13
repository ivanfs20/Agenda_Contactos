function mostrar(mensaje, optional, redireccion) {
    window.addEventListener("DOMContentLoaded", function () {
      if(mensaje==="agregar"){
          var overlay = null;
          if(optional==="Se ha agregado correctamente"){
               overlay = mostrarEscenario(optional,"media/agregar.png"); //Agregar y modificar solo tendran un boton de regreso ("FOTO DE SI O NEL")
          }else{
              overlay = mostrarEscenario(optional,"media/disgusto.png");
          }
          document.body.appendChild(overlay);
          const popup=document.getElementById("popupId");
          const button = añadirButton("Aceptar", redireccion);
  
          popup.appendChild(button);
      }else if(mensaje==="eliminar"){
          var overlay = overlay = mostrarEscenario(optional,"media/eliminar.png"); //Agregar y modificar solo tendran un boton de regreso ("FOTO DE SI O NO")
          document.body.appendChild(overlay);
          const buttonAceptar = añadirButton("Aceptar", redireccion);
          const buttonDenegar = añadirButton("Denegar", "inicio.php");
          const popup=document.getElementById("popupId");
          popup.appendChild(buttonAceptar);
          popup.appendChild(buttonDenegar);
      }else if(mensaje==="confirmar"){
          var overlay = null;
          if(optional==="Se ha eliminado correctamente"){
               overlay = mostrarEscenario(optional,"agregar.png"); //Agregar y modificar solo tendran un boton de regreso ("FOTO DE SI O NO")
          }else{
              overlay = mostrarEscenario(optional,"disgusto.png");
          }
          document.body.appendChild(overlay);
          const popup=document.getElementById("popupId");
          const button = añadirButton("Aceptar", "mostrar.php");
          popup.appendChild(button);
      }else{
          var overlay = null;
          if(optional==="Se ha modificado correctamente"){
               overlay = mostrarEscenario(optional,"media/rebautizar.png"); //Agregar y modificar solo tendran un boton de regreso ("FOTO DE SI O NO")
          }else{
              overlay = mostrarEscenario(optional,"disgusto.png");
          }
          document.body.appendChild(overlay);
          const popup=document.getElementById("popupId");
          const button = añadirButton("Aceptar", redireccion );
  
          popup.appendChild(button);
      }
    });
  }
  
  function mostrarEscenario(mensaje,imagen){
      const overlay = document.createElement("div");
      overlay.style.position = "fixed";
      overlay.style.top = 0;
      overlay.style.left = 0;
      overlay.style.width = "100%";
      overlay.style.height = "100%";
      overlay.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
      overlay.style.display = "flex";
      overlay.style.justifyContent = "center";
      overlay.style.alignItems = "center";
      overlay.style.zIndex = 1000;
  
      const popup = document.createElement("div");
      popup.id="popupId";
      popup.style.background = "#fff";
      popup.style.padding = "20px";
      popup.style.borderRadius = "10px";
      popup.style.textAlign = "center";
      popup.style.boxShadow = "0 0 10px rgba(0,0,0,0.3)";
  
      
    const message = document.createElement("p");
    message.textContent = mensaje;
  
    const imgi = document.createElement("img");
    imgi.src = imagen; // Cambia la ruta de la imagen según sea necesario
    imgi.width = 80;
    imgi.height = 80;
  
    popup.appendChild(imgi);
    popup.appendChild(message);
    overlay.appendChild(popup);
    return overlay;
    //document.body.appendChild(overlay);
  }
  
  
  
  function mostrarPopup(mensaje, redireccion) {
  
    const button = document.createElement("button");
    button.textContent = "Aceptar";
    button.style.marginTop = "10px";
    button.style.padding = "10px 20px";
    button.style.cursor = "pointer";
    button.style.backgroundColor = "#007BFF";
    button.style.color = "#fff";
  
    button.addEventListener("click", function () {
      window.location.href = redireccion;
    });
  
    popup.appendChild(imgi);
    popup.appendChild(message);
    popup.appendChild(button);
    overlay.appendChild(popup);
    document.body.appendChild(overlay);
  }
  
  
  function añadirButton(texto, redireccion){
      const button = document.createElement("button");
      button.textContent = texto;
      button.style.marginTop = "10px";
      button.style.padding = "10px 20px";
      button.style.cursor = "pointer";
      button.style.backgroundColor = "#007BFF";
      button.style.color = "#fff";
    
      button.addEventListener("click", function () {
        window.location.href =redireccion;
      });
  
      return button;
  }